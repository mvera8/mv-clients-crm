<?php
defined( 'ABSPATH' ) || exit;

$post_type = get_post_type();
$taxonomies = get_object_taxonomies( $post_type, 'objects' );

$tableHead = array(
    'tasks' => array(
        'title'    => 'Titulo',
        'project'  => 'Projecto',
        'hours'    => 'Horas',
        'status'   => 'Estado',
        'priority' => 'Prioridad',
    ),
     'projects' => array(
        'title'   => 'Nombre',
        'website' => 'Sitio Web',
        'client'  => 'Cliente',
        'type'    => 'Tipo',
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
                    // Page Title
                    get_template_part(
                        'template-parts/dashboard',
                        'title',
                        array(
                            'title'   => get_the_archive_title(),
                        )
                    );

                    // Filter
                    if ( !empty( $taxonomies ) ) :
                        foreach ( $taxonomies as $taxonomy ) :
                            // Opcional: ignorar algunas taxonomías si querés
                            if ( $taxonomy->name === 'post_tag' || $taxonomy->name === 'task_priority' ) continue;

                            $terms = get_terms( array(
                                'taxonomy'   => $taxonomy->name,
                                'hide_empty' => true,
                            ) );

                            if ( empty($terms) || is_wp_error($terms) ) continue;
                            ?>

                            <div class="btn-group mb-3" role="group">

                                <!-- Todos -->
                                <a
                                    href="<?php echo esc_url( get_post_type_archive_link( $post_type ) ); ?>"
                                    class="btn btn-outline-primary <?php echo !isset($_GET[$taxonomy->name]) ? 'active' : ''; ?>"
                                >
                                    Todos
                                </a>

                                <?php foreach ( $terms as $term ) : 
                                    $active = ( isset($_GET[$taxonomy->name]) && $_GET[$taxonomy->name] === $term->slug ) ? 'active' : '';
                                ?>
                                    <a
                                        href="<?php echo esc_url( add_query_arg( $taxonomy->name, $term->slug, get_post_type_archive_link( $post_type ) ) ); ?>"
                                        class="btn btn-outline-primary <?php echo $active; ?>"
                                    >
                                        <?php echo esc_html( $term->name ); ?>
                                    </a>
                                <?php endforeach; ?>

                            </div>

                        <?php
                        endforeach;
                    endif;
                    ?>

                    <div class="card mb-3">
                        <div class="card-body">
                            <table class="table">
                                <?php
                                if (array_key_exists($post_type, $tableHead)) {
                                    echo '<thead>';
                                    foreach ($tableHead[$post_type] as $key => $value) {
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
                                                $post_type,
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