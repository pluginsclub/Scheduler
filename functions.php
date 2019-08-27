<?php
/**
 * @package WordPress
 * @subpackage Scheduler
 * Author: tradesouthwestgmailcom
 */
/**
 * Compares the version of WordPress running to the $version specified.
 *
 * @uses get_bloginfo() Retrieve info about WP.
 * @uses switch_theme() Revert back to last theme if false.
 * @returns boolean
 */
function scheduler_test_min_version() 
{
    if(version_compare(get_bloginfo('version'),'4.5', '<') ) {
	    
		add_action( 'admin_notices', 'scheduler_min_version_not_met_notice' );
        // Switches back to the previous theme if the minimum WP version is not met.
        switch_theme( get_option( 'theme_switched' ) );
        unset( $_GET['activated'] );
		return false;
	}
}
// An error notice that can be displayed if the Minimum PHP version is not met.
function scheduler_min_version_not_met_notice() 
{
	
	$class = 'notice notice-error';
    $message = __( 'It is recommended that you update WordPress to 4.5 or higher in order to use this theme.', 
                    'scheduler' );
 
    printf( '<div class="%1$s"><p>%2$s</p></div>', 
                esc_attr( $class ), esc_html( $message ) ); 
}

/**
 * Setup theme defaults and support various features available from WordPress core.
 * 
 * @since theme 1.0.8
 * 
 */
function scheduler_setup() 
{

    /* Switch default core markup for search form, comment form, and comments
     * to output valid HTML5.
     */
    add_theme_support( 'html5', array( 'search-form', 
                                        'comment-form', 
                                        'comment-list', 
                                        'gallery', 
                                        'caption', )
                                    );

    // This theme uses Featured Images (also known as post thumbnails)
    add_theme_support( 'post-thumbnails' ); 
    // Image size for blog excerpt
    set_post_thumbnail_size( 99, 99 );
    // Add default posts and comments RSS feed links to head
    add_theme_support( 'title-tag' );
    add_theme_support( 'automatic-feed-links' );
    add_theme_support( 'custom-logo' );
    // Add support for editor styles.
    add_theme_support( 'editor-styles' );
    /*
     * Enqueue fonts in the editor.
     * Font family enqueued from function @see scheduler_fonts_url() */
    add_editor_style( scheduler_fonts_url() );

    // language support - for translations
    load_theme_textdomain( 'scheduler', get_template_directory_uri() . '/languages' );

    // This theme uses wp_nav_menu in two locations.
    register_nav_menus(array(
        'primary'   => __('Primary Top Navigation', 'scheduler'),
        'secondary' => __('Footer Menu limited depth', 'scheduler')
        ));     

    //page background image and color support
    $scheduler_bkgrnd_defaults = array(
        'default-color'      => '#fcfcfc',
        'default-image'       => '',
        'wp-head-callback'     => '_custom_background_cb',
        'admin-head-callback'   => '',
        'admin-preview-callback' => ''
     );
    add_theme_support( 'custom-background', $scheduler_bkgrnd_defaults );

    /*
     * Implementation of the Custom Header feature.
     * Custom header image in top of page header
     * @link https://developer.wordpress.org/themes/functionality/custom-headers/
     * 
     * @uses scheduler_theme_header_style()
     * 
     */
    add_theme_support( 'custom-header',
        apply_filters( 'scheduler_custom_header_args', array(
            'default-image'          => get_template_directory_uri()
                                        . '/images/default-header.png',
            'default-text-color'    => '002222',
            'width'                => 1080,
            'height'              => 250,
            'flex-height'        => true,
            'flex-width'        => true,
            'wp-head-callback' => 'scheduler_theme_header_style',
        ) ) 
    );  
    /*
     * Register Default Headers 
     * @since 1.7.1
     * https://codex.wordpress.org/Function_Reference/register_default_headers
     * https://generatewp.com/snippet/OvG9wDA/ updated
     * Left @string $parenturl to adjust for child theme
     */
    $parenturl = get_template_directory_uri();

    $scheduler_suggested_imgs  =  array( 
        'scheduler_prague_clock' => array( 
        'description'          => __( 'Prague Astronomical Clock', 'scheduler' ),
        'url'                => $parenturl . '/images/default-header.jpg',
        'thumbnail_url'    => $parenturl . '/images/default-header-small.jpg',
        ), 
    );

    register_default_headers( $scheduler_suggested_imgs );   
}
add_action('after_setup_theme', 'scheduler_setup');

