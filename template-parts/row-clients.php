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
        $client_contact_type = get_field( 'client_contact_type', $id );
        if ($client_contact_type) {
            if ('slack' === $client_contact_type) {
                echo '<svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="icon icon-tabler icons-tabler-outline icon-tabler-brand-slack"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M12 12v-6a2 2 0 0 1 4 0v6m0 -2a2 2 0 1 1 2 2h-6" /><path d="M12 12h6a2 2 0 0 1 0 4h-6m2 0a2 2 0 1 1 -2 2v-6" /><path d="M12 12v6a2 2 0 0 1 -4 0v-6m0 2a2 2 0 1 1 -2 -2h6" /><path d="M12 12h-6a2 2 0 0 1 0 -4h6m-2 0a2 2 0 1 1 2 -2v6" /></svg>';
            } else {
                echo '<svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="icon icon-tabler icons-tabler-outline icon-tabler-brand-whatsapp"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M3 21l1.65 -3.8a9 9 0 1 1 3.4 2.9l-5.05 .9" /><path d="M9 10a.5 .5 0 0 0 1 0v-1a.5 .5 0 0 0 -1 0v1a5 5 0 0 0 5 5h1a.5 .5 0 0 0 0 -1h-1a.5 .5 0 0 0 0 1" /></svg>';
            }
            
        }
        ?>
    </td>
    <th>
        <?php
        printf(
            '<a href="%s">%s</a>',
            esc_url($link),
            esc_html($title),
        );
        ?>
    </th>
    
    <?php
    if (isset($type) && $type === 'long') {
        echo '<td>';
        $client_email = get_field( 'client_email', $id );
        if ($client_email) {
            printf(
                '<a href="mailto:%s">%s</a>',
                esc_attr($client_email),
                esc_html($client_email),
            );
        }
        echo '</td>';
    }
    ?>
    <td>
        <?php
        $client_company = get_field( 'client_company', $id );
        if ($client_company) {
            echo esc_html($client_company);
        }
        ?>
    </td>
</tr>