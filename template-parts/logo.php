<?php
/**
 * Template Part: Logo (Bootstrap 5)
 */

 // Exit if accessed directly.
defined( 'ABSPATH' ) || exit;

if ( function_exists( 'the_custom_logo' ) && has_custom_logo() ) {
	the_custom_logo();
} else {
	?>
	<div class="d-flex align-items-center px-3 mb-3">
		<div class="border-bottom w-100 py-4 text-center">
			<a href="<?php echo esc_url( home_url( '/' ) ); ?>" class="navbar-brand fw-semibold lead">
				<?php bloginfo( 'name' ); ?>
			</a>
		</div>
	</div>
	<?php
}