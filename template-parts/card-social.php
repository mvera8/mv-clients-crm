<?php
/**
 * Template Part: Card (Bootstrap 5)
 */

 // Exit if accessed directly.
defined( 'ABSPATH' ) || exit;

$key = $args['key'] ?? '';
$value = $args['value'] ?? '';
$link = 'martinverauy';

switch ( $key ) {
    case 'facebook':
        $symbol = '/';
        $color = '#3b5998';
        break;
    case 'instagram':
        $symbol = '@';
        $color = '#e4405f';
        break;
    default:
        $symbol = '';
        $color = 'secondary';
}
?>
<div class="card border-0 shadow-sm">
    <div class="card-body">
        <a href="<?php echo esc_url( 'https://' . $key . '.com/' . $link ); ?>" target="_blank" rel="noopener noreferrer" class="text-decoration-none">
            <div class="d-flex justify-content-end">
                <?php
                if (isset( $key ) && $key ) {
                    ?>
                    <div style="color: <?php echo esc_attr( $color ); ?>;">
                        <?php echo mv_icon_selector($key); ?>
                    </div>
                    <?php
                }
                ?>
            </div>
            <h2 class="fw-bold mb-0" style="color: <?php echo esc_attr( $color ); ?>;">
                <?php echo esc_html( $value ); ?>
            </h2>

            <p class="mb-0 small" style="color: <?php echo esc_attr( $color ); ?>;">
                <?php
                if (isset( $link ) && $link) {
                    echo esc_html( $symbol . $link );
                }
                ?>
            </p>
        </a>
    </div>
</div>