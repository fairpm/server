<?php
// wp-config-ddev.php not needed

/**
 * Main config file.
 *
 * Configuration should go into .config instead of here.
 *
 * phpcs:disable PSR1.Files.SideEffects
 */

 if ( defined( 'WP_CLI' ) && WP_CLI && ! isset( $_SERVER['HTTP_HOST']   ) ) $_SERVER['HTTP_HOST'] = '';
if ( defined( 'WP_CLI' ) && WP_CLI && ! isset( $_SERVER['SERVER_PORT'] ) ) $_SERVER['SERVER_PORT'] = '';

// Load an escape hatch early load file, if it exists.
if ( is_readable( __DIR__ . '/.config/load-early.php' ) ) {
	include_once __DIR__ . '/.config/load-early.php';
}

// Load the plugin API (like add_action etc) early, so everything loaded
// via the Composer autoloaders can using actions.
require_once __DIR__ . '/wordpress/wp-includes/plugin.php';

// Load the whole autoloader very early, this will also include
// all `autoload.files` from all modules.
require_once __DIR__ . '/vendor/autoload.php';

// Ready to go.
do_action( 'fairserver.loaded_autoloader' );

// Load the regular configuration.
if ( file_exists( __DIR__ . '/.config/load.php' ) ) {
	require_once __DIR__ . '/.config/load.php';
}

if ( ! defined( 'ABSPATH' ) ) {
	define( 'ABSPATH', __DIR__ . '/wordpress/' );
}

if ( ! defined( 'WP_CONTENT_DIR' ) ) {
	define( 'WP_CONTENT_DIR', __DIR__ . '/content' );
}

if ( ! defined( 'WP_CONTENT_URL' ) ) {
	//$protocol = ! empty( $_SERVER['HTTPS'] ) ? 'https' : 'http';
	//define( 'WP_CONTENT_URL', $protocol . '://' . $_SERVER['HTTP_HOST'] . '/content' );
	define( 'WP_CONTENT_URL', WP_HOME . '/content' );
}

if ( ! defined( 'WP_INITIAL_INSTALL' ) || ! WP_INITIAL_INSTALL ) {
	// Multisite is always enabled, unless some spooky
	// early loading code tried to change that of course.
	if ( ! defined( 'MULTISITE' ) ) {
		define( 'MULTISITE', true );
	}
}

if ( ! isset( $table_prefix ) ) {
	$table_prefix = getenv( 'TABLE_PREFIX' ) ?: 'wp_';
}

/*
 * DB constants are expected to be provided by other modules, as they are
 * environment specific.
 */
$required_constants = [
	'DB_HOST',
	'DB_NAME',
	'DB_USER',
	'DB_PASSWORD',
];

foreach ( $required_constants as $constant ) {
	if ( ! defined( $constant ) ) {
		http_response_code( 500 );
		// phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
		die( "$constant constant is not defined." );
	}
}

if ( ! getenv( 'WP_PHPUNIT__TESTS_CONFIG' ) ) {
	require_once ABSPATH . 'wp-settings.php';
}
