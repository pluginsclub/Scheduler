<?php 
/*
 * If the current post is protected by a password and
 * the visitor has not yet entered the password we will
 * return early without loading the comments.
 */
?>
<?php if( comments_open() ) { ?>
    <?php if ( post_password_required() ) return; ?>

    <section>
        <ol class="commentlist" itemscope="commentText" 
                                itemtype="https://schema.org/UserComments">

            <?php wp_list_comments(); ?>

        </ol><!-- ends commentlist -->

        <?php  if ( get_comment_pages_count() > 1 && get_option( 'page_comments' ) ) : ?>
            
        <div class="postlink">
            <nav class="pagination post-page-nav" itemscope="itemscope" 
                 itemtype="https://schema.org/SiteNavigationElement">
                
                <?php previous_comments_link() ?>
                <?php next_comments_link() ?>
            
            </nav>
        </div>

        <?php endif; ?>

            <div class="scheduler-comment-form">

                <?php comment_form(); ?>

            </div>
    </section>

<?php } ?>
