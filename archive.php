<?php
defined( 'ABSPATH' ) || exit;

$queried_object = get_queried_object();
$queried_object_type = $queried_object->name ?? '';

$tableHead = array(
    'tasks' => array(
        'title' => 'Titulo',
        'project' => 'Projecto',
        'hours' => 'Horas',
        'status' => 'Estado',
        'priority' => 'Prioridad',
    ),
    'clients' => array(
        'title'   => 'Nombre',
        'email'   => 'Email',
        'company' => 'Empresa',
        'contact' => 'Contacto',
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
                        <button type="button" class="btn btn-outline-primary active">Left</button>
                        <button type="button" class="btn btn-outline-primary">Middle</button>
                        <button type="button" class="btn btn-outline-primary">Right</button>
                    </div>

                    <?php
                    if ( have_posts() ) :
                    
                        if (array_key_exists($queried_object_type, $tableHead)) {
                            echo '<div class="card mb-3"><div class="card-body"><table class="table"><thead>';
                            foreach ($tableHead[$queried_object_type] as $key => $value) {
                                echo '<th>' . esc_html($value) . '</th>';
                            }
                            echo '</thead><tbody>'; 
                        } else {
                            echo '<div class="row row-cols-1 row-cols-md-4">';
                        }

                            while ( have_posts() ) : the_post();
                                switch ($queried_object_type) {
                                    case 'clients':
                                        get_template_part(
                                            'template-parts/row',
                                            'clients',
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

                                    case 'projects':
                                        get_template_part(
                                            'template-parts/card',
                                            'company',
                                            array(
                                                'title' => get_the_title(),
                                                'link'  => get_the_permalink(),
                                            ),
                                        );
                                        break;
                                }
                            endwhile;
                            
                        if (array_key_exists($queried_object_type, $tableHead)) {
                            echo '</tbody></table></div></div>'; 
                        } else {
                            echo '</div>';
                        }
                        ?>

                    <div class="mt-4">
                        <?php the_posts_pagination(); ?>
                    </div>
                </div>

                <?php else : ?>
                    <p>No hay contenido para mostrar.</p>
                <?php endif; ?>
            </section>
        </div>
    </div>
</div>

<?php
get_footer();