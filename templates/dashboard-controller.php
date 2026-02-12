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

$cards = array(
    array(  
        'title' => 'Clientes',
        'total' => contar_posts_por_tipo('clients'),
    ),
    array(
        'title' => 'Proyectos',
        'total' => contar_posts_por_tipo('projects'),
    ),
    array(
        'title' => 'Tareas',
        'total' => contar_posts_por_tipo('tasks'),
    ),
    array(
        'title' => 'Pagos',
        'total' => contar_posts_por_tipo('payments'),
    ),
);

// Código para mostrar 4 clientes en la home
$clients_args = array(
    'post_type'      => 'clients',
    'posts_per_page' => 4,
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
