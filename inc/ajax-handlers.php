<?php
/**
 * AJAX handlers for forms
 */

if (!defined('ABSPATH')) {
    exit;
}

/**
 * Newsletter signup AJAX handler
 */
function yoursite_newsletter_signup() {
    // Verify nonce
    if (!wp_verify_nonce($_POST['nonce'], 'newsletter_nonce')) {
        wp_send_json_error(__('Security check failed', 'yoursite'));
    }
    
    $email = sanitize_email($_POST['email']);
    
    if (!is_email($email)) {
        wp_send_json_error(__('Invalid email address', 'yoursite'));
    }
    
    // Store subscriber emails (simple approach)
    $subscribers = get_option('yoursite_subscribers', array());
    if (!in_array($email, $subscribers)) {
        $subscribers[] = $email;
        update_option('yoursite_subscribers', $subscribers);
        
        // Send notification to admin
        wp_mail(
            get_option('admin_email'),
            __('New Newsletter Subscriber', 'yoursite'),
            sprintf(__('New subscriber: %s', 'yoursite'), $email),
            array('Content-Type: text/html; charset=UTF-8')
        );
        
        wp_send_json_success(__('Successfully subscribed!', 'yoursite'));
    } else {
        wp_send_json_error(__('Email already subscribed', 'yoursite'));
    }
}
add_action('wp_ajax_newsletter_signup', 'yoursite_newsletter_signup');
add_action('wp_ajax_nopriv_newsletter_signup', 'yoursite_newsletter_signup');

/**
 * Contact form AJAX handler
 */
function yoursite_contact_form() {
    // Verify nonce
    if (!wp_verify_nonce($_POST['nonce'], 'contact_nonce')) {
        wp_send_json_error(__('Security check failed', 'yoursite'));
    }
    
    $first_name = sanitize_text_field($_POST['first_name']);
    $last_name = sanitize_text_field($_POST['last_name']);
    $email = sanitize_email($_POST['email']);
    $phone = sanitize_text_field($_POST['phone']);
    $company = sanitize_text_field($_POST['company']);
    $subject = sanitize_text_field($_POST['subject']);
    $message = sanitize_textarea_field($_POST['message']);
    $newsletter = isset($_POST['newsletter']) ? true : false;
    
    // Validation
    $errors = array();
    
    if (empty($first_name)) {
        $errors[] = __('First name is required', 'yoursite');
    }
    
    if (empty($last_name)) {
        $errors[] = __('Last name is required', 'yoursite');
    }
    
    if (empty($email)) {
        $errors[] = __('Email is required', 'yoursite');
    } elseif (!is_email($email)) {
        $errors[] = __('Invalid email address', 'yoursite');
    }
    
    if (empty($subject)) {
        $errors[] = __('Subject is required', 'yoursite');
    }
    
    if (empty($message)) {
        $errors[] = __('Message is required', 'yoursite');
    }
    
    if (!empty($errors)) {
        wp_send_json_error(implode(', ', $errors));
    }
    
    // Send email to admin
    $admin_subject = sprintf(__('Contact Form: %s', 'yoursite'), $subject);
    $admin_message = sprintf(
        '<h3>%s</h3>
        <p><strong>%s</strong> %s %s</p>
        <p><strong>%s</strong> %s</p>
        <p><strong>%s</strong> %s</p>
        <p><strong>%s</strong> %s</p>
        <p><strong>%s</strong> %s</p>
        <p><strong>%s</strong></p>
        <p>%s</p>
        <p><strong>%s</strong> %s</p>',
        __('New Contact Form Submission', 'yoursite'),
        __('Name:', 'yoursite'), $first_name, $last_name,
        __('Email:', 'yoursite'), $email,
        __('Phone:', 'yoursite'), $phone,
        __('Company:', 'yoursite'), $company,
        __('Subject:', 'yoursite'), $subject,
        __('Message:', 'yoursite'),
        $message,
        __('Newsletter:', 'yoursite'), ($newsletter ? __('Yes', 'yoursite') : __('No', 'yoursite'))
    );
    
    $headers = array(
        'Content-Type: text/html; charset=UTF-8',
        sprintf('From: %s %s <%s>', $first_name, $last_name, $email),
        sprintf('Reply-To: %s', $email)
    );
    
    if (wp_mail(get_option('admin_email'), $admin_subject, $admin_message, $headers)) {
        // Add to newsletter if requested
        if ($newsletter) {
            $subscribers = get_option('yoursite_subscribers', array());
            if (!in_array($email, $subscribers)) {
                $subscribers[] = $email;
                update_option('yoursite_subscribers', $subscribers);
            }
        }
        
        wp_send_json_success(__('Message sent successfully!', 'yoursite'));
    } else {
        wp_send_json_error(__('Failed to send message. Please try again.', 'yoursite'));
    }
}
add_action('wp_ajax_contact_form', 'yoursite_contact_form');
add_action('wp_ajax_nopriv_contact_form', 'yoursite_contact_form');

