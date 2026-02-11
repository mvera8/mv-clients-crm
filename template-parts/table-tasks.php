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
                        <th>Projecto</th>
                        <th>Estado</th>
                        <th>Prioridad</th>
                    </tr>
                </thead>
                <tbody>
                    <?php 
                    while ( $data->have_posts() ) : $data->the_post();
                         get_template_part(
                            'template-parts/row',
                            'tasks',
                            array(
                                'id'    => get_the_ID(),
                                'title' => get_the_title(),
                                'link'  => get_the_permalink(),
                            ),
                        );
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