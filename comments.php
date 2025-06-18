<?php
/**
 * The template for displaying comments
 */

/*
 * If the current post is protected by a password and
 * the visitor has not yet entered the password,
 * return early without loading the comments.
 */
if (post_password_required()) {
    return;
}
?>

<div id="comments" class="comments-area">

    <?php if (have_comments()) : ?>
        
        <!-- Comments Title -->
        <h2 class="comments-title text-2xl font-bold text-gray-900 mb-8">
            <?php
            $comment_count = get_comments_number();
            if ('1' === $comment_count) {
                printf(
                    /* translators: 1: title. */
                    esc_html__('One thought on &ldquo;%1$s&rdquo;', 'yoursite'),
                    '<span>' . wp_kses_post(get_the_title()) . '</span>'
                );
            } else {
                printf(
                    /* translators: 1: comment count number, 2: title. */
                    esc_html(_nx('%1$s thought on &ldquo;%2$s&rdquo;', '%1$s thoughts on &ldquo;%2$s&rdquo;', $comment_count, 'comments title', 'yoursite')),
                    number_format_i18n($comment_count), // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
                    '<span>' . wp_kses_post(get_the_title()) . '</span>'
                );
            }
            ?>
        </h2>

        <!-- Comments Navigation (Top) -->
        <?php the_comments_navigation(array(
            'prev_text' => '<svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"></path></svg>' . __('Older Comments', 'yoursite'),
            'next_text' => __('Newer Comments', 'yoursite') . '<svg class="w-4 h-4 ml-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path></svg>',
            'class' => 'comments-navigation flex justify-between items-center mb-8 pb-8 border-b border-gray-200'
        )); ?>

        <!-- Comments List -->
        <ol class="comment-list space-y-8 mb-12">
            <?php
            wp_list_comments(array(
                'style'       => 'ol',
                'short_ping'  => true,
                'avatar_size' => 60,
                'callback'    => 'yoursite_comment_callback',
            ));
            ?>
        </ol>

        <!-- Comments Navigation (Bottom) -->
        <?php the_comments_navigation(array(
            'prev_text' => '<svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"></path></svg>' . __('Older Comments', 'yoursite'),
            'next_text' => __('Newer Comments', 'yoursite') . '<svg class="w-4 h-4 ml-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path></svg>',
            'class' => 'comments-navigation flex justify-between items-center mt-8 pt-8 border-t border-gray-200'
        )); ?>

    <?php endif; // Check for have_comments(). ?>

    <?php if (!comments_open() && get_comments_number() && post_type_supports(get_post_type(), 'comments')) : ?>
        <p class="no-comments bg-yellow-50 border border-yellow-200 text-yellow-800 px-4 py-3 rounded-lg">
            <?php esc_html_e('Comments are closed.', 'yoursite'); ?>
        </p>
    <?php endif; ?>

    <?php
    // Comment Form
    $comment_form_args = array(
        'title_reply'          => __('Leave a Reply', 'yoursite'),
        'title_reply_to'       => __('Leave a Reply to %s', 'yoursite'),
        'title_reply_before'   => '<h3 id="reply-title" class="comment-reply-title text-2xl font-bold text-gray-900 mb-6">',
        'title_reply_after'    => '</h3>',
        'cancel_reply_before'  => ' <small>',
        'cancel_reply_after'   => '</small>',
        'cancel_reply_link'    => __('Cancel reply', 'yoursite'),
        'label_submit'         => __('Post Comment', 'yoursite'),
        'submit_button'        => '<input name="%1$s" type="submit" id="%2$s" class="%3$s" value="%4$s" />',
        'submit_field'         => '<p class="form-submit">%1$s %2$s</p>',
        'format'               => 'xhtml',
        'comment_field'        => '<p class="comment-form-comment mb-6"><label for="comment" class="block text-sm font-medium text-gray-700 mb-2">' . _x('Comment', 'noun', 'yoursite') . ' <span class="required text-red-500">*</span></label><textarea id="comment" name="comment" cols="45" rows="6" maxlength="65525" required="required" class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500" placeholder="' . __('Write your comment here...', 'yoursite') . '"></textarea></p>',
        'must_log_in'          => '<p class="must-log-in bg-blue-50 border border-blue-200 text-blue-800 px-4 py-3 rounded-lg">' . sprintf(
            /* translators: %s: login URL */
            __('You must be <a href="%s" class="text-blue-600 hover:text-blue-700 underline">logged in</a> to post a comment.', 'yoursite'),
            wp_login_url(apply_filters('the_permalink', get_permalink(get_the_ID())))
        ) . '</p>',
        'logged_in_as'         => '<p class="logged-in-as bg-green-50 border border-green-200 text-green-800 px-4 py-3 rounded-lg mb-6">' . sprintf(
            /* translators: 1: edit user link, 2: accessibility text, 3: user name, 4: logout URL */
            __('<a href="%1$s" aria-label="%2$s" class="text-green-600 hover:text-green-700 underline">Logged in as %3$s</a>. <a href="%4$s" class="text-green-600 hover:text-green-700 underline">Log out?</a>', 'yoursite'),
            get_edit_user_link(),
            /* translators: %s: user name */
            esc_attr(sprintf(__('Logged in as %s. Edit your profile.', 'yoursite'), $user_identity)),
            $user_identity,
            wp_logout_url(apply_filters('the_permalink', get_permalink(get_the_ID())))
        ) . '</p>',
        'comment_notes_before' => '<p class="comment-notes text-sm text-gray-600 mb-6">' . __('Your email address will not be published. Required fields are marked with an asterisk (*).', 'yoursite') . '</p>',
        'comment_notes_after'  => '',
        'id_form'              => 'commentform',
        'id_submit'            => 'submit',
        'class_container'      => 'comment-respond bg-white p-8 rounded-lg border border-gray-200 shadow-sm',
        'class_form'           => 'comment-form',
        'class_submit'         => 'btn-primary bg-blue-600 text-white px-6 py-3 rounded-lg font-semibold hover:bg-blue-700 transition-colors duration-200 cursor-pointer',
        'name_submit'          => 'submit',
        'fields'               => array(
            'author' => '<p class="comment-form-author mb-4"><label for="author" class="block text-sm font-medium text-gray-700 mb-2">' . __('Name', 'yoursite') . ' <span class="required text-red-500">*</span></label> <input id="author" name="author" type="text" value="' . esc_attr($commenter['comment_author']) . '" size="30" maxlength="245" autocomplete="name" required="required" class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500" /></p>',
            'email'  => '<p class="comment-form-email mb-4"><label for="email" class="block text-sm font-medium text-gray-700 mb-2">' . __('Email', 'yoursite') . ' <span class="required text-red-500">*</span></label> <input id="email" name="email" type="email" value="' . esc_attr($commenter['comment_author_email']) . '" size="30" maxlength="100" aria-describedby="email-notes" autocomplete="email" required="required" class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500" /></p>',
            'url'    => '<p class="comment-form-url mb-6"><label for="url" class="block text-sm font-medium text-gray-700 mb-2">' . __('Website', 'yoursite') . '</label> <input id="url" name="url" type="url" value="' . esc_attr($commenter['comment_author_url']) . '" size="30" maxlength="200" autocomplete="url" class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500" /></p>',
        ),
    );

    comment_form($comment_form_args);
    ?>

