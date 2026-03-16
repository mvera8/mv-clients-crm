<?php
/**
 * Component: Dashboard Sidebar
 *
 * @package mv-clients-crm
 */

// Exit if accessed directly.
defined( 'ABSPATH' ) || exit;
?>

<style>
    .stikcy {
        position: sticky;
        top: 0;
    }
</style>

<aside class="col-12 col-md-2 position-relative">
    <div class="stikcy">
        <?php
        get_template_part('template-parts/logo');
        get_template_part('template-parts/add-modal');
        get_template_part('template-parts/dashboard-menu');
        ?>
    </div>
</aside>