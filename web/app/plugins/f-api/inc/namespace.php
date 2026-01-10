<?php

namespace FAIRServer\API;

const API_NAMESPACE = 'fair/v1';

/**
 * Boostrap the API system.
 */
function bootstrap() : void {
	add_filter( 'rest_url_prefix', '__return_empty_string' );

	// Remove sitemaps.
	remove_action( 'init', 'wp_sitemaps_get_server' );

	// Remove default rewrites.
	add_filter( 'post_rewrite_rules', '__return_empty_array' );
	add_filter( 'date_rewrite_rules', '__return_empty_array' );
	add_filter( 'comments_rewrite_rules', '__return_empty_array' );
	add_filter( 'search_rewrite_rules', '__return_empty_array' );
	add_filter( 'author_rewrite_rules', '__return_empty_array' );
	add_filter( 'category_rewrite_rules', '__return_empty_array' );
	add_filter( 'tag_rewrite_rules', '__return_empty_array' );
	add_filter( 'post_format_rewrite_rules', '__return_empty_array' );
	add_filter( 'page_rewrite_rules', '__return_empty_array' );
	add_filter( 'root_rewrite_rules', '__return_empty_array' );

	// Register our own rewrites.
	add_action( 'init', __NAMESPACE__ . '\\register_rewrites' );
	add_action( 'parse_request', __NAMESPACE__ . '\\redirect_old_namespace', 0 );

	Events\bootstrap();
}

/**
 * Register rewrites to handle all API requests.
 *
 * By default, rest_get_url_prefix() being set to an empty string will not
 * correctly trigger rewrites due to the leading slash. We manually register
 * rewrites to handle this.
 */
function register_rewrites() : void {
	// Our regular rule would match, but WP::parse_request manually checks for
	// a specific '$' rule.
	add_rewrite_rule( '$', 'index.php?rest_route=/', 'bottom' );
	add_rewrite_rule( '^(.*)?', 'index.php?rest_route=/$matches[1]', 'bottom' );
}

/**
 * Redirect the wp-json default prefix.
 */
function redirect_old_namespace() : void {
	if ( strpos( $_SERVER['REQUEST_URI'], '/wp-json/' ) !== false ) {
		$new_url = substr( $_SERVER['REQUEST_URI'], 8 );
		wp_safe_redirect( rest_url( $new_url ), 301 );
		exit;
	}
}
