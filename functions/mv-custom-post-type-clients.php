<?php
function crear_cpt_clients() {
    $labels = array(
        'name'                  => 'Clientes',
        'singular_name'         => 'Cliente',
        'menu_name'             => 'Clientes',
        'name_admin_bar'        => 'Cliente',
        'add_new'               => 'Añadir Nuevo',
        'add_new_item'          => 'Añadir Nuevo Cliente',
        'new_item'              => 'Nuevo Cliente',
        'edit_item'             => 'Editar Cliente',
        'view_item'             => 'Ver Cliente',
        'all_items'             => 'Todos los Clientes',
        'search_items'          => 'Buscar Clientes',
        'parent_item_colon'     => 'Cliente Padre:',
        'not_found'             => 'No se encontraron clientes',
        'not_found_in_trash'    => 'No hay clientes en la papelera'
    );

    $args = array(
        'labels'                => $labels,
        'description'           => 'Gestión de clientes del CRM',
        'public'                => false,
        'publicly_queryable'    => false,
        'show_ui'               => true,
        'show_in_menu'          => true,
        'query_var'             => false,
        'rewrite'               => false,
        'has_archive'           => false,
        'hierarchical'          => false,
        'menu_position'         => 5,
        'menu_icon'             => 'dashicons-groups',
        'supports'              => array('title', 'custom-fields'),
        'show_in_rest'          => true, // Para soporte de Gutenberg
    );

    register_post_type('clients', $args);
}
add_action('init', 'crear_cpt_clients');
