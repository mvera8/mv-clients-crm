<?php
/**
 * Template Part: Card (Bootstrap 5)
 */

 // Exit if accessed directly.
defined( 'ABSPATH' ) || exit;

$title = $args['title'];
$total = $args['total'];

?>
<div class="card mb-3">
    <div class="card-body">
        <p class="text-muted mb-0 small text-uppercase"><?php echo $title; ?></p>
        <h2 class="fw-bold mb-0"><?php echo $total; ?></h2>
    </div>
</div>