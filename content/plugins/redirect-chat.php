<?php
/**
 * Plugin Name: FAIR Server - Redirect to Slack Registration
 *
 * To Do: Make this a more generic redirect to the Slack registration page.
 */

add_action( 'template_redirect', function() {
	// Logged in users can see the site.
	if ( is_user_logged_in() ) {
		return;
	}

	// Also, allow access to login and admin, even for non-logged-in users.
	// (Admin allows the redirect to the login page.)
	if ( is_admin() || is_login() ) {
		return;
	}

	// Redirect to Slack.
	wp_redirect( 'https://join.slack.com/t/fair/shared_invite/zt-38pl25a7p-Zyykxt~bVyv6WZA6i47wMw', 302 );
	exit;
} );
