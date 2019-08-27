<?php 
/**
 * Attachment template used for multi-purpose attachments, images, files, etc.
 * @subpackage Scheduler theme
 * @since 1.8.0
 */
get_header(); ?>
<section id="content" role="main"> 

    <?php if (have_posts() ) { ?>
        <?php while ( have_posts() ) { the_post(); ?>

    <div id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
    
        <header class="postmetadata" role="content info">
            <h2 class="attach-viewer"><em><?php esc_html_e( 'Attachment Viewer: ', 'scheduler' ); ?></em> <?php the_title(); ?></h2>
            <p> <?php echo get_the_author(); ?> - <span><?php the_time('l, F jS, Y'); ?></span> 
        </header>
        <article class="entry">
            <div class="content">

            <div class="entry-attachment">
                <?php if ( wp_attachment_is_image( $post->id ) ) :
                    $att_image = wp_get_attachment_image_src( $post->id, "full"); ?>

                <p class="attachment">
                    <a class="img-responsive" 
                    href="<?php echo esc_url( wp_get_attachment_url( $post->id ) ); ?>"
                    title="<?php the_title_attribute(); ?>">
                    <img src="<?php echo esc_url($att_image[0]);?>" 
                    alt="<?php the_title_attribute(); ?>"
                    width="<?php echo esc_attr($att_image[1]);?>"
                    height="<?php echo esc_attr($att_image[2]);?>" /><a>
                </p>

                    <?php else : ?>

                    <a href="<?php echo esc_url(wp_get_attachment_url($post->ID)) ?>"
                       title="<?php echo esc_attr(get_the_title($post->ID), 1 ) ?>">
                       <?php print( esc_url_raw( basename($post->guid) ) ); ?></a>

                <?php endif; ?>
                <hr>

                <?php the_content(); ?>

            </div>

            <footer class="scheduler-entry-footer">

                <?php if( has_tag() && 'post_tag' === has_tag()  ) { ?>

                    <p class="spanlink"><span><?php esc_html_e( 'Keywords: ', 
                    'scheduler' ); ?> </span> <?php the_tags( ' ', ', ' ); ?></p>

                <?php } ?>
                <?php if( has_category( ) ) { ?>

                    <p class="spanlink"><span><?php esc_html_e( 'Topic:  ', 
                    'scheduler' ); ?></span> <?php the_category( ' ', ', ' ); ?></p> 

                <?php } ?>

            </footer>                      
                
                <section id="comments">
                    
                    <?php comments_template(); ?>
                
                </section>
    </div>
                <?php } ?><?php 
            } // ends if/while loop 
            ?>
            </div>
            </article>
            </div>
            </section>
 <div class="clearfix"></div>
<?php get_footer(); ?>