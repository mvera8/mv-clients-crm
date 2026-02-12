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
        $project = get_field('project', $id);
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
        $status = get_field( 'status', $id );
        if ($status) {
            echo mv_status_tag($status);
        }
        ?>
    </td>
    <td>
        <?php
        $priority = get_field( 'priority', $id );
        if ($priority) {
            echo mv_priority_tag($priority);
        }
        ?>
    </td>
</tr>