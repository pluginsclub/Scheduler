<!DOCTYPE html>
<html <?php language_attributes(); ?>>
<head>
<meta charset="<?php bloginfo( 'charset' ); ?>">
<meta name="viewport" content="width=device-width, initial-scale=1">
<link rel="profile" href="//gmpg.org/xfn/11">
<?php wp_head(); ?>
</head>
<body <?php body_class(); ?>>
<?php //wp_body_open hook if WordPress 5.2
    if ( function_exists( 'wp_body_open' ) ) {
        wp_body_open();
    } ?>
<a class="skip-link screen-reader-text" href="#content"><?php esc_attr_e( 'Skip to content', 'scheduler' ); ?></a>
<div id="wrapper">
    <div class="toggler sidenav-side">
			<span onclick="openNav()">
        	<div class="toggler-container">
            	<div class="sbar1"></div>
            	<div class="sbar2"></div>
            	<div class="sbar3"></div>
        	</div>
			</span>
    </div>

    <div id="sideSideNav" class="sidenav">
        <nav class="sidenav-wrap">
            <a href="<?php print scheduler_void_link(); ?>" class="sidenav closebtn" 
            onclick="closeNav()"><span>[ X ]</span></a> 

            <?php wp_nav_menu( array( 'container_id'   => 'sideNavWrap', 
                                      'theme_location' => 'primary',
                                      'menu_class'     => 'sidenav-menu',
                                      'items_wrap'     => '<ul>%3$s</ul>',
                                      'fallback_cb'    => 'scheduler_sidenav_side_nav_cb'
                                    ) ); ?>
        </nav>
   </div>    
        
        <header id="masthead" role="banner">
            <div id="branding">     
                
                <?php if( has_custom_logo() ) : ?>

                <div class="hgroup logo">
                    <figure class="header-logo">
                    <a title="<?php bloginfo( 'description' ); ?>" 
                       href="<?php echo esc_url( home_url( '/' ) ); ?>">
                       <?php echo scheduler_theme_custom_logo(); ?></a>
                    </figure>
                </div> 
                
                <?php update_post_thumbnail_cache(); 
                endif; ?>
                
                <div class="hgroup-headings">
                    <h1 class="site-title"><a href="<?php echo esc_url(home_url('/')); ?>" 
                        title="<?php bloginfo( 'name' ); ?>" 
                        rel="home"><?php bloginfo( 'name' ); ?></a></h1>
                    <h2 class="site-description"><?php bloginfo( 'description' ); ?></h2> 
                </div>

                    <div class="search-bar-nav">
                    
                        <?php get_search_form(); ?>
                        
                    </div>   
            </div><!-- ends branding -->
           
        </header>

    <div id="nav" role="navigation">

        <?php  wp_nav_menu( array( 'container_id' => 'primary_nav',
                                    'theme_location' => 'primary',
                                    'fallback_cb'     => 'wp_page_menu' ) ); ?>
                                    
    </div><div class="clearfix"></div>
        
    <nav id="sideDown" class="sidedown-box">

        <a href="#" title="<?php esc_attr_e( 'To top of this page', 'scheduler' ); ?>" 
            class="sidebar-nav-caret" rel="nofollow"><span class="down-caret">^</span></a>
        <a id="DownCaret" href="#sidebar" 
            title="<?php esc_attr_e( 'to widgets at bottom of page', 'scheduler' ); ?>" 
            class="sidebar-nav-caret">^</a>

    </nav> 
