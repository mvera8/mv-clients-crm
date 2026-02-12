<?php
defined( 'ABSPATH' ) || exit;

$queried_object = get_queried_object();
$queried_object_type = $queried_object->name ?? '';

$tableHead = array(
    'tasks' => array(
        'title'    => 'Titulo',
        'project'  => 'Projecto',
        'hours'    => 'Horas',
        'status'   => 'Estado',
        'priority' => 'Prioridad',
    ),
    'clients' => array(
        'title'   => 'Nombre',
        'email'   => 'Email',
        'company' => 'Empresa',
        'contact' => 'Contacto',
    ),
     'projects' => array(
        'title'   => 'Nombre',
        'website' => 'Sitio Web',
        'client'  => 'Cliente',
    ),
);

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
                            'title'   => get_the_archive_title(),
                        )
                    );
                    ?>

                    <div class="btn-group mb-2" role="group" aria-label="Basic example">
                        <button type="button" class="btn btn-outline-primary active">Todos</button>
                        <button type="button" class="btn btn-outline-primary">Middle</button>
                        <button type="button" class="btn btn-outline-primary">Right</button>
                    </div>

                    <div class="card mb-3">
                        <div class="card-body">
                            <table class="table">
                                <?php
                                if (array_key_exists($queried_object_type, $tableHead)) {
                                    echo '<thead>';
                                    foreach ($tableHead[$queried_object_type] as $key => $value) {
                                        echo '<th>' . esc_html($value) . '</th>';
                                    }
                                    echo '</thead>';
                                }
                                ?>
                                
                                <tbody>
                                    <?php
                                    if ( have_posts() ) :										
                                        while ( have_posts() ) : the_post();
                                            get_template_part(
                                                'template-parts/row',
                                                $queried_object_type,
                                                array(
                                                    'id'    => get_the_ID(),
                                                    'title' => get_the_title(),
                                                    'link'  => get_the_permalink(),
                                                ),
                                            );
                                        endwhile;
                                        ?>
										<div class="mt-4">
											<?php the_posts_pagination(); ?>
										</div>
                                    <?php else : ?>
                                        <p>No hay contenido para mostrar.</p>
                                    <?php endif; ?>
                                </tbody>
							</table>
                        </div>
                    </div>
                    
                </div>
            </section>
        </div>
    </div>
</div>

<?php
get_footer();