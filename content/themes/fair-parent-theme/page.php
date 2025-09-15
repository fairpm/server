<?php
/**
 * The template for displaying all pages
 *
 * This is the template that displays all pages by default.
 * Please note that this is the WordPress construct of pages
 * and that other 'pages' on your WordPress site may use a
 * different template.
 *
 * @Date:   2019-10-15 12:30:02
 * @Last Modified by:   Roni Laukkarinen
 * @Last Modified time: 2022-02-08 17:03:18
 *
 * @package fair-parent
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/
 */

namespace Fair_Parent;

the_post();

get_header(); ?>

<main class="site-main" id="content">
	<article class="entry-content">
		<?php $class = ( is_front_page() ) ? 'screen-reader-text ' : ''; ?>
		<header class="<?php echo esc_attr( $class ); ?>entry-title">
			<?php the_title( '<h1 class="entry-header">', '</h1>' ); ?>
		</header>
		<div class="entry-body">
		<?php
			the_content();
			air_edit_link();
		?>
		</div>
	</article>
</main>

<?php get_footer();
