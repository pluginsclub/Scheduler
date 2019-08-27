<?php 
/**
 * Page template for Scheduler theme.
 * @subpackage Scheduler theme
 * @since 1.8.25
 * 
 */
get_header(); ?>

<section id="content" class="page-content-wrapper" role="main">

<?php while (have_posts()) 
{ ?>		
    <?php the_post(); ?>		
    
    <div id="post-<?php the_ID(); ?>" <?php post_class(); ?>>

        <header class="postmetadata" role="content info">

            <?php // Header content in functions
            echo scheduler_heading_header_render(); ?>

        </header>   

            <?php get_template_part( 'content', 'page' ); ?>
                
    </div>

<?php /* ends if loop */
} ?>

</section>

<?php get_footer(); ?>