<?php
/**
 * Helper functions for payments
 */

defined( 'ABSPATH' ) || exit;

/**
 * Get total paid amount for a specific client
 *
 * @param int $client_id
 * @return float
 */
function mv_get_client_total_paid( $client_id ) {
    if ( ! $client_id ) {
        return 0.0;
    }

    $args = array(
        'post_type'      => 'payments',
        'posts_per_page' => -1,
        'post_status'    => 'publish',
        'fields'         => 'ids',
        'meta_query'     => array(
            'relation' => 'AND',
            array(
                'key'     => 'client',
                'value'   => $client_id,
                'compare' => '=',
            ),
            array(
                'relation' => 'OR',
                array(
                    'key'     => 'status',
                    'value'   => 'pagado',
                    'compare' => '=',
                ),
                array(
                    'key'     => 'pagada',
                    'value'   => '1',
                    'compare' => '=',
                ),
            ),
        ),
        'no_found_rows'  => true,
    );

    $query = new WP_Query( $args );
    $total = 0.0;

    if ( $query->have_posts() ) {
        foreach ( $query->posts as $payment_id ) {
            $amount = get_field( 'amount', $payment_id );
            if ( $amount ) {
                $total += (float) $amount;
            }
        }
    }

    return $total;
}
