<?php
$includes = array(
  '/class-wp-bootstrap-navwalker.php',
  '/cleanup.php',
  '/comments.php',
	'/enqueue.php',
  '/excerpt.php',
	'/preload.php',
  '/svg.php',
  '/theme-options.php',
  '/theme-setup.php',
  '/title-tag.php',
  '/custom-logo.php',
  '/mv-custom-post-type-clients.php',
  '/mv-custom-post-type-projects.php',
  '/mv-custom-post-type-tasks.php',
  '/mv-custom-post-type-payments.php',
  '/mv-count-cpt.php',
  '/mv-tags.php',
);

foreach ( $includes as $file ) {
	require_once get_template_directory() . '/functions' . $file;
}

add_filter('acf/settings/save_json', function() {
  return get_stylesheet_directory() . '/acf-json';
});

add_filter('acf/settings/load_json', function($paths) {
  $paths[] = get_stylesheet_directory() . '/acf-json';
  return $paths;
});

add_filter('get_the_archive_title', function ($title) {
    if (is_category()) {
        $title = single_cat_title('', false);
    } elseif (is_tag()) {
        $title = single_tag_title('', false);
    } elseif (is_author()) {
        $title = '<span class="vcard">' . get_the_author() . '</span>';
    } elseif (is_tax()) { //for custom post types
        $title = sprintf(__('%1$s'), single_term_title('', false));
    } elseif (is_post_type_archive()) {
        $title = post_type_archive_title('', false);
    }
    return $title;
});

add_action( 'template_redirect', function () {

    // Admin y login siempre accesibles
    if ( is_user_logged_in() || is_admin() || wp_doing_ajax() ) {
        return;
    }

    // Permitir página de login
    if ( in_array( $GLOBALS['pagenow'], [ 'wp-login.php', 'wp-register.php' ], true ) ) {
        return;
    }

    // Mostrar cartel y frenar el render
    get_header();
    get_template_part( 'template-parts/blocked-message' );
    get_footer();
    exit;
});

?>