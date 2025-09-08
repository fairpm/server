<?php
/**
 * Navigation layout.
 *
 * @package fair-parent
 */

namespace Fair_Parent;

?>

<nav id="nav" class="nav-primary nav-menu" aria-label="<?php esc_html_e( 'Main', 'fair-parent-theme' ); ?>">

  <button aria-haspopup="true" aria-expanded="false" aria-controls="nav" id="nav-toggle" class="nav-toggle" type="button" aria-label="<?php esc_html_e( 'Menu', 'fair-parent-theme' ); ?>">
    <span class="hamburger" aria-hidden="true"></span>
  </button>

  <div id="menu-items-wrapper" class="menu-items-wrapper">
    <?php wp_nav_menu( array(
      'theme_location' => 'primary',
      'container'      => false,
      'depth'          => 4,
      'menu_class'     => 'menu-items',
      'menu_id'        => 'main-menu',
      'echo'           => true,
      'fallback_cb'    => __NAMESPACE__ . '\Nav_Walker::fallback',
      'items_wrap'     => '<ul id="%1$s" class="%2$s">%3$s</ul>',
      'has_dropdown'   => true,
      'walker'         => new Nav_Walker(),
    ) ); ?>
  </div>

</nav>
