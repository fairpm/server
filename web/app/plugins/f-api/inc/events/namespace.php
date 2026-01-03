<?php
/**
 * Community events API.
 *
 * Powers the dashboard events widget.
 *
 * We store the cache for two hours, but update hourly, to ensure we always hit
 * the cache.
 */

namespace FAIRServer\API\Events;

use FAIRServer\API;
use WP_Error;
use WP_HTTP;
use WP_REST_Request;
use WP_REST_Response;
use WP_REST_Server;

const CACHE_GROUP = 'fairserver';
const CACHE_KEY = 'events';
const CACHE_LIFETIME = 2 * HOUR_IN_SECONDS;
const CRON_HOOK = 'fairserver_events_cron';
const CRON_SCHEDULE = 'hourly';
const HTTP_CACHE_MAXAGE = 10 * MINUTE_IN_SECONDS;
const HTTP_CACHE_SWR = 50 * MINUTE_IN_SECONDS;
const SOURCE_URL = 'https://thewp.world/wp-json/wp/v2/wordcamp?per_page=100';

/**
 * Bootstrap events API.
 */
function bootstrap() : void {
	add_action( 'init', __NAMESPACE__ . '\\schedule_cron' );
	add_action( 'rest_api_init', __NAMESPACE__ . '\\register_routes' );
	add_action( CRON_HOOK, __NAMESPACE__ . '\\refresh_events' );
}

/**
 * Pull data on an hourly basis.
 */
function schedule_cron() : void {
	if ( ! wp_next_scheduled( CRON_HOOK ) ) {
		wp_schedule_event( time(), CRON_SCHEDULE, CRON_HOOK );
	}
}

/**
 * Register the REST API routes.
 */
function register_routes() : void {
	register_rest_route( API\API_NAMESPACE, '/events', [
		'methods' => WP_REST_Server::READABLE,
		'callback' => __NAMESPACE__ . '\get_events',
		'permission_callback' => '__return_true',
	] );
}

/**
 * Refresh events data from thewp.world.
 *
 * This is refreshed hourly, so we always refresh before the cache expires.
 */
function refresh_events() : void {
	$response = wp_remote_get( SOURCE_URL, [
		'user-agent' => 'FAIR Server/1.0',
	] );
	if ( is_wp_error( $response ) ) {
		trigger_error(
			'Failed to fetch events from thewp.world: ' . $response->get_error_message(),
			E_USER_WARNING
		);
		return;
	}

	$body = wp_remote_retrieve_body( $response );
	if ( empty( $body ) ) {
		trigger_error(
			'Failed to fetch events from thewp.world: Empty response body',
			E_USER_WARNING
		);
		return;
	}
	$events = json_decode( $body, true );
	if ( json_last_error() !== JSON_ERROR_NONE ) {
		trigger_error(
			'Failed to decode events from thewp.world: ' . json_last_error_msg(),
			E_USER_WARNING
		);
		return;
	}

	wp_cache_set( CACHE_KEY, $events, CACHE_GROUP, CACHE_LIFETIME );
}

/**
 * Get the latest community events.
 *
 * @param WP_REST_Request $request The request object.
 * @return WP_REST_Response|WP_Error Response object on success or error.
 */
function get_events( WP_REST_Request $request ) {
	$data = wp_cache_get( CACHE_KEY, CACHE_GROUP );
	if ( ! $data ) {
		return new WP_Error(
			'fairserver.events.not_found',
			'Unable to fetch events.',
			[ 'status' => WP_Http::INTERNAL_SERVER_ERROR ]
		);
	}

	$response = rest_ensure_response( $data );
	$response->header(
		'Cache-Control',
		sprintf(
			'max-age=%d, stale-while-revalidate=%d',
			HTTP_CACHE_MAXAGE,
			HTTP_CACHE_SWR
		)
	);
	return $response;
}
