<?php
/**
 * Controller for Facturacion Page
 *
 * @package mv-clients-crm
 */

// Exit if accessed directly.
defined( 'ABSPATH' ) || exit;

$payments_args = array(
    'post_type'      => 'payments',
    'posts_per_page' => -1, // traemos todos
    'orderby'        => 'date',
    'order'          => 'DESC',
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
            $payments_by_month[$month_key]['total'] += $amount;
        }
    }

    wp_reset_postdata();
}
