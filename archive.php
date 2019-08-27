<?php 
/**
 * Archives template for Scheduler theme.
 * @subpackage Scheduler theme
 * @since 1.8.27
 * 
 */
get_header(); ?>

<?php echo scheduler_display_archive_type_maybe(); ?>

<section id="content" class="page-content-wrapper" role="main">

<?php while (have_posts()) 
{ ?>		
    <?php the_post(); ?>		
    
    <div id="post-<?php the_ID(); ?>" <?php post_class(); ?>>

        <header class="postmetadata" role="content info">

            <?php // Header content in functions
            echo scheduler_heading_header_render(); ?>

        </header>   

            <?php get_template_part( 'content' ); ?>
                
    </div>

<?php /* ends if loop */
} ?>

</section>

<?php get_footer(); ?>