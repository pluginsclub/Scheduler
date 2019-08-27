<?php 
/**
 * Using this template for both blog home pages and for archive post type
 * @since 1.8.25
 */
?>
<article class="entry entry-type-excerpt">
    <div class="content">
    
    <?php // If is blog type page
    if( is_home() ) : ?>

        <div class="blog-excerpt">
    
    <?php // Not blog type page (excerpt) 
    else: ?>
    
        <div class="archive-excerpt">

    <?php /* Thumbnail displays inline if exists */
    endif; ?>

            <div class="excerpt-hasthumb">
            <?php 
            if ( has_post_thumbnail() ) 
            { ?>

            
                <figure class="thumbnail excerpt-thumbnail-small">
                
                        <?php the_post_thumbnail(); ?>
                
                </figure>

            <?php } ?>
            </div>

                <div class="inner-excerpt">
                
                    <?php the_content(); ?>

                </div>

        </div>
    </div>
</article>     