/**
 * Set the $content_width for things such as video embeds that may have generic widths.
 * @since 1.7 
 */
add_action( 'after_setup_theme', 'scheduler_content_width', 0 );

function scheduler_content_width() 
{

	$GLOBALS['content_width'] = apply_filters( 'scheduler_content_width', 740 );
}

/**
 * Enqueue scripts and styles.
 * $handle, $src, $deps, $ver, $media
 * @since 1.7
 * https://developer.wordpress.org/reference/functions/wp_enqueue_script/
 */ 
add_action( 'wp_enqueue_scripts', 'scheduler_enqueue_scripts' );

function scheduler_enqueue_scripts() 
{

    wp_enqueue_style( 'scheduler-theme', get_stylesheet_uri() );

    wp_enqueue_script( 'scheduler-menu', 
                        get_template_directory_uri() 
                        . '/js/scheduler-menu.js', 
                        array(), '1.0.2', false 
                    );
    wp_enqueue_script( 'scheduler-html5', 
                        get_template_directory_uri() 
                        . '/js/html5.js', 
                        array(), '3.7.3', true 
                    );
    wp_script_add_data( 'scheduler-html5', 'conditional', 'lt IE 9' );
    
    /* 
     * Adds JavaScript to pages with the comment form to support
     * sites with threaded comments (when in use). */
    if ( is_singular() && comments_open() && get_option( 'thread_comments' ) )
	    wp_enqueue_script( 'comment-reply' );  
}

/**
 * Enqueue supplemental block editor styles.
 */
add_action( 'enqueue_block_editor_assets', 'scheduler_editor_frame_styles' );

function scheduler_editor_frame_styles() 
{

    wp_enqueue_style( 'scheduler-editor-styles', get_theme_file_uri() 
    . '/css/scheduler-editor.css', false, '', 'all' );
}

/**
 * Load external script for Google fonts.
 * @since 1.8.0
 * 
 * Translators: If there are characters in your language that are not supported by 
 * Muli, translate this to 'off'. Do not translate into your own language.
 * 
 * Other good fonts for this theme can be easily changed out:
 * Slabo+27px 
 * Tillium+Web
 * @param  string $FontFamily Add formal name here and same (name only) in CSS file.
 * @return string $font_url   Clean url to Google font.
 */
function scheduler_fonts_url() 
{

    $fonts_url  = '';
    $FamilyName = 'Muli:200,400'; 
    $FontFamily = _x( 'on', $FamilyName .' font: on or off', 'scheduler' );
	if ( 'off' !== $FontFamily  ) {

		$font_families = array();
		if ( 'off' !== $FontFamily ) {

			$font_families[] = rawurlencode( $FamilyName );
		}
		$protocol    = is_ssl() ? 'https' : 'http';
		$query_args  = array(
			'family' => implode( '|', $font_families ),
			'subset' => rawurlencode( 'latin,latin-ext' ),
		);
	$fonts_url = add_query_arg( $query_args, "$protocol://fonts.googleapis.com/css" );
	}
	return esc_url( $fonts_url );
}

/**
 * Loads custom font CSS file.
 *
 * To disable in a child theme, use `wp_dequeue_style`
 * @see https://codex.wordpress.org/Function_Reference/wp_dequeue_style
 *
 * @return void
 */
add_action( 'wp_enqueue_scripts', 'scheduler_enqueue_fonts', 10 );

function scheduler_enqueue_fonts() 
{

	$fonts_url = scheduler_fonts_url();
	if ( ! empty( $fonts_url ) ) {

        wp_enqueue_style( 'scheduler-fonts', esc_url_raw( $fonts_url ), array(), null );
    }
}

/**
 * Add credit so footer hard coded script not returning invalid.
 * @since 1.8.21
 * @uses  meta_tag `web_author`
 * @see   https://www.metatags.org/meta_name_webauthor
 */
add_action( 'wp_head', 'scheduler_add_meta_author', 3, 1 );

