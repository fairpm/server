<?php
/**
 * Plugin Name: FAIR Server - Redirect to GitHub
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

	// Redirect to GitHub.
	wp_redirect( 'https://github.com/fairpm', 302 );
	exit;
} );
