<?php
/**
 * Component: Dashboard Menu
 *
 * @package mv-clients-crm
 */

// Exit if accessed directly.
defined( 'ABSPATH' ) || exit;
?>

<header>
	<?php
        wp_nav_menu(
            array(
                'theme_location'  => 'primary-nav',
                'container'       => 'nav',
                // 'container_class' => 'd-flex flex-column gap-2 w-100',
                'menu_id'         => 'primary-nav',
                'menu_class'      => 'nav flex-column px-3',
                'depth'           => 0, 
                'walker'          => new Understrap_WP_Bootstrap_Navwalker(),
            )
        );
        ?>
</header>