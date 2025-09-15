<?php
/**
 * The template for displaying 404 pages (not found)
 *
 * @Date:   2019-10-15 12:30:02
 * @Last Modified by:   Timi Wahalahti
 * @Last Modified time: 2021-01-12 15:13:28
 *
 * @package fair-parent
 * @link https://codex.wordpress.org/Creating_an_Error_404_Page
 */

namespace Fair_Parent;

get_header(); ?>

<main class="site-main" id="content">

  <section class="block block-error-404">
    <div class="container">
      <div class="content">

        <h1 id="content">404 <span class="screen-reader-text"><?php echo esc_html__( 'Page not found.', 'fair-parent-theme' ); ?></span></h1>
        <h2 aria-hidden="true"><?php echo esc_html__( 'Page not found.', 'fair-parent-theme' ); ?></h2>
        <p><?php echo esc_html__( 'The reason might be a mistyped or expired URL.', 'fair-parent-theme' ); ?></p>

      </div>
    </div>
  </section>

</main>

<?php

// Enable visible footer if fits project:
// get_footer();

// WordPress scripts and hooks
wp_footer();
