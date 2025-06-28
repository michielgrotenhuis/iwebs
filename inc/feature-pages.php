<?php
/**
 * Feature Pages Post Type and Meta Boxes
 * Add this to your functions.php or create inc/feature-pages.php
 */

if (!defined('ABSPATH')) {
    exit;
}

// =============================================================================
// FEATURE PAGES POST TYPE
// =============================================================================

/**
 * Register Feature Pages custom post type
 */
function yoursite_register_feature_pages_post_type() {
    $labels = array(
        'name'                  => _x('Feature Pages', 'Post type general name', 'yoursite'),
        'singular_name'         => _x('Feature Page', 'Post type singular name', 'yoursite'),
        'menu_name'             => _x('Feature Pages', 'Admin Menu text', 'yoursite'),
        'name_admin_bar'        => _x('Feature Page', 'Add New on Toolbar', 'yoursite'),
        'add_new'               => __('Add New', 'yoursite'),
        'add_new_item'          => __('Add New Feature Page', 'yoursite'),
        'new_item'              => __('New Feature Page', 'yoursite'),
        'edit_item'             => __('Edit Feature Page', 'yoursite'),
        'view_item'             => __('View Feature Page', 'yoursite'),
        'all_items'             => __('All Feature Pages', 'yoursite'),
        'search_items'          => __('Search Feature Pages', 'yoursite'),
        'parent_item_colon'     => __('Parent Feature Pages:', 'yoursite'),
        'not_found'             => __('No feature pages found.', 'yoursite'),
        'not_found_in_trash'    => __('No feature pages found in Trash.', 'yoursite'),
    );

    $args = array(
        'labels'             => $labels,
        'public'             => true,
        'publicly_queryable' => true,
        'show_ui'            => true,
        'show_in_menu'       => true,
        'query_var'          => true,
        'rewrite'            => array('slug' => 'features'),
        'capability_type'    => 'post',
        'has_archive'        => true,
        'hierarchical'       => false,
        'menu_position'      => 25,
        'menu_icon'          => 'dashicons-star-filled',
        'supports'           => array('title', 'editor', 'excerpt', 'thumbnail', 'custom-fields'),
        'show_in_rest'       => true,
    );

    register_post_type('feature_pages', $args);
}
add_action('init', 'yoursite_register_feature_pages_post_type');

// =============================================================================
// META BOXES
// =============================================================================

/**
 * Add meta boxes for feature pages
 */
function yoursite_add_feature_pages_meta_boxes() {
    add_meta_box(
        'feature_hero_section',
        __('Hero Section', 'yoursite'),
        'yoursite_feature_hero_meta_box_callback',
        'feature_pages',
        'normal',
        'high'
    );
    
    add_meta_box(
        'feature_usp_sections',
        __('USP Sections', 'yoursite'),
        'yoursite_feature_usp_meta_box_callback',
        'feature_pages',
        'normal',
        'high'
    );
    
    add_meta_box(
        'feature_capabilities',
        __('Key Capabilities', 'yoursite'),
        'yoursite_feature_capabilities_meta_box_callback',
        'feature_pages',
        'normal',
        'high'
    );
    
    add_meta_box(
        'feature_integration',
        __('Integration Details', 'yoursite'),
        'yoursite_feature_integration_meta_box_callback',
        'feature_pages',
        'normal',
        'default'
    );
    
    add_meta_box(
        'feature_case_study',
        __('Case Study', 'yoursite'),
        'yoursite_feature_case_study_meta_box_callback',
        'feature_pages',
        'normal',
        'default'
    );
    
    add_meta_box(
        'feature_faq',
        __('FAQ Section', 'yoursite'),
        'yoursite_feature_faq_meta_box_callback',
        'feature_pages',
        'normal',
        'default'
    );
    
    add_meta_box(
        'feature_related',
        __('Related Features', 'yoursite'),
        'yoursite_feature_related_meta_box_callback',
        'feature_pages',
        'side',
        'default'
    );
}
add_action('add_meta_boxes', 'yoursite_add_feature_pages_meta_boxes');

/**
 * Hero Section Meta Box
 */
