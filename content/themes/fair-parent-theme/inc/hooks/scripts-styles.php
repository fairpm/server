<?php
/**
 * Enqueue and localize theme scripts and styles.
 *
 * @package fair-parent
 */

namespace Fair_Parent;

/**
 * Move jQuery to footer
 */
function move_jquery_into_footer( $wp_scripts ) {
  if ( ! is_admin() ) {
    $wp_scripts->add_data( 'jquery',         'group', 1 );
    $wp_scripts->add_data( 'jquery-core',    'group', 1 );
    $wp_scripts->add_data( 'jquery-migrate', 'group', 1 );
  }
} // end fair_parent_move_jquery_into_footer

/**
 * Enqueue scripts and styles.
 */
function enqueue_theme_scripts() {
	$version = ( SCRIPT_DEBUG ) ? filemtime( get_theme_file_path( 'style.css' ) ) : FAIR_PARENT_VERSION;
	wp_register_style( 'root', get_stylesheet_uri(), [], $version );
	// Enqueue global.css
	$version = ( SCRIPT_DEBUG ) ? filemtime( get_theme_file_path( get_asset_file( 'global.css' ) ) ) : FAIR_PARENT_VERSION;
	wp_enqueue_style( 'styles',
		get_theme_file_uri( get_asset_file( 'global.css' ) ),
		['root'],
		$version
	);

	$version = ( SCRIPT_DEBUG ) ? filemtime( get_theme_file_path( 'js/src/front-end.js' ) ) : FAIR_PARENT_VERSION;
	// Enqueue jquery and front-end.js
	wp_enqueue_script( 'jquery-core' );
	wp_enqueue_script_module( 'scripts',
		get_theme_file_uri( 'js/src/front-end.js' ),
		[],
		$version,
	);

  // Required comment-reply script
  if ( is_singular() && comments_open() && get_option( 'thread_comments' ) ) {
    wp_enqueue_script( 'comment-reply' );
  }

  add_filter(
	'script_module_data_scripts',
	function ( array $data ): array {
		$data['expand_for']      = __( 'Open child menu for', 'fair-parent-theme' );
		$data['collapse_for']    = __( 'Close child menu for', 'fair-parent-theme' );
		$data['expand_toggle']   = __( 'Menu', 'fair-parent-theme' );
		$data['collapse_toggle'] = __( 'Menu', 'fair-parent-theme' );
		$data['external_link']   = __( 'External site', 'fair-parent-theme' );
		$data['target_blank']    = __( 'opens in a new window', 'fair-parent-theme' );

		return $data;
	}
  );
} // end fair_parent_scripts

/**
 * Returns the built asset filename and path depending on
 * current environment.
 *
 * @param string $filename File name with the extension
 * @return string file and path of the asset file
 */
function get_asset_file( $filename ) {
  $env      = 'dev'; // At a later point, can reintroduce production builds.
  $filetype = pathinfo( $filename )['extension'];

  return "{$filetype}/{$env}/{$filename}";
} // end get_asset_file
