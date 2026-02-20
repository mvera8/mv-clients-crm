<?php
function crear_cpt_payments() {
    $labels = array(
        'name'                  => 'Pagos',
        'singular_name'         => 'Pago',
        'menu_name'             => 'Pagos',
        'name_admin_bar'        => 'Pago',
        'add_new'               => 'Añadir Nuevo',
        'add_new_item'          => 'Añadir Nuevo Pago',
        'new_item'              => 'Nuevo Pago',
        'edit_item'             => 'Editar Pago',
        'view_item'             => 'Ver Pago',
        'all_items'             => 'Todos los Pagos',
        'search_items'          => 'Buscar Pagos',
        'parent_item_colon'     => 'Pago Padre:',
        'not_found'             => 'No se encontraron pagos',
        'not_found_in_trash'    => 'No hay pagos en la papelera'
    );

    $args = array(
        'labels'                => $labels,
        'description'           => 'Gestión de pagos del CRM',
        'public'                => false, // 🔑
        'publicly_queryable'    => false, // 🔑
        'show_ui'               => true,
        'show_in_menu'          => true,
        'query_var'             => false, // 🔑
        'rewrite'               => false, // 🔑
        'has_archive'           => false, // 🔑
        'hierarchical'          => false,
        'menu_position'         => 8,
        'menu_icon'             => 'dashicons-money-alt',
        'supports'              => array('title', 'editor', 'custom-fields'),
        'show_in_rest'          => true,
    );

    register_post_type('payments', $args);
}
add_action('init', 'crear_cpt_payments');