function yoursite_feature_hero_meta_box_callback($post) {
    wp_nonce_field('yoursite_save_feature_meta', 'yoursite_feature_meta_nonce');
    
    $hero_subtitle = get_post_meta($post->ID, '_feature_hero_subtitle', true);
    $hero_bg_type = get_post_meta($post->ID, '_feature_hero_bg_type', true) ?: 'gradient';
    $hero_bg_image = get_post_meta($post->ID, '_feature_hero_bg_image', true);
    $hero_gradient_primary = get_post_meta($post->ID, '_feature_hero_gradient_primary', true) ?: '#1e3a8a';
    $hero_gradient_secondary = get_post_meta($post->ID, '_feature_hero_gradient_secondary', true) ?: '#7c3aed';
    $hero_cta_text = get_post_meta($post->ID, '_feature_hero_cta_text', true) ?: 'Learn More';
    $hero_cta_url = get_post_meta($post->ID, '_feature_hero_cta_url', true);
    ?>
    
    <style>
    .feature-meta-table { width: 100%; border-collapse: collapse; }
    .feature-meta-table th, .feature-meta-table td { padding: 12px; border-bottom: 1px solid #ddd; vertical-align: top; }
    .feature-meta-table th { background: #f9f9f9; font-weight: 600; width: 200px; }
    .feature-meta-table input[type="text"], .feature-meta-table input[type="url"], .feature-meta-table textarea, .feature-meta-table select { width: 100%; }
    .feature-meta-table textarea { height: 80px; resize: vertical; }
    .color-picker { width: 80px !important; }
    .bg-type-fields { margin-top: 10px; }
    .bg-type-fields > div { margin-bottom: 15px; }
    </style>
    
    <table class="feature-meta-table">
        <tr>
            <th><label for="feature_hero_subtitle"><?php _e('Hero Subtitle', 'yoursite'); ?></label></th>
            <td>
                <textarea id="feature_hero_subtitle" name="feature_hero_subtitle" placeholder="Compelling description that appears under the main title"><?php echo esc_textarea($hero_subtitle); ?></textarea>
                <p class="description"><?php _e('This appears under the main title (post title)', 'yoursite'); ?></p>
            </td>
        </tr>
        <tr>
            <th><label for="feature_hero_bg_type"><?php _e('Background Type', 'yoursite'); ?></label></th>
            <td>
                <select id="feature_hero_bg_type" name="feature_hero_bg_type" onchange="toggleHeroBgFields(this.value)">
                    <option value="gradient" <?php selected($hero_bg_type, 'gradient'); ?>><?php _e('Gradient', 'yoursite'); ?></option>
                    <option value="image" <?php selected($hero_bg_type, 'image'); ?>><?php _e('Image', 'yoursite'); ?></option>
                    <option value="image_gradient" <?php selected($hero_bg_type, 'image_gradient'); ?>><?php _e('Image with Gradient Overlay', 'yoursite'); ?></option>
                </select>
                
                <div class="bg-type-fields">
                    <div id="gradient-fields" style="<?php echo ($hero_bg_type === 'gradient' || $hero_bg_type === 'image_gradient') ? '' : 'display:none;'; ?>">
                        <label><?php _e('Gradient Colors:', 'yoursite'); ?></label><br>
                        <input type="color" name="feature_hero_gradient_primary" value="<?php echo esc_attr($hero_gradient_primary); ?>" class="color-picker">
                        <input type="color" name="feature_hero_gradient_secondary" value="<?php echo esc_attr($hero_gradient_secondary); ?>" class="color-picker">
                    </div>
                    
                    <div id="image-fields" style="<?php echo ($hero_bg_type === 'image' || $hero_bg_type === 'image_gradient') ? '' : 'display:none;'; ?>">
                        <label><?php _e('Background Image:', 'yoursite'); ?></label><br>
                        <input type="hidden" id="feature_hero_bg_image" name="feature_hero_bg_image" value="<?php echo esc_attr($hero_bg_image); ?>">
                        <button type="button" class="button" onclick="openMediaUploader('feature_hero_bg_image')"><?php _e('Choose Image', 'yoursite'); ?></button>
                        <div id="hero-image-preview" style="margin-top: 10px;">
                            <?php if ($hero_bg_image) : ?>
                                <img src="<?php echo esc_url($hero_bg_image); ?>" style="max-width: 200px; height: auto;">
                            <?php endif; ?>
                        </div>
                    </div>
                </div>
            </td>
        </tr>
        <tr>
            <th><label for="feature_hero_cta_text"><?php _e('CTA Button Text', 'yoursite'); ?></label></th>
            <td><input type="text" id="feature_hero_cta_text" name="feature_hero_cta_text" value="<?php echo esc_attr($hero_cta_text); ?>"></td>
        </tr>
        <tr>
            <th><label for="feature_hero_cta_url"><?php _e('CTA Button URL', 'yoursite'); ?></label></th>
            <td><input type="url" id="feature_hero_cta_url" name="feature_hero_cta_url" value="<?php echo esc_attr($hero_cta_url); ?>" placeholder="https://"></td>
        </tr>
    </table>
    
    <script>
    function toggleHeroBgFields(type) {
        const gradientFields = document.getElementById('gradient-fields');
        const imageFields = document.getElementById('image-fields');
        
        gradientFields.style.display = (type === 'gradient' || type === 'image_gradient') ? 'block' : 'none';
        imageFields.style.display = (type === 'image' || type === 'image_gradient') ? 'block' : 'none';
    }
    
    function openMediaUploader(fieldId) {
        const frame = wp.media({
            title: 'Select Image',
            button: { text: 'Use Image' },
            multiple: false
        });
        
        frame.on('select', function() {
            const attachment = frame.state().get('selection').first().toJSON();
            document.getElementById(fieldId).value = attachment.url;
            document.getElementById('hero-image-preview').innerHTML = '<img src="' + attachment.url + '" style="max-width: 200px; height: auto;">';
        });
        
        frame.open();
    }
    </script>
    <?php
}

/**
 * USP Sections Meta Box
 */
function yoursite_feature_usp_meta_box_callback($post) {
    $usp_sections = get_post_meta($post->ID, '_feature_usp_sections', true) ?: array();
    if (empty($usp_sections)) {
        $usp_sections = array(array('title' => '', 'description' => '', 'type' => 'image', 'image' => '', 'svg_code' => ''));
    }
    ?>
    
    <div id="usp-sections-container">
        <?php foreach ($usp_sections as $index => $usp) : ?>
        <div class="usp-section-item" data-index="<?php echo $index; ?>">
            <div class="feature-meta-table">
                <h4 style="background: #667eea; color: white; padding: 12px; margin: 0 0 15px 0; border-radius: 4px;">
                    <?php _e('USP Section', 'yoursite'); ?> #<?php echo $index + 1; ?>
                    <button type="button" class="remove-usp-section button button-small" style="float: right; background: rgba(255,255,255,0.2); border: none; color: white;"><?php _e('Remove', 'yoursite'); ?></button>
                </h4>
                
                <table class="feature-meta-table">
                    <tr>
                        <th><label><?php _e('Section Title', 'yoursite'); ?></label></th>
                        <td>
                            <input type="text" name="feature_usp_sections[<?php echo $index; ?>][title]" 
                                   value="<?php echo esc_attr($usp['title']); ?>" 
                                   placeholder="e.g., Seamless Integration Process">
                        </td>
                    </tr>
                    <tr>
                        <th><label><?php _e('Description', 'yoursite'); ?></label></th>
                        <td>
                            <textarea name="feature_usp_sections[<?php echo $index; ?>][description]" rows="4"
                                      placeholder="Detailed description of this unique selling point"><?php echo esc_textarea($usp['description']); ?></textarea>
                        </td>
                    </tr>
                    <tr>
                        <th><label><?php _e('Visual Type', 'yoursite'); ?></label></th>
                        <td>
                            <select name="feature_usp_sections[<?php echo $index; ?>][type]" class="usp-type-selector" data-index="<?php echo $index; ?>">
                                <option value="image" <?php selected($usp['type'], 'image'); ?>><?php _e('Image', 'yoursite'); ?></option>
                                <option value="svg" <?php selected($usp['type'], 'svg'); ?>><?php _e('SVG Code', 'yoursite'); ?></option>
                            </select>
                        </td>
                    </tr>
                    <tr class="usp-image-field" style="<?php echo ($usp['type'] === 'image') ? '' : 'display:none;'; ?>">
                        <th><label><?php _e('Image', 'yoursite'); ?></label></th>
                        <td>
                            <input type="hidden" name="feature_usp_sections[<?php echo $index; ?>][image]" 
                                   value="<?php echo esc_attr($usp['image']); ?>" class="usp-image-input">
                            <button type="button" class="button usp-image-upload" data-index="<?php echo $index; ?>">
                                <?php _e('Choose Image', 'yoursite'); ?>
                            </button>
                            <div class="usp-image-preview" style="margin-top: 10px;">
                                <?php if (!empty($usp['image'])) : ?>
                                    <img src="<?php echo esc_url($usp['image']); ?>" style="max-width: 200px; height: auto; border-radius: 4px;">
                                <?php endif; ?>
                            </div>
                        </td>
                    </tr>
                    <tr class="usp-svg-field" style="<?php echo ($usp['type'] === 'svg') ? '' : 'display:none;'; ?>">
                        <th><label><?php _e('SVG Code', 'yoursite'); ?></label></th>
                        <td>
                            <textarea name="feature_usp_sections[<?php echo $index; ?>][svg_code]" rows="6" 
                                      placeholder="Paste your SVG code here..."><?php echo esc_textarea($usp['svg_code']); ?></textarea>
                            <p class="description"><?php _e('Paste the complete SVG code including &lt;svg&gt; tags', 'yoursite'); ?></p>
                        </td>
                    </tr>
                </table>
            </div>
            <hr style="margin: 30px 0;">
        </div>
        <?php endforeach; ?>
    </div>
    
    <button type="button" id="add-usp-section" class="button button-primary"><?php _e('Add USP Section', 'yoursite'); ?></button>
    
    <script>
    jQuery(document).ready(function($) {
        let uspIndex = <?php echo count($usp_sections); ?>;
        
        $('#add-usp-section').on('click', function() {
            const html = `
                <div class="usp-section-item" data-index="${uspIndex}">
                    <div class="feature-meta-table">
                        <h4 style="background: #667eea; color: white; padding: 12px; margin: 0 0 15px 0; border-radius: 4px;">
                            USP Section #${uspIndex + 1}
                            <button type="button" class="remove-usp-section button button-small" style="float: right; background: rgba(255,255,255,0.2); border: none; color: white;">Remove</button>
                        </h4>
                        <table class="feature-meta-table">
                            <tr>
                                <th><label>Section Title</label></th>
                                <td><input type="text" name="feature_usp_sections[${uspIndex}][title]" placeholder="e.g., Seamless Integration Process"></td>
                            </tr>
                            <tr>
                                <th><label>Description</label></th>
                                <td><textarea name="feature_usp_sections[${uspIndex}][description]" rows="4" placeholder="Detailed description of this unique selling point"></textarea></td>
                            </tr>
                            <tr>
                                <th><label>Visual Type</label></th>
                                <td>
                                    <select name="feature_usp_sections[${uspIndex}][type]" class="usp-type-selector" data-index="${uspIndex}">
                                        <option value="image">Image</option>
                                        <option value="svg">SVG Code</option>
                                    </select>
                                </td>
                            </tr>
                            <tr class="usp-image-field">
                                <th><label>Image</label></th>
                                <td>
                                    <input type="hidden" name="feature_usp_sections[${uspIndex}][image]" class="usp-image-input">
                                    <button type="button" class="button usp-image-upload" data-index="${uspIndex}">Choose Image</button>
                                    <div class="usp-image-preview" style="margin-top: 10px;"></div>
                                </td>
                            </tr>
                            <tr class="usp-svg-field" style="display:none;">
                                <th><label>SVG Code</label></th>
                                <td>
                                    <textarea name="feature_usp_sections[${uspIndex}][svg_code]" rows="6" placeholder="Paste your SVG code here..."></textarea>
                                    <p class="description">Paste the complete SVG code including &lt;svg&gt; tags</p>
                                </td>
                            </tr>
                        </table>
                    </div>
                    <hr style="margin: 30px 0;">
                </div>
            `;
            $('#usp-sections-container').append(html);
            uspIndex++;
        });
        
        $(document).on('click', '.remove-usp-section', function() {
            if (confirm('Remove this USP section?')) {
                $(this).closest('.usp-section-item').remove();
            }
        });
        
        $(document).on('change', '.usp-type-selector', function() {
            const container = $(this).closest('.usp-section-item');
            const type = $(this).val();
            
            if (type === 'image') {
                container.find('.usp-image-field').show();
                container.find('.usp-svg-field').hide();
            } else {
                container.find('.usp-image-field').hide();
                container.find('.usp-svg-field').show();
            }
        });
        
        $(document).on('click', '.usp-image-upload', function() {
            const button = $(this);
            const input = button.siblings('.usp-image-input');
            const preview = button.siblings('.usp-image-preview');
            
            const frame = wp.media({
                title: 'Select USP Image',
                button: { text: 'Use Image' },
                multiple: false
            });
            
            frame.on('select', function() {
                const attachment = frame.state().get('selection').first().toJSON();
                input.val(attachment.url);
                preview.html('<img src="' + attachment.url + '" style="max-width: 200px; height: auto; border-radius: 4px;">');
            });
            
            frame.open();
        });
    });
    </script>
    <?php
}

/**
 * Key Capabilities Meta Box
 */
function yoursite_feature_capabilities_meta_box_callback($post) {
    $capabilities = get_post_meta($post->ID, '_feature_capabilities', true) ?: array();
    if (empty($capabilities)) {
        $capabilities = array(array('title' => '', 'description' => ''));
    }
    ?>
    
    <div id="capabilities-container">
        <?php foreach ($capabilities as $index => $capability) : ?>
        <div class="capability-item" data-index="<?php echo $index; ?>">
            <table class="feature-meta-table">
                <tr>
                    <th><label><?php _e('Capability Title', 'yoursite'); ?></label></th>
                    <td>
                        <input type="text" name="feature_capabilities[<?php echo $index; ?>][title]" 
                               value="<?php echo esc_attr($capability['title']); ?>" 
                               placeholder="e.g., Unlimited Variant Combinations">
                    </td>
                </tr>
                <tr>
                    <th><label><?php _e('Description', 'yoursite'); ?></label></th>
                    <td>
                        <textarea name="feature_capabilities[<?php echo $index; ?>][description]" 
                                  placeholder="Detailed description of this capability"><?php echo esc_textarea($capability['description']); ?></textarea>
                        <button type="button" class="button button-small remove-capability" style="margin-top: 5px;"><?php _e('Remove', 'yoursite'); ?></button>
                    </td>
                </tr>
            </table>
            <hr>
        </div>
        <?php endforeach; ?>
    </div>
    
    <button type="button" id="add-capability" class="button button-primary"><?php _e('Add Capability', 'yoursite'); ?></button>
    
    <script>
    jQuery(document).ready(function($) {
        let capabilityIndex = <?php echo count($capabilities); ?>;
        
        $('#add-capability').on('click', function() {
            const html = `
                <div class="capability-item" data-index="${capabilityIndex}">
                    <table class="feature-meta-table">
                        <tr>
                            <th><label>Capability Title</label></th>
                            <td><input type="text" name="feature_capabilities[${capabilityIndex}][title]" placeholder="e.g., Unlimited Variant Combinations"></td>
                        </tr>
                        <tr>
                            <th><label>Description</label></th>
                            <td>
                                <textarea name="feature_capabilities[${capabilityIndex}][description]" placeholder="Detailed description of this capability"></textarea>
                                <button type="button" class="button button-small remove-capability" style="margin-top: 5px;">Remove</button>
                            </td>
                        </tr>
                    </table>
                    <hr>
                </div>
            `;
            $('#capabilities-container').append(html);
            capabilityIndex++;
        });
        
        $(document).on('click', '.remove-capability', function() {
            $(this).closest('.capability-item').remove();
        });
    });
    </script>
    <?php
}

/**
 * Integration Details Meta Box
 */
function yoursite_feature_integration_meta_box_callback($post) {
    $setup_steps = get_post_meta($post->ID, '_feature_setup_steps', true);
    $api_info = get_post_meta($post->ID, '_feature_api_info', true);
    $technical_notes = get_post_meta($post->ID, '_feature_technical_notes', true);
    ?>
    
    <table class="feature-meta-table">
        <tr>
            <th><label for="feature_setup_steps"><?php _e('Setup Steps', 'yoursite'); ?></label></th>
            <td>
                <textarea id="feature_setup_steps" name="feature_setup_steps" rows="5" 
                          placeholder="1. Step one&#10;2. Step two&#10;3. Step three"><?php echo esc_textarea($setup_steps); ?></textarea>
                <p class="description"><?php _e('Enter setup steps, one per line', 'yoursite'); ?></p>
            </td>
        </tr>
        <tr>
            <th><label for="feature_api_info"><?php _e('API Information', 'yoursite'); ?></label></th>
            <td>
                <textarea id="feature_api_info" name="feature_api_info" rows="4" 
                          placeholder="API endpoints, authentication details, code examples"><?php echo esc_textarea($api_info); ?></textarea>
            </td>
        </tr>
        <tr>
            <th><label for="feature_technical_notes"><?php _e('Technical Notes', 'yoursite'); ?></label></th>
            <td>
                <textarea id="feature_technical_notes" name="feature_technical_notes" rows="3" 
                          placeholder="Additional technical information, requirements, limitations"><?php echo esc_textarea($technical_notes); ?></textarea>
            </td>
        </tr>
    </table>
    <?php
}

/**
 * Case Study Meta Box
 */
function yoursite_feature_case_study_meta_box_callback($post) {
    $case_study_enable = get_post_meta($post->ID, '_feature_case_study_enable', true);
    $case_study_company = get_post_meta($post->ID, '_feature_case_study_company', true);
    $case_study_challenge = get_post_meta($post->ID, '_feature_case_study_challenge', true);
    $case_study_implementation = get_post_meta($post->ID, '_feature_case_study_implementation', true);
    $case_study_results = get_post_meta($post->ID, '_feature_case_study_results', true);
    $case_study_quote = get_post_meta($post->ID, '_feature_case_study_quote', true);
    $case_study_quote_author = get_post_meta($post->ID, '_feature_case_study_quote_author', true);
    ?>
    
    <table class="feature-meta-table">
        <tr>
            <th><label for="feature_case_study_enable"><?php _e('Enable Case Study', 'yoursite'); ?></label></th>
            <td>
                <input type="checkbox" id="feature_case_study_enable" name="feature_case_study_enable" value="1" 
                       <?php checked($case_study_enable, '1'); ?> onchange="toggleCaseStudyFields(this.checked)">
                <label for="feature_case_study_enable"><?php _e('Show case study section', 'yoursite'); ?></label>
            </td>
        </tr>
    </table>
    
    <div id="case-study-fields" style="<?php echo $case_study_enable ? '' : 'display:none;'; ?>">
        <table class="feature-meta-table">
            <tr>
                <th><label for="feature_case_study_company"><?php _e('Company Name', 'yoursite'); ?></label></th>
                <td><input type="text" id="feature_case_study_company" name="feature_case_study_company" value="<?php echo esc_attr($case_study_company); ?>"></td>
            </tr>
            <tr>
                <th><label for="feature_case_study_challenge"><?php _e('Challenge', 'yoursite'); ?></label></th>
                <td><textarea id="feature_case_study_challenge" name="feature_case_study_challenge" rows="3"><?php echo esc_textarea($case_study_challenge); ?></textarea></td>
            </tr>
            <tr>
                <th><label for="feature_case_study_implementation"><?php _e('Implementation', 'yoursite'); ?></label></th>
                <td><textarea id="feature_case_study_implementation" name="feature_case_study_implementation" rows="4"><?php echo esc_textarea($case_study_implementation); ?></textarea></td>
            </tr>
            <tr>
                <th><label for="feature_case_study_results"><?php _e('Results', 'yoursite'); ?></label></th>
                <td><textarea id="feature_case_study_results" name="feature_case_study_results" rows="4"><?php echo esc_textarea($case_study_results); ?></textarea></td>
            </tr>
            <tr>
                <th><label for="feature_case_study_quote"><?php _e('Customer Quote', 'yoursite'); ?></label></th>
                <td><textarea id="feature_case_study_quote" name="feature_case_study_quote" rows="2"><?php echo esc_textarea($case_study_quote); ?></textarea></td>
            </tr>
            <tr>
                <th><label for="feature_case_study_quote_author"><?php _e('Quote Author', 'yoursite'); ?></label></th>
                <td><input type="text" id="feature_case_study_quote_author" name="feature_case_study_quote_author" value="<?php echo esc_attr($case_study_quote_author); ?>" placeholder="Name, Title, Company"></td>
            </tr>
        </table>
    </div>
    
    <script>
    function toggleCaseStudyFields(enabled) {
        document.getElementById('case-study-fields').style.display = enabled ? 'block' : 'none';
    }
    </script>
    <?php
}

/**
 * FAQ Meta Box
 */
function yoursite_feature_faq_meta_box_callback($post) {
    $faqs = get_post_meta($post->ID, '_feature_faqs', true) ?: array();
    if (empty($faqs)) {
        $faqs = array(array('question' => '', 'answer' => ''));
    }
    ?>
    
    <div id="faqs-container">
        <?php foreach ($faqs as $index => $faq) : ?>
        <div class="faq-item" data-index="<?php echo $index; ?>">
            <table class="feature-meta-table">
                <tr>
                    <th><label><?php _e('Question', 'yoursite'); ?></label></th>
                    <td>
                        <input type="text" name="feature_faqs[<?php echo $index; ?>][question]" 
                               value="<?php echo esc_attr($faq['question']); ?>" 
                               placeholder="What question might customers have?">
                    </td>
                </tr>
                <tr>
                    <th><label><?php _e('Answer', 'yoursite'); ?></label></th>
                    <td>
                        <textarea name="feature_faqs[<?php echo $index; ?>][answer]" rows="3"
                                  placeholder="Clear, helpful answer"><?php echo esc_textarea($faq['answer']); ?></textarea>
                        <button type="button" class="button button-small remove-faq" style="margin-top: 5px;"><?php _e('Remove', 'yoursite'); ?></button>
                    </td>
                </tr>
            </table>
            <hr>
        </div>
        <?php endforeach; ?>
    </div>
    
    <button type="button" id="add-faq" class="button button-primary"><?php _e('Add FAQ', 'yoursite'); ?></button>
    
    <script>
    jQuery(document).ready(function($) {
        let faqIndex = <?php echo count($faqs); ?>;
        
        $('#add-faq').on('click', function() {
            const html = `
                <div class="faq-item" data-index="${faqIndex}">
                    <table class="feature-meta-table">
                        <tr>
                            <th><label>Question</label></th>
                            <td><input type="text" name="feature_faqs[${faqIndex}][question]" placeholder="What question might customers have?"></td>
                        </tr>
                        <tr>
                            <th><label>Answer</label></th>
                            <td>
                                <textarea name="feature_faqs[${faqIndex}][answer]" rows="3" placeholder="Clear, helpful answer"></textarea>
                                <button type="button" class="button button-small remove-faq" style="margin-top: 5px;">Remove</button>
                            </td>
                        </tr>
                    </table>
                    <hr>
                </div>
            `;
            $('#faqs-container').append(html);
            faqIndex++;
        });
        
        $(document).on('click', '.remove-faq', function() {
            $(this).closest('.faq-item').remove();
        });
    });
    </script>
    <?php
}

/**
 * Related Features Meta Box
 */
function yoursite_feature_related_meta_box_callback($post) {
    $related_features = get_post_meta($post->ID, '_feature_related_features', true) ?: array();
    
    // Get all feature pages except current one
    $feature_pages = get_posts(array(
        'post_type' => 'feature_pages',
        'posts_per_page' => -1,
        'post_status' => 'publish',
        'exclude' => array($post->ID)
    ));
    ?>
    
    <p><?php _e('Select related features to display at the bottom of this page:', 'yoursite'); ?></p>
    
    <?php foreach ($feature_pages as $feature_page) : ?>
        <label style="display: block; margin-bottom: 8px;">
            <input type="checkbox" name="feature_related_features[]" value="<?php echo $feature_page->ID; ?>"
                   <?php checked(in_array($feature_page->ID, $related_features)); ?>>
            <?php echo esc_html($feature_page->post_title); ?>
        </label>
    <?php endforeach; ?>
    
    <?php if (empty($feature_pages)) : ?>
        <p class="description"><?php _e('No other feature pages found. Create more feature pages to show related features.', 'yoursite'); ?></p>
    <?php endif; ?>
    <?php
}

// =============================================================================
// SAVE META DATA
// =============================================================================

/**
 * Save feature page meta data
 */
function yoursite_save_feature_meta($post_id) {
    // Verify nonce
    if (!isset($_POST['yoursite_feature_meta_nonce']) || 
        !wp_verify_nonce($_POST['yoursite_feature_meta_nonce'], 'yoursite_save_feature_meta')) {
        return;
    }
    
    // Check if user has permission
    if (!current_user_can('edit_post', $post_id)) {
        return;
    }
    
    // Don't save on autosave
    if (defined('DOING_AUTOSAVE') && DOING_AUTOSAVE) {
        return;
    }
    
    // Save hero section data
    $hero_fields = array(
        'feature_hero_subtitle',
        'feature_hero_bg_type',
        'feature_hero_bg_image',
        'feature_hero_gradient_primary',
        'feature_hero_gradient_secondary',
        'feature_hero_cta_text',
        'feature_hero_cta_url'
    );
    
    foreach ($hero_fields as $field) {
        if (isset($_POST[$field])) {
            update_post_meta($post_id, '_' . $field, sanitize_text_field($_POST[$field]));
        }
    }
    
    // Save USP sections
    if (isset($_POST['feature_usp_sections'])) {
        $usp_sections = array();
        foreach ($_POST['feature_usp_sections'] as $usp) {
            if (!empty($usp['title'])) {
                $clean_usp = array(
                    'title' => sanitize_text_field($usp['title']),
                    'description' => sanitize_textarea_field($usp['description']),
                    'type' => sanitize_text_field($usp['type']),
                    'image' => esc_url_raw($usp['image']),
                    'svg_code' => wp_kses($usp['svg_code'], array(
                        'svg' => array(
                            'xmlns' => array(),
                            'width' => array(),
                            'height' => array(),
                            'viewbox' => array(),
                            'viewBox' => array(),
                            'fill' => array(),
                            'stroke' => array(),
                        ),
                        'g' => array('fill' => array(), 'stroke' => array()),
                        'path' => array(
                            'd' => array(),
                            'fill' => array(),
                            'stroke' => array(),
                            'stroke-width' => array(),
                        ),
                        'circle' => array(
                            'cx' => array(),
                            'cy' => array(),
                            'r' => array(),
                            'fill' => array(),
                        ),
                        'rect' => array(
                            'x' => array(),
                            'y' => array(),
                            'width' => array(),
                            'height' => array(),
                            'fill' => array(),
                        ),
                    ))
                );
                $usp_sections[] = $clean_usp;
            }
        }
        update_post_meta($post_id, '_feature_usp_sections', $usp_sections);
    }
    
    // Save capabilities
    if (isset($_POST['feature_capabilities'])) {
        $capabilities = array();
        foreach ($_POST['feature_capabilities'] as $capability) {
            if (!empty($capability['title'])) {
                $capabilities[] = array(
                    'title' => sanitize_text_field($capability['title']),
                    'description' => sanitize_textarea_field($capability['description'])
                );
            }
        }
        update_post_meta($post_id, '_feature_capabilities', $capabilities);
    }
    
    // Save integration details
    $integration_fields = array(
        'feature_setup_steps',
        'feature_api_info',
        'feature_technical_notes'
    );
    
    foreach ($integration_fields as $field) {
        if (isset($_POST[$field])) {
            update_post_meta($post_id, '_' . $field, sanitize_textarea_field($_POST[$field]));
        }
    }
    
    // Save case study
    update_post_meta($post_id, '_feature_case_study_enable', isset($_POST['feature_case_study_enable']) ? '1' : '0');
    
    $case_study_fields = array(
        'feature_case_study_company',
        'feature_case_study_challenge',
        'feature_case_study_implementation',
        'feature_case_study_results',
        'feature_case_study_quote',
        'feature_case_study_quote_author'
    );
    
    foreach ($case_study_fields as $field) {
        if (isset($_POST[$field])) {
            update_post_meta($post_id, '_' . $field, sanitize_textarea_field($_POST[$field]));
        }
    }
    
    // Save FAQs
    if (isset($_POST['feature_faqs'])) {
        $faqs = array();
        foreach ($_POST['feature_faqs'] as $faq) {
            if (!empty($faq['question'])) {
                $faqs[] = array(
                    'question' => sanitize_text_field($faq['question']),
                    'answer' => sanitize_textarea_field($faq['answer'])
                );
            }
        }
        update_post_meta($post_id, '_feature_faqs', $faqs);
    }
    
    // Save related features
    if (isset($_POST['feature_related_features'])) {
        $related_features = array_map('intval', $_POST['feature_related_features']);
        update_post_meta($post_id, '_feature_related_features', $related_features);
    } else {
        update_post_meta($post_id, '_feature_related_features', array());
    }
}
add_action('save_post', 'yoursite_save_feature_meta');

// =============================================================================
// ADMIN ENHANCEMENTS
// =============================================================================

/**
 * Add custom columns to feature pages list
 */
function yoursite_feature_pages_columns($columns) {
    $new_columns = array();
    $new_columns['cb'] = $columns['cb'];
    $new_columns['title'] = $columns['title'];
    $new_columns['hero_bg'] = __('Hero Background', 'yoursite');
    $new_columns['capabilities_count'] = __('Capabilities', 'yoursite');
    $new_columns['usp_count'] = __('USP Sections', 'yoursite');
    $new_columns['case_study'] = __('Case Study', 'yoursite');
    $new_columns['date'] = $columns['date'];
    
    return $new_columns;
}
add_filter('manage_feature_pages_posts_columns', 'yoursite_feature_pages_columns');

/**
 * Fill custom columns with data
 */
function yoursite_feature_pages_column_data($column, $post_id) {
    switch ($column) {
        case 'hero_bg':
            $bg_type = get_post_meta($post_id, '_feature_hero_bg_type', true);
            switch ($bg_type) {
                case 'gradient':
                    echo '<span style="color: #667eea;">●</span> Gradient';
                    break;
                case 'image':
                    echo '<span style="color: #10b981;">●</span> Image';
                    break;
                case 'image_gradient':
                    echo '<span style="color: #f59e0b;">●</span> Image + Gradient';
                    break;
                default:
                    echo '—';
            }
            break;
            
        case 'capabilities_count':
            $capabilities = get_post_meta($post_id, '_feature_capabilities', true);
            $count = is_array($capabilities) ? count($capabilities) : 0;
            echo $count . ' ' . _n('capability', 'capabilities', $count, 'yoursite');
            break;
            
        case 'usp_count':
            $usp_sections = get_post_meta($post_id, '_feature_usp_sections', true);
            $count = is_array($usp_sections) ? count($usp_sections) : 0;
            echo $count . ' ' . _n('USP section', 'USP sections', $count, 'yoursite');
            break;
            
        case 'case_study':
            $enabled = get_post_meta($post_id, '_feature_case_study_enable', true);
            if ($enabled) {
                echo '<span style="color: #10b981;">✓</span> Enabled';
            } else {
                echo '<span style="color: #6b7280;">—</span> Disabled';
            }
            break;
    }
}
add_action('manage_feature_pages_posts_custom_column', 'yoursite_feature_pages_column_data', 10, 2);

/**
 * Enqueue admin scripts and styles for feature pages
 */
function yoursite_feature_pages_admin_scripts($hook) {
    global $post_type;
    
    if ($post_type === 'feature_pages' && in_array($hook, array('post.php', 'post-new.php'))) {
        wp_enqueue_media();
        wp_enqueue_script('wp-color-picker');
        wp_enqueue_style('wp-color-picker');
        
        wp_add_inline_style('wp-admin', '
            .feature-pages-admin-header {
                background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
                color: white;
                padding: 20px;
                margin: 20px 0;
                border-radius: 8px;
            }
            .feature-pages-admin-header h2 {
                color: white;
                margin: 0 0 10px 0;
            }
            .feature-meta-table input:focus,
            .feature-meta-table textarea:focus,
            .feature-meta-table select:focus {
                border-color: #667eea;
                box-shadow: 0 0 0 1px #667eea;
            }
        ');
        
        wp_add_inline_script('jquery', '
            jQuery(document).ready(function($) {
                // Add helpful header
                if ($(".wrap h1").length && $(".wrap h1").text().includes("Feature")) {
                    $(".wrap h1").after(`
                        <div class="feature-pages-admin-header">
                            <h2>⭐ Feature Page Builder</h2>
                            <p>Create conversion-optimized feature pages with hero sections, USP sections, capabilities, case studies, and more.</p>
                        </div>
                    `);
                }
                
                // Initialize color pickers
                $(".color-picker").wpColorPicker();
            });
        ');
    }
}
add_action('admin_enqueue_scripts', 'yoursite_feature_pages_admin_scripts');

/**
 * Add feature pages to admin menu with counter
 */
function yoursite_feature_pages_admin_menu() {
    global $menu;
    
    // Find the feature pages menu item and add a counter
    foreach ($menu as $key => $item) {
        if (isset($item[2]) && $item[2] === 'edit.php?post_type=feature_pages') {
            $count = wp_count_posts('feature_pages');
            if ($count && $count->publish > 0) {
                $menu[$key][0] .= ' <span class="awaiting-mod">' . $count->publish . '</span>';
            }
            break;
        }
    }
}
add_action('admin_menu', 'yoursite_feature_pages_admin_menu', 999);

/**
 * Flush rewrite rules when feature pages are activated
 */
function yoursite_feature_pages_flush_rewrites() {
    yoursite_register_feature_pages_post_type();
    flush_rewrite_rules();
}
register_activation_hook(__FILE__, 'yoursite_feature_pages_flush_rewrites');

?>