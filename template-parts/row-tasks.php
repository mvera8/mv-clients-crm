<?php
/**
 * Template Part: Table Tasks (Bootstrap 5)
 */

 // Exit if accessed directly.
defined( 'ABSPATH' ) || exit;

$id = $args['id'] ?? '';
$title = $args['title'] ?? '';
$link = $args['link'] ?? '';
$type = $args['type'] ?? 'long';

$project = get_field('project', $id);
$priority = get_field( 'priority', $id );

$task_status = get_the_terms( $id, 'task_status' );
$task_priority = get_the_terms( $id, 'task_priority' );
?>

<tr>
    <td>
        <?php
        printf(
            '<a href="%s">%s</a>',
            esc_url( $link ),
            esc_html( $title ),
        );
        ?>
    </td>
    <td>
        <?php
        if( $project ):
            printf(
            '<a href="%s">%s</a>',
                esc_url( get_permalink( $project->ID ) ),
                esc_html( $project->post_title ),
            );
        endif;
        ?>
    </td>
    <?php
    if (isset($type) && $type === 'long') {
        echo '<td>';
        $hours = get_field( 'hours', $id ) ?? '-';
        if ($hours) {
            echo '<span class="badge rounded-pill bg-secondary">' . esc_html($hours) . '</span>';
        }
        echo '</td>';
    }
    ?>
    <td>
        <?php
        if ( $task_status && ! is_wp_error( $task_status ) ) {
            foreach ( $task_status as $st ) {
                echo mv_status_tag($st->name);
            }
        }
        ?>
    </td>
    <?php
    if (isset($type) && $type === 'long') {
        echo '<td>';
        if ( $task_priority && ! is_wp_error( $task_priority ) ) {
            foreach ( $task_priority as $st ) {
                echo mv_priority_tag($st->name);
            }
        }
        echo '</td>';
    }
    ?>
</tr>