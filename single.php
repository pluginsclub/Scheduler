<?php 
/** 
 * Template for single posts.
 * @subpackage Scheduler theme
 * @since 1.8.0
 */ 
get_header(); 
?>

<section id="content" role="main"> 

<?php if (have_posts() ) 
{ ?>
    <?php while ( have_posts() ) 
    { the_post(); ?>

    <div id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
        
        <header class="postmetadata" role="content info">

            <?php // Header content in functions
            echo scheduler_heading_header_render(); ?>
                
        </header> 

        <article class="entry">

            <?php // Thumbnail page layout
            if ( has_post_thumbnail() ) { ?>
            
            <figure class="single-main-image">

                <?php the_post_thumbnail('medium'); ?>

            </figure>
            <?php 
            } ?>

            <div class="inner-content">
        
                <?php the_content(); ?><div class="schdlr-clearfix"></div>
           
            <?php wp_link_pages( array(
            'before'      => '<div class="pagelink"><span class="page-links-title">' 
                             . __( 'Pages:', 'scheduler' ) . '</span>',
            'after'       => '</div>',
            'link_before' => '<span>',
            'link_after'  => '</span>',
            ) ); ?>

                
            </div>

            <footer class="scheduler-entry-footer">

                <?php if( has_tag() ) { ?>

                    <p class="spanlink"><span><?php esc_html_e( 'Keywords: ', 
                    'scheduler' ); ?> </span> <?php the_tags( ' ', ', ' ); ?></p>

                <?php } ?>
                <?php if( has_category( ) ) 
                { ?>

                    <p class="spanlink"><span><?php esc_html_e( 'Topic:  ', 
                    'scheduler' ); ?></span> <?php the_category( ', ', ' ' ); ?></p> 

                <?php // Ends if-Cat 
                } ?>

                <p class="spanlink"><span><?php edit_post_link(); ?></span></p> 

            </footer>  

        </article>

    </div><!-- ends single posts -->  
                                
                <section id="comments">
                    
                    <?php comments_template(); ?>
                
                </section>
                <nav class="pagination lower-post-links">

        <?php /* using `the_post_navigation` returns block CSS property value 
        and incorrect characters for this theme. Falling back to inline value. 
        TODO: remove comment after review. */ 
        ?>
                <?php previous_post_link('&laquo; %link'); ?> =|= 
                <?php next_post_link('%link &raquo;'); ?>

                </nav>

    <?php // ends while loop 
    } ?>
        
    <?php // No posts found continue
    } else {  ?>

    <?php get_template_part( 'content', '404' ); ?>
        
<?php // ends if-posts loop
} ?>

</section>

<?php get_footer(); ?>