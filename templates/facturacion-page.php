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

                    <div class="row">
                        <div class="col-12 col-md-3">
                            <?php
                            get_template_part(
                                'template-parts/card',
                                'number',
                                array(
                                    'title' => 'Total cobrado',
                                    'total' => 'USD ' . number_format($payments_total),
                                )
                            );
                            ?>
                        </div>
                        <div class="col-12 col-md-3">
                            <?php
                            get_template_part(
                                'template-parts/card',
                                'number',
                                array(
                                    'title' => 'Pendiente',
                                    'total' => 'USD ' . number_format($payments_pending_total),
                                )
                            );
                            ?>
                        </div>
                        <div class="col-12 col-md-6">
                            <div class="card mb-4">
                                <div class="card-body">
                                    <div class="d-flex justify-content-between align-items-end mb-2">
                                        <h3 class="mb-0">USD <?php echo number_format($payments_current_month); ?> <span class="text-body-secondary fs-6">Este mes</small></h3>
                                        <p class="mb-0">Meta: USD <?php echo number_format($payments_current_month_goal); ?></p>
                                    </div>
                                    

                                    <div class="progress">
                                        <div 
                                            class="progress-bar bg-success"
                                            role="progressbar"
                                            style="width: <?php echo esc_attr($progress_percentage); ?>%"
                                            aria-valuenow="<?php echo esc_attr($progress_percentage); ?>"
                                            aria-valuemin="0"
                                            aria-valuemax="100">
                                        </div>
                                    </div>

                                </div>
                            </div>
                        </div>
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
