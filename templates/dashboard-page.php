<?php
/**
 * Template Name: Dashboard Page
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

get_header();
?>

<div class="container-fluid px-0">
    <div class="row">
        <?php get_template_part('template-parts/dashboard-sidebar'); ?>

       <div class="col-12 col-md-10">
            <section id="dashboard-content" class="py-4 bg-light min-vh-100">
                <div class="container">
                    <?php
                    printf(
                        '<p class="text-muted mb-3">Bienvenido <b>%s</b></p>',
                        $user_name,
                    );

                    get_template_part(
                        'template-parts/title',
                        'section',
                        array(
                            'title' => get_the_title(),
                        )
                    );
                    ?>
                    <div class="row">

                        <?php foreach ($cards as $card) : ?>
                            <div class="col-md-3">
                                <?php
                                get_template_part(
                                    'template-parts/card',
                                    'number',
                                    array(
                                        'title' => $card['title'],
                                        'total' => $card['total'],
                                    )
                                );
                                ?>
                            </div>
                        <?php endforeach; ?>
                    
                        <div class="col-md-6">
                            <?php
                            get_template_part(
                                'template-parts/table',
                                'clients',
                                array(
                                    'title' => 'Clientes',
                                    'data' => $clients_query,
                                )
                            );
                            ?>
                        </div>

                        <div class="col-md-6">
                            <?php   
                            get_template_part(
                                'template-parts/table',
                                'tasks',
                                array(
                                    'title' => 'Clientes',
                                    'data' => $tasks_query,
                                )
                            );
                            ?>
                        </div>
                    </div>
                </div>
            </section>
        </div>
    </div>
</div>

<?php 
get_footer();
