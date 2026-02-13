<?php
/**
 * Template Part: Card (Bootstrap 5)
 */

 // Exit if accessed directly.
defined( 'ABSPATH' ) || exit;

$title = $args['title'] ?? '';
$total = $args['total'] ?? '';
$icon  = $args['icon'] ?? '';
$color = $args['color'] ?? 'secondary';
?>
<div class="card border-0 mb-3 shadow-sm">
    <div class="card-body">
        <div class="d-flex justify-content-between align-items-start">
            <div>
                <p class="text-muted mb-0 small text-uppercase">
                    <?php echo esc_html( $title ); ?>
                </p>
                <h2 class="fw-bold mb-0">
                    <?php echo esc_html( $total ); ?>
                </h2>
            </div>
            <?php
            if (isset( $icon ) && $icon ) {
                ?>
                <div class="rounded text-<?php echo esc_attr( $color ); ?> bg-<?php echo esc_attr( $color ); ?>-subtle p-3">
                    <?php echo $icon; ?>
                </div>
                <?php
            }
            ?>
        </div>
    </div>
</div>