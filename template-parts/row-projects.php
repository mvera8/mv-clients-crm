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
        printf(
            '<a href="%1$s" target="_blank">%1$s</a>',
            esc_url($website)
        );
        ?>
    </td>
    <td>
        <?php
        if( $client ):
            printf(
            '<a href="%s">%s</a>',
                esc_url( get_permalink( $client->ID ) ),
                esc_html( $client->post_title ),
            );
        endif;
        ?>
    </td>
</tr>