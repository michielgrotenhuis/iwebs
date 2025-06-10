<?php
/**
 * Meta boxes for custom fields
 */

if (!defined('ABSPATH')) {
    exit;
}
/**
 * Add careers and partner meta boxes
 */
function yoursite_add_careers_meta_boxes() {
    // Job meta box
    add_meta_box(
        'job-details',
        __('Job Details', 'yoursite'),
        'yoursite_job_meta_box_callback',
        'jobs'
    );
    
    // Partner application meta box
    add_meta_box(
        'partner-details',
        __('Partner Application Details', 'yoursite'),
        'yoursite_partner_meta_box_callback',
        'partner_applications'
    );
}
add_action('add_meta_boxes', 'yoursite_add_careers_meta_boxes');

/**
 * Job meta box callback
 */
function yoursite_job_meta_box_callback($post) {
    wp_nonce_field('save_job_meta', 'job_meta_nonce');
    
    $fields = yoursite_get_job_meta_fields($post->ID);
    
    yoursite_job_meta_box_styles();
    
    echo '<table class="job-meta-table">';
    
    // Basic Job Info
    echo '<tr><td colspan="2"><div class="meta-section"><h4>💼 ' . __('Job Information', 'yoursite') . '</h4></div></td></tr>';
    
    // Salary Range
    echo '<tr>';
    echo '<th><label for="job_salary_min"><strong>' . __('Salary Range', 'yoursite') . '</strong></label></th>';
    echo '<td>';
    echo '<input type="number" id="job_salary_min" name="job_salary_min" value="' . esc_attr($fields['job_salary_min']) . '" placeholder="50000" style="max-width: 120px;" /> - ';
    echo '<input type="number" id="job_salary_max" name="job_salary_max" value="' . esc_attr($fields['job_salary_max']) . '" placeholder="80000" style="max-width: 120px;" />';
    echo '<select id="job_salary_currency" name="job_salary_currency" style="max-width: 100px;">';
    $currencies = array('USD', 'EUR', 'GBP', 'CAD', 'AUD');
    foreach ($currencies as $currency) {
        echo '<option value="' . $currency . '"' . selected($fields['job_salary_currency'], $currency, false) . '>' . $currency . '</option>';
    }
    echo '</select>';
    echo '<p class="description">' . __('Annual salary range', 'yoursite') . '</p>';
    echo '</td>';
    echo '</tr>';
    
    // Experience Level
    echo '<tr>';
    echo '<th><label for="job_experience"><strong>' . __('Experience Level', 'yoursite') . '</strong></label></th>';
    echo '<td>';
    echo '<select id="job_experience" name="job_experience">';
    $experience_levels = array('entry' => 'Entry Level', 'mid' => 'Mid Level', 'senior' => 'Senior Level', 'lead' => 'Lead/Principal', 'executive' => 'Executive');
    foreach ($experience_levels as $key => $label) {
        echo '<option value="' . $key . '"' . selected($fields['job_experience'], $key, false) . '>' . $label . '</option>';
    }
    echo '</select>';
    echo '</td>';
    echo '</tr>';
    
    // Remote Work
    echo '<tr>';
    echo '<th><label for="job_remote"><strong>' . __('Remote Work', 'yoursite') . '</strong></label></th>';
    echo '<td>';
    echo '<select id="job_remote" name="job_remote">';
    echo '<option value="no"' . selected($fields['job_remote'], 'no', false) . '>Office Only</option>';
    echo '<option value="hybrid"' . selected($fields['job_remote'], 'hybrid', false) . '>Hybrid</option>';
    echo '<option value="yes"' . selected($fields['job_remote'], 'yes', false) . '>Fully Remote</option>';
    echo '</select>';
    echo '</td>';
    echo '</tr>';
    
    // Application Details
    echo '<tr><td colspan="2"><div class="meta-section"><h4>📝 ' . __('Application Details', 'yoursite') . '</h4></div></td></tr>';
    
    // Application Email
    echo '<tr>';
    echo '<th><label for="job_application_email"><strong>' . __('Application Email', 'yoursite') . '</strong></label></th>';
    echo '<td>';
    echo '<input type="email" id="job_application_email" name="job_application_email" value="' . esc_attr($fields['job_application_email']) . '" placeholder="jobs@company.com" />';
    echo '<p class="description">' . __('Email where applications should be sent', 'yoursite') . '</p>';
    echo '</td>';
    echo '</tr>';
    
    // Application URL
    echo '<tr>';
    echo '<th><label for="job_application_url"><strong>' . __('Application URL', 'yoursite') . '</strong></label></th>';
    echo '<td>';
    echo '<input type="url" id="job_application_url" name="job_application_url" value="' . esc_attr($fields['job_application_url']) . '" placeholder="https://company.com/apply" />';
    echo '<p class="description">' . __('External application link (optional)', 'yoursite') . '</p>';
    echo '</td>';
    echo '</tr>';
    
    // Requirements
    echo '<tr>';
    echo '<th><label for="job_requirements"><strong>' . __('Requirements', 'yoursite') . '</strong></label></th>';
    echo '<td>';
    echo '<textarea id="job_requirements" name="job_requirements" placeholder="Bachelor\'s degree in Computer Science&#10;3+ years of experience&#10;Strong communication skills">' . esc_textarea($fields['job_requirements']) . '</textarea>';
    echo '<p class="description">' . __('List requirements, one per line', 'yoursite') . '</p>';
    echo '</td>';
    echo '</tr>';
    
    // Benefits
    echo '<tr>';
    echo '<th><label for="job_benefits"><strong>' . __('Benefits', 'yoursite') . '</strong></label></th>';
    echo '<td>';
    echo '<textarea id="job_benefits" name="job_benefits" placeholder="Health insurance&#10;401k matching&#10;Flexible PTO&#10;Remote work options">' . esc_textarea($fields['job_benefits']) . '</textarea>';
    echo '<p class="description">' . __('List benefits, one per line', 'yoursite') . '</p>';
    echo '</td>';
    echo '</tr>';
    
    // Status
    echo '<tr>';
    echo '<th><label for="job_status"><strong>' . __('Status', 'yoursite') . '</strong></label></th>';
    echo '<td>';
    echo '<select id="job_status" name="job_status">';
    echo '<option value="open"' . selected($fields['job_status'], 'open', false) . '>Open</option>';
    echo '<option value="closed"' . selected($fields['job_status'], 'closed', false) . '>Closed</option>';
    echo '<option value="paused"' . selected($fields['job_status'], 'paused', false) . '>Paused</option>';
    echo '</select>';
    echo '</td>';
    echo '</tr>';
    
    echo '</table>';
}

/**
 * Partner meta box callback
 */
