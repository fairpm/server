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
  wp_register_style( 'root', get_stylesheet_uri(), [], filemtime( get_theme_file_path( 'style.css' ) ) );
  // Enqueue global.css
  wp_enqueue_style( 'styles',
    get_theme_file_uri( get_asset_file( 'global.css' ) ),
    ['root'],
    filemtime( get_theme_file_path( get_asset_file( 'global.css' ) ) )
  );

  // Enqueue jquery and front-end.js
  wp_enqueue_script( 'jquery-core' );
  wp_enqueue_script( 'scripts',
    get_theme_file_uri( get_asset_file( 'front-end.js' ) ),
    [],
    filemtime( get_theme_file_path( get_asset_file( 'front-end.js' ) ) ),
    true
  );

  // Required comment-reply script
  if ( is_singular() && comments_open() && get_option( 'thread_comments' ) ) {
    wp_enqueue_script( 'comment-reply' );
  }

  wp_localize_script( 'scripts', 'fair_parent_screenReaderText', [
    'expand_for'      => __( 'Open child menu for', 'fair-parent-theme' ),
    'collapse_for'    => __( 'Close child menu for', 'fair-parent-theme' ),
    'expand_toggle'   => __( 'Menu', 'fair-parent-theme' ),
    'collapse_toggle' => __( 'Menu', 'fair-parent-theme' ),
    'external_link'   => __( 'External site', 'fair-parent-theme' ),
    'target_blank'    => __( 'opens in a new window', 'fair-parent-theme' ),
    'previous_slide'  => __( 'Previous slide', 'fair-parent-theme' ),
    'next_slide'      => __( 'Next slide', 'fair-parent-theme' ),
    'last_slide'      => __( 'Last slide', 'fair-parent-theme' ),
    'skip_slider'     => __( 'Skip over the carousel element', 'fair-parent-theme' ),
  ] );

  // Add domains/hosts to disable external link indicators
  wp_localize_script( 'scripts', 'fair_parent_externalLinkDomains', THEME_SETTINGS['external_link_domains_exclude'] );
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