</div><!-- #comments -->

<style>
/* Comments styling */
.comments-area {
    margin-top: 2rem;
}

.comment-list {
    list-style: none;
    padding: 0;
}

.comment {
    margin-bottom: 2rem;
}

.comment-body {
    background: #f9fafb;
    border: 1px solid #e5e7eb;
    border-radius: 8px;
    padding: 1.5rem;
}

.comment-meta {
    margin-bottom: 1rem;
    display: flex;
    align-items: center;
    gap: 0.75rem;
}

.comment-author {
    font-weight: 600;
    color: #111827;
}

.comment-metadata {
    color: #6b7280;
    font-size: 0.875rem;
}

.comment-metadata a {
    color: #6b7280;
    text-decoration: none;
}

.comment-metadata a:hover {
    color: #374151;
    text-decoration: underline;
}

.comment-content {
    margin-bottom: 1rem;
    line-height: 1.6;
    color: #374151;
}

.comment-content p {
    margin-bottom: 1rem;
}

.comment-content p:last-child {
    margin-bottom: 0;
}

.reply {
    text-align: right;
}

.comment-reply-link {
    color: #667eea;
    text-decoration: none;
    font-size: 0.875rem;
    font-weight: 500;
}

.comment-reply-link:hover {
    color: #5b21b6;
    text-decoration: underline;
}

/* Nested comments */
.children {
    margin-top: 1.5rem;
    margin-left: 2rem;
    list-style: none;
    padding: 0;
}

.children .comment-body {
    background: #ffffff;
    border-left: 3px solid #667eea;
}

/* Comment form */
.comment-respond {
    margin-top: 3rem;
}

.comment-form input[type="text"],
.comment-form input[type="email"],
.comment-form input[type="url"],
.comment-form textarea {
    transition: border-color 0.15s ease-in-out, box-shadow 0.15s ease-in-out;
}

