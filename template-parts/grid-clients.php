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
        $companies = get_the_terms( $id, 'client_company' );
        ?>
        <div class="col-12 col-md-4 pb-4">
            <div class="card border-0 mb-3 shadow-sm h-100">
                <div class="card-body pb-0">
                    <div class="d-flex justify-content-between align-items-start gap-3">
                        
                        <div>
                            <h5 class="card-title mb-1"><?php echo esc_html( $name ); ?></h5>
                            <p class="card-text text-muted small mb-1"><?php echo esc_html( $email ); ?></p>
                        </div>
                        <div class="d-flex gap-2">
                            <?php if ( is_array($client_contact_type) && !empty($client_contact_type) ) : ?>
                                <?php foreach ( $client_contact_type as $type ) : ?>
                                    <span class="rounded text-primary bg-primary-subtle p-1">
                                        <?php echo mv_icon_selector($type); ?>
                                    </span>
                                <?php endforeach; ?>
                            <?php else : ?>
                                <span class="rounded text-primary bg-primary-subtle p-1">
                                    <?php echo mv_icon_selector($client_contact_type); ?>
                                </span>
                            <?php endif; ?>
                        </div>
                    </div>
                </div>
                <div class="card-footer text-body-secondary">
                    <?php if ( is_array($companies) && !empty($companies) ) : ?>
                        <ul class="list-unstyled mb-0">
                            <?php foreach ( $companies as $company ) : ?>
                                <li>
                                    <a href="<?php echo esc_url( get_term_link($company) ); ?>" class="text-decoration-none">
                                        <span class="badge bg-primary-subtle text-primary me-1">
                                            <?php echo esc_html( $company->name ); ?>
                                        </span>
                                    </a>
                                </li>
                            <?php endforeach; ?>
                        </ul>
                    <?php else : ?>
                        <small class="text-muted">Sin empresa asociada</small>
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