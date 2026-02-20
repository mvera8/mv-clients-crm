<?php
function clients_custom_columns($columns) {
    $new_columns = array(
        'cb' => $columns['cb'],
        'title' => 'Cliente',
        'email' => 'Email',
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
        case 'empresa':
            echo get_the_terms($post_id, 'client_company');
            break;
    }
}
add_action('manage_clients_posts_custom_column', 'clients_custom_column_content', 10, 2);