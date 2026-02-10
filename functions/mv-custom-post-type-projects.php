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

// Columnas personalizadas en la lista de proyectos
function projects_custom_columns($columns) {
    $new_columns = array(
        'cb' => $columns['cb'],
        'title' => 'Proyecto',
        'client' => 'Cliente',
        'website' => 'Website',
        'date' => 'Fecha'
    );
    return $new_columns;
}
add_filter('manage_projects_posts_columns', 'projects_custom_columns');

function projects_custom_column_content($column, $post_id) {
    switch ($column) {
        case 'client':
            // ACF campo tipo "Post Object" o "Relationship" con nombre 'client'
            $client = get_field('client', $post_id);
            if ($client) {
                // Si es Post Object
                if (is_object($client)) {
                    echo '<a href="' . get_edit_post_link($client->ID) . '">' . esc_html($client->post_title) . '</a>';
                }
                // Si es Relationship (array)
                elseif (is_array($client) && !empty($client)) {
                    $client_post = $client[0];
                    echo '<a href="' . get_edit_post_link($client_post->ID) . '">' . esc_html($client_post->post_title) . '</a>';
                }
            } else {
                echo '—';
            }
            break;
            
        case 'website':
            // ACF campo tipo "URL" con nombre 'website'
            $website = get_field('website', $post_id);
            if ($website) {
                echo '<a href="' . esc_url($website) . '" target="_blank">' . esc_html($website) . '</a>';
            } else {
                echo '—';
            }
            break;
    }
}
add_action('manage_projects_posts_custom_column', 'projects_custom_column_content', 10, 2);

// Hacer la columna 'client' ordenable (opcional)
function projects_sortable_columns($columns) {
    $columns['client'] = 'client';
    return $columns;
}
add_filter('manage_edit-projects_sortable_columns', 'projects_sortable_columns');