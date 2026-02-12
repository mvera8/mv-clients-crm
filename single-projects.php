<?php
defined( 'ABSPATH' ) || exit;

include locate_template( 'single-projects-controller.php' );

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
                            'prelink' => 'proyectos',
                        )
                    );

                    echo '<p><b>Cliente:</b> ' . ($project_client ? get_the_title($project_client) : '—') . '</p>';
                    echo '<p><b>Website:</b> ' . ($project_website ? '<a href="' . esc_url($project_website) . '" target="_blank">' . esc_html($project_website) . '</a>' : '—') . '</p>';
                    if (isset( $project_github_repo ) && !empty($project_github_repo)) {
                        echo '<p><b>Github Repo:</b> ' . ($project_github_repo ? '<a href="' . esc_url($project_github_repo) . '" target="_blank">' . esc_html($project_github_repo) . '</a>' : '—') . '</p>';
                    }

                    get_template_part(
                        'template-parts/table',
                        'tasks',
                        array(
                            'data' => $tasks_query,
                            'type' => 'long',
                        )
                    );
                    ?>        
                </div>
            </section>
        </div>
    </div>
</div>

<?php
get_footer();