function scheduler_add_meta_author() 
{

    echo '<meta name="designer" content="theme Scheduler by Tradesouthwest">';
}

/**
 * Theme widgets only for above footer section, below content.
 * https://developer.wordpress.org/reference/hooks/widgets_init/
 */
function scheduler_widgets_init() {
    register_sidebar( array(
        'name'         => 'Footer Sidebar',
        'id'           => 'sidebar-1',     
        'description'  => __('Widgets in this area will be shown at bottom of page.', 'scheduler'),
        'before_title' => '<h4>',
        'after_title'  => '</h4>',
        'before_widget' => '<div id="%1$s" class="widget %2$s">',
        'after_widget'  => '</div>',
    ) );
}
add_action( 'widgets_init', 'scheduler_widgets_init' );

/**
 * Create header styles
 * @since 1.8.1
 * 
 * @param string $modrepeat Header background repeat property.
 * @param string $modsize   Header background size property.
 * @return script           Stylesheet inline via the customizer option callback.
 * @since  1.8.26
 */
function scheduler_theme_header_style()
{

    /* You can over ride height by adding CSS 
       `max-height: x!important;` where x = less than 250px */
    $modrepeat = $modsize = $styl ='';
    $scheduler_header_text_color  = get_header_textcolor();
    $scheduler_header_image       = get_header_image();

    if ( get_header_image() )
    { 
        // Background repeat maybe
        if( true === get_theme_mod( 'scheduler_header_background_image_repeat_setting'))
             : $modrepeat = "background-repeat: repeat"; 
            else: 
                $modrepeat = "background-repeat: no-repeat";  
        endif;

        // Background size
        if ( true === get_theme_mod( 'scheduler_header_background_image_size_setting')) 
            : $modsize = "background-size: cover";
            else:
                $modsize = "background-position: center";
        endif; 
        // Ends if image not blank
    }
        /* Check if core option set 
           Otherwise set background image and titles color */
    if ( '' === get_header_textcolor() || ! display_header_text()  ) 
    {
        $styl = '.hgroup-headings { 
            position: absolute; 
            width: 0; 
            height: 0; 
            clip: rect(1px, 1px, 1px, 1px);}';
    }
    echo '<style id="scheduler-header" type="text/css">#branding{background: url( ' . esc_url( $scheduler_header_image ) . ' );' . esc_attr( $modrepeat ) . ';' . esc_attr( $modsize ) . '; }.site-title a,.site-description{color: #'. esc_attr( $scheduler_header_text_color ) . ';}' . $styl . '</style>'; 
}

/**
 * Support for logo customizer, output.
 * 
 * @since 1.8.21
 * @param  string $custom_logo_id   Find theme mod from Customizer settings.
 * @param  string $custom_logo_attr Attributes for custom logo rendering.
 * @return string                   HTML content.
 * 
 */
add_filter( 'get_custom_logo', 'scheduler_theme_custom_logo' );

function scheduler_theme_custom_logo() 
{

    $html = '';
    $custom_logo_id = get_theme_mod( 'custom_logo' );
    $alt = ( empty ( get_post_meta( $custom_logo_id, '_wp_attachment_image_alt', true ) ) )
            ? get_bloginfo( 'name', 'display' ) : get_post_meta( $custom_logo_id, '_wp_attachment_image_alt', true );
    
    $custom_logo_attr = array(
        'class' => 'header-logo scheduler-header-logo',
        'alt' => $alt,
    );
    $html = sprintf(
        '<a href="%1$s" class="custom-logo-link" rel="home">%2$s</a>',
        esc_url( home_url( '/' ) ),
        wp_get_attachment_image( $custom_logo_id, 'full', true, $custom_logo_attr )
    );

        return $html;
}

/**
 * Callback fallback for no menu. 
 * Fills side pullout nav with default menu items.
 * @since 1.8.0
 * 
 */  
function scheduler_sidenav_side_nav_cb() { 
    ?>
    <div class="sidenav">
        <ul id="sideNav">
            <?php
            wp_list_pages( array(
                'depth' => 3,
                'title_li' => ''
            ) );
            ?>
        </ul>
    </div>
    <?php
}

