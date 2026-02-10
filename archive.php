<?php
defined( 'ABSPATH' ) || exit;

$queried_object = get_queried_object();
//echo $queried_object->name;

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
                        'template-parts/breadcrumbs',
                        null,
                        array(
                            'links' => 'lala',
                            'active_text' => get_the_archive_title(),                        )
                    );

                    get_template_part(
                        'template-parts/title',
                        'section',
                        array(
                            'title' => get_the_archive_title(),
                        )
                    );
                    ?>
                    
                    <?php if ( have_posts() ) : ?>
                        <ul class="list-unstyled">
                            <?php while ( have_posts() ) : the_post(); ?>
                                <li class="mb-3">
                                    <a href="<?php the_permalink(); ?>" class="text-decoration-none">
                                        <?php the_title(); ?>
                                    </a>
                                </li>
                            <?php endwhile; ?>
                        </ul>

                        <div class="mt-4">
                            <?php the_posts_pagination(); ?>
                        </div>

                    <?php else : ?>
                        <p>No hay contenido para mostrar.</p>
                    <?php endif; ?>



                </div>
            </section>
        </div>
    </div>
</div>

<?php
get_footer();