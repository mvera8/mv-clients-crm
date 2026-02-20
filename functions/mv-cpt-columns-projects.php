<?php
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