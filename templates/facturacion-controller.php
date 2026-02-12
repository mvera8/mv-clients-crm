<?php
/**
 * Controller for Facturacion Page
 *
 * @package mv-clients-crm
 */

// Exit if accessed directly.
defined( 'ABSPATH' ) || exit;

$payments_total = 0;
$payments_current_month = 0;
$payments_current_month_goal = 2500;
$payments_pending_total = 0;
$payments_current_month_pending = 0;
$current_month_key = date('Y-m');

$payments_args = array(
    'post_type'      => 'payments',
    'posts_per_page' => -1,
    'orderby'        => 'date',
    'order'          => 'DESC',
    'no_found_rows'  => true,
    'update_post_meta_cache' => false,
    'update_post_term_cache' => false,
);

$payments_query = new WP_Query($payments_args);

$payments_by_month = array();

if ( $payments_query->have_posts() ) {
    while ( $payments_query->have_posts() ) {
        $payments_query->the_post();

        $month_key = get_the_date('Y-m'); // 2026-02
        $month_label = get_the_date('F Y'); // February 2026

        $amount = (float) get_field('amount');
        $paid   = get_field('pagada');

        $payments_by_month[$month_key]['label'] = $month_label;
        $payments_by_month[$month_key]['items'][] = array(
            'title'  => get_the_title(),
            'amount' => $amount,
            'paid'   => $paid,
        );

        if (!isset($payments_by_month[$month_key]['total'])) {
            $payments_by_month[$month_key]['total'] = 0;
        }

        if ($paid) {

            // Total histórico cobrado
            $payments_total += $amount;

            // Total por mes cobrado
            $payments_by_month[$month_key]['total'] += $amount;

            // Total mes actual cobrado
            if ($month_key === $current_month_key) {
                $payments_current_month += $amount;
            }

        } else {

            // Total pendiente histórico
            $payments_pending_total += $amount;

            // Total pendiente mes actual
            if ($month_key === $current_month_key) {
                $payments_current_month_pending += $amount;
            }
        }
    }

    wp_reset_postdata();
}

$progress_percentage = 0;

if ($payments_current_month_goal > 0) {
    $progress_percentage = min(
        100,
        ($payments_current_month / $payments_current_month_goal) * 100
    );
}

