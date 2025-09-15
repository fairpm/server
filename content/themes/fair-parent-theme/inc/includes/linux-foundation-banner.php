<?php
/**
 * Output Linux Foundation Project banner.
 *
 * @package fair-parent
 **/

namespace Fair_Parent;

/**
 * Output the Linux Foundation Project Banner at the top of the `body` element.
 */
function fair_linux_banner() {
	?>
	<aside id="lf-header">
		<div class="container">
			<a href="https://www.linuxfoundation.org/projects">
				<img src="<?php echo esc_url( get_template_directory_uri() ); ?>/svg/lfprojects_banner_other.svg" alt="The Linux Foundation Projects">
			</a>
		</div>
	</aside>
	<?php
}