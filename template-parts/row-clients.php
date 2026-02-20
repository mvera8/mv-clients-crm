<?php
/**
 * Template Part: Table Tasks (Bootstrap 5)
 */

 // Exit if accessed directly.
defined( 'ABSPATH' ) || exit;

$id = $args['id'] ?? '';
$title = $args['title'] ?? '';

$client_company = get_the_terms( $id, 'client_company' );

$money = mv_get_client_total_paid( $id );
?>

<tr>
    <th>
        <?php echo esc_html($title); ?>
    </th>
    <td>
        <?php
        if ( $client_company && ! is_wp_error( $client_company ) ) {
            foreach ( $client_company as $company ) {
                echo esc_html( $company->name );
            }
        }
        ?>
    </td>
    <td>
        $<?php echo esc_html( number_format($money, 0, ',', '.') ); ?>
    </td>
</tr>