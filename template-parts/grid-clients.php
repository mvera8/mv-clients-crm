<?php
/**
 * Template Part: Table Clients (Bootstrap 5)
 */

 // Exit if accessed directly.
defined( 'ABSPATH' ) || exit;

$data = $args['data'];
?>

<?php
if ( $data->have_posts() ) :
    while ( $data->have_posts() ) : $data->the_post();
        $id = get_the_ID();
        $name = get_the_title($id);
        $email = get_field('client_email', $id);
        $client_contact_type = get_field('client_contact_type', $id);

        $projects_query = new WP_Query(array(
            'post_type'      => 'projects',
            'posts_per_page' => -1,
            'meta_query'     => array(
                array(
                    'key'     => 'client',
                    'value'   => $id,
                    'compare' => '=',
                ),
            ),
        ));
        ?>
        <div class="col-12 col-md-4">
            <div class="card border-0 mb-3 shadow-sm">
                <div class="card-body">
                    <div class="d-flex justify-content-start align-items-start gap-3">
                        <span class="rounded text-primary bg-primary-subtle p-3">
                            <?php echo mv_icon_selector($client_contact_type); ?>
                        </span>
                        <div>
                            <h5 class="card-title mb-1"><?php echo esc_html( $name ); ?></h5>
                            <p class="card-text text-muted small mb-1"><?php echo esc_html( $email ); ?></p>
                            <p class="card-text small mb-0"><?php echo $projects_query->found_posts; ?> proyecto/s</p>
                        </div>
                    </div>
                </div>
                <div class="card-footer text-body-secondary">
                    <?php if ( $projects_query->have_posts() ) : ?>
                        
                        <ul class="list-unstyled mb-0">
                            <?php while ( $projects_query->have_posts() ) : $projects_query->the_post(); ?>
                                <li>
                                    <a href="<?php the_permalink(); ?>" class="text-decoration-none">
                                        <span class="badge bg-primary-subtle text-primary me-1">
                                            <?php the_title(); ?>
                                        </span>
                                    </a>
                                </li>
                            <?php endwhile; ?>
                        </ul>

                        <?php wp_reset_postdata(); ?>

                    <?php else : ?>
                        <small class="text-muted">Sin proyectos asociados</small>
                    <?php endif; ?>
                </div>
            </div>
        </div>
       <?php

    endwhile;
    wp_reset_postdata();
else : ?>
    <p>No hay datos</p>
<?php
endif;