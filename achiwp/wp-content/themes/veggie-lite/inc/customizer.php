<?php
/**
 * Veggie Theme Customizer
 *
 * @package Veggie
 */

/**
 * Add postMessage support for site title and description for the Theme Customizer.
 *
 * @param WP_Customize_Manager $wp_customize Theme Customizer object.
 */
function veggie_customize_register( $wp_customize ) {
	$wp_customize->get_setting( 'blogname' )->transport         = 'postMessage';
	$wp_customize->get_setting( 'blogdescription' )->transport  = 'postMessage';
	$wp_customize->get_setting( 'header_textcolor' )->transport = 'postMessage';

	$wp_customize->add_section( 'veggie_general_options', array(
		'title'             => esc_html__( 'Theme Options', 'veggie' ),
		'priority'          => 1,
	) );
	/**
	* Search Bar
	*/
	$wp_customize->add_setting( 'veggie_search_top', array(
		'default'           => false,
		'sanitize_callback' => 'veggie_sanitize_checkbox',
	) );
	$wp_customize->add_control( 'veggie_search_top', array(
		'label'             => esc_html__( 'Hide Search Box', 'veggie' ),
		'section'           => 'veggie_general_options',
		'settings'          => 'veggie_search_top',
		'type'		        => 'checkbox',
		'priority'          => 1,
	) );

		/* Adds the individual sections for custom logo*/
	$wp_customize->add_section( 'veggie_logo_section' , array(
	  'title'       => esc_html__( 'Logo', 'veggie' ),
	  'priority'    => 28,
	  'description' => esc_html__( 'Upload a logo to replace the default site name and description in the header', 'veggie' )
	) );
	$wp_customize->add_setting( 'veggie_logo', array(
		'sanitize_callback' => 'esc_url_raw',
	) );
	$wp_customize->add_control( new WP_Customize_Image_Control( $wp_customize, 'veggie_logo', array(
		'label'    => esc_html__( 'Logo', 'veggie' ),
		'section'  => 'veggie_logo_section',
		'settings' => 'veggie_logo',
	) ) );
	
	/**
* Custom CSS
*/
	$wp_customize->add_section( 'veggie_custom_css_section' , array(
   		'title'    => esc_html__( 'Custom CSS', 'veggie' ),
   		'description'=> 'Add your custom CSS which will overwrite the theme CSS',
   		'priority'   => 32,
	) );

	/* Custom CSS*/
	$wp_customize->add_setting( 'veggie_custom_css', array(
		'default'           => '',
		'sanitize_callback' => 'veggie_sanitize_text',
	) );
	$wp_customize->add_control( 'veggie_custom_css', array(
		'label'             => esc_html__( 'Custom CSS', 'veggie' ),
		'section'           => 'veggie_custom_css_section',
		'settings'          => 'veggie_custom_css',
		'type'		        => 'textarea',
		'priority'          => 1,
	) );

}
add_action( 'customize_register', 'veggie_customize_register' );

/**
 * Sanitization
 */
//Checkboxes
function veggie_sanitize_checkbox( $input ) {
	if ( $input == 1 ) {
		return 1;
	} else {
		return '';
	}
}
//Integers
function veggie_sanitize_int( $input ) {
	if( is_numeric( $input ) ) {
		return intval( $input );
	}
}
//Text
function veggie_sanitize_text( $input ) {
	return wp_kses_post( force_balance_tags( $input ) );
}

/**
 * Binds JS handlers to make Theme Customizer preview reload changes asynchronously.
 */
function veggie_customize_preview_js() {
	wp_enqueue_script( 'veggie_customizer', get_template_directory_uri() . '/js/customizer.js', array( 'customize-preview' ), '20150908', true );
}
add_action( 'customize_preview_init', 'veggie_customize_preview_js' );