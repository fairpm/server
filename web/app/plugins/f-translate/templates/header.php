<?php

gp_enqueue_styles( array( 'gp-jquery-webui-popover', 'driver-js' ) );
gp_enqueue_scripts( array( 'gp-tour' ) );

get_header();

do_blocks( '<!-- wp:template-part {"slug":"header"} /-->' );

?>
<script type="text/javascript">document.body.className = document.body.className.replace('no-js','js');</script>

<main class="wp-block-group" style="margin-top:var(--wp--preset--spacing--60)">

<article class="gp-content clearfix">
	<header>
		<h1 class="entry-title">Fair Translations</h1>
		<p class="entry-subtitle">
			Contribute to translation WordPress core, themes, and plugins by translating them into your language.
		</p>
	</header>

	<div id="gp-js-message"></div>

	<?php
	if ( gp_notice( 'error' ) ) :
		?>
		<div class="error">
			<?php echo gp_notice( 'error' ); //TODO: run kses on notices ?>
		</div>
		<?php
	endif;

	if ( gp_notice() ) :
		?>
		<div class="notice">
			<?php echo gp_notice(); ?>
		</div>
		<?php
	endif;

	echo gp_breadcrumb();

	do_action( 'gp_after_notices' );
