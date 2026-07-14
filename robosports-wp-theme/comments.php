<?php
/**
 * The template for displaying comments
 */

if (post_password_required()) {
    return;
}
?>

<div id="comments" class="comments-area">
    <?php if (have_comments()) : ?>
        <h2 class="comments-title">
            <?php
            $comment_count = get_comments_number();
            if ('1' === $comment_count) {
                printf(_x('One comment on &ldquo;%1$s&rdquo;', 'comments title', 'robosports'), get_the_title());
            } else {
                printf(_nx('%1$s comment on &ldquo;%2$s&rdquo;', '%1$s comments on &ldquo;%2$s&rdquo;', $comment_count, 'comments title', 'robosports'), number_format_i18n($comment_count), get_the_title());
            }
            ?>
        </h2>

        <ol class="comment-list">
            <?php
            wp_list_comments(array(
                'style'       => 'ol',
                'short_ping'  => true,
                'avatar_size' => 50,
                'callback'    => 'robosports_comment_callback',
            ));
            ?>
        </ol>

        <?php
        the_comments_navigation(array(
            'prev_text' => __('← Older Comments', 'robosports'),
            'next_text' => __('Newer Comments →', 'robosports'),
        ));
        ?>

    <?php endif; ?>

    <?php if (!comments_open() && get_comments_number() && post_type_supports(get_post_type(), 'comments')) : ?>
        <p class="no-comments">
            <?php _e('Comments are closed.', 'robosports'); ?>
        </p>
    <?php endif; ?>

    <?php
    $commenter = wp_get_current_commenter();
    $comment_author = isset($commenter['comment_author']) ? $commenter['comment_author'] : '';
    $comment_author_email = isset($commenter['comment_author_email']) ? $commenter['comment_author_email'] : '';
    $comment_author_url = isset($commenter['comment_author_url']) ? $commenter['comment_author_url'] : '';

    comment_form(array(
        'title_reply'          => __('Leave a Comment', 'robosports'),
        'title_reply_to'       => __('Leave a Reply to %s', 'robosports'),
        'cancel_reply_link'    => __('Cancel Reply', 'robosports'),
        'label_submit'         => __('Post Comment', 'robosports'),
        'submit_button'        => '<input name="%1$s" type="submit" id="%2$s" class="cyber-button cyber-glow" value="%4$s" />',
        'comment_field'        => '<p class="comment-form-comment"><label for="comment">' . _x('Comment', 'noun', 'robosports') . ' <span class="required">*</span></label><textarea id="comment" name="comment" cols="45" rows="8" maxlength="65525" required="required" class="comment-textarea"></textarea></p>',
        'fields'               => array(
            'author' => '<p class="comment-form-author"><label for="author">' . __('Name', 'robosports') . ' <span class="required">*</span></label> <input id="author" name="author" type="text" value="' . esc_attr($comment_author) . '" size="30" maxlength="245" required="required" class="comment-input" /></p>',
            'email'  => '<p class="comment-form-email"><label for="email">' . __('Email', 'robosports') . ' <span class="required">*</span></label> <input id="email" name="email" type="email" value="' . esc_attr($comment_author_email) . '" size="30" maxlength="100" aria-describedby="email-notes" required="required" class="comment-input" /></p>',
            'url'    => '<p class="comment-form-url"><label for="url">' . __('Website', 'robosports') . '</label> <input id="url" name="url" type="url" value="' . esc_attr($comment_author_url) . '" size="30" maxlength="200" class="comment-input" /></p>',
        ),
        'class_form'           => 'comment-form glass',
        'class_submit'         => 'submit cyber-button',
    ));
    ?>
</div>

<?php
// Custom comment callback
function robosports_comment_callback($comment, $args, $depth) {
    $tag = ($args['style'] === 'div') ? 'div' : 'li';
    ?>
    <<?php echo $tag; ?> id="comment-<?php comment_ID(); ?>" <?php comment_class(empty($args['has_children']) ? '' : 'parent'); ?> class="comment-item">
        <div class="comment-body">
            <div class="comment-meta">
                <div class="comment-author vcard">
                    <?php echo get_avatar($comment, 40, '', '', array('class' => 'avatar comment-avatar')); ?>
                    <b class="fn comment-author-name">
                        <?php comment_author_link(); ?>
                    </b>
                </div>
                <div class="comment-metadata">
                    <time datetime="<?php comment_time('c'); ?>">
                        <?php comment_date(); ?> <?php _e('at', 'robosports'); ?> <?php comment_time(); ?>
                    </time>
                    <?php edit_comment_link(__('Edit', 'robosports'), '<span class="edit-link">', '</span>'); ?>
                </div>
            </div>

            <div class="comment-content">
                <?php comment_text(); ?>
            </div>

            <?php if ('0' == $comment->comment_approved) : ?>
                <em class="comment-awaiting-moderation">
                    <?php _e('Your comment is awaiting moderation.', 'robosports'); ?>
                </em>
            <?php endif; ?>

            <div class="reply">
                <?php
                comment_reply_link(array_merge($args, array(
                    'add_below' => 'comment',
                    'depth'     => $depth,
                    'max_depth' => $args['max_depth'],
                    'before'    => '<span class="reply-link">',
                    'after'     => '</span>',
                )));
                ?>
            </div>
        </div>
    </<?php echo $tag; ?>>
    <?php
}
?>
