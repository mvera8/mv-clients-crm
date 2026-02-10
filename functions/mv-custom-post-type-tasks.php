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

// Columnas personalizadas en la lista de tareas
function tasks_custom_columns($columns) {
    $new_columns = array(
        'cb' => $columns['cb'],
        'title' => 'Tarea',
        'project' => 'Proyecto',
        'status' => 'Estado',
        'priority' => 'Prioridad',
        'date' => 'Creada'
    );
    return $new_columns;
}
add_filter('manage_tasks_posts_columns', 'tasks_custom_columns');

function tasks_custom_column_content($column, $post_id) {
    switch ($column) {
        case 'project':
            // ACF campo tipo "Post Object" o "Relationship" con nombre 'project'
            $project = get_field('project', $post_id);
            if ($project) {
                if (is_object($project)) {
                    echo '<a href="' . get_edit_post_link($project->ID) . '">' . esc_html($project->post_title) . '</a>';
                } elseif (is_array($project) && !empty($project)) {
                    $project_post = $project[0];
                    echo '<a href="' . get_edit_post_link($project_post->ID) . '">' . esc_html($project_post->post_title) . '</a>';
                }
            } else {
                echo '—';
            }
            break;
            
        case 'status':
            // ACF campo tipo "Select" con nombre 'status'
            $status = get_field('status', $post_id);
            echo ucfirst($status);
            break;
            
        case 'priority':
            // ACF campo tipo "Select" con nombre 'priority'
            $priority = get_field('priority', $post_id);
            echo ucfirst($priority);
            break;
    }
}
add_action('manage_tasks_posts_custom_column', 'tasks_custom_column_content', 10, 2);

// Hacer columnas ordenables
function tasks_sortable_columns($columns) {
    $columns['project'] = 'project';
    $columns['client'] = 'client';
    $columns['status'] = 'status';
    $columns['priority'] = 'priority';
    $columns['due_date'] = 'due_date';
    return $columns;
}
add_filter('manage_edit-tasks_sortable_columns', 'tasks_sortable_columns');
