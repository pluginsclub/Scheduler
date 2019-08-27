<?php 
/**
 * Search results template for Scheduler theme.
 * @subpackage Scheduler theme
 * @since 1.8.25
 * 
 */
get_header(); ?>

<section id="content" class="page-content-wrapper" role="main">
    <header class="postmetadata search-page-title" role="content info">
    <h2><?php esc_html_e( 'Search Results', 'scheduler' ); ?>
    <small><span class="archive-meta">
    <?php if ( the_archive_description() != '' ) : ?> 
            
            <?php the_archive_description(); ?>

    <?php endif; ?></span></small></h2>
    </header>

<?php if (have_posts()) 
{ ?>	

    

    <?php while (have_posts()) 
    { ?>		
        <?php the_post(); ?>		
    
    <div id="post-<?php the_ID(); ?>" <?php post_class(); ?>>

        <header class="postmetadata">

            <?php // Header content in functions
            echo scheduler_heading_header_render(); ?>

        </header>   

            <?php get_template_part( 'content' ); ?>
                
    </div>

    <?php /* ends while loop */
    } ?> 

        <?php 
        the_posts_pagination( array(
            'mid_size' => 2,
            'prev_text' => '&laquo; ' . __( 'Prev', 'scheduler' ),
            'next_text' => __( 'Next', 'scheduler' ) . ' &raquo;',
        ) ); ?> 

    <?php // No posts found continue to 404 type
    } else {  ?>

        <?php get_template_part( 'content', '404' ); ?>

<?php /* ends if loop */
} ?>

</section>

<?php get_footer(); ?>