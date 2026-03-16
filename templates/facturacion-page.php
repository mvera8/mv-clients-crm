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

                    <div class="row g-3">
                        <div class="col-12 col-md-4">
                            <?php
                            get_template_part(
                                'template-parts/card',
                                'number',
                                array(
                                    'title' => 'Total cobrado',
                                    'total' => 'USD ' . number_format($payments_total_paid),
                                )
                            );
                            ?>
                        </div>
                        <div class="col-12 col-md-4">
                            <?php
                            get_template_part(
                                'template-parts/card',
                                'number',
                                array(
                                    'title' => 'Total pendiente',
                                    'total' => 'USD ' . number_format($payments_total_pending),
                                )
                            );
                            ?>
                        </div>
                        <div class="col-12 col-md-4">
                            <?php
                            get_template_part(
                                'template-parts/card',
                                'number',
                                array(
                                    'title' => 'Total cotizado',
                                    'total' => 'USD ' . number_format($payments_total_quoted),
                                )
                            );
                            ?>
                        </div>
                        <div class="col-12 col-md-6">
                            <div class="card border-0 shadow-sm h-100">
                                <div class="card-body">

                                    <div class="row align-items-end g-1">
                                        <?php
                                        if (!empty($payments_by_month)) :
                                            foreach (array_slice(array_reverse($payments_by_month), 0, 12) as $month) :
                                                printf(
                                                    '<div class="col-1">
                                                        <div
                                                        class="p-1 bg-success rounded w-100"
                                                        style="height: %spx;"
                                                        data-bs-toggle="tooltip"
                                                        data-bs-placement="top"
                                                        data-bs-title="%s"
                                                        ></div>
                                                        <p class="text-muted mb-0 mt-1 small text-uppercase">%s</p>
                                                    </div>',
                                                    $month['total']/4,
                                                    'USD ' . number_format($month['total']),
                                                    substr($month['label'], 0, 3)
                                                );
                                            endforeach;
                                        endif;
                                        ?>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-12 col-md-6">
                            <div class="card border-0 shadow-sm h-100">
                                <div class="card-body">
                                    <div class="d-flex justify-content-between align-items-end mb-2">
                                        <div>
                                            <p class="text-muted mb-0 small text-uppercase">
                                                Este mes
                                            </p>
                                            <h3 class="mb-0">USD <?php echo number_format($payments_current_month_paid); ?></h3>
                                        </div>
                                        <p class="text-muted mb-0 small text-uppercase">Meta: USD <?php echo number_format($payments_current_month_goal); ?></p>
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

                        <?php
                        if (!empty($payments_by_month)) :
                            foreach ($payments_by_month as $month) :
                                ?>
                                <div class="col-12">
                                    <div class="card">
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
                                                        <?php if ($item['status'] !== 'pagado') : ?>
                                                            <?php
                                                            $badge_class = match ($item['status']) {
                                                                'pendiente' => 'bg-warning text-dark',
                                                                'cotizado'  => 'bg-info text-dark',
                                                                default     => 'bg-secondary'
                                                            };
                                                            ?>
                                                            <span class="badge <?php echo esc_attr($badge_class); ?> ms-2">
                                                                <?php echo esc_html(ucfirst($item['status'])); ?>
                                                            </span>
                                                        <?php endif; ?>
                                                    </span>
                                                    <span>
                                                        $<?php echo number_format($item['amount'], 2); ?>
                                                    </span>
                                                </li>
                                            <?php endforeach; ?>
                                        </ul>
                                    </div>
                                </div>
                            <?php endforeach; ?>

                        <?php else : ?>
                            <div class="col-12">
                                <p>No hay datos</p>
                            </div>
                        <?php endif; ?>
                    </div>

                    

                </div>
            </section>
        </div>
    </div>
</div>

<?php 
get_footer();
