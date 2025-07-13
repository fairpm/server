<?php
/**
 * Connect environment variables to WP constants.
 */

defined( 'WP_HOME' ) or define( 'WP_HOME', getenv( 'WP_HOME' ) );
defined( 'WP_SITEURL' ) or define( 'WP_SITEURL', getenv( 'WP_SITEURL' ) );

defined( 'DB_HOST' ) or define( 'DB_HOST', getenv( 'DB_HOST' ) );
defined( 'DB_USER' ) or define( 'DB_USER', getenv( 'DB_USER' ) );
defined( 'DB_PASSWORD' ) or define( 'DB_PASSWORD', getenv( 'DB_PASSWORD' ) );
defined( 'DB_NAME' ) or define( 'DB_NAME', getenv( 'DB_NAME' ) );

define( 'ELASTICSEARCH_HOST', getenv( 'ELASTICSEARCH_HOST' ) );
define( 'ELASTICSEARCH_PORT', getenv( 'ELASTICSEARCH_PORT' ) );

if ( ! defined( 'AWS_XRAY_DAEMON_IP_ADDRESS' ) ) {
	define( 'AWS_XRAY_DAEMON_IP_ADDRESS', gethostbyname( getenv( 'AWS_XRAY_DAEMON_HOST' ) ) );
}

define( 'REDIS_HOST', getenv( 'REDIS_HOST' ) );
define( 'REDIS_PORT', getenv( 'REDIS_PORT' ) );
define( 'REDIS_SECURE', false );
define( 'REDIS_AUTH', '' );

global $redis_server;
$redis_server = [
	'host' => REDIS_HOST,
	'port' => REDIS_PORT,
];