function yoursite_partner_meta_box_callback($post) {
    wp_nonce_field('save_partner_meta', 'partner_meta_nonce');
    
    $fields = yoursite_get_partner_meta_fields($post->ID);
    
    echo '<table class="partner-meta-table">';
    
    // Contact Information
    echo '<tr><td colspan="2"><div class="meta-section"><h4>👤 ' . __('Contact Information', 'yoursite') . '</h4></div></td></tr>';
    
    echo '<tr>';
    echo '<th><label for="partner_name"><strong>' . __('Full Name', 'yoursite') . '</strong></label></th>';
    echo '<td><input type="text" id="partner_name" name="partner_name" value="' . esc_attr($fields['partner_name']) . '" /></td>';
    echo '</tr>';
    
    echo '<tr>';
    echo '<th><label for="partner_email"><strong>' . __('Email', 'yoursite') . '</strong></label></th>';
    echo '<td><input type="email" id="partner_email" name="partner_email" value="' . esc_attr($fields['partner_email']) . '" /></td>';
    echo '</tr>';
    
    echo '<tr>';
    echo '<th><label for="partner_phone"><strong>' . __('Phone', 'yoursite') . '</strong></label></th>';
    echo '<td><input type="text" id="partner_phone" name="partner_phone" value="' . esc_attr($fields['partner_phone']) . '" /></td>';
    echo '</tr>';
    
    echo '<tr>';
    echo '<th><label for="partner_company"><strong>' . __('Company Name', 'yoursite') . '</strong></label></th>';
    echo '<td><input type="text" id="partner_company" name="partner_company" value="' . esc_attr($fields['partner_company']) . '" /></td>';
    echo '</tr>';
    
    echo '<tr>';
    echo '<th><label for="partner_website"><strong>' . __('Website', 'yoursite') . '</strong></label></th>';
    echo '<td><input type="url" id="partner_website" name="partner_website" value="' . esc_attr($fields['partner_website']) . '" /></td>';
    echo '</tr>';
    
    // Business Information
    echo '<tr><td colspan="2"><div class="meta-section"><h4>🏢 ' . __('Business Information', 'yoursite') . '</h4></div></td></tr>';
    
    echo '<tr>';
    echo '<th><label for="partner_type"><strong>' . __('Partner Type', 'yoursite') . '</strong></label></th>';
    echo '<td>';
    echo '<select id="partner_type" name="partner_type">';
    $partner_types = array('reseller' => 'Reseller', 'affiliate' => 'Affiliate', 'agency' => 'Agency', 'consultant' => 'Consultant', 'other' => 'Other');
    foreach ($partner_types as $key => $label) {
        echo '<option value="' . $key . '"' . selected($fields['partner_type'], $key, false) . '>' . $label . '</option>';
    }
    echo '</select>';
    echo '</td>';
    echo '</tr>';
    
    echo '<tr>';
    echo '<th><label for="partner_experience"><strong>' . __('Years of Experience', 'yoursite') . '</strong></label></th>';
    echo '<td>';
    echo '<select id="partner_experience" name="partner_experience">';
    echo '<option value="0-1"' . selected($fields['partner_experience'], '0-1', false) . '>0-1 years</option>';
    echo '<option value="2-5"' . selected($fields['partner_experience'], '2-5', false) . '>2-5 years</option>';
    echo '<option value="6-10"' . selected($fields['partner_experience'], '6-10', false) . '>6-10 years</option>';
    echo '<option value="10+"' . selected($fields['partner_experience'], '10+', false) . '>10+ years</option>';
    echo '</select>';
    echo '</td>';
    echo '</tr>';
    
    echo '<tr>';
    echo '<th><label for="partner_clients"><strong>' . __('Number of Clients', 'yoursite') . '</strong></label></th>';
    echo '<td><input type="number" id="partner_clients" name="partner_clients" value="' . esc_attr($fields['partner_clients']) . '" /></td>';
    echo '</tr>';
    
    echo '<tr>';
    echo '<th><label for="partner_revenue"><strong>' . __('Annual Revenue', 'yoursite') . '</strong></label></th>';
    echo '<td>';
    echo '<select id="partner_revenue" name="partner_revenue">';
    echo '<option value="0-50k"' . selected($fields['partner_revenue'], '0-50k', false) . '>$0 - $50k</option>';
    echo '<option value="50k-100k"' . selected($fields['partner_revenue'], '50k-100k', false) . '>$50k - $100k</option>';
    echo '<option value="100k-500k"' . selected($fields['partner_revenue'], '100k-500k', false) . '>$100k - $500k</option>';
    echo '<option value="500k+"' . selected($fields['partner_revenue'], '500k+', false) . '>$500k+</option>';
    echo '</select>';
    echo '</td>';
    echo '</tr>';
    
    echo '<tr>';
    echo '<th><label for="partner_message"><strong>' . __('Message', 'yoursite') . '</strong></label></th>';
    echo '<td><textarea id="partner_message" name="partner_message" rows="5">' . esc_textarea($fields['partner_message']) . '</textarea></td>';
    echo '</tr>';
    
    // Application Status
    echo '<tr><td colspan="2"><div class="meta-section"><h4>📋 ' . __('Application Status', 'yoursite') . '</h4></div></td></tr>';
    
    echo '<tr>';
    echo '<th><label for="partner_status"><strong>' . __('Status', 'yoursite') . '</strong></label></th>';
    echo '<td>';
    echo '<select id="partner_status" name="partner_status">';
    echo '<option value="pending"' . selected($fields['partner_status'], 'pending', false) . '>Pending Review</option>';
    echo '<option value="approved"' . selected($fields['partner_status'], 'approved', false) . '>Approved</option>';
    echo '<option value="rejected"' . selected($fields['partner_status'], 'rejected', false) . '>Rejected</option>';
    echo '<option value="onboarding"' . selected($fields['partner_status'], 'onboarding', false) . '>Onboarding</option>';
    echo '</select>';
    echo '</td>';
    echo '</tr>';
    
    echo '<tr>';
    echo '<th><label for="partner_notes"><strong>' . __('Internal Notes', 'yoursite') . '</strong></label></th>';
    echo '<td><textarea id="partner_notes" name="partner_notes" rows="3">' . esc_textarea($fields['partner_notes']) . '</textarea></td>';
    echo '</tr>';
    
    echo '</table>';
}

/**
 * Save job meta
 */
function yoursite_save_job_meta($post_id) {
    if (!yoursite_verify_meta_nonce('job_meta_nonce', 'save_job_meta')) {
        return;
    }
    
    if (!current_user_can('edit_post', $post_id)) {
        return;
    }
    
    $fields = array(
        'job_salary_min' => 'intval',
        'job_salary_max' => 'intval',
        'job_salary_currency' => 'sanitize_text_field',
        'job_experience' => 'sanitize_text_field',
        'job_remote' => 'sanitize_text_field',
        'job_application_email' => 'sanitize_email',
        'job_application_url' => 'esc_url_raw',
        'job_requirements' => 'sanitize_textarea_field',
        'job_benefits' => 'sanitize_textarea_field',
        'job_status' => 'sanitize_text_field'
    );
    
    foreach ($fields as $field => $sanitize_function) {
        if (isset($_POST[$field])) {
            $value = $sanitize_function($_POST[$field]);
            update_post_meta($post_id, '_' . $field, $value);
        }
    }
}
add_action('save_post', 'yoursite_save_job_meta');

/**
 * Save partner meta
 */
function yoursite_save_partner_meta($post_id) {
    if (!yoursite_verify_meta_nonce('partner_meta_nonce', 'save_partner_meta')) {
        return;
    }
    
    if (!current_user_can('edit_post', $post_id)) {
        return;
    }
    
    $fields = array(
        'partner_name' => 'sanitize_text_field',
        'partner_email' => 'sanitize_email',
        'partner_phone' => 'sanitize_text_field',
        'partner_company' => 'sanitize_text_field',
        'partner_website' => 'esc_url_raw',
        'partner_type' => 'sanitize_text_field',
        'partner_experience' => 'sanitize_text_field',
        'partner_clients' => 'intval',
        'partner_revenue' => 'sanitize_text_field',
        'partner_message' => 'sanitize_textarea_field',
        'partner_status' => 'sanitize_text_field',
        'partner_notes' => 'sanitize_textarea_field'
    );
    
    foreach ($fields as $field => $sanitize_function) {
        if (isset($_POST[$field])) {
            $value = $sanitize_function($_POST[$field]);
            update_post_meta($post_id, '_' . $field, $value);
        }
    }
}
add_action('save_post', 'yoursite_save_partner_meta');

/**
 * Get job meta fields
 */
