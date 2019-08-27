<?php
/**
 * Customizer settings here.
 * @package: Scheduler Theme
 * Header Background Image setting and Theme specific attributes.
 *
 * https://developer.wordpress.org/reference/classes/wp_customize_manager/add_setting/
 *
 * 
 */
add_action( 'customize_register', 'scheduler_register_theme_customizer_setup' );
add_action( 'wp_head', 'scheduler_customizer_head_css' );
//add_action( 'customize_register', 'de_register', 11 );
/**
 * Remove parts of the Options menu we don't use.
 *
 * @param WP_Customize_Manager $wp_customize Customizer manager.
 */



function scheduler_register_theme_customizer_setup($wp_customize)
{

    $wp_customize->add_section('scheduler_custom_setting_section', array(
            'title'             => __( 'Scheduler Theme Controls', 'scheduler' ),
            'priority'          => 15
        )); 
    //-----------------Settings-------------------------------------------------
    /* @since 1.8.23 */
    $wp_customize->add_setting( 'scheduler_navbars_color' , array(
        'default' => '#fafafa',
        'sanitize_callback' => 'sanitize_hex_color',
    ) );
    /* @since 1.8.21 */
	$wp_customize->add_setting(	
        'scheduler_copyright_text_setting', 
        array(
        'type'              => 'theme_mod',
        'capability'        => 'edit_theme_options',
        'default'           => '',
        'sanitize_callback'	=> 'sanitize_text_field',
        'transport'			=> 'refresh'
        )
    );
    $wp_customize->add_setting(
		// $id
		'scheduler_maybe_header_display_setting',
		// $args
		array(
            'type'              => 'theme_mod',
            'capability' => 'edit_theme_options',
			'default'			=> false,
			'sanitize_callback'	=> 'scheduler_sanitize_checkbox',
			'transport'			=> 'refresh'
		)
    );
    $wp_customize->add_setting(
		// $id
		'scheduler_maybe_searchbar_display_setting',
		// $args
		array(
            'type'              => 'theme_mod',
            'capability' => 'edit_theme_options',
			'default'			=> false,
			'sanitize_callback'	=> 'scheduler_sanitize_checkbox',
			'transport'			=> 'refresh'
		)
    );
    $wp_customize->add_setting(
		// $id
		'scheduler_page_hgroup_display_setting',
		// $args
		array(
			'default'			=> false,
			'sanitize_callback'	=> 'scheduler_sanitize_checkbox',
			'transport'			=> 'refresh'
		)
    );
    $wp_customize->add_setting(
		// @since 1.8.1
		'scheduler_header_nickname_setting',
		// $args
		array(
			'default'			=> false,
			'sanitize_callback'	=> 'scheduler_sanitize_checkbox',
			'transport'			=> 'refresh'
		)
    );
    $wp_customize->add_setting(
		// $id
		'scheduler_set_page_width_setting',
		// $args
		array(
            'type'              => 'theme_mod',
            'capability' => 'edit_theme_options',
			'default'			=> '90',
			'sanitize_callback'	=> 'esc_attr',
			'transport'			=> 'refresh'
		)
    );
    /* @since 1.0.8 */
    $wp_customize->add_setting(
		// $id
		'scheduler_header_background_image_repeat_setting',
		// $args
		array(
            'type'              => 'theme_mod',
            'capability' => 'edit_theme_options',
			'default'			=> false,
			'sanitize_callback'	=> 'scheduler_sanitize_checkbox',
			'transport'			=> 'refresh'
		)
    );
    /* @since 1.0.8 */
    $wp_customize->add_setting(
		// $id
		'scheduler_header_background_image_size_setting',
		// $args
		array(
            'type'              => 'theme_mod',
            'capability'        => 'edit_theme_options',
			'default'			=> true,
			'sanitize_callback'	=> 'scheduler_sanitize_checkbox',
			'transport'			=> 'refresh'
		)
    );
    
    //-----------------Controls-------------------------------------------------
    /* @since 1.8.23 */
    $wp_customize->add_control( 
        new WP_Customize_Color_Control( 
        $wp_customize, 
        'scheduler_navbars_color', 
        array(
            'label'       => __( 'Menu Background Color', 'scheduler' ),
            'description' => __( 'Top - Bottom and Side Navigation', 'scheduler' ),
            'section'     => 'colors',
            'settings'    => 'scheduler_navbars_color',
        ) ) 
    );
        // Scheduler copyright footing text
        $wp_customize->add_control(
            'scheduler_copyright_text_setting', 
            array(
                'settings'    => 'scheduler_copyright_text_setting',
                'section'     => 'scheduler_custom_setting_section',
                'type'        => 'text',
                'label'       => __( 'Replace Footer Copyright with Text', 'scheduler' ),
                'description' => __( 'Copyright in footer', 'scheduler' ),
            )
        );
     
    $wp_customize->add_control(
        // $id
        'scheduler_maybe_header_display_setting',
        // $args
        array(
            'settings'		=> 'scheduler_maybe_header_display_setting',
            'section'		=> 'scheduler_custom_setting_section',
            'type'			=> 'checkbox',
            'label'			=> __( 'Remove Header', 'scheduler' ),
            'description'	=> __( 'Check box to make more room for mobile', 'scheduler' ),
        )
    );
    $wp_customize->add_control(
        /* @since 1.0.8 */
        'scheduler_maybe_searchbar_display_setting',
        // $args
        array(
            'settings'		=> 'scheduler_maybe_searchbar_display_setting',
            'section'		=> 'scheduler_custom_setting_section',
            'type'			=> 'checkbox',
            'label'			=> __( 'Remove Searchbar', 'scheduler' ),
            'description'	=> __( 'Check box to remove searchbox for Header.', 'scheduler' ),
        )
    );
    $wp_customize->add_control(
        // $id
        'scheduler_page_hgroup_display_setting',
        // $args
        array(
            'settings'		=> 'scheduler_page_hgroup_display_setting',
            'section'		=> 'scheduler_custom_setting_section',
            'type'			=> 'checkbox',
            'label'			=> __( 'Remove SubHeader from Pages', 'scheduler' ),
            'description'	=> __( 'Check box to remove the secondary meta data heading from all pages except Post pages.', 'scheduler' ),
        )
    );
    /* @since 1.8.1 */
    $wp_customize->add_control(
        // $id
        'scheduler_header_nickname_setting',
        // $args
        array(
            'settings'		=> 'scheduler_header_nickname_setting',
            'section'		=> 'scheduler_custom_setting_section',
            'type'			=> 'checkbox',
            'label'			=> __( 'Remove Admin Login Name from Headers', 'scheduler' ),
            'description'	=> __( 'Check box to remove the author name on posts. Public display of Administrator login name is not a good practice.', 'scheduler' ),
        )
    );
    //scheduler_set_page_width_setting
    $wp_customize->add_control(
        'scheduler_set_page_width_setting',
        // $args
        array(
            'settings'		=> 'scheduler_set_page_width_setting',
            'section'		=> 'scheduler_custom_setting_section',
            'type'			=> 'number',
            'label'			=> __( 'Set Non Mobile Width of Page', 'scheduler' ),
            'description'	=> __( 'Add page width in PERCENTAGE for screens wider than 600px. Any screen smaller than 600px will not be affected by this setting.', 'scheduler' ),
            'input_attrs'   => array(
                            'min' => 60,
                            'max' => 102,
            ),
        ) 
    );
    /* @since 1.0.8 */
    $wp_customize->add_control(
		// $id
		'scheduler_header_background_image_repeat',
		// $args
		array(
			'settings'		=> 'scheduler_header_background_image_repeat_setting',
			'section'		=> 'header_image',
			'type'			=> 'checkbox',
			'label'			=> __( 'Background Repeat', 'scheduler' ),
			'description'	=> __( 'Should the header background image repeat?', 'scheduler' ),
		)
    );
    /* @since 1.0.8 */
    $wp_customize->add_control(
		// $id
		'scheduler_header_background_image_size',
		// $args
		array(
			'settings'		=> 'scheduler_header_background_image_size_setting',
			'section'		=> 'header_image',
			'type'			=> 'checkbox',
			'label'			=> __( 'Background Stretch', 'scheduler' ),
			'description'	=> __( 'Should the header background image stretch in full? Turn OFF if using background-repeat!', 
			                       'scheduler' ),
		)
    );   
}

