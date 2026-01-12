<?php
/*
Plugin Name:  Disallow Indexing (FAIR)
Description:  Disallow indexing of your site on non-production environments.  Based on roots/bedrock-disallow-indexing.
Version:      1.0
Author:       FAIR
Author URI:   https://fair.pm
License:      MIT
*/

if (!defined('DISALLOW_INDEXING') || DISALLOW_INDEXING !== true) {
    return;
}

add_action('pre_option_blog_public', '__return_zero');

// Unlike the Roots Bedrock mu-plugin, this one does not add an admin notice.
