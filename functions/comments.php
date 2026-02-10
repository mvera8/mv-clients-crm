<?php
// 1) Nunca abrir comentarios ni pings en ningún post type.
add_filter('comments_open', '__return_false', 20, 2);
add_filter('pings_open', '__return_false', 20, 2);

// 2) No mostrar comentarios existentes en el frontend.
add_filter('comments_array', '__return_empty_array', 20, 2);

// 3) Quitar soporte de comments/trackbacks de todos los post types (incluye custom).
add_action('init', function () {
	foreach (get_post_types() as $type) {
		if (post_type_supports($type, 'comments')) {
			remove_post_type_support($type, 'comments');
		}
		if (post_type_supports($type, 'trackbacks')) {
			remove_post_type_support($type, 'trackbacks');
		}
	}
}, 100);

// 4) Vaciar el template de comentarios (por si algún theme lo llama sí o sí).
add_filter('comments_template', function ($file) {
	return __DIR__ . '/empty-comments-template.php';
}, 100);

// Crear un template vacío en memoria (fallback si no existe el archivo).
// Opcional: también podés crear un archivo real en este mismo directorio.
if (!file_exists(__DIR__ . '/empty-comments-template.php')) {
	file_put_contents(__DIR__ . '/empty-comments-template.php', "<?php\n// Comentarios deshabilitados.\n");
}

// 5) Bloquear envío directo a wp-comments-post.php.
add_action('preprocess_comment', function () {
	wp_die(__('Comentarios deshabilitados.'), 403);
});

// 6) Admin: ocultar menú de comentarios y redirigir pantallas de discusión/comentarios.
add_action('admin_menu', function () {
	remove_menu_page('edit-comments.php');
}, 999);

add_action('admin_init', function () {
	// Redirigir listado de comentarios
	if (isset($_GET['page']) && 'edit-comments.php' === $_GET['page']) {
		wp_safe_redirect(admin_url());
		exit;
	}
	global $pagenow;
	if ('edit-comments.php' === $pagenow) {
		wp_safe_redirect(admin_url());
		exit;
	}
	// Redirigir ajustes de Discusión
	if ('options-discussion.php' === $pagenow) {
		wp_safe_redirect(admin_url());
		exit;
	}

	// Ocultar metaboxes relacionados en pantallas de edición
	foreach (get_post_types('', 'names') as $type) {
		remove_meta_box('commentstatusdiv', $type, 'normal');
		remove_meta_box('commentsdiv',      $type, 'normal');
		remove_meta_box('trackbacksdiv',    $type, 'normal');
	}
}, 100);

// 7) Quitar el ícono de comentarios de la admin bar.
add_action('admin_bar_menu', function ($wp_admin_bar) {
	$wp_admin_bar->remove_node('comments');
}, 999);

// 8) Desactivar endpoints REST relacionados a comentarios.
add_filter('rest_endpoints', function ($endpoints) {
	foreach ($endpoints as $route => $details) {
		if (strpos($route, '/comments') !== false) {
			unset($endpoints[$route]);
		}
	}
	return $endpoints;
});

// 9) Desactivar pingbacks/trackbacks: header X-Pingback + método XML-RPC.
add_filter('wp_headers', function ($headers) {
	if (isset($headers['X-Pingback'])) unset($headers['X-Pingback']);
	return $headers;
});
add_filter('xmlrpc_methods', function ($methods) {
	unset($methods['pingback.ping']);
	unset($methods['pingback.extensions.getPingbacks']);
	return $methods;
});

// 10) Ocultar feeds de comentarios y enlaces en el <head>.
add_filter('feed_links_show_comments_feed', '__return_false');
remove_action('wp_head', 'feed_links_extra', 3); // categorías, etc.
remove_action('wp_head', 'feed_links', 2);       // feeds generales (si querés mantenerlos, comentá esta línea)

// 11) Desregistrar el widget de "Comentarios Recientes" y su CSS.
add_action('widgets_init', function () {
	unregister_widget('WP_Widget_Recent_Comments');
	// Remover estilos en el head si algún theme/versión los añade
	remove_action('wp_head', 'wp_widget_recent_comments_style');
}, 100);

// 12) Seguridad extra: marcar todo nuevo comentario (si lograra pasar) como spam.
add_filter('pre_comment_approved', function ($approved) {
	return 'spam';
}, 20);

// 13) Ajuste de opción por si algún proceso intenta abrirlos por defecto.
add_action('init', function () {
	update_option('default_comment_status', 'closed');
	update_option('default_ping_status', 'closed');
}, 1);
