<?php
/**
 * Template Name: Clients Page
 *
 * @package mv-clients-crm
 */

// Exit if accessed directly.
defined( 'ABSPATH' ) || exit;

$clients_args = array(
    'post_type'      => 'clients',
    'posts_per_page' => -1,
    'orderby'        => 'date',
    'order'          => 'DESC',
    'no_found_rows'  => true,
    'update_post_meta_cache' => false,
    'update_post_term_cache' => false,
);
$clients_query = new WP_Query( $clients_args );

get_header();
?>

<div class="container-fluid px-0">
    <div class="row">
        <?php get_template_part('template-parts/dashboard-sidebar'); ?>

        <div class="col-12 col-md-10">
            <section id="dashboard-content" class="py-4 bg-light min-vh-100">
                <div class="container">
                    <?php
                    get_template_part(
                        'template-parts/dashboard',
                        'title',
                        array(
                            'title' => get_the_title(),
                        )
                    );
                    ?>

                    <div class="row">
                        <?php
                        if ( $clients_query->have_posts() ) {
                            get_template_part(
                                'template-parts/grid',
                                'clients',
                                array(
                                    'data' => $clients_query,
                                )
                            );
                        }
                        wp_reset_postdata();
                        ?>
                    </div>
                </div>
            </section>
        </div>
    </div>
</div>

<?php
get_footer();
