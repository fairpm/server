<?php

/**
 * Plugin Name: FAIR Patterns Importer - WP CLI
 * Description: Using WP-CLI, create pattern categories and keywords, then import patterns from JSON files.
 * Author:      FAIR Contributors
 * License:     GPLv2
 */

namespace FAIR\Patterns;

if ( ! defined( 'WP_CLI' ) ) {
    return; // Bail if accessed directly.
}

use WP_CLI;

require_once __DIR__ . '/inc/class-importer.php';

WP_CLI::add_command( 'fair_patterns', __NAMESPACE__ . '\\Importer' );