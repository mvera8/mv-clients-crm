<?php
/**
 * Template Part: Table Clients (Bootstrap 5)
 */

 // Exit if accessed directly.
defined( 'ABSPATH' ) || exit;

$data = $args['data'];
?>

<div class="card mb-3">
    <div class="card-body">
        <h4 class="card-title">Clientes</h4>

        <?php if ( $data->have_posts() ) : ?>
        <table class="table">          
            <tbody>
                <?php 
                $i = 1;
                while ( $data->have_posts() ) : $data->the_post(); 
                ?>
                <tr>
                    <th>
                        <?php
                        printf(
                            '<a href="%s">%s</a>',
                            get_permalink(),
                            get_the_title()
                        );
                        ?>
                    </th>
                    <td>
                        <?php
                        $client_company = get_field( 'client_company' );
                        if ($client_company) {
                            echo $client_company;
                        }
                        ?>
                    </td>
                </tr>
                <?php 
                $i++;
                endwhile; 
                ?>
            </tbody>
            </table>
            <?php wp_reset_postdata(); ?>
        <?php else : ?>
            <p>No hay datos</p>
        <?php endif; ?>
    </div>
</div>