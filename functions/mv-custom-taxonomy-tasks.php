<?php
// Estado
function crear_taxonomia_task_status() {

    $labels = array(
        'name'              => 'Estados',
        'singular_name'     => 'Estado',
        'search_items'      => 'Buscar Estados',
        'all_items'         => 'Todos los Estados',
        'edit_item'         => 'Editar Estado',
        'update_item'       => 'Actualizar Estado',
        'add_new_item'      => 'Añadir Nuevo Estado',
        'new_item_name'     => 'Nuevo Nombre de Estado',
        'menu_name'         => 'Estados',
    );

    $args = array(
        'hierarchical'      => true, // true = Empresa categorías | false = Empresa tags
        'labels'            => $labels,
        'show_ui'           => true,
        'show_admin_column' => true, // muestra columna en el admin
        'query_var'         => true,
        'rewrite'           => array( 'slug' => 'task_status' ),
        'show_in_rest'      => true, // importante si usás Gutenberg
    );

    register_taxonomy(
        'task_status',   // slug interno
        array( 'tasks' ), // CPT al que se asigna
        $args
    );
}
add_action( 'init', 'crear_taxonomia_task_status' );

// Prioridad
function crear_taxonomia_task_priority() {

    $labels = array(
        'name'              => 'Prioridad',
        'singular_name'     => 'Prioridad',
        'search_items'      => 'Buscar Prioridad',
        'all_items'         => 'Todos los Prioridad',
        'edit_item'         => 'Editar Prioridad',
        'update_item'       => 'Actualizar Prioridad',
        'add_new_item'      => 'Añadir Nuevo Prioridad',
        'new_item_name'     => 'Nuevo Nombre de Prioridad',
        'menu_name'         => 'Prioridad',
    );

    $args = array(
        'hierarchical'      => true, // true = Empresa categorías | false = Empresa tags
        'labels'            => $labels,
        'show_ui'           => true,
        'show_admin_column' => true, // muestra columna en el admin
        'query_var'         => true,
        'rewrite'           => array( 'slug' => 'task_priority' ),
        'show_in_rest'      => true, // importante si usás Gutenberg
    );

    register_taxonomy(
        'task_priority',   // slug interno
        array( 'tasks' ), // CPT al que se asigna
        $args
    );
}
add_action( 'init', 'crear_taxonomia_task_priority' );
