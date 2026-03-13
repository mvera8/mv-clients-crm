<?php
/**
 * Template Part: Table Clients (Bootstrap 5)
 */

 // Exit if accessed directly.
defined( 'ABSPATH' ) || exit;

$data = $args['data'];
?>

<div class="card border-0 mb-3 shadow-sm">
    <div class="card-body">
        <h4 class="card-title mb-2 text-uppercase fs-6">Showroom</h4>
        <?php if ( $data->have_posts() ) : ?>
            <table class="table">          
                <tbody>
                    <?php 
                    while ( $data->have_posts() ) : $data->the_post(); 
                        get_template_part(
                            'template-parts/row',
                            'projects',
                            [
                                'id'    => get_the_ID(),
                                'title' => get_the_title(),
                                'link'  => get_permalink(),
                            ]
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