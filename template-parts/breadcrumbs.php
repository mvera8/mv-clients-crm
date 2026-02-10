<?php
/**
 * Template Part: Card (Bootstrap 5)
 */

 // Exit if accessed directly.
defined( 'ABSPATH' ) || exit;

$active_link = $args['active_link'] ?? '';
$active_text = $args['active_text'] ?? '';
?>

<nav aria-label="breadcrumb">
    <ol class="breadcrumb">
        <li class="breadcrumb-item">
            <a href="<?php echo home_url('/'); ?>">Dashboard</a>
        </li>

        <?php
        if ($active_link) {
            printf(
                '<li class="breadcrumb-item"><a href="%s">%s</a></li>',
                
                home_url( strtolower( $active_link ) ),
                $active_link,
            );
        }
        ?>

        <li class="breadcrumb-item active" aria-current="page">
            <?php echo $active_text; ?>
        </li>
    </ol>
</nav>