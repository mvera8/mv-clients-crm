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
        'icon'  => '<svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="icon icon-tabler icons-tabler-outline icon-tabler-user"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M8 7a4 4 0 1 0 8 0a4 4 0 0 0 -8 0" /><path d="M6 21v-2a4 4 0 0 1 4 -4h4a4 4 0 0 1 4 4v2" /></svg>',
        'color' => 'primary',
    ),
    array(
        'title' => 'Proyectos totales',
        'total' => contar_posts_por_tipo('projects'),
        'icon'  => '<svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="icon icon-tabler icons-tabler-outline icon-tabler-briefcase"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M3 9a2 2 0 0 1 2 -2h14a2 2 0 0 1 2 2v9a2 2 0 0 1 -2 2h-14a2 2 0 0 1 -2 -2l0 -9" /><path d="M8 7v-2a2 2 0 0 1 2 -2h4a2 2 0 0 1 2 2v2" /><path d="M12 12l0 .01" /><path d="M3 13a20 20 0 0 0 18 0" /></svg>',
        'color' => 'warning',
    ),
    array(
        'title' => 'Tareas totales',
        'total' => contar_posts_por_tipo('tasks'),
        'icon'  => '<svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="icon icon-tabler icons-tabler-outline icon-tabler-clipboard-copy"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M9 5h-2a2 2 0 0 0 -2 2v12a2 2 0 0 0 2 2h3m9 -9v-5a2 2 0 0 0 -2 -2h-2" /><path d="M13 17v-1a1 1 0 0 1 1 -1h1m3 0h1a1 1 0 0 1 1 1v1m0 3v1a1 1 0 0 1 -1 1h-1m-3 0h-1a1 1 0 0 1 -1 -1v-1" /><path d="M9 5a2 2 0 0 1 2 -2h2a2 2 0 0 1 2 2a2 2 0 0 1 -2 2h-2a2 2 0 0 1 -2 -2" /></svg>',
        'color' => 'info',
    ),
    array(
        'title' => contar_posts_por_tipo('payments', array( array( 'key' => 'pagada', 'value' => '1', 'compare' => '='))) . ' Pago/s',
        'total' => 'USD ' . number_format($total_payments_amount, 0),
        'icon'  => '<svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="icon icon-tabler icons-tabler-outline icon-tabler-pig-money"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M15 11v.01" /><path d="M5.173 8.378a3 3 0 1 1 4.656 -1.377" /><path d="M16 4v3.803a6.019 6.019 0 0 1 2.658 3.197h1.341a1 1 0 0 1 1 1v2a1 1 0 0 1 -1 1h-1.342c-.336 .95 -.907 1.8 -1.658 2.473v2.027a1.5 1.5 0 0 1 -3 0v-.583a6.04 6.04 0 0 1 -1 .083h-4a6.04 6.04 0 0 1 -1 -.083v.583a1.5 1.5 0 0 1 -3 0v-2l0 -.027a6 6 0 0 1 4 -10.473h2.5l4.5 -3" /></svg>',
        'color' => $total_payments_amount >= 0 ? 'success' : 'danger'
    ),
);
