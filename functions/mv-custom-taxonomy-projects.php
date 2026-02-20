<?php
function crear_taxonomia_project_type() {

    $labels = array(
        'name'              => 'Tipos',
        'singular_name'     => 'Tipo',
        'search_items'      => 'Buscar Tipos',
        'all_items'         => 'Todos los Tipos',
        'edit_item'         => 'Editar Tipo',
        'update_item'       => 'Actualizar Tipo',
        'add_new_item'      => 'Añadir Nuevo Tipo',
        'new_item_name'     => 'Nuevo Nombre de Tipo',
        'menu_name'         => 'Tipos',
    );

    $args = array(
        'hierarchical'      => true, // true = tipo categorías | false = tipo tags
        'labels'            => $labels,
        'show_ui'           => true,
        'show_admin_column' => true, // muestra columna en el admin
        'query_var'         => true,
        'rewrite'           => array( 'slug' => 'project-type' ),
        'show_in_rest'      => true, // importante si usás Gutenberg
    );

    register_taxonomy(
        'project_type',      // slug interno
        array( 'projects' ), // CPT al que se asigna
        $args
    );
}
add_action( 'init', 'crear_taxonomia_project_type' );
