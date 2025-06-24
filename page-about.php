<?php
/*
Template Name: About Us Page
*/

get_header(); ?>

<?php if (get_theme_mod('about_hero_enable', true)) : ?>
<!-- Hero Section -->
<section class="bg-gradient-to-br from-blue-50 to-indigo-100 py-20">
    <div class="container mx-auto px-4">
        <div class="max-w-4xl mx-auto text-center">
            <h1 class="text-4xl lg:text-6xl font-bold text-gray-900 mb-6">
                <?php echo esc_html(get_theme_mod('about_hero_title', __('We\'re making eCommerce accessible for everyone', 'yoursite'))); ?>
            </h1>
            <p class="text-xl text-gray-600 mb-8 max-w-3xl mx-auto">
                <?php echo esc_html(get_theme_mod('about_hero_subtitle', __('Founded in 2020, YourSite.biz started with a simple mission: to democratize online commerce by providing powerful, easy-to-use tools that help anyone build a successful online store.', 'yoursite'))); ?>
            </p>
        </div>
    </div>
</section>
<?php endif; ?>

<?php if (get_theme_mod('about_story_enable', true)) : ?>
<!-- Our Story -->
<section class="py-20">
    <div class="container mx-auto px-4">
        <div class="max-w-6xl mx-auto">
            <div class="grid lg:grid-cols-2 gap-12 items-center">
                <div>
                    <h2 class="text-3xl lg:text-4xl font-bold text-gray-900 mb-6">
                        <?php echo esc_html(get_theme_mod('about_story_title', __('Our Story', 'yoursite'))); ?>
                    </h2>
                    <p class="text-lg text-gray-600 mb-6">
                        <?php echo esc_html(get_theme_mod('about_story_paragraph_1', __('When we saw small businesses struggling with complicated and expensive eCommerce platforms, we knew there had to be a better way. We believed that powerful online store capabilities shouldn\'t be reserved for large enterprises with big budgets.', 'yoursite'))); ?>
                    </p>
                    <p class="text-lg text-gray-600 mb-6">
                        <?php echo esc_html(get_theme_mod('about_story_paragraph_2', __('Today, we\'re proud to serve over 50,000 merchants worldwide, from solo entrepreneurs to growing businesses. Our platform has processed over $2 billion in sales, helping our customers achieve their dreams of online success.', 'yoursite'))); ?>
                    </p>
                    <div class="grid grid-cols-3 gap-8 mt-8">
                        <?php for ($i = 1; $i <= 3; $i++) : 
                            $number = get_theme_mod("about_story_stat_{$i}_number", '');
                            $label = get_theme_mod("about_story_stat_{$i}_label", '');
                            if ($number && $label) :
                        ?>
                        <div class="text-center">
                            <div class="text-3xl font-bold text-blue-600"><?php echo esc_html($number); ?></div>
                            <div class="text-sm text-gray-600"><?php echo esc_html($label); ?></div>
                        </div>
                        <?php endif; endfor; ?>
                    </div>
                </div>
                <div class="bg-gradient-to-br from-blue-100 to-purple-100 rounded-lg p-8 flex items-center justify-center">
                    <div class="text-center">
                        <div class="w-32 h-32 bg-blue-200 rounded-lg mx-auto mb-4 flex items-center justify-center">
                            <svg class="w-16 h-16 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"></path>
                            </svg>
                        </div>
                        <p class="text-gray-600 font-medium">Empowering entrepreneurs worldwide</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
<?php endif; ?>

<?php if (get_theme_mod('about_values_enable', true)) : ?>
<!-- Our Values -->
<section class="bg-gray-50 py-20">
    <div class="container mx-auto px-4">
        <div class="max-w-6xl mx-auto">
            <div class="text-center mb-16">
                <h2 class="text-3xl lg:text-4xl font-bold text-gray-900 mb-4">
                    <?php echo esc_html(get_theme_mod('about_values_title', __('Our Values', 'yoursite'))); ?>
                </h2>
                <p class="text-xl text-gray-600">
                    <?php echo esc_html(get_theme_mod('about_values_subtitle', __('The principles that guide everything we do', 'yoursite'))); ?>
                </p>
            </div>
            
            <div class="grid md:grid-cols-2 lg:grid-cols-3 gap-8">
                <?php 
                // Value icons
                $value_icons = array(
                    1 => '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197m13.5-9a2.5 2.5 0 11-5 0 2.5 2.5 0 015 0z"></path>',
                    2 => '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>',
                    3 => '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"></path>',
                    4 => '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"></path>',
                    5 => '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z"></path>',
                    6 => '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 3v1m0 16v1m9-9h-1M4 12H3m15.364 6.364l-.707-.707M6.343 6.343l-.707-.707m12.728 0l-.707.707M6.343 17.657l-.707.707M16 12a4 4 0 11-8 0 4 4 0 018 0z"></path>'
                );
                
                for ($i = 1; $i <= 6; $i++) {
                    if (get_theme_mod("about_value_{$i}_enable", true)) :
                        $title = get_theme_mod("about_value_{$i}_title", '');
                        $description = get_theme_mod("about_value_{$i}_description", '');
                        $color = get_theme_mod("about_value_{$i}_color", '#3b82f6');
                        ?>
                        <div class="bg-white rounded-lg p-8 text-center feature-card border border-gray-200">
                            <div class="w-16 h-16 rounded-lg mx-auto mb-6 flex items-center justify-center" style="background-color: <?php echo esc_attr($color); ?>20;">
                                <svg class="w-8 h-8" style="color: <?php echo esc_attr($color); ?>;" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <?php echo $value_icons[$i]; ?>
                                </svg>
                            </div>
                            <h3 class="text-xl font-semibold mb-3"><?php echo esc_html($title); ?></h3>
                            <p class="text-gray-600"><?php echo esc_html($description); ?></p>
                        </div>
                        <?php
                    endif;
                }
                ?>
            </div>
        </div>
    </div>
