<?php
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
            $task_status = get_the_terms($post_id, 'task_status');
            if ($task_status && !is_wp_error($task_status)) {
                foreach ($task_status as $ts) {
                    echo mv_status_tag($ts->name);
                }
            } else {
                echo '-';
            }
            break;
            
        case 'priority':
            $task_priority = get_the_terms($post_id, 'task_priority');
            if ($task_priority && !is_wp_error($task_priority)) {
                foreach ($task_priority as $tp) {
                    echo mv_priority_tag($tp->name);
                }
            } else {
                echo '-';
            }
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
