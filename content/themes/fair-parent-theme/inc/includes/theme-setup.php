<?php
/**
 * Theme setup and supports.
 *
 * @package fair-parent
 **/

namespace Fair_Parent;

function theme_setup() {

  /**
   * Register menu locations
   */

  register_nav_menus( THEME_SETTINGS['menu_locations'] );

  /**
   * Load textdomain.
   */
  load_theme_textdomain( THEME_SETTINGS['textdomain'], get_template_directory() . '/languages' );

  /**
   * Define content width in articles
   */
  if ( ! isset( $content_width ) ) {
    $content_width = THEME_SETTINGS['content_width'];
  }
}

/**
 * Build theme support
 */
function build_theme_support() {
  add_theme_support( 'automatic-feed-links' );
  add_theme_support( 'title-tag' );
  add_theme_support( 'post-thumbnails' );
  add_theme_support( 'align-wide' );
  add_theme_support( 'wp-block-styles' );
  add_theme_support(
    'html5',
    [
      'search-form',
      'comment-form',
      'comment-list',
	  'navigation-widgets',
      'gallery',
      'caption',
      'script',
      'style',
    ]
  );
	// Disable Custom Colors
	add_theme_support( 'disable-custom-colors' );
	// Editor Color Palette
	add_theme_support(
		'editor-color-palette',
		array(
			array(
				'name'  => __( 'Orange', 'fair-parent-theme' ),
				'slug'  => 'orange',
				'color' => '#ffaa00',
			),
			array(
				'name'  => __( 'Green', 'fair-parent-theme' ),
				'slug'  => 'green',
				'color' => '#25b372',
			),
			array(
				'name'  => __( 'Blue', 'fair-parent-theme' ),
				'slug'  => 'blue',
				'color' => '#0073aa',
			),
			array(
				'name'  => __( 'Red', 'fair-parent-theme' ),
				'slug'  => 'red',
				'color' => '#970101',
			),
			array(
				'name'  => __( 'Dark Blue', 'fair-parent-theme' ),
				'slug'  => 'dark-blue',
				'color' => '#003d5c',
			),
			array(
				'name'  => __( 'Light Blue', 'fair-parent-theme' ),
				'slug'  => 'light-blue',
				'color'	=> '#66b3d6',
			),
			array(
				'name'  => __( 'Black', 'fair-parent-theme' ),
				'slug'  => 'black',
				'color' => '#000000',
			),
			array(
				'name'	=> __( 'White', 'fair-parent-theme' ),
				'slug'	=> 'white',
				'color'	=> '#FFFFFF',
			),
			array(
				'name'	=> __( 'Light Gray', 'fair-parent-theme' ),
				'slug'	=> 'light-gray',
				'color'	=> '#f6f7f7',
			),
			array(
				'name'	=> __( 'Dark Gray', 'fair-parent-theme' ),
				'slug'	=> 'dark-gray',
				'color'	=> '#565757',
			),
			array(
				'name'	=> __( 'Transparent Gray', 'fair-parent-theme' ),
				'slug'	=> 'transparent-gray',
				'color'	=> '#e6e6e766',
			),
		)
	);
}
