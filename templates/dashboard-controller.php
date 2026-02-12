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

// Código para mostrar 4 clientes en la home
$clients_args = array(
    'post_type'      => 'clients',
    'posts_per_page' => 5,
    'orderby'        => 'date',
    'order'          => 'DESC',
    'no_found_rows'  => true,
    'update_post_meta_cache' => false,
    'update_post_term_cache' => false,
);
$clients_query = new WP_Query($clients_args);

$tasks_args = array(
    'post_type'      => 'tasks',
    'posts_per_page' => 4,
    'orderby'        => 'date',
    'order'          => 'DESC',
    'no_found_rows'  => true,
    'update_post_meta_cache' => false,
    'update_post_term_cache' => false,
    'meta_query' => array(
        array(
            'key'     => 'status',
            'value'   => array('completada', 'Completada'),
            'compare' => 'NOT IN'
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
    ),
    array(
        'title' => 'Proyectos totales',
        'total' => contar_posts_por_tipo('projects'),
    ),
    array(
        'title' => 'Tareas totales',
        'total' => contar_posts_por_tipo('tasks'),
    ),
    array(
        'title' => contar_posts_por_tipo('payments', array( array( 'key' => 'pagada', 'value' => '1', 'compare' => '='))) . ' Pago/s',
        'total' => 'USD ' . number_format($total_payments_amount, 0),
    ),
);
