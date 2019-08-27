<div id="sidebar-widget" class="sidebar" role="complementary">
    
    <nav id="nav" class="secondary-footer-nav" role="navigation">
        <?php  wp_nav_menu( array( 'theme_location' => 'secondary' ) ); ?>
    </nav>  

        <?php 
        if (is_active_sidebar('sidebar-1')) 
        { ?>
        
        <div class="sidebar-1">
        
            <?php dynamic_sidebar( 'sidebar-1' ); ?>

        </div>
        
        <?php 
        } ?>

</div><div class="clearfix"></div>