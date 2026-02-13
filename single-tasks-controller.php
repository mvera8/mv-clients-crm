<?php
defined( 'ABSPATH' ) || exit;

$task_id = get_the_ID();

$branch = get_post_meta( $task_id, 'branch', true );
$branch = $branch ? $branch : 'MV-' . $task_id . '-' . get_post_field( 'post_name' );

$status = get_field( 'status', $task_id ) ?: 'pending';
$priority = get_field( 'priority', $task_id ) ?: 'pending';

$project = get_field( 'project', $task_id );
$hours   = get_field( 'hours', $task_id );

// ---------------------------------
// PAYMENT STATUS
// ---------------------------------

$payment_status = null; // pagado | pendiente | cotizado
$payment_amount = 0;

$payment_query = new WP_Query(array(
    'post_type'      => 'payments',
    'posts_per_page' => -1,
    'no_found_rows'  => true,
    'fields'         => 'ids', // 🔥 más performante
));

if ($payment_query->have_posts()) {

    foreach ($payment_query->posts as $payment_id) {

        $tasks = get_field('task', $payment_id); // relationship

        if (!$tasks) {
            continue;
        }

        foreach ($tasks as $task) {

            $task_id_in_payment = is_object($task) ? $task->ID : $task;

            if ((int) $task_id_in_payment === (int) $task_id) {

                $payment_status = get_field('pagada', $payment_id); // select
                $payment_amount = (float) get_field('amount', $payment_id);

                break 2; // salimos de ambos loops
            }
        }
    }

    wp_reset_postdata();
}
