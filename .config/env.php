<?php
/**
 * Connect environment variables to WP constants.
 */

defined( 'WP_HOME' ) or define( 'WP_HOME', getenv( 'WP_HOME' ) );
defined( 'WP_SITEURL' ) or define( 'WP_SITEURL', getenv( 'WP_SITEURL' ) );
define( 'CURRENT_PATH', '/wordpress/' );

// Multisite Cookie
define('ADMIN_COOKIE_PATH', '/');
define('COOKIE_DOMAIN', '');
define('COOKIEPATH', '');
define('SITECOOKIEPATH', '');

// Database
defined( 'DB_HOST' ) or define( 'DB_HOST', getenv( 'DB_HOST' ) );
defined( 'DB_USER' ) or define( 'DB_USER', getenv( 'DB_USER' ) );
defined( 'DB_PASSWORD' ) or define( 'DB_PASSWORD', getenv( 'DB_PASSWORD' ) );
defined( 'DB_NAME' ) or define( 'DB_NAME', getenv( 'DB_NAME' ) );

// Elasticsearch
define( 'ELASTICSEARCH_HOST', getenv( 'ELASTICSEARCH_HOST' ) );
define( 'ELASTICSEARCH_PORT', getenv( 'ELASTICSEARCH_PORT' ) );

// AWS
if ( ! defined( 'AWS_XRAY_DAEMON_IP_ADDRESS' ) ) {
	define( 'AWS_XRAY_DAEMON_IP_ADDRESS', gethostbyname( getenv( 'AWS_XRAY_DAEMON_HOST' ) ) );
}

// SSL
define('FORCE_SSL_ADMIN', true);
if (isset($_SERVER['HTTP_X_FORWARDED_PROTO']) && strpos($_SERVER['HTTP_X_FORWARDED_PROTO'], 'https') !== false) {
	$_SERVER['HTTPS']='on';
}

// Redis
define( 'REDIS_HOST', getenv( 'REDIS_HOST' ) );
define( 'REDIS_PORT', getenv( 'REDIS_PORT' ) );
define( 'REDIS_SECURE', false );
define( 'REDIS_AUTH', '' );

global $redis_server;
$redis_server = [
	'host' => REDIS_HOST,
	'port' => REDIS_PORT,
];
