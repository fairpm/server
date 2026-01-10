<?php
/**
 * Custom stats for GlotPress.
 *
 * Based on code from https://github.com/WordPress/wordpress.org
 * Used under the GPLv2 license. Copyright authors.
 */

namespace FAIRServer\Translate\Stats;

use WP_CLI;

function bootstrap() {
	add_action( 'gp_init', initialize(...) );

	if ( defined( 'WP_CLI' ) && WP_CLI ) {
		WP_CLI::add_command( 'fair-translate stats init', __NAMESPACE__ . '\\init_command' );
	}
}

function initialize() {
	$GLOBALS['gp_custom_stats'] = [
		'user' => new UserStats(),
		'project' => new ProjectStats(),
		'warnings' => new WarningStats(),
		'discarded_warning' => new DiscardedWarningStats(),
	];
}

/**
 * Initialize the stats system, including database tables.
 */
function init_command( $args, $assoc_args ) {
	$schemas = [
		'user' => UserStats::get_schema(),
		'project' => ProjectStats::get_schema(),
		'warnings' => WarningStats::get_schema(),
		'discarded_warning' => DiscardedWarningStats::get_schema(),
	];

	if ( ! function_exists( 'dbDelta' ) ) {
		require_once ABSPATH . 'wp-admin/includes/upgrade.php';
	}

	foreach ( $schemas as $name => $schema ) {
		$res = dbDelta( $schema );
		foreach ( $res as $result ) {
			WP_CLI::line( $result );
		}
	}

	// Output a success message.
	WP_CLI::success( 'Stats tables initialized.' );
}