function yoursite_get_job_meta_fields($post_id) {
    return array(
        'job_salary_min' => get_post_meta($post_id, '_job_salary_min', true),
        'job_salary_max' => get_post_meta($post_id, '_job_salary_max', true),
        'job_salary_currency' => get_post_meta($post_id, '_job_salary_currency', true) ?: 'USD',
        'job_experience' => get_post_meta($post_id, '_job_experience', true) ?: 'mid',
        'job_remote' => get_post_meta($post_id, '_job_remote', true) ?: 'no',
        'job_application_email' => get_post_meta($post_id, '_job_application_email', true),
        'job_application_url' => get_post_meta($post_id, '_job_application_url', true),
        'job_requirements' => get_post_meta($post_id, '_job_requirements', true),
        'job_benefits' => get_post_meta($post_id, '_job_benefits', true),
        'job_status' => get_post_meta($post_id, '_job_status', true) ?: 'open'
    );
}

/**
 * Get partner meta fields
 */
function yoursite_get_partner_meta_fields($post_id) {
    return array(
        'partner_name' => get_post_meta($post_id, '_partner_name', true),
        'partner_email' => get_post_meta($post_id, '_partner_email', true),
        'partner_phone' => get_post_meta($post_id, '_partner_phone', true),
        'partner_company' => get_post_meta($post_id, '_partner_company', true),
        'partner_website' => get_post_meta($post_id, '_partner_website', true),
        'partner_type' => get_post_meta($post_id, '_partner_type', true) ?: 'reseller',
        'partner_experience' => get_post_meta($post_id, '_partner_experience', true) ?: '2-5',
        'partner_clients' => get_post_meta($post_id, '_partner_clients', true),
        'partner_revenue' => get_post_meta($post_id, '_partner_revenue', true) ?: '0-50k',
        'partner_message' => get_post_meta($post_id, '_partner_message', true),
        'partner_status' => get_post_meta($post_id, '_partner_status', true) ?: 'pending',
        'partner_notes' => get_post_meta($post_id, '_partner_notes', true)
    );
}

/**
 * Job meta box styles
 */
