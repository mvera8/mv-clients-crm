<?php
/**
 * Template Part: Table Tasks (Bootstrap 5)
 */

 // Exit if accessed directly.
defined( 'ABSPATH' ) || exit;

$data = $args['data'];
$title = $args['title'] ?? '';
?>

<div class="card mb-3">
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
                                'type'  => 'short',
                            ),
                        );
                    endwhile; 
                    ?>
                </tbody>
            </table>
            <?php wp_reset_postdata(); ?>

            <div class="text-start">
                <a
                    href="<?php echo esc_url( get_post_type_archive_link( 'tasks' ) ); ?>"
                    class="btn btn-sm btn-outline-dark"
                >Ver tareas</a>
            </div>

        <?php else : ?>
            <p>No hay tareas agregadas</p>
        <?php endif; ?>
    </div>
</div>