<?php
/**
 * Template Part: Table Clients (Bootstrap 5)
 */

 // Exit if accessed directly.
defined( 'ABSPATH' ) || exit;

$data = $args['data'];
$title = $args['title'] ?? '';
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
            <tbody>
                <?php 
                while ( $data->have_posts() ) : $data->the_post(); 
                    get_template_part(
                        'template-parts/row',
                        'clients',
                        [
                            'id'    => get_the_ID(),
                            'title' => get_the_title(),
                            'link'  => get_permalink(),
                            'type'  => 'short',
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