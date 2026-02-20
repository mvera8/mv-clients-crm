<?php
function crear_cpt_projects() {
    $labels = array(
        'name'                  => 'Proyectos',
        'singular_name'         => 'Proyecto',
        'menu_name'             => 'Proyectos',
        'name_admin_bar'        => 'Proyecto',
        'add_new'               => 'Añadir Nuevo',
        'add_new_item'          => 'Añadir Nuevo Proyecto',
        'new_item'              => 'Nuevo Proyecto',
        'edit_item'             => 'Editar Proyecto',
        'view_item'             => 'Ver Proyecto',
        'all_items'             => 'Todos los Proyectos',
        'search_items'          => 'Buscar Proyectos',
        'parent_item_colon'     => 'Proyecto Padre:',
        'not_found'             => 'No se encontraron proyectos',
        'not_found_in_trash'    => 'No hay proyectos en la papelera'
    );

    $args = array(
        'labels'                => $labels,
        'description'           => 'Gestión de proyectos del CRM',
        'public'                => true,
        'publicly_queryable'    => true,
        'show_ui'               => true,
        'show_in_menu'          => true,
        'query_var'             => true,
        'rewrite'               => array('slug' => 'proyectos'),
        'capability_type'       => 'post',
        'has_archive'           => true,
        'hierarchical'          => false,
        'menu_position'         => 6,
        'menu_icon'             => 'dashicons-portfolio',
        'supports'              => array('title', 'editor', 'excerpt', 'custom-fields'),
        'show_in_rest'          => true,
    );

    register_post_type('projects', $args);
}
add_action('init', 'crear_cpt_projects');
