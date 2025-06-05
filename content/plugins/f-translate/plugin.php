<?php
/**
 * Plugin Name: FAIR Server - Translate
 */

namespace FAIRServer\Translate;

use FAIRServer;

defined( 'WPORGPATH' ) or define( 'WPORGPATH', ABSPATH . '/wp-content/themes/pub/wporg/inc/' );

// Ported from dotorg.
require __DIR__ . '/wporg-gp-routes/wporg-gp-routes.php';

// Our code.
require __DIR__ . '/inc/namespace.php';
require __DIR__ . '/inc/stats/namespace.php';
require __DIR__ . '/inc/stats/class-discardedwarningstats.php';
require __DIR__ . '/inc/stats/class-projectstats.php';
require __DIR__ . '/inc/stats/class-warningstats.php';

FAIRServer\register_class_path( __NAMESPACE__, __DIR__ . '/inc/' );

bootstrap();
