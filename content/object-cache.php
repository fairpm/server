<?php
WP_Predis\add_filters();

// Set the host from the environment variable before loading the plugin logic
if ( getenv( 'REDIS_PORT' ) && ! defined( 'WP_REDIS_PORT' ) ) {
	define( 'WP_REDIS_PORT', getenv( 'REDIS_PORT' ) );
}

if ( getenv( 'REDIS_HOST' ) && ! defined( 'WP_REDIS_BACKEND_HOST' ) ) {
    define( 'WP_REDIS_BACKEND_HOST', getenv( 'REDIS_HOST' ) );
}

require_once __DIR__ . '/plugins/wp-redis/object-cache.php';
