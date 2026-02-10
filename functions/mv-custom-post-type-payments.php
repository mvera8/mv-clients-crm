<?php
function crear_cpt_payments() {
    $labels = array(
        'name'                  => 'Pagos',
        'singular_name'         => 'Pago',
        'menu_name'             => 'Pagos',
        'name_admin_bar'        => 'Pago',
        'add_new'               => 'Añadir Nuevo',
        'add_new_item'          => 'Añadir Nuevo Pago',
        'new_item'              => 'Nuevo Pago',
        'edit_item'             => 'Editar Pago',
        'view_item'             => 'Ver Pago',
        'all_items'             => 'Todos los Pagos',
        'search_items'          => 'Buscar Pagos',
        'parent_item_colon'     => 'Pago Padre:',
        'not_found'             => 'No se encontraron pagos',
        'not_found_in_trash'    => 'No hay pagos en la papelera'
    );

    $args = array(
        'labels'                => $labels,
        'description'           => 'Gestión de pagos del CRM',
        'public'                => false, // 🔑
        'publicly_queryable'    => false, // 🔑
        'show_ui'               => true,
        'show_in_menu'          => true,
        'query_var'             => false, // 🔑
        'rewrite'               => false, // 🔑
        'has_archive'           => false, // 🔑
        'hierarchical'          => false,
        'menu_position'         => 8,
        'menu_icon'             => 'dashicons-money-alt',
        'supports'              => array('title', 'editor', 'custom-fields'),
        'show_in_rest'          => true,
    );

    register_post_type('payments', $args);
}
add_action('init', 'crear_cpt_payments');

// Columnas personalizadas en la lista de pagos
function payments_custom_columns($columns) {
    $new_columns = array(
        'cb' => $columns['cb'],
        'title' => 'Concepto',
        'client' => 'Cliente',
        'task' => 'Tarea',
        'amount' => 'Monto',
        'date' => 'Fecha'
    );
    return $new_columns;
}
add_filter('manage_payments_posts_columns', 'payments_custom_columns');

function payments_custom_column_content($column, $post_id) {
    switch ($column) {
        case 'client':
            // ACF campo tipo "Post Object" con nombre 'client'
            $client = get_field('client', $post_id);
            if ($client) {
                if (is_object($client)) {
                    echo '<a href="' . get_edit_post_link($client->ID) . '">' . esc_html($client->post_title) . '</a>';
                } elseif (is_array($client) && !empty($client)) {
                    $client_post = $client[0];
                    echo '<a href="' . get_edit_post_link($client_post->ID) . '">' . esc_html($client_post->post_title) . '</a>';
                }
            } else {
                echo '—';
            }
            break;
            
        case 'task':
            // ACF campo tipo "Post Object" con nombre 'task'
            $task = get_field('task', $post_id);
            if ($task) {
                if (is_object($task)) {
                    echo '<a href="' . get_edit_post_link($task->ID) . '">' . esc_html($task->post_title) . '</a>';
                } elseif (is_array($task) && !empty($task)) {
                    $task_post = $task[0];
                    echo '<a href="' . get_edit_post_link($task_post->ID) . '">' . esc_html($task_post->post_title) . '</a>';
                }
            } else {
                echo '—';
            }
            break;
            
        case 'amount':
            // ACF campo tipo "Number" con nombre 'amount'
            $amount = get_field('amount', $post_id);
            if ($amount) {
                echo '<strong>$' . number_format($amount, 2, ',', '.') . '</strong>';
            } else {
                echo '—';
            }
            break;
    }
}
add_action('manage_payments_posts_custom_column', 'payments_custom_column_content', 10, 2);

// Hacer columnas ordenables
function payments_sortable_columns($columns) {
    $columns['client'] = 'client';
    $columns['task'] = 'task';
    $columns['amount'] = 'amount';
    return $columns;
}
add_filter('manage_edit-payments_sortable_columns', 'payments_sortable_columns');