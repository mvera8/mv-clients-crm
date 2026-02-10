<?php
/**
 * Template Part: Title Section (Bootstrap 5)
 */

 // Exit if accessed directly.
defined( 'ABSPATH' ) || exit;

$title = $args['title'] ?? '';
?>


<header class="mb-4">
    <h1 class="mb-2">
        <?php echo $title; ?>
    </h1>
</header>