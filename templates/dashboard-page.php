<?php
/**
 * Template Name: Dashboard Page
 *
 * @package mv-clients-crm
 */

// Exit if accessed directly.
defined( 'ABSPATH' ) || exit;

include plugin_dir_path( __FILE__ ) . 'dashboard-controller.php';

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
                        '<p class="text-muted mb-0">Bienvenido <b>%s</b></p>',
                        $user_name,
                    );

                    get_template_part(
                        'template-parts/dashboard',
                        'title',
                        array(
                            'title'      => get_the_title(),
                            'breadcrumb' => false
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
                                        'title' => $card['title'] ?? '',
                                        'total' => $card['total'] ?? '',
                                        'icon'  => $card['icon'] ?? '',
                                        'color' => $card['color'] ?? '',
                                    )
                                );
                                ?>
                            </div>
                        <?php endforeach; ?>
                    
                        <div class="col-md-5">
                            <?php
                            get_template_part(
                                'template-parts/table',
                                'clients',
                                array(
                                    'data' => $clients_query,
                                )
                            );
                            ?>
                        </div>

                        <div class="col-md-7">
                            <?php   
                            get_template_part(
                                'template-parts/table',
                                'tasks',
                                array(
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
