<?php
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