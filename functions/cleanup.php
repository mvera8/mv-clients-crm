<?php
add_action('init', function () {
  // 🔹 Elimina scripts y estilos de emojis
  remove_action('wp_head', 'print_emoji_detection_script', 7);
  remove_action('wp_print_styles', 'print_emoji_styles');
  remove_action('admin_print_scripts', 'print_emoji_detection_script');
  remove_action('admin_print_styles', 'print_emoji_styles');

  // 🔹 Elimina links innecesarios del <head>
  remove_action('wp_head', 'rsd_link');
  remove_action('wp_head', 'wlwmanifest_link');
  remove_action('wp_head', 'wp_generator');
  remove_action('wp_head', 'rest_output_link_wp_head');
  remove_action('wp_head', 'wp_oembed_add_discovery_links');
  remove_action('wp_head', 'wp_oembed_add_host_js');
  remove_action('wp_head', 'wp_shortlink_wp_head');

  add_action('wp_footer', function () {
    remove_action('wp_footer', 'wp_embed_footer_scripts');
  }, 1);
}, 0);

add_action('wp_enqueue_scripts', function () {
  // 🔹 Elimina Dashicons del frontend
  if (!is_admin() && !is_user_logged_in()) {
    wp_deregister_style('dashicons');
  }

	// Eliminar jquery si no lo usás
	if (!is_admin() && !is_user_logged_in()) {
		// 🔹 Elimina jQuery (solo si no lo usás en tu sitio o plugins)
		wp_deregister_script('jquery');
		wp_deregister_script('jquery-core');
		wp_deregister_script('jquery-migrate');
	}

  // 🔹 Elimina estilos de bloques de Gutenberg
  // wp_dequeue_style( 'wp-block-library' );
	wp_dequeue_style( 'wp-block-library-theme' );
	wp_dequeue_style( 'wc-block-style' );
	wp_dequeue_style( 'storefront-gutenberg-blocks' );
}, 100);