/**
 * Remove ellipsis and set read more text.
 * @return string Clean HTML output.
 * 
 */
/**
 * Filter whether a user is administrator so we are not showing their login name.
 * 
 * @since 1.8.2
 * 
 * This may be considered 'presentational' (author display) over plugin territory (security).
 * 
 * @param var $nickname(s) Display author nice_name maybe
 * @return string
 * 
 */
function scheduler_checkfor_nickname($post)
{

    global $post;
    $nickname = '';

    //Gets the ID of the author using the ID of the post
    $author_id = $post->post_author;

    //Gets all the data of the author, using the ID
    $authordata = get_the_author_meta('user_level', $author_id );

    //Checks if the author has the role-level of 'x'
    if ( $authordata >= absint( 9 ) ) 
    {
        $nickname = get_bloginfo( 'name' );
        } else {
        $nickname = get_the_author();
    }
        if ( get_theme_mod( 'scheduler_header_nickname_setting' ) ) : 
            
            $schdlr_nickname = get_theme_mod( 'scheduler_header_nickname_setting');
        
            if( $schdlr_nickname != false ) 
            { 

                return $nickname;
                } else {
                return get_the_author();
            }
        else:
            return get_the_author();
        endif;
}

/**
 * Programatically add script to mobile menu close link url.
 * @uses javascript void to avoid screen jumping onclick event.
 * 
 * @since 1.8.21
 * 
 */
function scheduler_void_link()
{
    
    return esc_js( 'javascript:void(0);' );
}

/**
 * Get copyright footing text from Customizer theme mod.
 * @since 1.8.21
 * @param string  $copy_text      Gets blog name.
 * @return string $copyright_text Admin option text encapsulated in anchor link.
 * 
 */
add_action( 'scheduler_copyright_footing', 'scheduler_maybe_copyright_footing' );

function scheduler_maybe_copyright_footing()
{

    $copy_text = ( empty( get_bloginfo( 'name' ) ) ) 
                   ? '' : get_bloginfo( 'name' ); 
    if ( get_theme_mod( 'scheduler_copyright_text_setting' ) ) :  

        $copytext = get_theme_mod( 'scheduler_copyright_text_setting' );

        if( $copytext !='')  
        { 

            $copy_text = get_theme_mod( 'scheduler_copyright_text_setting' );
            } 
            else { 
                $copy_text = get_bloginfo( 'name' ); 
        }

    endif;

    $copyright_text = '<p class="info">&copy; ' . esc_attr( date("Y") ) 
    . ' <a href="' . esc_url( home_url() ) . '" title="' . esc_attr( get_bloginfo( "name" ) ) 
    . '" rel="nofollow">' . esc_html( $copy_text ) . '</a></p>';  

        echo $copyright_text;
}

/**
 * Conditional footer scripts outputs javascript if page has comments.
 * Creates a hide/show toggler to comments form.
 * @since 1.8.22
 * 
 */
add_action( 'wp_print_scripts', 'scheduler_comment_form_footer_script' );

function scheduler_comment_form_footer_script()
{

    if ( is_singular() && comments_open() ) : 
        
        wp_enqueue_script( 'comments-toggle', get_template_directory_uri() 
        .'/js/scheduler-footer.js', 
        array( 'jquery' ), '', true );

    endif;
}

/**
 * Render a dropdown list for 404 page
 * @since 1.8.22
 * @uses  wp_dropdown_categories
 * @see https://codex.wordpress.org/Function_Reference/wp_dropdown_categories
 * 
 */
add_action( 'scheduler_category_list', 'scheduler_list_cats_dropdown' );

function scheduler_list_cats_dropdown()
{
    
    ?>
    <h2><?php _e( 'Posts by Category', 'scheduler' ); ?></h2>
<form id="category-select" class="category-select" action="<?php echo esc_url( home_url( '/' ) ); ?>" method="get">
 
    <?php
    $args = array(
        'show_option_none' => __( 'Select category', 'scheduler' ),
        'show_count'      => 1,
        'show_empty'     => 0,
        'orderby'       => 'name',
        'echo'         => 0,

    );
    ?>
 
    <?php $select  = wp_dropdown_categories( $args ); ?>
    <?php $replace = "<select$1 onchange='return this.form.submit()'>"; ?>
    <?php $select  = preg_replace( '#<select([^>]*)>#', $replace, $select ); ?>
 
    <?php echo $select; ?>
 
    <noscript>
        <input type="submit" value="<?php esc_attr_e( 'View', 'scheduler' ); ?>" />
    </noscript>
 
</form>
<?php 
}

