<?php
/**
 * Template Part: Table Tasks (Bootstrap 5)
 */

 // Exit if accessed directly.
defined( 'ABSPATH' ) || exit;

$data = $args['data'];
$title = $args['title'] ?? '';
$type = $args['type'] ?? 'short';
?>

<div class="card border-0 mb-3 shadow-sm">
    <div class="card-body">
        <?php 
        if (isset($title) && !empty($title)) {
            echo '<h4 class="card-title">' . esc_html( $title ) . '</h4>';
        }
        ?>

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
                                'type'  => $type,
                            ),
                        );
                    endwhile; 
                    ?>
                </tbody>
            </table>
            <?php
            wp_reset_postdata();
            
            if ('short' === $type) {
               printf(
                    '<div class="text-start">
                        <a href="%s" class="btn btn-sm btn-outline-dark">Ver todas</a>
                    </div>',
                    esc_url( get_post_type_archive_link( 'tasks' ) ),
               );
            }
            ?>

        <?php else : ?>
            <p>No hay tareas agregadas</p>
        <?php endif; ?>
    </div>
</div>