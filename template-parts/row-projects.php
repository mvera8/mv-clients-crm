<?php
/**
 * Template Part: Table Tasks (Bootstrap 5)
 */

 // Exit if accessed directly.
defined( 'ABSPATH' ) || exit;

$id = $args['id'] ?? '';
$title = $args['title'] ?? '';
$link = $args['link'] ?? '';

$client = get_field( 'client', $id ) ?? '';
$website = get_field( 'website', $id ) ?? '';
$types = get_the_terms( $id, 'project_type' );
?>

<tr>
    <th>
        <?php
        printf(
            '<a href="%s">%s</a>',
            esc_url($link),
            esc_html($title),
        );
        ?>
    </th>
    <td>
        <?php
        if ( $website) {
            printf(
                '<a href="%1$s" target="_blank">%1$s</a>',
                esc_url($website)
            );
        } else {
            echo '-';
        }
        ?>
    </td>
    <td>
        <?php
        if( $client ):
            echo esc_html( $client->post_title );
        else:
            echo '-';
        endif;
        ?>
    </td>
    <td>
        <?php
        if ( $types && ! is_wp_error( $types ) ) {
            foreach ( $types as $type ) {
                echo '<span class="badge bg-secondary me-1">' . esc_html( $type->name ) . '</span>';
            }
        }
        ?>
    </td>
</tr>