<?php

namespace FAIRServer;

const NS_SEPARATOR = '\\';

/**
 * Register a path for autoloading.
 *
 * @param string $prefix The namespace prefix.
 * @param string $path   The path to the class files.
 * @return void
 */
function register_class_path( string $prefix, string $path ) : void {
	$prefix_length = strlen( $prefix );
	spl_autoload_register( function ( $class ) use ( $prefix, $prefix_length, $path ) {
		if ( strpos( $class, $prefix . NS_SEPARATOR ) !== 0 ) {
			return;
		}

		// Strip prefix from the start (ala PSR-4).
		$class = substr( $class, $prefix_length + 1 );
		$class = strtolower( $class );
		$class = str_replace( '_', '-', $class );
		$file  = '';

		// Split on namespace separator.
		$last_ns_pos = strripos( $class, NS_SEPARATOR );
		if ( $last_ns_pos !== false ) {
			$namespace = substr( $class, 0, $last_ns_pos );
			$class     = substr( $class, $last_ns_pos + 1 );
			$file      = str_replace( NS_SEPARATOR, DIRECTORY_SEPARATOR, $namespace ) . DIRECTORY_SEPARATOR;
		}
		$file .= 'class-' . $class . '.php';

		$path = $path . $file;

		if ( file_exists( $path ) ) {
			require_once $path;
		}
	} );
}
