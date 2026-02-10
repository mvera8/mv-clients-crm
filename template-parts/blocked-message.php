<?php
defined( 'ABSPATH' ) || exit;
?>

<section class="min-vh-100 d-flex align-items-center justify-content-center text-center">
    <div class="container">
        <h1 class="mb-3">Acceso restringido</h1>
        <p class="mb-4 text-muted">
            Este sitio es solo para usuarios registrados.
        </p>

        <a href="<?php echo wp_login_url(); ?>" class="btn btn-primary">
            Iniciar sesión
        </a>
    </div>
</section>
