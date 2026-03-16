<?php
/**
 * Component: Dashboard Sidebar
 *
 * @package mv-clients-crm
 */

// Exit if accessed directly.
defined( 'ABSPATH' ) || exit;
?>

<aside id="dashboard-sidebar" class="col-12 col-md-2 position-relative">
    <div class="sticky">
        <?php
        get_template_part('template-parts/logo');
        get_template_part('template-parts/modal-button');
        get_template_part('template-parts/dashboard-menu');
        ?>
    </div>
</aside>

<?php
get_template_part('template-parts/modal');
