<?php 
/**
 * Content for all page post_types 
 */
?>
<article class="entry entry-type-content">
                
    <div class="content">

        <div class="thumbnail">

            <?php if ( has_post_thumbnail() ) { 
                    the_post_thumbnail('medium'); } ?>
                
        </div>
            <div class="inner-content">

                <?php the_content(); ?><div class="schdlr-clearfix"></div>

                <?php wp_link_pages( array(
                'before' => '<div class="pagelink"><span class="page-links-title">' 
                    . __( 'Pages:', 'scheduler' ) . '</span>',
                'after'       => '</div>',
                'link_before' => '<span>',
                'link_after'  => '</span>',
                ) ); ?>

            </div>
            
                <?php if( has_tag() && 'post_tag' === has_tag() ) 
                { ?>

                    <p class="spanlink"><span><?php esc_html_e( 'Keywords: ', 
                    'scheduler' ); ?> </span> <?php the_tags( ' ', ', ' ); ?></p>

                    <?php // !Tag-link 
                    } ?>

                    <?php if( has_category() ) 
                    { ?>

                    <p class="spanlink"><span><?php esc_html_e( 'Topic: ', 
                    'scheduler' ); ?></span> <?php the_category( ' ', ', ' ); ?></p> 

                    <?php // !Cat-link 
                    } ?>

                <p class="spanlink"><?php edit_post_link( __('Edit', 'scheduler'), 
                                                        '<span>', '</span>'); ?></p>

    </div><!-- ends content -->
    
</article>

    <section id="comments">
        
        <?php comments_template(); ?>
    
    </section>
