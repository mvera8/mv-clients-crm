<?php
defined( 'ABSPATH' ) || exit;

$project_id = get_the_ID();
$project_client = get_field('client', $project_id);
$project_website = get_field('website', $project_id);
$project_github_repo = get_field('github_repo', $project_id);

$tasks_args = array(
    'post_type'      => 'tasks',
    'posts_per_page' => -1,
    'meta_query'     => array(
        array(
            'key'     => 'project',
            'value'   => $project_id,
            'compare' => '=',
        ),
    ),
);

$tasks_query = new WP_Query($tasks_args);

if ($tasks_query->have_posts()) {
    while ($tasks_query->have_posts()) {
        $tasks_query->the_post();

        $projects = get_field('project'); // relationship devuelve array

        if ($projects) {
            foreach ($projects as $project) {
                $project_id = is_object($project) ? $project->ID : $project;

                // Aquí puedes hacer algo con el ID del proyecto, como mostrar su título o enlace
                // Por ejemplo:
                // echo '<p>Projecto: <a href="' . get_permalink($project_id) . '">' . get_the_title($project_id) . '</a></p>';
            }
        }
    }
    wp_reset_postdata();
}
