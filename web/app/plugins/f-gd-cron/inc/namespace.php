<?php

namespace FAIRServer\GD_Cron;

const CRON_HOOK = 'fairserver_gd_cron';
const CRON_SCHEDULE = 'f-5min';
const MAX_SITES = 100;

/**
 * Bootstrap.
 */
function bootstrap() : void {
	add_action( 'plugins_loaded', __NAMESPACE__ . '\\load' );
}

/**
 * Load the actions, for the main site only.
 */
function load() : void {
	if ( ! is_multisite() || ! is_main_site() ) {
		return;
	}

	add_filter( 'cron_schedules', __NAMESPACE__ . '\\add_cron_schedule' );
	add_action( 'init', function () {
		if ( ! wp_next_scheduled( CRON_HOOK ) ) {
			wp_schedule_event( time(), CRON_SCHEDULE, CRON_HOOK );
		}
	} );
	add_action( CRON_HOOK, __NAMESPACE__ . '\\run_cron' );
}

/**
 * Register our 5 minute schedule.
 *
 * @param array $schedules Existing schedules.
 * @return array Modified schedules.
 */
function add_cron_schedule( array $schedules ) : array {
	$schedules[ CRON_SCHEDULE ] = [
		'interval' => 5 * MINUTE_IN_SECONDS,
		'display' => __( 'FAIR Server - GD Cron', 'fairserver' ),
	];

	return $schedules;
}

/**
 * Run the cron job on all sites.
 *
 * GD only runs wp-cron on the main site, so we need to force-spawn it on all
 * sites.
 */
function run_cron() : void {
	$sites = get_sites( [
		'number' => MAX_SITES,
		'fields' => 'ids',
	] );

	foreach ( $sites as $site_id ) {
		switch_to_blog( $site_id );
		run_site_cron();
		restore_current_blog();
	}
}

/**
 * Spawn cron for the current site.
 *
 * @internal Copy of spawn_cron() to allow recursive spawning.
 */
function run_site_cron() : bool {
	$gmt_time = microtime( true );

	/*
	 * Get the cron lock, which is a Unix timestamp of when the last cron was spawned
	 * and has not finished running.
	 *
	 * Multiple processes on multiple web servers can run this code concurrently,
	 * this lock attempts to make spawning as atomic as possible.
	 */
	$lock = (float) get_transient( 'doing_cron' );

	if ( $lock > $gmt_time + 10 * MINUTE_IN_SECONDS ) {
		$lock = 0;
	}

	// Don't run if another process is currently running it or more than once every 60 sec.
	if ( $lock + WP_CRON_LOCK_TIMEOUT > $gmt_time ) {
		return false;
	}

	// Confidence check.
	$crons = wp_get_ready_cron_jobs();
	if ( empty( $crons ) ) {
		return false;
	}

	$keys = array_keys( $crons );
	if ( isset( $keys[0] ) && $keys[0] > $gmt_time ) {
		return false;
	}

	// Set the cron lock with the current unix timestamp, when the cron is being spawned.
	$doing_wp_cron = sprintf( '%.22F', $gmt_time );
	set_transient( 'doing_cron', $doing_wp_cron );

	$cron_request = apply_filters(
		'cron_request',
		array(
			'url'  => add_query_arg( 'doing_wp_cron', $doing_wp_cron, site_url( 'wp-cron.php' ) ),
			'key'  => $doing_wp_cron,
			'args' => array(
				'timeout'   => 0.01,
				'blocking'  => false,
				/** This filter is documented in wp-includes/class-wp-http-streams.php */
				'sslverify' => apply_filters( 'https_local_ssl_verify', false ),
			),
		),
		$doing_wp_cron
	);

	$result = wp_remote_post( $cron_request['url'], $cron_request['args'] );
	return ! is_wp_error( $result );
}
