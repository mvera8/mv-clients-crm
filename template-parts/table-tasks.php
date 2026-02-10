<?php
/**
 * Template Part: Table Tasks (Bootstrap 5)
 */

 // Exit if accessed directly.
defined( 'ABSPATH' ) || exit;

$data = $args['data'];
?>

<div class="card mb-3">
    <div class="card-body">
        <h4 class="card-title">Tareas</h4>

        <?php if ( $data->have_posts() ) : ?>
            <table class="table">
                <thead>
                    <tr>
                        <th>Titulo</th>
                        <th>Estado</th>
                        <th>Prioridad</th>
                    </tr>
                </thea>
                <tbody>
                    <?php 
                    while ( $data->have_posts() ) : $data->the_post(); 
                    ?>
                        <tr>
                            <td>
                                <?php
                                printf(
                                    '<a href="%s">%s</a>',
                                    get_permalink(),
                                    get_the_title()
                                );
                                ?>
                            </td>
                            <td>
                                <?php
                                $status = get_field( 'status' );
                                if ($status) {
                                    echo mv_status_tag($status);
                                }
                                ?>
                            </td>
                            <td>
                                <?php
                                $priority = get_field( 'priority' );
                                if ($priority) {
                                    echo mv_priority_tag($priority);
                                }
                                ?>
                            </td>
                        </tr>
                    <?php 
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