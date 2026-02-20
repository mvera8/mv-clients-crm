<?php
function crear_cpt_tasks() {
    $labels = array(
        'name'                  => 'Tareas',
        'singular_name'         => 'Tarea',
        'menu_name'             => 'Tareas',
        'name_admin_bar'        => 'Tarea',
        'add_new'               => 'Añadir Nueva',
        'add_new_item'          => 'Añadir Nueva Tarea',
        'new_item'              => 'Nueva Tarea',
        'edit_item'             => 'Editar Tarea',
        'view_item'             => 'Ver Tarea',
        'all_items'             => 'Todas las Tareas',
        'search_items'          => 'Buscar Tareas',
        'parent_item_colon'     => 'Tarea Padre:',
        'not_found'             => 'No se encontraron tareas',
        'not_found_in_trash'    => 'No hay tareas en la papelera'
    );

    $args = array(
        'labels'                => $labels,
        'description'           => 'Gestión de tareas del CRM',
        'public'                => true,
        'publicly_queryable'    => true,
        'show_ui'               => true,
        'show_in_menu'          => true,
        'query_var'             => true,
        'rewrite'               => array('slug' => 'tareas'),
        'capability_type'       => 'post',
        'has_archive'           => true,
        'hierarchical'          => false,
        'menu_position'         => 7,
        'menu_icon'             => 'dashicons-yes-alt',
        'supports'              => array('title', 'editor', 'custom-fields'),
        'show_in_rest'          => true,
    );

    register_post_type('tasks', $args);
}
add_action('init', 'crear_cpt_tasks');
