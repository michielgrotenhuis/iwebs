<?php
/**
 * The template for displaying all pages
 */

get_header();
?>

<main id="primary" class="site-main">
    <div class="container mx-auto px-4 py-16">
        <div class="max-w-4xl mx-auto">
            
            <?php while (have_posts()) : the_post(); ?>
            
            <article id="page-<?php the_ID(); ?>" <?php post_class('bg-white rounded-lg shadow-sm p-8'); ?>>
                
                <!-- Page Header -->
                <header class="entry-header text-center mb-12">
                    <h1 class="entry-title text-3xl lg:text-5xl font-bold text-gray-900 mb-6 leading-tight">
                        <?php the_title(); ?>
                    </h1>
                    
                    <?php if (has_excerpt()) : ?>
                        <div class="entry-excerpt text-xl text-gray-600 leading-relaxed">
                            <?php the_excerpt(); ?>
                        </div>
                    <?php endif; ?>
                    
                    <?php if (has_post_thumbnail()) : ?>
                        <div class="mt-8">
                            <?php the_post_thumbnail('large', array('class' => 'w-full h-64 lg:h-96 object-cover rounded-lg')); ?>
                        </div>
                    <?php endif; ?>
                </header><!-- .entry-header -->

                <!-- Page Content -->
                <div class="entry-content prose prose-lg max-w-none">
                    <?php
                    the_content();

                    wp_link_pages(array(
                        'before' => '<div class="page-links mt-8 text-center"><span class="page-links-title text-gray-600">' . __('Pages:', 'yoursite') . '</span>',
                        'after'  => '</div>',
                        'link_before' => '<span class="inline-block mx-1 px-3 py-2 bg-blue-500 text-white rounded hover:bg-blue-600 transition-colors">',
                        'link_after' => '</span>',
                    ));
                    ?>
                </div><!-- .entry-content -->

                <!-- Page Footer -->
                <footer class="entry-footer mt-8 pt-8 border-t border-gray-200">
                    <?php
                    edit_post_link(
                        sprintf(
                            wp_kses(
                                __('Edit <span class="screen-reader-text">"%s"</span>', 'yoursite'),
                                array(
                                    'span' => array(
                                        'class' => array(),
                                    ),
                                )
                            ),
                            wp_kses_post(get_the_title())
                        ),
                        '<span class="edit-link inline-block bg-gray-100 text-gray-700 px-3 py-1 rounded hover:bg-gray-200 transition-colors">',
                        '</span>'
                    );
                    ?>
                </footer><!-- .entry-footer -->
            </article><!-- #page-<?php the_ID(); ?> -->

            <?php
            // If comments are open or we have at least one comment, load up the comment template.
            if (comments_open() || get_comments_number()) :
                ?>
                <div class="comments-section mt-16 pt-8 border-t border-gray-200">
                    <?php comments_template(); ?>
                </div>
                <?php
            endif;
            ?>

            <?php endwhile; // End of the loop. ?>
        </div>
    </div>
</main><!-- #primary -->

<?php
get_footer();
?>
