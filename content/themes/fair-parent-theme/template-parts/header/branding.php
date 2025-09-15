<?php
/**
 * Site branding & logo
 *
 * @package fair-parent
 */

namespace Fair_Parent;

$description = get_bloginfo( 'description', 'display' );
?>

<div class="site-branding">
<?php
	$el = ( is_front_page() ) ? 'h1' : 'p';
	$is_current = ( is_front_page() ) ? ' aria-current="page"' : '';
?>
  <<?php echo $el; ?> class="site-title">
    <a href="<?php echo esc_url( home_url( '/' ) ); ?>" rel="home"<?php echo $is_current; ?>>
		<?php include get_theme_file_path( THEME_SETTINGS['logo'] ); ?>
		<?php bloginfo( 'name' ); ?>
    </a>
  </<?php echo $el; ?>>

  <?php if ( $description || is_customize_preview() ) : ?>
    <p class="site-description">
      <?php echo esc_html( $description ); ?>
    </p>
  <?php endif; ?>

</div>
