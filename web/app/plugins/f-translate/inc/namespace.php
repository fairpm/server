<?php
namespace FAIRServer\Translate;

use WP_CLI;

function bootstrap() {

	add_action( 'gp_tmpl_load_locations', __NAMESPACE__ . '\\add_template_locations', 50, 4 );

	// Load the command class.
	if ( defined( 'WP_CLI' ) && WP_CLI ) {
		// WP_CLI::add_command( 'fair-translate', '__return_null' );
		WP_CLI::add_command( 'fair-translate project', __NAMESPACE__ . '\\ProjectCommand' );
		WP_CLI::add_command( 'fair-translate translation-set', __NAMESPACE__ . '\\TranslationSetCommand' );
	}
	Stats\bootstrap();
}

function add_template_locations( $locations, $template, $args, $template_path ) {
	// Add the theme directories to the template locations.
	$locations[] = get_stylesheet_directory() . '/glotpress';
	$locations[] = get_template_directory() . '/glotpress';
	return $locations;
}
