<?php
defined( 'ABSPATH' ) || exit;

$queried_object = get_queried_object();
$queried_object_type = $queried_object->post_type ?? '';

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
                            'prelink' => $post_type,
                        )
                    );
                    
                    the_content();
                    
                    // list all meta data
                    $meta_data = get_post_meta( get_the_ID() );
                    echo '<pre>';
                    print_r( $meta_data );
                    echo '</pre>';
                    ?>

                </div>
            </section>
        </div>
    </div>
</div>

<?php
get_footer();