//sanitize for checkbox
function scheduler_sanitize_checkbox( $checked ) {
	// Boolean check.
	return ( ( isset( $checked ) && true == $checked ) ? true : false );
}

// Site width & Maybe display header
function scheduler_customizer_head_css() 
{

    if ( get_theme_mods() )
    :   
    echo '<style id="scheduler_custmzr" type="text/css">';

        if ( get_theme_mod( 'scheduler_navbars_color' ) ) : 
            $schdlrnavbar = get_theme_mod( 'scheduler_navbars_color' );
            $schdlr_navbar = ( $schdlrnavbar !='' ) ? $schdlrnavbar : '#fafafa';
    echo '#nav{background:' . esc_attr($schdlr_navbar) . ';}';
        endif;
        if ( get_theme_mod( 'scheduler_maybe_header_display_setting' ) ) :
            $schdlrheader  = get_theme_mod( 'scheduler_maybe_header_display_setting');
            $schdlr_header = ( $schdlrheader ===false ) ? 'block' : 'none';
            if($schdlr_header !=false) {  
    echo '#masthead #branding{display:' . esc_attr($schdlr_header) . ';}';   
            }
        endif;
        if ( get_theme_mod( 'scheduler_maybe_searchbar_display_setting' ) ) :
            $schdlrsearch  = get_theme_mod( 'scheduler_maybe_searchbar_display_setting');
            $schdlr_search = ( $schdlrsearch ===false ) ? 'visible' : 'hidden';
            if($schdlr_search !=false) {  
    echo '.search-bar-nav{visibility:' . esc_attr($schdlr_search) . ';}';   
            }
        endif;
        if ( get_theme_mod( 'scheduler_page_hgroup_display_setting' ) ) :
            $schdlrhgroup  = get_theme_mod( 'scheduler_page_hgroup_display_setting');
            $schdlr_hgroup = ( $schdlrhgroup ===false ) ? 'block' : 'none';
            if($schdlr_hgroup !=false) {  
    echo '.page .postmetadata p{display:' . esc_attr($schdlr_hgroup) . ';}';   
            }
        endif;

        if ( get_theme_mod( 'scheduler_set_page_width_setting' ) ) :
            $schdlrwidth  = get_theme_mod( 'scheduler_set_page_width_setting');
            $schdlr_width = ( empty( $schdlrwidth ) ) ? '90' : $schdlrwidth;
echo '@media screen and (min-width: 600px){#wrapper{width:'. esc_attr($schdlr_width) .'%;}}'; 
        endif;
    echo '</style>';
        // Destroy strings to save PHP dump
        $schdlrheader = $schdlr_header = $schdlrsearch = $schdlr_search = 
        $schdlrhgroup = $schdlr_hgroup = $schdlrwidth = $schdlr_width = null;
    endif;
} 
