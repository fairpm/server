<?php
/**
 * Edit link
 *
 * This function shows edit links.
 *
 * @package fair-parent
 * @link https://developer.wordpress.org/themes/basics/template-files/#template-partials
 */

namespace Fair_Parent;

function air_edit_link() {

  if ( ! get_edit_post_link() ) {
    return;
  } ?>

    <p class="edit-link">
      <a href="<?php echo esc_url( get_edit_post_link() ); ?>">
        <?php esc_html_e( 'Edit', 'fair-parent-theme' ); ?>
        <span class="screen-reader-text"><?php echo esc_html( get_the_title() ); ?></span>
      </a>
    </p>
  <?php
}