.comment-form input[type="text"]:focus,
.comment-form input[type="email"]:focus,
.comment-form input[type="url"]:focus,
.comment-form textarea:focus {
    border-color: #667eea;
    box-shadow: 0 0 0 3px rgba(102, 126, 234, 0.1);
}

/* Comments navigation */
.comments-navigation {
    margin: 2rem 0;
}

.comments-navigation .nav-previous,
.comments-navigation .nav-next {
    display: flex;
    align-items: center;
}

.comments-navigation a {
    color: #667eea;
    text-decoration: none;
    font-weight: 500;
    display: flex;
    align-items: center;
    padding: 0.5rem 1rem;
    border: 1px solid #e5e7eb;
    border-radius: 6px;
    transition: all 0.2s ease;
}

.comments-navigation a:hover {
    background-color: #f3f4f6;
    border-color: #667eea;
    color: #5b21b6;
}

/* Dark mode styles */
body.dark-mode .comment-body {
    background: var(--card-bg);
    border-color: var(--border-color);
}

body.dark-mode .comment-author {
    color: var(--text-primary);
}

body.dark-mode .comment-metadata,
body.dark-mode .comment-metadata a {
    color: var(--text-tertiary);
}

body.dark-mode .comment-metadata a:hover {
    color: var(--text-secondary);
}

body.dark-mode .comment-content {
    color: var(--text-secondary);
}

body.dark-mode .children .comment-body {
    background: var(--bg-primary);
    border-left-color: #667eea;
}

body.dark-mode .comment-respond {
    background: var(--card-bg);
    border-color: var(--border-color);
}

body.dark-mode .comment-form input[type="text"],
body.dark-mode .comment-form input[type="email"],
body.dark-mode .comment-form input[type="url"],
body.dark-mode .comment-form textarea {
    background: var(--bg-tertiary);
    border-color: var(--border-color);
    color: var(--text-primary);
}

body.dark-mode .comment-form label {
    color: var(--text-secondary);
}

body.dark-mode .comment-notes {
    color: var(--text-tertiary);
}

/* Responsive design */
@media (max-width: 768px) {
    .children {
        margin-left: 1rem;
    }
    
    .comment-meta {
        flex-direction: column;
        align-items: flex-start;
        gap: 0.5rem;
    }
    
    .comments-navigation {
        flex-direction: column;
        gap: 1rem;
    }
}
</style>

<?php
/**
 * Custom comment callback function
 */
function yoursite_comment_callback($comment, $args, $depth) {
    if ('div' === $args['style']) {
        $tag       = 'div';
        $add_below = 'comment';
    } else {
        $tag       = 'li';
        $add_below = 'div-comment';
    }
    ?>
    <<?php echo $tag; ?> <?php comment_class(empty($args['has_children']) ? '' : 'parent'); ?> id="comment-<?php comment_ID(); ?>">
    
    <?php if ('div' !== $args['style']) : ?>
        <div id="div-comment-<?php comment_ID(); ?>" class="comment-body">
    <?php endif; ?>
    
    <div class="comment-meta">
        <div class="comment-author vcard">
            <?php if ($args['avatar_size'] != 0) echo get_avatar($comment, $args['avatar_size'], '', '', array('class' => 'w-12 h-12 rounded-full')); ?>
            <?php
            /* translators: %s: comment author name */
            printf(__('<b class="fn">%s</b> <span class="says">says:</span>', 'yoursite'), get_comment_author_link());
            ?>
        </div>
        
        <div class="comment-metadata">
            <a href="<?php echo htmlspecialchars(get_comment_link($comment->comment_ID)); ?>">
                <?php
                /* translators: 1: date, 2: time */
                printf(__('%1$s at %2$s', 'yoursite'), get_comment_date(), get_comment_time());
                ?>
            </a>
            <?php edit_comment_link(__('(Edit)', 'yoursite'), '  ', ''); ?>
        </div>
    </div>

    <?php if ($comment->comment_approved == '0') : ?>
        <em class="comment-awaiting-moderation text-yellow-600 text-sm italic">
            <?php _e('Your comment is awaiting moderation.', 'yoursite'); ?>
        </em>
        <br />
    <?php endif; ?>

    <div class="comment-content">
        <?php comment_text(); ?>
    </div>

    <div class="reply">
        <?php
        comment_reply_link(array_merge($args, array(
            'add_below' => $add_below,
            'depth'     => $depth,
            'max_depth' => $args['max_depth']
        )));
        ?>
    </div>
    
    <?php if ('div' !== $args['style']) : ?>
        </div>
    <?php endif; ?>
    <?php
}
?>