<?php
/**
 * Component: Dashboard Sidebar
 *
 * @package mv-clients-crm
 */

// Exit if accessed directly.
defined( 'ABSPATH' ) || exit;
?>

<aside class="col-12 col-md-2">
    <?php
    get_template_part('template-parts/logo');
    get_template_part('template-parts/dashboard-menu');
    ?>
</aside>