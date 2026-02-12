<?php
WP_Predis\add_filters();

// Set the host from the environment variable before loading the plugin logic
if ( getenv( 'REDIS_HOST' ) ) {
    define( 'WP_REDIS_BACKEND_HOST', getenv( 'REDIS_HOST' ) );
    define( 'WP_REDIS_PORT', getenv( 'REDIS_PORT' ) ?: 6379 );
}

require_once __DIR__ . '/plugins/wp-redis/object-cache.php';
