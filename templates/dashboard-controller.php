<?php
/**
 * Controller for Dashboard Page
 *
 * @package mv-clients-crm
 */

// Exit if accessed directly.
defined( 'ABSPATH' ) || exit;

$current_user = wp_get_current_user();
$user_name = $current_user->user_login;

$project_args = array(
    'post_type' => 'projects',
    'posts_per_page' => 4,
    'orderby'        => 'date',
    'order'          => 'DESC',
    'no_found_rows'  => true,
    'update_post_meta_cache' => false,
    'update_post_term_cache' => false,
    'tax_query' => array(
        array(
            'taxonomy' => 'project_type',
            'field'    => 'slug',
            'terms'    => 'interno',
        ),
    ),
);
$project_query = new WP_Query($project_args);

// Código para mostrar 5 clientes ordenados por lo que pagaron
$all_clients_ids = get_posts(array(
    'post_type'      => 'clients',
    'posts_per_page' => -1,
    'fields'         => 'ids',
));

$clients_with_payments = array();
foreach ($all_clients_ids as $client_id) {
    $amount = mv_get_client_total_paid($client_id);
    if ($amount > 0) {
        $clients_with_payments[$client_id] = $amount;
    }
}

// Ordenar por monto (descendente)
arsort($clients_with_payments);

// Tomar los primeros 5
$top_client_ids = array_slice(array_keys($clients_with_payments), 0, 5);

// Query final para obtener los objetos en ese orden exacto
$clients_args = array(
    'post_type'      => 'clients',
    'post__in'       => $top_client_ids,
    'orderby'        => 'post__in',
    'posts_per_page' => 4,
    'no_found_rows'  => true,
);
$clients_query = new WP_Query($clients_args);

$tasks_args = array(
    'post_type'      => 'tasks',
    'posts_per_page' => -1,
    'orderby'        => 'date',
    'order'          => 'DESC',
    'no_found_rows'  => true,
    'update_post_meta_cache' => false,
    'update_post_term_cache' => false,
    'tax_query' => array(
        array(
            'taxonomy' => 'task_status',
            'field'    => 'slug',        // o 'name' si preferís
            'terms'    => array('completada'),
            'operator' => 'NOT IN',
        )
    )
);
$tasks_query = new WP_Query($tasks_args);

$total_payments_amount = 0;

$payments_args = array(
    'post_type'      => 'payments',
    'posts_per_page' => -1,
    'fields'         => 'ids', // 🔥 optimización importante
    'meta_query'     => array(
        array(
            'key'     => 'pagada',
            'value'   => '1', // True/False guarda "1"
            'compare' => '=',
        ),
    ),
);

$payments_query = new WP_Query($payments_args);

if ($payments_query->have_posts()) {
    foreach ($payments_query->posts as $payment_id) {
        $amount = (float) get_field('amount', $payment_id);
        $total_payments_amount += $amount;
    }
}

$cards = array(
    array(  
        'title' => 'Clientes',
        'total' => contar_posts_por_tipo('clients'),
        'icon'  => 'user',
        'color' => 'primary',
    ),
    array(
        'title' => 'Proyectos totales',
        'total' => contar_posts_por_tipo('projects'),
        'icon'  => 'brief',
        'color' => 'warning',
    ),
    array(
        'title' => 'Tareas totales',
        'total' => contar_posts_por_tipo('tasks'),
        'icon'  => 'tasks',
        'color' => 'info',
    ),
    array(
        'title' => contar_posts_por_tipo('payments', array( array( 'key' => 'pagada', 'value' => '1', 'compare' => '='))) . ' Pago/s',
        'total' => 'USD ' . number_format($total_payments_amount, 0),
        'icon'  => 'money',
        'color' => $total_payments_amount >= 0 ? 'success' : 'danger'
    ),
);
