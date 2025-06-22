<?php
/**
 * Meta boxes for custom fields - FIXED VERSION
 */

if (!defined('ABSPATH')) {
    exit;
}

/**
 * FIXED: Improved markdown to WordPress blocks converter
 */
function yoursite_convert_markdown_to_blocks($markdown) {
    // Check if markdown is null or empty
    if (empty($markdown)) {
        return '';
    }
    
    $html = '';
    $lines = explode("\n", $markdown);
    $in_code_block = false;
    $code_language = '';
    $code_content = '';
    $in_list = false;
    $list_type = '';
    $in_blockquote = false;
    $blockquote_content = '';
    
    foreach ($lines as $line_index => $line) {
        $original_line = $line;
        $line = rtrim($line); // Only trim right to preserve left indentation
        
        // Handle code blocks first
        if (preg_match('/^```(\w+)?/', $line, $matches)) {
            if (!$in_code_block) {
                // Close any open elements before starting code block
                if ($in_list) {
                    $html .= '</' . $list_type . '>' . "\n";
                    $html .= '<!-- /wp:list -->' . "\n\n";
                    $in_list = false;
                }
                if ($in_blockquote) {
                    $html .= '</blockquote>' . "\n";
                    $html .= '<!-- /wp:quote -->' . "\n\n";
                    $in_blockquote = false;
                    $blockquote_content = '';
                }
                
                $in_code_block = true;
                $code_language = isset($matches[1]) ? $matches[1] : 'text';
                $code_content = '';
                continue;
            } else {
                $in_code_block = false;
                $html .= '<!-- wp:code {"language":"' . esc_attr($code_language) . '"} -->' . "\n";
                $html .= '<pre class="wp-block-code"><code lang="' . esc_attr($code_language) . '" class="language-' . esc_attr($code_language) . '">' . esc_html(rtrim($code_content)) . '</code></pre>' . "\n";
                $html .= '<!-- /wp:code -->' . "\n\n";
                continue;
            }
        }
        
        if ($in_code_block) {
            $code_content .= $original_line . "\n";
            continue;
        }
        
        // Handle blockquotes
        if (preg_match('/^>\s*(.*)/', $line, $matches)) {
            if (!$in_blockquote) {
                // Close any open lists
                if ($in_list) {
                    $html .= '</' . $list_type . '>' . "\n";
                    $html .= '<!-- /wp:list -->' . "\n\n";
                    $in_list = false;
                }
                $in_blockquote = true;
                $blockquote_content = '';
            }
            $blockquote_content .= yoursite_process_inline_markdown(trim($matches[1])) . ' ';
            continue;
        } else if ($in_blockquote) {
            // End blockquote
            $html .= '<!-- wp:quote -->' . "\n";
            $html .= '<blockquote class="wp-block-quote"><p>' . trim($blockquote_content) . '</p></blockquote>' . "\n";
            $html .= '<!-- /wp:quote -->' . "\n\n";
            $in_blockquote = false;
            $blockquote_content = '';
        }
        
        // Empty line handling - close lists and add spacing
        if (empty(trim($line))) {
            if ($in_list) {
                $html .= '</' . $list_type . '>' . "\n";
                $html .= '<!-- /wp:list -->' . "\n\n";
                $in_list = false;
            }
            
            // Add spacer for multiple empty lines (paragraph breaks)
            if (!empty(trim($html)) && !$in_code_block) {
                $html .= '<!-- wp:spacer {"height":"20px"} -->' . "\n";
                $html .= '<div style="height:20px" aria-hidden="true" class="wp-block-spacer"></div>' . "\n";
                $html .= '<!-- /wp:spacer -->' . "\n\n";
            }
            continue;
        }
        
        // Headers
        if (preg_match('/^(#{1,6})\s+(.+)/', $line, $matches)) {
            // Close any open elements
            if ($in_list) {
                $html .= '</' . $list_type . '>' . "\n";
                $html .= '<!-- /wp:list -->' . "\n\n";
                $in_list = false;
            }
            
            $level = strlen($matches[1]);
            $text = yoursite_process_inline_markdown(trim($matches[2]));
            $html .= '<!-- wp:heading {"level":' . $level . '} -->' . "\n";
            $html .= '<h' . $level . ' class="wp-block-heading">' . $text . '</h' . $level . '>' . "\n";
            $html .= '<!-- /wp:heading -->' . "\n\n";
            continue;
        }
        
        // Unordered lists
        if (preg_match('/^(\s*)[-*+]\s+(.+)/', $line, $matches)) {
            $indent_level = strlen($matches[1]);
            $text = yoursite_process_inline_markdown(trim($matches[2]));
            
            if (!$in_list) {
                $html .= '<!-- wp:list -->' . "\n";
                $html .= '<ul class="wp-block-list">' . "\n";
                $in_list = true;
                $list_type = 'ul';
            } elseif ($list_type !== 'ul') {
                // Switch from ordered to unordered
                $html .= '</' . $list_type . '>' . "\n";
                $html .= '<!-- /wp:list -->' . "\n\n";
                $html .= '<!-- wp:list -->' . "\n";
                $html .= '<ul class="wp-block-list">' . "\n";
                $list_type = 'ul';
            }
            
            $html .= '<li>' . $text . '</li>' . "\n";
            continue;
        }
        
        // Ordered lists
        if (preg_match('/^(\s*)\d+\.\s+(.+)/', $line, $matches)) {
            $indent_level = strlen($matches[1]);
            $text = yoursite_process_inline_markdown(trim($matches[2]));
            
            if (!$in_list) {
                $html .= '<!-- wp:list {"ordered":true} -->' . "\n";
                $html .= '<ol class="wp-block-list">' . "\n";
                $in_list = true;
                $list_type = 'ol';
            } elseif ($list_type !== 'ol') {
                // Switch from unordered to ordered
                $html .= '</' . $list_type . '>' . "\n";
                $html .= '<!-- /wp:list -->' . "\n\n";
                $html .= '<!-- wp:list {"ordered":true} -->' . "\n";
                $html .= '<ol class="wp-block-list">' . "\n";
                $list_type = 'ol';
            }
            
            $html .= '<li>' . $text . '</li>' . "\n";
            continue;
        }
        
        // Horizontal rule
        if (preg_match('/^(-{3,}|={3,}|\*{3,})$/', $line)) {
            if ($in_list) {
                $html .= '</' . $list_type . '>' . "\n";
                $html .= '<!-- /wp:list -->' . "\n\n";
                $in_list = false;
            }
            
            $html .= '<!-- wp:separator -->' . "\n";
            $html .= '<hr class="wp-block-separator has-alpha-channel-opacity"/>' . "\n";
            $html .= '<!-- /wp:separator -->' . "\n\n";
            continue;
        }
        
        // Regular paragraphs
        if (!empty(trim($line))) {
            // Close any open lists
            if ($in_list) {
                $html .= '</' . $list_type . '>' . "\n";
                $html .= '<!-- /wp:list -->' . "\n\n";
                $in_list = false;
            }
            
            $text = yoursite_process_inline_markdown($line);
            $html .= '<!-- wp:paragraph -->' . "\n";
            $html .= '<p class="wp-block-paragraph">' . $text . '</p>' . "\n";
            $html .= '<!-- /wp:paragraph -->' . "\n\n";
        }
    }
    
    // Close any remaining open elements
    if ($in_list) {
        $html .= '</' . $list_type . '>' . "\n";
        $html .= '<!-- /wp:list -->' . "\n\n";
    }
    
    if ($in_blockquote) {
        $html .= '<!-- wp:quote -->' . "\n";
        $html .= '<blockquote class="wp-block-quote"><p>' . trim($blockquote_content) . '</p></blockquote>' . "\n";
        $html .= '<!-- /wp:quote -->' . "\n\n";
    }
    
    return $html;
}

