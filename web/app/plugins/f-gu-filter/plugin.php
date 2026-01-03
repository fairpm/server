<?php
/**
 * Plugin Name: FAIR Server - Git Updater Filter
 * Description: Filter GU output to rewrite download urls
 * Network: true
 */

namespace FAIRServer\GUFilter;

add_filter('rest_pre_echo_response', __NAMESPACE__ . '\\rewrite_gu_response');

function rewrite_gu_response($response)
{
    $download_link = $response['download_link'] ?? null;

    if (!$download_link || !str_contains($download_link, 'fairpm/fair-plugin')) {
        return $response;
    }

    $versions = $response['versions'] ?? null;
    if (!$versions) {
        error_log('WARNING: response contained download_link for fair-plugin but no versions: '
            . print_r($response, true));
        return $response;
    }

    $version = array_flip($versions)[$download_link] ?? null;
    if (!$version) {
        error_log('WARNING: download_link not contained in versions: ' . print_r($versions, true));
        return $response;
    }

    // This is hairier than it should be because of the screamingly bad idea of caching 404 responses
    $mirror_url = "https://download.fair.pm/release/fair-connect-$version.zip";
    $busted = $mirror_url . '?' . time();

    // throttle requests by way of a short cache on the un-busted url
    $status = get_transient("mirror_url:$mirror_url");
    if (!$status) {
        $result = wp_safe_remote_head($busted);
        $status = wp_remote_retrieve_response_code($result);
        set_transient("mirror_url:$mirror_url", $status, 300); // cache for 5 minutes
    }

    if ((int)$status !== 200) {
        error_log(__FUNCTION__ . ": HEAD on $mirror_url returned status $status");
        return $response;
    }

    $response['download_link'] = $busted; // need cache-busted url because a cached 404 is guaranteed to be broken
    return $response;
}
