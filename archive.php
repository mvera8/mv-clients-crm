<?php
defined( 'ABSPATH' ) || exit;

$queried_object = get_queried_object();
$queried_object_type = $queried_object->name;

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
                            'title' => get_the_archive_title(),
                        )
                    );
                    ?>

                    <div class="card mb-3">
                        <div class="card-body">
                            <?php if ( have_posts() ) : ?>
                               <table class="table">  
                                    <thead>
                                        <tr>
                                            <th>Titulo</th>
                                            <th>Projecto</th>
                                            <th>Horas</th>
                                            <th>Estado</th>
                                            <th>Prioridad</th>
                                        </tr>
                                    </thead>        
                                    <tbody>
                                        <?php
                                        while ( have_posts() ) : the_post();
                                            switch ($queried_object_type) {
                                                case 'clients':
                                                    get_template_part(
                                                        'template-parts/row',
                                                        'tasks',
                                                        array(
                                                            'id'    => get_the_ID(),
                                                            'title' => get_the_title(),
                                                            'link'  => get_the_permalink(),
                                                        ),
                                                    );
                                                    break;

                                                case 'tasks':
                                                    get_template_part(
                                                        'template-parts/row',
                                                        'tasks',
                                                        array(
                                                            'id'    => get_the_ID(),
                                                            'title' => get_the_title(),
                                                            'link'  => get_the_permalink(),
                                                        ),
                                                    );
                                                    break;

                                                default:
                                                    echo 'bbbb';
                                            }
                                        endwhile; ?>
                                    </tbody>
                                </table>

                                <div class="mt-4">
                                    <?php the_posts_pagination(); ?>
                                </div>

                            <?php else : ?>
                                <p>No hay contenido para mostrar.</p>
                            <?php endif; ?>
                        </div>
                    </div>
                </div>
            </section>
        </div>
    </div>
</div>

<?php
get_footer();