function yoursite_job_meta_box_styles() {
    echo '<style>
        .job-meta-table, .partner-meta-table { width: 100%; }
        .job-meta-table th, .partner-meta-table th { text-align: left; padding: 15px 10px 15px 0; width: 150px; vertical-align: top; }
        .job-meta-table td, .partner-meta-table td { padding: 15px 0; }
        .job-meta-table input[type="text"], .job-meta-table input[type="number"], .job-meta-table input[type="email"], .job-meta-table input[type="url"], .job-meta-table select,
        .partner-meta-table input[type="text"], .partner-meta-table input[type="number"], .partner-meta-table input[type="email"], .partner-meta-table input[type="url"], .partner-meta-table select 
        { width: 100%; max-width: 400px; }
        .job-meta-table textarea, .partner-meta-table textarea { width: 100%; max-width: 600px; height: 80px; }
        .job-meta-table .description, .partner-meta-table .description { font-style: italic; color: #666; margin-top: 5px; }
        .meta-section { background: #f9f9f9; padding: 15px; margin: 20px 0; border-radius: 5px; }
        .meta-section h4 { margin-top: 0; color: #333; }
    </style>';
}

/**
 * Add integration meta boxes
 */
function yoursite_add_integration_meta_boxes() {
    add_meta_box(
        'integration-details',
        __('Integration Details', 'yoursite'),
        'yoursite_integration_meta_box_callback',
        'integrations'
    );
}
add_action('add_meta_boxes', 'yoursite_add_integration_meta_boxes');

/**
 * Integration meta box callback
 */
function yoursite_integration_meta_box_callback($post) {
    wp_nonce_field('save_integration_meta', 'integration_meta_nonce');
    
    $fields = yoursite_get_integration_meta_fields($post->ID);
    
    yoursite_integration_meta_box_styles();
    
    echo '<table class="integration-meta-table">';
    
    // Basic Info Section
    echo '<tr><td colspan="2"><div class="integration-section"><h4>🔌 ' . __('Basic Information', 'yoursite') . '</h4></div></td></tr>';
    
    // Icon/Logo
    echo '<tr>';
    echo '<th><label for="integration_icon"><strong>' . __('Icon Text', 'yoursite') . '</strong></label></th>';
    echo '<td>';
    echo '<input type="text" id="integration_icon" name="integration_icon" value="' . esc_attr($fields['integration_icon']) . '" placeholder="M" maxlength="5" style="max-width: 100px;" />';
    echo '<p class="description">' . __('Short text to display as icon (1-3 characters)', 'yoursite') . '</p>';
    echo '</td>';
    echo '</tr>';
    
    // Color
    echo '<tr>';
    echo '<th><label for="integration_color"><strong>' . __('Color', 'yoursite') . '</strong></label></th>';
    echo '<td>';
    echo '<select id="integration_color" name="integration_color">';
    $colors = array('blue', 'purple', 'green', 'red', 'yellow', 'pink', 'orange', 'gray');
    foreach ($colors as $color) {
        echo '<option value="' . $color . '"' . selected($fields['integration_color'], $color, false) . '>' . ucfirst($color) . '</option>';
    }
    echo '</select>';
    echo '</td>';
    echo '</tr>';
    
    // Website URL
    echo '<tr>';
    echo '<th><label for="integration_website"><strong>' . __('Website URL', 'yoursite') . '</strong></label></th>';
    echo '<td>';
    echo '<input type="url" id="integration_website" name="integration_website" value="' . esc_attr($fields['integration_website']) . '" placeholder="https://example.com" />';
    echo '<p class="description">' . __('Official website of the integration', 'yoursite') . '</p>';
    echo '</td>';
    echo '</tr>';
    
    // Setup Guide URL
    echo '<tr>';
    echo '<th><label for="integration_setup_url"><strong>' . __('Setup Guide URL', 'yoursite') . '</strong></label></th>';
    echo '<td>';
    echo '<input type="url" id="integration_setup_url" name="integration_setup_url" value="' . esc_attr($fields['integration_setup_url']) . '" placeholder="https://docs.example.com/setup" />';
    echo '<p class="description">' . __('Link to setup documentation', 'yoursite') . '</p>';
    echo '</td>';
    echo '</tr>';
    
    // Status Section
    echo '<tr><td colspan="2"><div class="integration-section"><h4>📊 ' . __('Status & Availability', 'yoursite') . '</h4></div></td></tr>';
    
    // Status
    echo '<tr>';
    echo '<th><label for="integration_status"><strong>' . __('Status', 'yoursite') . '</strong></label></th>';
    echo '<td>';
    echo '<select id="integration_status" name="integration_status">';
    echo '<option value="available"' . selected($fields['integration_status'], 'available', false) . '>' . __('Available', 'yoursite') . '</option>';
    echo '<option value="coming_soon"' . selected($fields['integration_status'], 'coming_soon', false) . '>' . __('Coming Soon', 'yoursite') . '</option>';
    echo '<option value="beta"' . selected($fields['integration_status'], 'beta', false) . '>' . __('Beta', 'yoursite') . '</option>';
    echo '<option value="deprecated"' . selected($fields['integration_status'], 'deprecated', false) . '>' . __('Deprecated', 'yoursite') . '</option>';
    echo '</select>';
    echo '</td>';
    echo '</tr>';
    
    // Popularity Score
    echo '<tr>';
    echo '<th><label for="integration_popularity"><strong>' . __('Popularity Score', 'yoursite') . '</strong></label></th>';
    echo '<td>';
    echo '<input type="number" id="integration_popularity" name="integration_popularity" value="' . esc_attr($fields['integration_popularity']) . '" min="1" max="5" step="0.1" placeholder="4.5" style="max-width: 100px;" />';
    echo '<p class="description">' . __('Rating out of 5 (e.g., 4.5)', 'yoursite') . '</p>';
    echo '</td>';
    echo '</tr>';
    
    // Features Section
    echo '<tr><td colspan="2"><div class="integration-section"><h4>✨ ' . __('Features & Details', 'yoursite') . '</h4></div></td></tr>';
    
    // Key Features
    echo '<tr>';
    echo '<th><label for="integration_features"><strong>' . __('Key Features', 'yoursite') . '</strong></label></th>';
    echo '<td>';
    echo '<textarea id="integration_features" name="integration_features" placeholder="Accept multiple payment methods&#10;Real-time transaction processing&#10;Advanced fraud protection">' . esc_textarea($fields['integration_features']) . '</textarea>';
    echo '<p class="description">' . __('List key features, one per line', 'yoursite') . '</p>';
    echo '</td>';
    echo '</tr>';
    
    // Supported Countries
    echo '<tr>';
    echo '<th><label for="integration_countries"><strong>' . __('Supported Countries', 'yoursite') . '</strong></label></th>';
    echo '<td>';
    echo '<input type="text" id="integration_countries" name="integration_countries" value="' . esc_attr($fields['integration_countries']) . '" placeholder="Global, US, EU, etc." />';
    echo '<p class="description">' . __('Countries where this integration is available', 'yoursite') . '</p>';
    echo '</td>';
    echo '</tr>';
    
    // Pricing Info
    echo '<tr>';
    echo '<th><label for="integration_pricing"><strong>' . __('Pricing Info', 'yoursite') . '</strong></label></th>';
    echo '<td>';
    echo '<input type="text" id="integration_pricing" name="integration_pricing" value="' . esc_attr($fields['integration_pricing']) . '" placeholder="2.9% + 30¢ per transaction" />';
    echo '<p class="description">' . __('Brief pricing information', 'yoursite') . '</p>';
    echo '</td>';
    echo '</tr>';
    
    echo '</table>';
}

/**
 * Save integration meta
 */
function yoursite_save_integration_meta($post_id) {
    if (!yoursite_verify_meta_nonce('integration_meta_nonce', 'save_integration_meta')) {
        return;
    }
    
    if (!current_user_can('edit_post', $post_id)) {
        return;
    }
    
    $fields = array(
        'integration_icon' => 'sanitize_text_field',
        'integration_color' => 'sanitize_text_field',
        'integration_website' => 'esc_url_raw',
        'integration_setup_url' => 'esc_url_raw',
        'integration_status' => 'sanitize_text_field',
        'integration_popularity' => 'floatval',
        'integration_features' => 'sanitize_textarea_field',
        'integration_countries' => 'sanitize_text_field',
        'integration_pricing' => 'sanitize_text_field'
    );
    
    foreach ($fields as $field => $sanitize_function) {
        if (isset($_POST[$field])) {
            $value = $sanitize_function($_POST[$field]);
            update_post_meta($post_id, '_' . $field, $value);
        }
    }
}
add_action('save_post', 'yoursite_save_integration_meta');

/**
 * Get integration meta fields
 */
function yoursite_get_integration_meta_fields($post_id) {
    return array(
        'integration_icon' => get_post_meta($post_id, '_integration_icon', true),
        'integration_color' => get_post_meta($post_id, '_integration_color', true) ?: 'blue',
        'integration_website' => get_post_meta($post_id, '_integration_website', true),
        'integration_setup_url' => get_post_meta($post_id, '_integration_setup_url', true),
        'integration_status' => get_post_meta($post_id, '_integration_status', true) ?: 'available',
        'integration_popularity' => get_post_meta($post_id, '_integration_popularity', true) ?: '4.5',
        'integration_features' => get_post_meta($post_id, '_integration_features', true),
        'integration_countries' => get_post_meta($post_id, '_integration_countries', true),
        'integration_pricing' => get_post_meta($post_id, '_integration_pricing', true)
    );
}

/**
 * Integration meta box styles
 */
function yoursite_integration_meta_box_styles() {
    echo '<style>
        .integration-meta-table { width: 100%; }
        .integration-meta-table th { text-align: left; padding: 15px 10px 15px 0; width: 150px; vertical-align: top; }
        .integration-meta-table td { padding: 15px 0; }
        .integration-meta-table input[type="text"], 
        .integration-meta-table input[type="number"], 
        .integration-meta-table input[type="url"], 
        .integration-meta-table select { width: 100%; max-width: 400px; }
        .integration-meta-table textarea { width: 100%; max-width: 600px; height: 80px; }
        .integration-meta-table .description { font-style: italic; color: #666; margin-top: 5px; }
        .integration-section { background: #f9f9f9; padding: 15px; margin: 20px 0; border-radius: 5px; }
        .integration-section h4 { margin-top: 0; color: #333; }
    </style>';
}
/**
 * Add custom meta boxes
 */
function yoursite_add_meta_boxes() {
    // Pricing meta box
    add_meta_box(
        'pricing-details',
        __('Pricing Details', 'yoursite'),
        'yoursite_pricing_meta_box_callback',
        'pricing'
    );
    
    // Webinar meta box
    add_meta_box(
        'webinar-details',
        __('Webinar Details', 'yoursite'),
        'yoursite_webinar_meta_box_callback',
        'webinars'
    );
}
add_action('add_meta_boxes', 'yoursite_add_meta_boxes');

/**
 * Pricing meta box callback
 */
function yoursite_pricing_meta_box_callback($post) {
    wp_nonce_field('save_pricing_meta', 'pricing_meta_nonce');
    
    $price = get_post_meta($post->ID, '_pricing_price', true);
    $period = get_post_meta($post->ID, '_pricing_period', true);
    $features = get_post_meta($post->ID, '_pricing_features', true);
    $featured = get_post_meta($post->ID, '_pricing_featured', true);
    $purchase_url = get_post_meta($post->ID, '_pricing_purchase_url', true);
    $button_text = get_post_meta($post->ID, '_pricing_button_text', true);
    $base_currency = get_post_meta($post->ID, '_pricing_base_currency', true);
    if (!$base_currency) $base_currency = 'USD';
    
    yoursite_pricing_meta_box_styles();
    
    echo '<table class="pricing-meta-table">';
    
    // Price field
    echo '<tr>';
    echo '<th><label for="pricing_price"><strong>' . __('Price', 'yoursite') . '</strong></label></th>';
    echo '<td>';
    echo '<div style="display: flex; gap: 10px;">';
    echo '<input type="number" id="pricing_price" name="pricing_price" value="' . esc_attr($price) . '" step="0.01" placeholder="19.99" style="max-width: 200px;" />';
    echo '<select id="pricing_base_currency" name="pricing_base_currency" style="max-width: 100px;">';
    
    $currencies = yoursite_get_currencies();
    foreach ($currencies as $code => $label) {
        echo '<option value="' . $code . '"' . selected($base_currency, $code, false) . '>' . $label . '</option>';
    }
    
    echo '</select>';
    echo '</div>';
    echo '<p class="description">' . __('Enter the base price and currency. Other currencies will be calculated automatically.', 'yoursite') . '</p>';
    echo '</td>';
    echo '</tr>';
    
    // Period field
    echo '<tr>';
    echo '<th><label for="pricing_period"><strong>' . __('Billing Period', 'yoursite') . '</strong></label></th>';
    echo '<td>';
    echo '<select id="pricing_period" name="pricing_period">';
    echo '<option value="month"' . selected($period, 'month', false) . '>' . __('Monthly', 'yoursite') . '</option>';
    echo '<option value="year"' . selected($period, 'year', false) . '>' . __('Yearly', 'yoursite') . '</option>';
    echo '</select>';
    echo '</td>';
    echo '</tr>';
    
    // Purchase URL field
    echo '<tr>';
    echo '<th><label for="pricing_purchase_url"><strong>' . __('Purchase URL', 'yoursite') . '</strong></label></th>';
    echo '<td>';
    echo '<input type="url" id="pricing_purchase_url" name="pricing_purchase_url" value="' . esc_attr($purchase_url) . '" placeholder="https://checkout.stripe.com/your-link" />';
    echo '<p class="description">' . __('The complete URL where customers will be redirected to purchase this plan', 'yoursite') . '</p>';
    echo '</td>';
    echo '</tr>';
    
    // Button text field
    echo '<tr>';
    echo '<th><label for="pricing_button_text"><strong>' . __('Button Text', 'yoursite') . '</strong></label></th>';
    echo '<td>';
    echo '<input type="text" id="pricing_button_text" name="pricing_button_text" value="' . esc_attr($button_text) . '" placeholder="Get Started" />';
    echo '<p class="description">' . __('Text that will appear on the purchase button', 'yoursite') . '</p>';
    echo '</td>';
    echo '</tr>';
    
    // Features field
    echo '<tr>';
    echo '<th><label for="pricing_features"><strong>' . __('Features List', 'yoursite') . '</strong></label></th>';
    echo '<td>';
    echo '<textarea id="pricing_features" name="pricing_features" placeholder="Up to 1,000 products&#10;Free SSL certificate&#10;24/7 support&#10;Mobile responsive">' . esc_textarea($features) . '</textarea>';
    echo '<p class="description">' . __('List each feature on a separate line. These will appear as bullet points with checkmarks.', 'yoursite') . '</p>';
    echo '</td>';
    echo '</tr>';
    
    // Featured field
    echo '<tr>';
    echo '<th><strong>' . __('Featured Plan', 'yoursite') . '</strong></th>';
    echo '<td>';
    echo '<label for="pricing_featured">';
    echo '<input type="checkbox" id="pricing_featured" name="pricing_featured" value="1"' . checked($featured, 1, false) . ' /> ';
    echo __('Mark this as the featured/popular plan (will show "Most Popular" badge)', 'yoursite') . '</label>';
    echo '</td>';
    echo '</tr>';
    
    echo '</table>';
}

/**
 * Webinar meta box callback
 */
function yoursite_webinar_meta_box_callback($post) {
    wp_nonce_field('save_webinar_meta', 'webinar_meta_nonce');
    
    $fields = yoursite_get_webinar_meta_fields($post->ID);
    
    yoursite_webinar_meta_box_styles();
    
    echo '<table class="webinar-meta-table">';
    
    // Basic Information Section
    echo '<tr><td colspan="2"><div class="webinar-section"><h4>📅 ' . __('Basic Information', 'yoursite') . '</h4></div></td></tr>';
    
    yoursite_render_webinar_basic_fields($fields);
    
    // Speaker Information Section
    echo '<tr><td colspan="2"><div class="webinar-section"><h4>👤 ' . __('Speaker Information', 'yoursite') . '</h4></div></td></tr>';
    
    yoursite_render_webinar_speaker_fields($fields);
    
    // Registration & Links Section
    echo '<tr><td colspan="2"><div class="webinar-section"><h4>🔗 ' . __('Registration & Links', 'yoursite') . '</h4></div></td></tr>';
    
    yoursite_render_webinar_link_fields($fields);
    
    // Additional Options Section
    echo '<tr><td colspan="2"><div class="webinar-section"><h4>⚙️ ' . __('Additional Options', 'yoursite') . '</h4></div></td></tr>';
    
    yoursite_render_webinar_additional_fields($fields);
    
    echo '</table>';
}

/**
 * Save pricing meta
 */
function yoursite_save_pricing_meta($post_id) {
    if (!yoursite_verify_meta_nonce('pricing_meta_nonce', 'save_pricing_meta')) {
        return;
    }
    
    if (!current_user_can('edit_post', $post_id)) {
        return;
    }
    
    $fields = array(
        'pricing_price' => 'floatval',
        'pricing_period' => 'sanitize_text_field',
        'pricing_purchase_url' => 'esc_url_raw',
        'pricing_button_text' => 'sanitize_text_field',
        'pricing_base_currency' => 'sanitize_text_field',
        'pricing_features' => 'sanitize_textarea_field'
    );
    
    foreach ($fields as $field => $sanitize_function) {
        if (isset($_POST[$field])) {
            $value = $sanitize_function($_POST[$field]);
            update_post_meta($post_id, '_' . $field, $value);
        }
    }
    
    // Save Featured Status
    $featured = isset($_POST['pricing_featured']) && $_POST['pricing_featured'] == '1' ? 1 : 0;
    update_post_meta($post_id, '_pricing_featured', $featured);
}
add_action('save_post', 'yoursite_save_pricing_meta');

/**
 * Save webinar meta
 */
function yoursite_save_webinar_meta($post_id) {
    if (!yoursite_verify_meta_nonce('webinar_meta_nonce', 'save_webinar_meta')) {
        return;
    }
    
    if (!current_user_can('edit_post', $post_id)) {
        return;
    }
    
    $fields = array(
        'webinar_date' => 'sanitize_text_field',
        'webinar_time' => 'sanitize_text_field',
        'webinar_timezone' => 'sanitize_text_field',
        'webinar_duration' => 'sanitize_text_field',
        'webinar_speaker' => 'sanitize_text_field',
        'webinar_speaker_bio' => 'sanitize_textarea_field',
        'webinar_register_url' => 'esc_url_raw',
        'webinar_recording_url' => 'esc_url_raw',
        'webinar_price' => 'sanitize_text_field',
        'webinar_max_attendees' => 'intval',
        'webinar_status' => 'sanitize_text_field',
        'webinar_platform' => 'sanitize_text_field'
    );
    
    foreach ($fields as $field => $sanitize_function) {
        if (isset($_POST[$field])) {
            $value = $sanitize_function($_POST[$field]);
            update_post_meta($post_id, '_' . $field, $value);
        }
    }
}
add_action('save_post', 'yoursite_save_webinar_meta');

/**
 * Helper functions for meta boxes
 */

/**
 * Verify meta nonce
 */
function yoursite_verify_meta_nonce($nonce_field, $nonce_action) {
    if (!isset($_POST[$nonce_field]) || !wp_verify_nonce($_POST[$nonce_field], $nonce_action)) {
        return false;
    }
    
    if (defined('DOING_AUTOSAVE') && DOING_AUTOSAVE) {
        return false;
    }
    
    return true;
}

/**
 * Get currencies array
 */
function yoursite_get_currencies() {
    return array(
        'USD' => '$ USD',
        'EUR' => '€ EUR', 
        'GBP' => '£ GBP',
        'CAD' => '$ CAD',
        'AUD' => '$ AUD',
        'JPY' => '¥ JPY',
        'CHF' => 'CHF',
        'SEK' => 'kr SEK',
        'NOK' => 'kr NOK',
        'DKK' => 'kr DKK'
    );
}

/**
 * Get webinar meta fields
 */
function yoursite_get_webinar_meta_fields($post_id) {
    $fields = array(
        'webinar_date' => get_post_meta($post_id, '_webinar_date', true),
        'webinar_time' => get_post_meta($post_id, '_webinar_time', true),
        'webinar_timezone' => get_post_meta($post_id, '_webinar_timezone', true) ?: 'EST',
        'webinar_duration' => get_post_meta($post_id, '_webinar_duration', true),
        'webinar_speaker' => get_post_meta($post_id, '_webinar_speaker', true),
        'webinar_speaker_bio' => get_post_meta($post_id, '_webinar_speaker_bio', true),
        'webinar_register_url' => get_post_meta($post_id, '_webinar_register_url', true),
        'webinar_recording_url' => get_post_meta($post_id, '_webinar_recording_url', true),
        'webinar_price' => get_post_meta($post_id, '_webinar_price', true),
        'webinar_max_attendees' => get_post_meta($post_id, '_webinar_max_attendees', true),
        'webinar_status' => get_post_meta($post_id, '_webinar_status', true) ?: 'upcoming',
        'webinar_platform' => get_post_meta($post_id, '_webinar_platform', true) ?: 'zoom'
    );
    
    return $fields;
}

/**
 * Pricing meta box styles
 */
function yoursite_pricing_meta_box_styles() {
    echo '<style>
        .pricing-meta-table { width: 100%; }
        .pricing-meta-table th { text-align: left; padding: 15px 10px 15px 0; width: 150px; vertical-align: top; }
        .pricing-meta-table td { padding: 15px 0; }
        .pricing-meta-table input[type="text"], 
        .pricing-meta-table input[type="number"], 
        .pricing-meta-table input[type="url"], 
        .pricing-meta-table select { width: 100%; max-width: 400px; }
        .pricing-meta-table textarea { width: 100%; max-width: 600px; height: 120px; }
        .pricing-meta-table .description { font-style: italic; color: #666; margin-top: 5px; }
    </style>';
}

/**
 * Webinar meta box styles
 */
function yoursite_webinar_meta_box_styles() {
    echo '<style>
        .webinar-meta-table { width: 100%; }
        .webinar-meta-table th { text-align: left; padding: 15px 10px 15px 0; width: 150px; vertical-align: top; }
        .webinar-meta-table td { padding: 15px 0; }
        .webinar-meta-table input[type="text"], 
        .webinar-meta-table input[type="number"], 
        .webinar-meta-table input[type="url"], 
        .webinar-meta-table input[type="date"],
        .webinar-meta-table select { width: 100%; max-width: 400px; }
        .webinar-meta-table textarea { width: 100%; max-width: 600px; height: 80px; }
        .webinar-meta-table .description { font-style: italic; color: #666; margin-top: 5px; }
        .webinar-section { background: #f9f9f9; padding: 15px; margin: 20px 0; border-radius: 5px; }
        .webinar-section h4 { margin-top: 0; color: #333; }
    </style>';
}
/**
 * Case Study Meta Boxes
 * Add this to your inc/meta-boxes.php file
 */

/**
 * Add case study meta boxes
 */
function yoursite_add_case_study_meta_boxes() {
    add_meta_box(
        'case-study-details',
        __('Case Study Details', 'yoursite'),
        'yoursite_case_study_meta_box_callback',
        'case_studies'
    );
}
add_action('add_meta_boxes', 'yoursite_add_case_study_meta_boxes');

/**
 * Case study meta box callback
 */
function yoursite_case_study_meta_box_callback($post) {
    wp_nonce_field('save_case_study_meta', 'case_study_meta_nonce');
    
    $fields = yoursite_get_case_study_meta_fields($post->ID);
    
    yoursite_case_study_meta_box_styles();
    
    echo '<table class="case-study-meta-table">';
    
    // Client Information Section
    echo '<tr><td colspan="2"><div class="meta-section"><h4>🏢 ' . __('Client Information', 'yoursite') . '</h4></div></td></tr>';
    
    // Client Name
    echo '<tr>';
    echo '<th><label for="case_study_client"><strong>' . __('Client Name', 'yoursite') . '</strong></label></th>';
    echo '<td>';
    echo '<input type="text" id="case_study_client" name="case_study_client" value="' . esc_attr($fields['case_study_client']) . '" placeholder="Acme Corporation" />';
    echo '<p class="description">' . __('The name of the client company', 'yoursite') . '</p>';
    echo '</td>';
    echo '</tr>';
    
    // Industry
    echo '<tr>';
    echo '<th><label for="case_study_industry_text"><strong>' . __('Industry', 'yoursite') . '</strong></label></th>';
    echo '<td>';
    echo '<input type="text" id="case_study_industry_text" name="case_study_industry_text" value="' . esc_attr($fields['case_study_industry_text']) . '" placeholder="E-commerce, Healthcare, etc." />';
    echo '<p class="description">' . __('Industry or sector the client operates in', 'yoursite') . '</p>';
    echo '</td>';
    echo '</tr>';
    
    // Website URL
    echo '<tr>';
    echo '<th><label for="case_study_website"><strong>' . __('Client Website', 'yoursite') . '</strong></label></th>';
    echo '<td>';
    echo '<input type="url" id="case_study_website" name="case_study_website" value="' . esc_attr($fields['case_study_website']) . '" placeholder="https://example.com" />';
    echo '<p class="description">' . __('Link to the client\'s website', 'yoursite') . '</p>';
    echo '</td>';
    echo '</tr>';
    
    // Project Details Section
    echo '<tr><td colspan="2"><div class="meta-section"><h4>📊 ' . __('Project Details', 'yoursite') . '</h4></div></td></tr>';
    
    // Project Duration
    echo '<tr>';
    echo '<th><label for="case_study_duration"><strong>' . __('Project Duration', 'yoursite') . '</strong></label></th>';
    echo '<td>';
    echo '<input type="text" id="case_study_duration" name="case_study_duration" value="' . esc_attr($fields['case_study_duration']) . '" placeholder="3 months" />';
    echo '<p class="description">' . __('How long the project took to complete', 'yoursite') . '</p>';
    echo '</td>';
    echo '</tr>';
    
    // Technologies Used
    echo '<tr>';
    echo '<th><label for="case_study_technologies"><strong>' . __('Technologies Used', 'yoursite') . '</strong></label></th>';
    echo '<td>';
    echo '<textarea id="case_study_technologies" name="case_study_technologies" placeholder="WordPress, WooCommerce, React, Custom API">' . esc_textarea($fields['case_study_technologies']) . '</textarea>';
    echo '<p class="description">' . __('List technologies, platforms, or tools used', 'yoursite') . '</p>';
    echo '</td>';
    echo '</tr>';
    
    // Challenge Section
    echo '<tr><td colspan="2"><div class="meta-section"><h4>🎯 ' . __('Project Breakdown', 'yoursite') . '</h4></div></td></tr>';
    
    // Challenge
    echo '<tr>';
    echo '<th><label for="case_study_challenge"><strong>' . __('The Challenge', 'yoursite') . '</strong></label></th>';
    echo '<td>';
    echo '<textarea id="case_study_challenge" name="case_study_challenge" rows="4" placeholder="Describe the main challenges the client was facing...">' . esc_textarea($fields['case_study_challenge']) . '</textarea>';
    echo '<p class="description">' . __('What problems did the client need to solve?', 'yoursite') . '</p>';
    echo '</td>';
    echo '</tr>';
    
    // Solution
    echo '<tr>';
    echo '<th><label for="case_study_solution"><strong>' . __('Our Solution', 'yoursite') . '</strong></label></th>';
    echo '<td>';
    echo '<textarea id="case_study_solution" name="case_study_solution" rows="4" placeholder="Explain how you addressed the challenges...">' . esc_textarea($fields['case_study_solution']) . '</textarea>';
    echo '<p class="description">' . __('How did you solve the client\'s problems?', 'yoursite') . '</p>';
    echo '</td>';
    echo '</tr>';
    
    // Results
    echo '<tr>';
    echo '<th><label for="case_study_results"><strong>' . __('Results & Impact', 'yoursite') . '</strong></label></th>';
    echo '<td>';
    echo '<textarea id="case_study_results" name="case_study_results" rows="4" placeholder="Quantify the results and impact of your work...">' . esc_textarea($fields['case_study_results']) . '</textarea>';
    echo '<p class="description">' . __('What were the measurable outcomes?', 'yoursite') . '</p>';
    echo '</td>';
    echo '</tr>';
    
    // Key Metrics Section
    echo '<tr><td colspan="2"><div class="meta-section"><h4>📈 ' . __('Key Metrics', 'yoursite') . '</h4></div></td></tr>';
    
    // Metric 1
    echo '<tr>';
    echo '<th><label for="case_study_metric_1_label"><strong>' . __('Metric 1', 'yoursite') . '</strong></label></th>';
    echo '<td>';
    echo '<div style="display: flex; gap: 10px; align-items: center;">';
    echo '<input type="text" id="case_study_metric_1_label" name="case_study_metric_1_label" value="' . esc_attr($fields['case_study_metric_1_label']) . '" placeholder="Revenue Increase" style="flex: 1;" />';
    echo '<input type="text" id="case_study_metric_1_value" name="case_study_metric_1_value" value="' . esc_attr($fields['case_study_metric_1_value']) . '" placeholder="150%" style="max-width: 100px;" />';
    echo '</div>';
    echo '<p class="description">' . __('First key metric (label and value)', 'yoursite') . '</p>';
    echo '</td>';
    echo '</tr>';
    
    // Metric 2
    echo '<tr>';
    echo '<th><label for="case_study_metric_2_label"><strong>' . __('Metric 2', 'yoursite') . '</strong></label></th>';
    echo '<td>';
    echo '<div style="display: flex; gap: 10px; align-items: center;">';
    echo '<input type="text" id="case_study_metric_2_label" name="case_study_metric_2_label" value="' . esc_attr($fields['case_study_metric_2_label']) . '" placeholder="Conversion Rate" style="flex: 1;" />';
    echo '<input type="text" id="case_study_metric_2_value" name="case_study_metric_2_value" value="' . esc_attr($fields['case_study_metric_2_value']) . '" placeholder="3.2%" style="max-width: 100px;" />';
    echo '</div>';
    echo '<p class="description">' . __('Second key metric (label and value)', 'yoursite') . '</p>';
    echo '</td>';
    echo '</tr>';
    
    // Metric 3
    echo '<tr>';
    echo '<th><label for="case_study_metric_3_label"><strong>' . __('Metric 3', 'yoursite') . '</strong></label></th>';
    echo '<td>';
    echo '<div style="display: flex; gap: 10px; align-items: center;">';
    echo '<input type="text" id="case_study_metric_3_label" name="case_study_metric_3_label" value="' . esc_attr($fields['case_study_metric_3_label']) . '" placeholder="Page Load Time" style="flex: 1;" />';
    echo '<input type="text" id="case_study_metric_3_value" name="case_study_metric_3_value" value="' . esc_attr($fields['case_study_metric_3_value']) . '" placeholder="0.8s" style="max-width: 100px;" />';
    echo '</div>';
    echo '<p class="description">' . __('Third key metric (label and value)', 'yoursite') . '</p>';
    echo '</td>';
    echo '</tr>';
    
    // Testimonial Section
    echo '<tr><td colspan="2"><div class="meta-section"><h4>💬 ' . __('Client Testimonial', 'yoursite') . '</h4></div></td></tr>';
    
    // Testimonial
    echo '<tr>';
    echo '<th><label for="case_study_testimonial"><strong>' . __('Testimonial Quote', 'yoursite') . '</strong></label></th>';
    echo '<td>';
    echo '<textarea id="case_study_testimonial" name="case_study_testimonial" rows="3" placeholder="What did the client say about working with you?">' . esc_textarea($fields['case_study_testimonial']) . '</textarea>';
    echo '<p class="description">' . __('Client quote about the project', 'yoursite') . '</p>';
    echo '</td>';
    echo '</tr>';
    
    // Testimonial Author
    echo '<tr>';
    echo '<th><label for="case_study_testimonial_author"><strong>' . __('Testimonial Author', 'yoursite') . '</strong></label></th>';
    echo '<td>';
    echo '<input type="text" id="case_study_testimonial_author" name="case_study_testimonial_author" value="' . esc_attr($fields['case_study_testimonial_author']) . '" placeholder="John Smith, CEO" />';
    echo '<p class="description">' . __('Name and title of the person giving the testimonial', 'yoursite') . '</p>';
    echo '</td>';
    echo '</tr>';
    
    echo '</table>';
}

/**
 * Save case study meta
 */
function yoursite_save_case_study_meta($post_id) {
    if (!yoursite_verify_meta_nonce('case_study_meta_nonce', 'save_case_study_meta')) {
        return;
    }
    
    if (!current_user_can('edit_post', $post_id)) {
        return;
    }
    
    $fields = array(
        'case_study_client' => 'sanitize_text_field',
        'case_study_industry_text' => 'sanitize_text_field',
        'case_study_website' => 'esc_url_raw',
        'case_study_duration' => 'sanitize_text_field',
        'case_study_technologies' => 'sanitize_textarea_field',
        'case_study_challenge' => 'sanitize_textarea_field',
        'case_study_solution' => 'sanitize_textarea_field',
        'case_study_results' => 'sanitize_textarea_field',
        'case_study_metric_1_label' => 'sanitize_text_field',
        'case_study_metric_1_value' => 'sanitize_text_field',
        'case_study_metric_2_label' => 'sanitize_text_field',
        'case_study_metric_2_value' => 'sanitize_text_field',
        'case_study_metric_3_label' => 'sanitize_text_field',
        'case_study_metric_3_value' => 'sanitize_text_field',
        'case_study_testimonial' => 'sanitize_textarea_field',
        'case_study_testimonial_author' => 'sanitize_text_field'
    );
    
    foreach ($fields as $field => $sanitize_function) {
        if (isset($_POST[$field])) {
            $value = $sanitize_function($_POST[$field]);
            update_post_meta($post_id, '_' . $field, $value);
        }
    }
}
add_action('save_post', 'yoursite_save_case_study_meta');

/**
 * Get case study meta fields
 */
function yoursite_get_case_study_meta_fields($post_id) {
    return array(
        'case_study_client' => get_post_meta($post_id, '_case_study_client', true),
        'case_study_industry_text' => get_post_meta($post_id, '_case_study_industry_text', true),
        'case_study_website' => get_post_meta($post_id, '_case_study_website', true),
        'case_study_duration' => get_post_meta($post_id, '_case_study_duration', true),
        'case_study_technologies' => get_post_meta($post_id, '_case_study_technologies', true),
        'case_study_challenge' => get_post_meta($post_id, '_case_study_challenge', true),
        'case_study_solution' => get_post_meta($post_id, '_case_study_solution', true),
        'case_study_results' => get_post_meta($post_id, '_case_study_results', true),
        'case_study_metric_1_label' => get_post_meta($post_id, '_case_study_metric_1_label', true),
        'case_study_metric_1_value' => get_post_meta($post_id, '_case_study_metric_1_value', true),
        'case_study_metric_2_label' => get_post_meta($post_id, '_case_study_metric_2_label', true),
        'case_study_metric_2_value' => get_post_meta($post_id, '_case_study_metric_2_value', true),
        'case_study_metric_3_label' => get_post_meta($post_id, '_case_study_metric_3_label', true),
        'case_study_metric_3_value' => get_post_meta($post_id, '_case_study_metric_3_value', true),
        'case_study_testimonial' => get_post_meta($post_id, '_case_study_testimonial', true),
        'case_study_testimonial_author' => get_post_meta($post_id, '_case_study_testimonial_author', true)
    );
}

/**
 * Case study meta box styles
 */
function yoursite_case_study_meta_box_styles() {
    echo '<style>
        .case-study-meta-table { width: 100%; }
        .case-study-meta-table th { text-align: left; padding: 15px 10px 15px 0; width: 150px; vertical-align: top; }
        .case-study-meta-table td { padding: 15px 0; }
        .case-study-meta-table input[type="text"], 
        .case-study-meta-table input[type="url"], 
        .case-study-meta-table select { width: 100%; max-width: 400px; }
        .case-study-meta-table textarea { width: 100%; max-width: 600px; height: 80px; }
        .case-study-meta-table .description { font-style: italic; color: #666; margin-top: 5px; }
        .meta-section { background: #f9f9f9; padding: 15px; margin: 20px 0; border-radius: 5px; }
        .meta-section h4 { margin-top: 0; color: #333; }
    </style>';
}
/**
 * Render webinar basic fields
 */
function yoursite_render_webinar_basic_fields($fields) {
    // Date field
    echo '<tr>';
    echo '<th><label for="webinar_date"><strong>' . __('Date', 'yoursite') . '</strong></label></th>';
    echo '<td>';
    echo '<input type="date" id="webinar_date" name="webinar_date" value="' . esc_attr($fields['webinar_date']) . '" />';
    echo '<p class="description">' . __('The date when the webinar will take place', 'yoursite') . '</p>';
    echo '</td>';
    echo '</tr>';
    
    // Time and timezone fields
    echo '<tr>';
    echo '<th><label for="webinar_time"><strong>' . __('Time', 'yoursite') . '</strong></label></th>';
    echo '<td>';
    echo '<div style="display: flex; gap: 10px;">';
    echo '<input type="text" id="webinar_time" name="webinar_time" value="' . esc_attr($fields['webinar_time']) . '" placeholder="2:00 PM" style="max-width: 150px;" />';
    echo '<select id="webinar_timezone" name="webinar_timezone" style="max-width: 100px;">';
    
    $timezones = array(
        'EST' => 'EST', 'PST' => 'PST', 'CST' => 'CST', 'MST' => 'MST',
        'GMT' => 'GMT', 'CET' => 'CET', 'JST' => 'JST', 'AEST' => 'AEST'
    );
    
    foreach ($timezones as $code => $label) {
        echo '<option value="' . $code . '"' . selected($fields['webinar_timezone'], $code, false) . '>' . $label . '</option>';
    }
    
    echo '</select>';
    echo '</div>';
    echo '<p class="description">' . __('Start time and timezone', 'yoursite') . '</p>';
    echo '</td>';
    echo '</tr>';
    
    // Duration field
    echo '<tr>';
    echo '<th><label for="webinar_duration"><strong>' . __('Duration', 'yoursite') . '</strong></label></th>';
    echo '<td>';
    echo '<input type="text" id="webinar_duration" name="webinar_duration" value="' . esc_attr($fields['webinar_duration']) . '" placeholder="60 minutes" />';
    echo '<p class="description">' . __('How long the webinar will last', 'yoursite') . '</p>';
    echo '</td>';
    echo '</tr>';
    
    // Status field
    echo '<tr>';
    echo '<th><label for="webinar_status"><strong>' . __('Status', 'yoursite') . '</strong></label></th>';
    echo '<td>';
    echo '<select id="webinar_status" name="webinar_status">';
    echo '<option value="upcoming"' . selected($fields['webinar_status'], 'upcoming', false) . '>' . __('Upcoming', 'yoursite') . '</option>';
    echo '<option value="live"' . selected($fields['webinar_status'], 'live', false) . '>' . __('Live Now', 'yoursite') . '</option>';
    echo '<option value="completed"' . selected($fields['webinar_status'], 'completed', false) . '>' . __('Completed', 'yoursite') . '</option>';
    echo '<option value="cancelled"' . selected($fields['webinar_status'], 'cancelled', false) . '>' . __('Cancelled', 'yoursite') . '</option>';
    echo '</select>';
    echo '</td>';
    echo '</tr>';
}

/**
 * Render webinar speaker fields
 */
function yoursite_render_webinar_speaker_fields($fields) {
    // Speaker name field
    echo '<tr>';
    echo '<th><label for="webinar_speaker"><strong>' . __('Speaker Name', 'yoursite') . '</strong></label></th>';
    echo '<td>';
    echo '<input type="text" id="webinar_speaker" name="webinar_speaker" value="' . esc_attr($fields['webinar_speaker']) . '" placeholder="John Doe, Marketing Expert" />';
    echo '<p class="description">' . __('Speaker name and title', 'yoursite') . '</p>';
    echo '</td>';
    echo '</tr>';
    
    // Speaker bio field
    echo '<tr>';
    echo '<th><label for="webinar_speaker_bio"><strong>' . __('Speaker Bio', 'yoursite') . '</strong></label></th>';
    echo '<td>';
    echo '<textarea id="webinar_speaker_bio" name="webinar_speaker_bio" placeholder="Brief biography of the speaker...">' . esc_textarea($fields['webinar_speaker_bio']) . '</textarea>';
    echo '<p class="description">' . __('Short biography to display on the webinar page', 'yoursite') . '</p>';
    echo '</td>';
    echo '</tr>';
}

/**
 * Render webinar link fields
 */
function yoursite_render_webinar_link_fields($fields) {
    // Registration URL field
    echo '<tr>';
    echo '<th><label for="webinar_register_url"><strong>' . __('Registration URL', 'yoursite') . '</strong></label></th>';
    echo '<td>';
    echo '<input type="url" id="webinar_register_url" name="webinar_register_url" value="' . esc_attr($fields['webinar_register_url']) . '" placeholder="https://zoom.us/register/..." />';
    echo '<p class="description">' . __('Link where people can register for the webinar', 'yoursite') . '</p>';
    echo '</td>';
    echo '</tr>';
    
    // Recording URL field
    echo '<tr>';
    echo '<th><label for="webinar_recording_url"><strong>' . __('Recording URL', 'yoursite') . '</strong></label></th>';
    echo '<td>';
    echo '<input type="url" id="webinar_recording_url" name="webinar_recording_url" value="' . esc_attr($fields['webinar_recording_url']) . '" placeholder="https://youtube.com/watch?v=..." />';
    echo '<p class="description">' . __('Link to the recorded session (for completed webinars)', 'yoursite') . '</p>';
    echo '</td>';
    echo '</tr>';
    
    // Platform field
    echo '<tr>';
    echo '<th><label for="webinar_platform"><strong>' . __('Platform', 'yoursite') . '</strong></label></th>';
    echo '<td>';
    echo '<select id="webinar_platform" name="webinar_platform">';
    echo '<option value="zoom"' . selected($fields['webinar_platform'], 'zoom', false) . '>Zoom</option>';
    echo '<option value="teams"' . selected($fields['webinar_platform'], 'teams', false) . '>Microsoft Teams</option>';
    echo '<option value="webex"' . selected($fields['webinar_platform'], 'webex', false) . '>WebEx</option>';
    echo '<option value="youtube"' . selected($fields['webinar_platform'], 'youtube', false) . '>YouTube Live</option>';
    echo '<option value="other"' . selected($fields['webinar_platform'], 'other', false) . '>Other</option>';
    echo '</select>';
    echo '</td>';
    echo '</tr>';
}

/**
 * Render webinar additional fields
 */
function yoursite_render_webinar_additional_fields($fields) {
    // Price field
    echo '<tr>';
    echo '<th><label for="webinar_price"><strong>' . __('Price', 'yoursite') . '</strong></label></th>';
    echo '<td>';
    echo '<input type="text" id="webinar_price" name="webinar_price" value="' . esc_attr($fields['webinar_price']) . '" placeholder="Free or $29" />';
    echo '<p class="description">' . __('Leave empty or enter "Free" for free webinars', 'yoursite') . '</p>';
    echo '</td>';
    echo '</tr>';
    
    // Max attendees field
    echo '<tr>';
    echo '<th><label for="webinar_max_attendees"><strong>' . __('Max Attendees', 'yoursite') . '</strong></label></th>';
    echo '<td>';
    echo '<input type="number" id="webinar_max_attendees" name="webinar_max_attendees" value="' . esc_attr($fields['webinar_max_attendees']) . '" placeholder="100" />';
    echo '<p class="description">' . __('Maximum number of attendees (optional)', 'yoursite') . '</p>';
    echo '</td>';
    echo '</tr>';
}