/**
 * Webinar registration AJAX handler
 */
function yoursite_webinar_registration() {
    // Verify nonce
    if (!wp_verify_nonce($_POST['nonce'], 'webinar_nonce')) {
        wp_send_json_error(__('Security check failed', 'yoursite'));
    }
    
    $webinar_id = intval($_POST['webinar_id']);
    $name = sanitize_text_field($_POST['name']);
    $email = sanitize_email($_POST['email']);
    $company = sanitize_text_field($_POST['company']);
    
    // Validation
    $errors = array();
    
    if (empty($webinar_id)) {
        $errors[] = __('Invalid webinar', 'yoursite');
    }
    
    if (empty($name)) {
        $errors[] = __('Name is required', 'yoursite');
    }
    
    if (empty($email)) {
        $errors[] = __('Email is required', 'yoursite');
    } elseif (!is_email($email)) {
        $errors[] = __('Invalid email address', 'yoursite');
    }
    
    if (!empty($errors)) {
        wp_send_json_error(implode(', ', $errors));
    }
    
    // Get webinar details
    $webinar = get_post($webinar_id);
    if (!$webinar || $webinar->post_type !== 'webinars') {
        wp_send_json_error(__('Webinar not found', 'yoursite'));
    }
    
    // Store registration
    $registrations = get_option('yoursite_webinar_registrations', array());
    $registration_key = $webinar_id . '_' . $email;
    
    if (!isset($registrations[$registration_key])) {
        $registrations[$registration_key] = array(
            'webinar_id' => $webinar_id,
            'webinar_title' => $webinar->post_title,
            'name' => $name,
            'email' => $email,
            'company' => $company,
            'registered_at' => current_time('mysql')
        );
        
        update_option('yoursite_webinar_registrations', $registrations);
        
        // Send confirmation email
        $webinar_date = get_post_meta($webinar_id, '_webinar_date', true);
        $webinar_time = get_post_meta($webinar_id, '_webinar_time', true);
        $webinar_timezone = get_post_meta($webinar_id, '_webinar_timezone', true);
        
        $subject = sprintf(__('Webinar Registration Confirmation: %s', 'yoursite'), $webinar->post_title);
        $message = sprintf(
            '<h3>%s</h3>
            <p>%s %s,</p>
            <p>%s</p>
            <h4>%s</h4>
            <ul>
                <li><strong>%s</strong> %s</li>
                <li><strong>%s</strong> %s</li>
                <li><strong>%s</strong> %s %s</li>
            </ul>
            <p>%s</p>',
            __('Registration Confirmed!', 'yoursite'),
            __('Hi', 'yoursite'), $name,
            sprintf(__('Thank you for registering for "%s". We\'re excited to have you join us!', 'yoursite'), $webinar->post_title),
            __('Webinar Details:', 'yoursite'),
            __('Title:', 'yoursite'), $webinar->post_title,
            __('Date:', 'yoursite'), date('F j, Y', strtotime($webinar_date)),
            __('Time:', 'yoursite'), $webinar_time, $webinar_timezone,
            __('You\'ll receive a reminder email closer to the event date.', 'yoursite')
        );
        
        wp_mail($email, $subject, $message, array('Content-Type: text/html; charset=UTF-8'));
        
        // Notify admin
        wp_mail(
            get_option('admin_email'),
            sprintf(__('New Webinar Registration: %s', 'yoursite'), $webinar->post_title),
            sprintf(__('New registration from %s (%s) for webinar: %s', 'yoursite'), $name, $email, $webinar->post_title),
            array('Content-Type: text/html; charset=UTF-8')
        );
        
        wp_send_json_success(__('Registration successful! Check your email for confirmation.', 'yoursite'));
    } else {
        wp_send_json_error(__('You are already registered for this webinar', 'yoursite'));
    }
}
add_action('wp_ajax_webinar_registration', 'yoursite_webinar_registration');
add_action('wp_ajax_nopriv_webinar_registration', 'yoursite_webinar_registration');

/**
 * Search functionality AJAX handler
 */
