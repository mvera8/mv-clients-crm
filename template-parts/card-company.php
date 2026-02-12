<?php
/**
 * Template Part: Card Company (Bootstrap 5)
 */

 // Exit if accessed directly.
defined( 'ABSPATH' ) || exit;

$title = $args['title'] ?? 'Empresa';
$link = $args['link'] ?? '';
?>

<div class="col">
	<a class="text-decoration-none text-dark" href="<?php echo esc_url( $link ); ?>">
		<div class="card mb-3">
				<div class="card-body">
						<h5 class="fw-bold mb-0">
							<?php echo esc_html( $title ); ?>
						</h5>
						<p class="text-muted mb-0 small">
							Información de la empresa.
						</p>
				</div>
		</div>
	</a>
</div>
