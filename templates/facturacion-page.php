<?php
/**
 * Template Name: Facturacion Page
 *
 * @package mv-clients-crm
 */

// Exit if accessed directly.
defined( 'ABSPATH' ) || exit;

include_once plugin_dir_path( __FILE__ ) . 'facturacion-controller.php';

get_header();
?>

<div class="container-fluid px-0">
    <div class="row">
        <?php get_template_part('template-parts/dashboard-sidebar'); ?>

       <div class="col-12 col-md-10">
            <section id="dashboard-content" class="py-4 bg-light min-vh-100">
                <div class="container">
                    <?php
                    get_template_part(
                        'template-parts/dashboard',
                        'title',
                        array(
                            'title' => get_the_title(),
                        )
                    );

                    the_content();
                    ?>



                    <div class="progress mb-5">
                        <div class="progress-bar" role="progressbar" style="width: 15%" aria-valuenow="15" aria-valuemin="0" aria-valuemax="100"></div>
                        <div class="progress-bar bg-success" role="progressbar" style="width: 30%" aria-valuenow="30" aria-valuemin="0" aria-valuemax="100"></div>
                        <div class="progress-bar bg-info" role="progressbar" style="width: 20%" aria-valuenow="20" aria-valuemin="0" aria-valuemax="100"></div>
                    </div>

                    <?php

                    if (!empty($payments_by_month)) : ?>

                        <?php foreach ($payments_by_month as $month) : ?>

                            <div class="card mb-4">
                                <div class="card-header d-flex justify-content-between">
                                    <strong><?php echo esc_html($month['label']); ?></strong>
                                    <span>Total cobrado: 
                                        <strong>
                                            $<?php echo number_format($month['total'], 2); ?>
                                        </strong>
                                    </span>
                                </div>

                                <ul class="list-group list-group-flush">
                                    <?php foreach ($month['items'] as $item) : ?>
                                        <li class="list-group-item d-flex justify-content-between">
                                            <span>
                                                <?php echo esc_html($item['title']); ?>
                                                <?php if (!$item['paid']) : ?>
                                                    <span class="badge bg-warning text-dark ms-2">Pendiente</span>
                                                <?php endif; ?>
                                            </span>
                                            <span>
                                                $<?php echo number_format($item['amount'], 2); ?>
                                            </span>
                                        </li>
                                    <?php endforeach; ?>
                                </ul>
                            </div>

                        <?php endforeach; ?>

                    <?php else : ?>
                        <p>No hay datos</p>
                    <?php endif; ?>



                </div>
            </section>
        </div>
    </div>
</div>

<?php 
get_footer();