/**
 * Render heading for page
 * @since 1.8.23
 * @uses  scheduler_checkfor_nickname to get option state
 * 
 * @return string $output HTML.
 * 
 */
//add_action( 'scheduler_page_heading', 'scheduler_heading_header_render' );
function scheduler_heading_header_render()
{
    ob_start();
    ?>

    <?php if( is_page() || is_singular() ) : ?>
    
        <h2 class="title-no-anchor"><?php the_title(); ?></h2>
    
    <?php 
    else: ?>
    
        <h2><a href="<?php the_permalink() ?>" rel="bookmark" 
        title="<?php the_title_attribute(); ?>">
        <small class="titleless"> </small> <?php the_title(); ?></a></h2>

    <?php 
    endif; ?>
        
    <p><span><?php echo esc_html( scheduler_checkfor_nickname( get_the_ID() ) ); ?> 
        - <?php the_time('l, F jS, Y'); ?> </span> <strong class="responses">
    <?php comments_popup_link('0 ', '1', '%'); ?> <img alt="!" 
    src="<?php echo esc_url( get_template_directory_uri() . '/images/comment.gif'); ?>" 
    width="16" /></strong></p>

<?php 
    $output = ob_get_clean();
        
        return $output;
}

/**
 * Display heading if certain page type
 * @since 1.8.23
 * @since 1.8.25      Changed to query object from get body class.
 * 
 * @uses   statement  Switch/case statement whos expression evaluates to a value 
 *                    that matches the value of the switch expression.
 * @return bool
 * @see https://developer.wordpress.org/reference/hooks/get_the_archive_title/
 * 
 * Note: `attachment` and `search` left out since theme has its own templates.
 * 
 */
//add_filter( 'get_the_archive_title', 'scheduler_the_page_type_title' );

function scheduler_the_page_type_title()
{

    switch( true ) 
    {

        case is_post_type_archive():
            return true;
        case is_category(): 
            return true;
        case is_tag():
            return true;
        case is_search(): 
            return true;
        case is_tax():
            return true;
        case is_year():
            return true;
        case is_month():
            return true;
        case is_day():
            return true;
        case is_author():
            return true;
        break;
        default:
            return false;
            break;
    } 
}

/**
 * Page type title property to filter p tag
 * @since 1.8.25
 */
function scheduler_before_page_type_title()
{

    return remove_filter( 'term_description', 'wpautop' );
}

/**
 * Page type title property to filter p tag
 * @since 1.8.25
 */
function scheduler_after_page_type_title()
{
    
    return apply_filters( 'term_description', 'wpautop' );
}

/**
 * Render heading for archive type pages
 * @since 1.8.25
 * @uses get_the_archive_description To check for description.
 * @see https://developer.wordpress.org/reference/functions/get_the_archive_description/
 */
function scheduler_display_archive_type_maybe()
{

    $output = '';
    /* Only display if archive or tax */
    if( scheduler_the_page_type_title() ) : 
        
        ob_start();
?>

        <section id="page_type" class="postmetadata postmeta-tall">

        <?php if ( get_the_archive_description() ) : ?>
        
        <?php scheduler_before_page_type_title(); ?>

            <h2><?php the_archive_title(); ?><br><small><span class="archive-meta">
            <?php the_archive_description(); ?></span></small></h2>
        
        <?php scheduler_after_page_type_title(); ?>
    
        <?php else: ?>
    
            <h2><?php the_archive_title(); ?></h2>
        
        <?php endif; ?>
        </section>

        <?php $output = ob_get_clean(); ?>    
    <?php 
    endif;

    return $output;
}

/**
 * Load Customizer settings API for this theme.
 * Register Customizer assets
 * @since 1.8.0
 * @see   https://codex.wordpress.org/Theme_Customization_API
 */
require_once get_template_directory() . '/customizer.php'; 
?>