/**
 * FIXED: Enhanced inline markdown processor
 */
function yoursite_process_inline_markdown($text) {
    // Check if text is null or empty
    if (empty($text)) {
        return '';
    }
    
    // Bold text (**text** or __text__)
    $text = preg_replace('/\*\*(.*?)\*\*/', '<strong>$1</strong>', $text);
    $text = preg_replace('/__(.*?)__/', '<strong>$1</strong>', $text);
    
    // Italic text (*text* or _text_)
    $text = preg_replace('/(?<!\*)\*([^*\s].*?[^*\s])\*(?!\*)/', '<em>$1</em>', $text);
    $text = preg_replace('/(?<!_)_([^_\s].*?[^_\s])_(?!_)/', '<em>$1</em>', $text);
    
    // Inline code (`text`)
    $text = preg_replace('/`([^`]+)`/', '<code>$1</code>', $text);
    
    // Strikethrough (~~text~~)
    $text = preg_replace('/~~(.*?)~~/', '<del>$1</del>', $text);
    
    // Links [text](url)
    $text = preg_replace_callback('/\[([^\]]+)\]\(([^)]+)\)/', function($matches) {
        $link_text = $matches[1];
        $url = $matches[2];
        $title = '';
        
        // Check for title in URL
        if (preg_match('/^([^\s]+)\s+"([^"]+)"$/', $url, $url_matches)) {
            $url = $url_matches[1];
            $title = ' title="' . esc_attr($url_matches[2]) . '"';
        }
        
        return '<a href="' . esc_url($url) . '"' . $title . '>' . $link_text . '</a>';
    }, $text);
    
    // Images ![alt](url)
    $text = preg_replace_callback('/!\[([^\]]*)\]\(([^)]+)\)/', function($matches) {
        $alt = $matches[1];
        $url = $matches[2];
        $title = '';
        
        // Check for title in URL
        if (preg_match('/^([^\s]+)\s+"([^"]+)"$/', $url, $url_matches)) {
            $url = $url_matches[1];
            $title = ' title="' . esc_attr($url_matches[2]) . '"';
        }
        
        return '<img src="' . esc_url($url) . '" alt="' . esc_attr($alt) . '"' . $title . ' class="wp-image-markdown" />';
    }, $text);
    
    return $text;
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
 * Add meta boxes for guides
 */
function yoursite_add_guide_meta_boxes() {
    add_meta_box(
        'guide_settings',
        __('Guide Settings', 'yoursite'),
        'yoursite_guide_settings_callback',
        'guide',
        'side',
        'high'
    );

    add_meta_box(
        'guide_markdown',
        __('Markdown Content', 'yoursite'),
        'yoursite_guide_markdown_callback',
        'guide',
        'normal',
        'high'
    );
}
add_action('add_meta_boxes', 'yoursite_add_guide_meta_boxes');

/**
 * Guide settings meta box callback
 */
function yoursite_guide_settings_callback($post) {
    // Add nonce for security
    wp_nonce_field('yoursite_guide_meta_box', 'yoursite_guide_meta_box_nonce');

    // Get current values
    $featured = get_post_meta($post->ID, '_featured_guide', true);
    $difficulty = get_post_meta($post->ID, '_guide_difficulty', true);
    $reading_time = get_post_meta($post->ID, '_reading_time', true);
    $order = get_post_meta($post->ID, '_guide_order', true);
    
    echo '<table class="form-table">';
    
    // Featured Guide
    echo '<tr>';
    echo '<th><label for="featured_guide">' . __('Featured Guide', 'yoursite') . '</label></th>';
    echo '<td>';
    echo '<input type="checkbox" id="featured_guide" name="featured_guide" value="1" ' . checked($featured, '1', false) . ' />';
    echo '<label for="featured_guide">' . __('Mark as featured guide', 'yoursite') . '</label>';
    echo '</td>';
    echo '</tr>';
    
    // Difficulty Level
    echo '<tr>';
    echo '<th><label for="guide_difficulty">' . __('Difficulty Level', 'yoursite') . '</label></th>';
    echo '<td>';
    echo '<select id="guide_difficulty" name="guide_difficulty">';
    echo '<option value="beginner" ' . selected($difficulty, 'beginner', false) . '>' . __('Beginner', 'yoursite') . '</option>';
    echo '<option value="intermediate" ' . selected($difficulty, 'intermediate', false) . '>' . __('Intermediate', 'yoursite') . '</option>';
    echo '<option value="advanced" ' . selected($difficulty, 'advanced', false) . '>' . __('Advanced', 'yoursite') . '</option>';
    echo '</select>';
    echo '</td>';
    echo '</tr>';
    
    // Reading Time
    echo '<tr>';
    echo '<th><label for="reading_time">' . __('Reading Time (minutes)', 'yoursite') . '</label></th>';
    echo '<td>';
    echo '<input type="number" id="reading_time" name="reading_time" value="' . esc_attr($reading_time) . '" min="1" max="120" />';
    echo '<p class="description">' . __('Estimated reading time in minutes. Leave empty to auto-calculate.', 'yoursite') . '</p>';
    echo '</td>';
    echo '</tr>';
    
    // Guide Order
    echo '<tr>';
    echo '<th><label for="guide_order">' . __('Display Order', 'yoursite') . '</label></th>';
    echo '<td>';
    echo '<input type="number" id="guide_order" name="guide_order" value="' . esc_attr($order) . '" />';
    echo '<p class="description">' . __('Order for displaying guides (lower numbers first).', 'yoursite') . '</p>';
    echo '</td>';
    echo '</tr>';
    
    echo '</table>';
}

/**
 * Guide markdown content meta box callback
 */
function yoursite_guide_markdown_callback($post) {
    // Get current markdown content
    $markdown_content = get_post_meta($post->ID, '_markdown_content', true);
    
    echo '<p><strong>' . __('Paste your Docusaurus markdown content here:', 'yoursite') . '</strong></p>';
    echo '<p class="description">' . __('This content will be automatically converted to WordPress blocks when you save. The regular editor above will be updated with the converted content.', 'yoursite') . '</p>';
    
    echo '<textarea id="markdown_content" name="markdown_content" rows="20" style="width: 100%; font-family: monospace;">' . esc_textarea($markdown_content) . '</textarea>';
    
    echo '<p class="description">';
    echo __('Supported Markdown features:', 'yoursite') . '<br>';
    echo '• ' . __('Headers (# ## ###)', 'yoursite') . '<br>';
    echo '• ' . __('Bold (**text**) and Italic (*text*)', 'yoursite') . '<br>';
    echo '• ' . __('Links [text](url)', 'yoursite') . '<br>';
    echo '• ' . __('Images ![alt](url)', 'yoursite') . '<br>';
    echo '• ' . __('Code blocks ```language', 'yoursite') . '<br>';
    echo '• ' . __('Inline code `code`', 'yoursite') . '<br>';
    echo '• ' . __('Lists (- or 1.)', 'yoursite') . '<br>';
    echo '• ' . __('Blockquotes (>)', 'yoursite') . '<br>';
    echo '• ' . __('Tables', 'yoursite') . '<br>';
    echo '</p>';
    
    // Add some JavaScript for better UX
    echo '<script>
    document.getElementById("markdown_content").addEventListener("keydown", function(e) {
        if (e.key === "Tab") {
            e.preventDefault();
            var start = this.selectionStart;
            var end = this.selectionEnd;
            this.value = this.value.substring(0, start) + "\t" + this.value.substring(end);
            this.selectionStart = this.selectionEnd = start + 1;
        }
    });
    </script>';
}

/**
 * FIXED: Save guide meta box data
 */
function yoursite_save_guide_meta_box_data($post_id) {
    // Check if nonce is valid
    if (!isset($_POST['yoursite_guide_meta_box_nonce']) || !wp_verify_nonce($_POST['yoursite_guide_meta_box_nonce'], 'yoursite_guide_meta_box')) {
        return;
    }

    // Check if user has permissions to save data
    if (isset($_POST['post_type']) && 'guide' == $_POST['post_type']) {
        if (!current_user_can('edit_post', $post_id)) {
            return;
        }
    }

    // Check if not an autosave
    if (defined('DOING_AUTOSAVE') && DOING_AUTOSAVE) {
        return;
    }

    // Save featured guide setting
    $featured = isset($_POST['featured_guide']) ? '1' : '0';
    update_post_meta($post_id, '_featured_guide', $featured);

    // Save difficulty level
    if (isset($_POST['guide_difficulty'])) {
        $difficulty = sanitize_text_field($_POST['guide_difficulty']);
        update_post_meta($post_id, '_guide_difficulty', $difficulty);
    }

    // Save reading time
    if (isset($_POST['reading_time'])) {
        $reading_time = intval($_POST['reading_time']);
        update_post_meta($post_id, '_reading_time', $reading_time);
    }

    // Save guide order
    if (isset($_POST['guide_order'])) {
        $order = intval($_POST['guide_order']);
        update_post_meta($post_id, '_guide_order', $order);
    }

    // FIXED: Save markdown content and convert to HTML
    if (isset($_POST['markdown_content'])) {
        $markdown_content = wp_unslash($_POST['markdown_content']);
        update_post_meta($post_id, '_markdown_content', $markdown_content);
        
        // Convert markdown to HTML and update post content
        if (!empty($markdown_content)) {
            $html_content = yoursite_convert_markdown_to_blocks($markdown_content);
            
            // Only update if we have valid HTML content
            if (!empty($html_content)) {
                // Update the post content
                $post_data = array(
                    'ID' => $post_id,
                    'post_content' => $html_content
                );
                
                // Remove the action to prevent infinite loop
                remove_action('save_post', 'yoursite_save_guide_meta_box_data');
                wp_update_post($post_data);
                add_action('save_post', 'yoursite_save_guide_meta_box_data');
            }
        }
    }
}
add_action('save_post', 'yoursite_save_guide_meta_box_data');

/**
 * Get job meta fields with null checking
 */
function yoursite_get_job_meta_fields($post_id) {
    return array(
        'job_salary_min' => get_post_meta($post_id, '_job_salary_min', true) ?: '',
        'job_salary_max' => get_post_meta($post_id, '_job_salary_max', true) ?: '',
        'job_salary_currency' => get_post_meta($post_id, '_job_salary_currency', true) ?: 'USD',
        'job_experience' => get_post_meta($post_id, '_job_experience', true) ?: 'mid',
        'job_remote' => get_post_meta($post_id, '_job_remote', true) ?: 'no',
        'job_application_email' => get_post_meta($post_id, '_job_application_email', true) ?: '',
        'job_application_url' => get_post_meta($post_id, '_job_application_url', true) ?: '',
        'job_requirements' => get_post_meta($post_id, '_job_requirements', true) ?: '',
        'job_benefits' => get_post_meta($post_id, '_job_benefits', true) ?: '',
        'job_status' => get_post_meta($post_id, '_job_status', true) ?: 'open'
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
 * Helper function to verify meta nonce with null checking
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
?>