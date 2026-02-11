<?php
defined( 'ABSPATH' ) || exit;
get_header();

$task_id = get_the_ID();
$branch = get_post_meta( $task_id, 'branch', true );
$branch = $branch ? $branch : 'MV-' . $task_id . '-' . get_post_field( 'post_name' );

$status = get_field( 'status', $task_id );
$status = $status ? $status : 'pending';

$priority = get_field( 'priority', $task_id );
$priority = $priority ? $priority : 'pending';

$project = get_field( 'project', $task_id );

// payment
$payment_args = array(
    'post_type'      => 'payments',
    'posts_per_page' => -1,
);

$payment_query = new WP_Query($payment_args);

$paid = false;

if ($payment_query->have_posts()) {
    while ($payment_query->have_posts()) {
        $payment_query->the_post();

        $tasks = get_field('task'); // relationship devuelve array

        if ($tasks) {
            foreach ($tasks as $task) {
                $task_id_in_payment = is_object($task) ? $task->ID : $task;

                if ($task_id_in_payment == $task_id) {
                    $paid = (bool) get_field('pagada');
                    break 2; // salimos de ambos loops
                }
            }
        }
    }
    wp_reset_postdata();
}
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
                            'active_link' => 'Tareas',
                            'active_text' => get_the_title(),                        )
                    );

                    get_template_part(
                        'template-parts/title',
                        'section',
                        array(
                            'title' => get_the_title(),
                        )
                    );
                    ?>
                    
                    <div class="row">
                        <div class="col-8">
                            <?php 
                            if ($paid) : ?>
                                <div class="alert alert-success" role="alert">
                                    💰 Esta tarea ya fue pagada.
                                </div>
                            <?php endif; ?>


                            <div class="task-description card">
                                <div class="card-body">
                                    <?php
                                    echo '<h2>Descripción:</h2>';
                                    the_content();
                                    ?>
                                </div>
                            </div>
                        </div>

                        <aside class="col-4">
                            <div class="widget card">
                                <div class="card-body">
                                    <?php
                                    if ($status) {
                                        echo '<p><b>Estado:</b> ' . mv_status_tag($status) . '</p>';
                                    }

                                    if ($priority) {
                                        echo '<p><b>Prioridad:</b> ' . mv_priority_tag($priority) . '</p>';
                                    }

                                    if ($project) {
                                        echo '<p><b>Projecto: </b><a href="' . get_permalink($project) . '">' . get_the_title($project) . '</a></p>';

                                        // id projecto get get_field website
                                        $website = get_field('website', $project);
                                        if ($website) {
                                            echo '<p><b>Website: </b><a href="' . $website . '" target="_blank">' . $website . '</a></p>';
                                        }
                                    }
                                    ?>

                                    <hr />

                                    <p><b>Branch</b></p>
                                    <code id="branch-text" class="bg-light d-block p-2 mb-2 overflow-auto"><?php echo $branch; ?></code>
                                    <button class="btn btn-sm btn-outline-secondary" onclick="copyToClipboard('branch-text')">
                                        Copiar
                                    </button>
                                </div>
                            </div>
                        </aside>
                    </div>


        
                </div>
            </section>
        </div>
    </div>
</div>

<script>
function copyToClipboard(elementId) {
    const text = document.getElementById(elementId).innerText;
    navigator.clipboard.writeText(text).then(() => {
        const btn = event.target;
        const originalText = btn.innerText;
        btn.innerText = '¡Copiado!';
        btn.classList.replace('btn-outline-secondary', 'btn-success');
        
        setTimeout(() => {
            btn.innerText = originalText;
            btn.classList.replace('btn-success', 'btn-outline-secondary');
        }, 2000);
    }).catch(err => {
        console.error('Error al copiar: ', err);
    });
}
</script>
<?php
get_footer();