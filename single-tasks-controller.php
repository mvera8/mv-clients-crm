<?php
defined( 'ABSPATH' ) || exit;

$task_id = get_the_ID();
$branch = get_post_meta( $task_id, 'branch', true );
$branch = $branch ? $branch : 'MV-' . $task_id . '-' . get_post_field( 'post_name' );

$status = get_field( 'status', $task_id );
$status = $status ? $status : 'pending';

$priority = get_field( 'priority', $task_id );
$priority = $priority ? $priority : 'pending';

$project = get_field( 'project', $task_id );

// payment
$payment_args = array(
    'post_type'      => 'payments',
    'posts_per_page' => -1,
);

$payment_query = new WP_Query($payment_args);

$paid = false;

if ($payment_query->have_posts()) {
    while ($payment_query->have_posts()) {
        $payment_query->the_post();

        $tasks = get_field('task'); // relationship devuelve array

        if ($tasks) {
            foreach ($tasks as $task) {
                $task_id_in_payment = is_object($task) ? $task->ID : $task;

                if ($task_id_in_payment == $task_id) {
                    $paid = (bool) get_field('pagada');
                    break 2; // salimos de ambos loops
                }
            }
        }
    }
    wp_reset_postdata();
}
