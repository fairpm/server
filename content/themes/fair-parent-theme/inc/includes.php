<?php
/**
 * Include custom features etc.
 *
 * @package fair-parent
 */

namespace Fair_Parent;

// Theme setup
require get_theme_file_path( '/inc/includes/theme-setup.php' );

// Nav walkers
require get_theme_file_path( '/inc/includes/nav-walker.php' );
require get_theme_file_path( '/inc/includes/nav-walker-footer.php' );
// Post type and taxonomy base classes
// We check this with if, because this stuff will not go to WP theme directory
if ( file_exists( get_theme_file_path( '/inc/includes/taxonomy.php' ) ) ) {
  require get_theme_file_path( '/inc/includes/taxonomy.php' );
}

if ( file_exists( get_theme_file_path( '/inc/includes/post-type.php' ) ) ) {
  require get_theme_file_path( '/inc/includes/post-type.php' );
}

if ( file_exists( get_theme_file_path( '/inc/includes/linux-foundation-banner.php' ) ) ) {
	require get_theme_file_path( '/inc/includes/linux-foundation-banner.php' );
}
