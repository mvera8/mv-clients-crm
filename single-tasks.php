<?php
defined( 'ABSPATH' ) || exit;

include locate_template( 'single-tasks-controller.php' );

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
                            'title'   => get_the_title(),
                            'prelink' => 'tareas',
                        )
                    );
                    ?>
                    
                    <div class="row">
                        <div class="col-9">
                            <?php                            
                            if ($payment_status === "1") : ?>
                                <div class="alert alert-success d-flex justify-content-between align-items-center" role="alert">
                                    <span>💰 Esta tarea fue pagada</span>
                                    <?php if ($payment_amount) : ?>
                                        <strong>USD <?php echo number_format($payment_amount); ?></strong>
                                    <?php endif; ?>
                                </div>
                            <?php endif; ?>

                            <div class="task-description card border-0 mb-3 shadow-sm">
                                <div class="card-body">
                                    <?php
                                    echo '<h2>Descripción:</h2>';
                                    the_content();
                                    ?>
                                </div>
                            </div>
                        </div>

                        <aside class="col-3">
                            <?php
                            get_template_part(
                                'template-parts/card',
                                'number',
                                array(
                                    'title' => 'Horas metidas',
                                    'total' => $hours,
                                    'icon'  => '<svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="icon icon-tabler icons-tabler-outline icon-tabler-clock"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M3 12a9 9 0 1 0 18 0a9 9 0 0 0 -18 0" /><path d="M12 7v5l3 3" /></svg>'
                                )
                            );
                            ?>
                            <div class="widget card border-0 shadow-sm">
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
                                    <code id="branch-text" class="bg-light d-block p-2 mb-2 overflow-auto">
                                        <?php echo $branch; ?> 
                                    </code>
                                    <button id="copy-button" class="btn btn-sm btn-outline-secondary" onclick="copyToClipboard('branch-text')">
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
    const copyButton = document.getElementById('copy-button');
    const copyText = document.getElementById('branch-text');
    const text = copyText.innerText;
    navigator.clipboard.writeText(text).then(() => {
        const originalText = copyButton.innerText;
        copyButton.innerText = '¡Copiado!';
        copyButton.classList.replace('btn-outline-secondary', 'btn-success');
        
        setTimeout(() => {
            copyButton.innerText = originalText;
            copyButton.classList.replace('btn-success', 'btn-outline-secondary');
        }, 1000);
    }).catch(err => {
        console.error('Error al copiar: ', err);
    });
}
</script>
<?php
get_footer();