function yoursite_live_search() {
    // Verify nonce
    if (!wp_verify_nonce($_POST['nonce'], 'search_nonce')) {
        wp_send_json_error(__('Security check failed', 'yoursite'));
    }
    
    $search_term = sanitize_text_field($_POST['search_term']);
    
    if (strlen($search_term) < 3) {
        wp_send_json_error(__('Search term must be at least 3 characters', 'yoursite'));
    }
    
    $results = array();
    
    // Search posts
    $posts = get_posts(array(
        'post_type' => array('post', 'page', 'features', 'webinars'),
        'post_status' => 'publish',
        's' => $search_term,
        'numberposts' => 10
    ));
    
    foreach ($posts as $post) {
        $results[] = array(
            'title' => $post->post_title,
            'url' => get_permalink($post->ID),
            'excerpt' => wp_trim_words(get_the_excerpt($post->ID), 20),
            'type' => get_post_type($post->ID),
            'date' => get_the_date('', $post->ID)
        );
    }
    
    wp_send_json_success($results);
}
add_action('wp_ajax_live_search', 'yoursite_live_search');
add_action('wp_ajax_nopriv_live_search', 'yoursite_live_search');

/**
 * Demo request AJAX handler
 */
function yoursite_demo_request() {
    // Verify nonce
    if (!wp_verify_nonce($_POST['nonce'], 'demo_nonce')) {
        wp_send_json_error(__('Security check failed', 'yoursite'));
    }
    
    $name = sanitize_text_field($_POST['name']);
    $email = sanitize_email($_POST['email']);
    $company = sanitize_text_field($_POST['company']);
    $phone = sanitize_text_field($_POST['phone']);
    $preferred_time = sanitize_text_field($_POST['preferred_time']);
    $message = sanitize_textarea_field($_POST['message']);
    
    // Validation
    $errors = array();
    
    if (empty($name)) {
        $errors[] = __('Name is required', 'yoursite');
    }
    
    if (empty($email)) {
        $errors[] = __('Email is required', 'yoursite');
    } elseif (!is_email($email)) {
        $errors[] = __('Invalid email address', 'yoursite');
    }
    
    if (empty($company)) {
        $errors[] = __('Company is required', 'yoursite');
    }
    
    if (!empty($errors)) {
        wp_send_json_error(implode(', ', $errors));
    }
    
    // Store demo request
    $demo_requests = get_option('yoursite_demo_requests', array());
    $demo_requests[] = array(
        'name' => $name,
        'email' => $email,
        'company' => $company,
        'phone' => $phone,
        'preferred_time' => $preferred_time,
        'message' => $message,
        'requested_at' => current_time('mysql'),
        'status' => 'pending'
    );
    
    update_option('yoursite_demo_requests', $demo_requests);
    
    // Send confirmation email to user
    $subject = __('Demo Request Received', 'yoursite');
    $user_message = sprintf(
        '<h3>%s</h3>
        <p>%s %s,</p>
        <p>%s</p>
        <p>%s</p>
        <h4>%s</h4>
        <ul>
            <li><strong>%s</strong> %s</li>
            <li><strong>%s</strong> %s</li>
            <li><strong>%s</strong> %s</li>
            <li><strong>%s</strong> %s</li>
        </ul>',
        __('Thank you for your interest!', 'yoursite'),
        __('Hi', 'yoursite'), $name,
        __('We\'ve received your demo request and will be in touch within 24 hours to schedule your personalized demonstration.', 'yoursite'),
        __('Here\'s what we received:', 'yoursite'),
        __('Your Information:', 'yoursite'),
        __('Name:', 'yoursite'), $name,
        __('Company:', 'yoursite'), $company,
        __('Email:', 'yoursite'), $email,
        __('Preferred Time:', 'yoursite'), $preferred_time
    );
    
    wp_mail($email, $subject, $user_message, array('Content-Type: text/html; charset=UTF-8'));
    
    // Send notification to admin
    $admin_subject = sprintf(__('New Demo Request from %s', 'yoursite'), $company);
    $admin_message = sprintf(
        '<h3>%s</h3>
        <p><strong>%s</strong> %s</p>
        <p><strong>%s</strong> %s</p>
        <p><strong>%s</strong> %s</p>
        <p><strong>%s</strong> %s</p>
        <p><strong>%s</strong> %s</p>
        <p><strong>%s</strong></p>
        <p>%s</p>',
        __('New Demo Request', 'yoursite'),
        __('Name:', 'yoursite'), $name,
        __('Company:', 'yoursite'), $company,
        __('Email:', 'yoursite'), $email,
        __('Phone:', 'yoursite'), $phone,
        __('Preferred Time:', 'yoursite'), $preferred_time,
        __('Message:', 'yoursite'),
        $message
    );
    
    wp_mail(get_option('admin_email'), $admin_subject, $admin_message, array('Content-Type: text/html; charset=UTF-8'));
    
    wp_send_json_success(__('Demo request submitted successfully! We\'ll be in touch within 24 hours.', 'yoursite'));
}
add_action('wp_ajax_demo_request', 'yoursite_demo_request');
add_action('wp_ajax_nopriv_demo_request', 'yoursite_demo_request');