</section>
<?php endif; ?>

<?php if (get_theme_mod('about_team_enable', true)) : ?>
<!-- Team Section -->
<section class="py-20">
    <div class="container mx-auto px-4">
        <div class="max-w-6xl mx-auto">
            <div class="text-center mb-16">
                <h2 class="text-3xl lg:text-4xl font-bold text-gray-900 mb-4">
                    <?php echo esc_html(get_theme_mod('about_team_title', __('Meet Our Team', 'yoursite'))); ?>
                </h2>
                <p class="text-xl text-gray-600">
                    <?php echo esc_html(get_theme_mod('about_team_subtitle', __('The people behind YourSite.biz', 'yoursite'))); ?>
                </p>
            </div>
            
            <div class="grid md:grid-cols-2 lg:grid-cols-4 gap-8">
                <?php for ($i = 1; $i <= 4; $i++) {
                    if (get_theme_mod("about_team_{$i}_enable", true)) :
                        $name = get_theme_mod("about_team_{$i}_name", '');
                        $position = get_theme_mod("about_team_{$i}_position", '');
                        $bio = get_theme_mod("about_team_{$i}_bio", '');
                        $initials = get_theme_mod("about_team_{$i}_initials", '');
                        $color = get_theme_mod("about_team_{$i}_color", '#3b82f6');
                        ?>
                        <div class="text-center">
                            <div class="w-32 h-32 rounded-full mx-auto mb-4 flex items-center justify-center" style="background: linear-gradient(to bottom right, <?php echo esc_attr($color); ?>CC, <?php echo esc_attr($color); ?>80);">
                                <span class="text-2xl font-bold text-white"><?php echo esc_html($initials); ?></span>
                            </div>
                            <h3 class="text-xl font-semibold mb-2"><?php echo esc_html($name); ?></h3>
                            <p class="font-medium mb-2" style="color: <?php echo esc_attr($color); ?>;"><?php echo esc_html($position); ?></p>
                            <p class="text-gray-600 text-sm"><?php echo esc_html($bio); ?></p>
                        </div>
                        <?php
                    endif;
                } ?>
            </div>
        </div>
    </div>
</section>
<?php endif; ?>

<?php if (get_theme_mod('about_awards_enable', true)) : ?>
<!-- Awards & Recognition -->
<section class="bg-gray-50 py-20">
    <div class="container mx-auto px-4">
        <div class="max-w-6xl mx-auto">
            <div class="text-center mb-16">
                <h2 class="text-3xl lg:text-4xl font-bold text-gray-900 mb-4">
                    <?php echo esc_html(get_theme_mod('about_awards_title', __('Awards & Recognition', 'yoursite'))); ?>
                </h2>
                <p class="text-xl text-gray-600">
                    <?php echo esc_html(get_theme_mod('about_awards_subtitle', __('Honored to be recognized by industry leaders', 'yoursite'))); ?>
                </p>
            </div>
            
            <div class="grid md:grid-cols-2 lg:grid-cols-4 gap-8">
                <?php for ($i = 1; $i <= 4; $i++) {
                    if (get_theme_mod("about_award_{$i}_enable", true)) :
                        $title = get_theme_mod("about_award_{$i}_title", '');
                        $source = get_theme_mod("about_award_{$i}_source", '');
                        $color = get_theme_mod("about_award_{$i}_color", '#eab308');
                        ?>
                        <div class="bg-white rounded-lg p-8 text-center feature-card border border-gray-200">
                            <div class="w-16 h-16 rounded-lg mx-auto mb-4 flex items-center justify-center" style="background-color: <?php echo esc_attr($color); ?>20;">
                                <svg class="w-8 h-8" style="color: <?php echo esc_attr($color); ?>;" fill="currentColor" viewBox="0 0 20 20">
                                    <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"></path>
                                </svg>
                            </div>
                            <h3 class="text-lg font-semibold mb-2"><?php echo esc_html($title); ?></h3>
                            <p class="text-gray-600 text-sm"><?php echo esc_html($source); ?></p>
                        </div>
                        <?php
                    endif;
                } ?>
            </div>
        </div>
    </div>
</section>
<?php endif; ?>


<?php get_footer(); ?>