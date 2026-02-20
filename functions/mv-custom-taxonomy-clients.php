<?php
function crear_taxonomia_client_company() {

    $labels = array(
        'name'              => 'Empresas',
        'singular_name'     => 'Empresa',
        'search_items'      => 'Buscar Empresas',
        'all_items'         => 'Todos los Empresas',
        'edit_item'         => 'Editar Empresa',
        'update_item'       => 'Actualizar Empresa',
        'add_new_item'      => 'Añadir Nuevo Empresa',
        'new_item_name'     => 'Nuevo Nombre de Empresa',
        'menu_name'         => 'Empresas',
    );

    $args = array(
        'hierarchical'      => true, // true = Empresa categorías | false = Empresa tags
        'labels'            => $labels,
        'show_ui'           => true,
        'show_admin_column' => true, // muestra columna en el admin
        'query_var'         => true,
        'rewrite'           => array( 'slug' => 'client_company' ),
        'show_in_rest'      => true, // importante si usás Gutenberg
    );

    register_taxonomy(
        'client_company',   // slug interno
        array( 'clients' ), // CPT al que se asigna
        $args
    );
}
add_action( 'init', 'crear_taxonomia_client_company' );
