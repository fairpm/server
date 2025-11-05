<?php

// Disable writing to the filesystem.
define( 'DISALLOW_FILE_MODS', true );

// GlotPress configuration.
define( 'GP_URL_BASE', '/' );
define( 'GP_TMPL_PATH', dirname( __DIR__ ) . '/content/plugins/f-translate/templates/' );

// SES configuration.
define( 'AWS_SES_WP_MAIL_REGION', 'us-east-1' );
define( 'AWS_SES_WP_MAIL_USE_INSTANCE_PROFILE', true );

// S3 Uploads configuration.
define( 'S3_UPLOADS_BUCKET', 'fairpm-site-production' );
define( 'S3_UPLOADS_REGION', 'us-east-1' );
define( 'S3_UPLOADS_USE_INSTANCE_PROFILE', true );

// Root path for URL structure for Packages for Aspire Explorer.
define( 'AE_ROOT', 'packages/' );
