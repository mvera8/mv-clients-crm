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
        'public'                => true,
        'publicly_queryable'    => true,
        'show_ui'               => true,
        'show_in_menu'          => true,
        'query_var'             => true,
        'rewrite'               => array('slug' => 'clientes'),
        'capability_type'       => 'post',
        'has_archive'           => true,
        'hierarchical'          => false,
        'menu_position'         => 5,
        'menu_icon'             => 'dashicons-groups',
        'supports'              => array('title', 'editor', 'custom-fields'),
        'show_in_rest'          => true, // Para soporte de Gutenberg
    );

    register_post_type('clients', $args);
}
add_action('init', 'crear_cpt_clients');

// Opcional: Agregar columnas personalizadas en la lista de clientes
function clients_custom_columns($columns) {
    $new_columns = array(
        'cb' => $columns['cb'],
        'title' => 'Cliente',
        'email' => 'Email',
        'contacto' => 'Contacto',
        'empresa' => 'Empresa',
        'date' => 'Fecha'
    );
    return $new_columns;
}
add_filter('manage_clients_posts_columns', 'clients_custom_columns');

function clients_custom_column_content($column, $post_id) {
    switch ($column) {
        case 'email':
            echo get_post_meta($post_id, 'client_email', true);
            break;
        case 'contacto':
            echo get_post_meta($post_id, 'client_contact_type', true);
            break;
        case 'empresa':
            echo get_post_meta($post_id, 'client_company', true);
            break;
    }
}
add_action('manage_clients_posts_custom_column', 'clients_custom_column_content', 10, 2);