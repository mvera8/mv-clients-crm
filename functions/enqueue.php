<?php
add_action('wp_enqueue_scripts', function () {
  // Dev con Vite server
  if (defined('WP_ENV') && WP_ENV === 'development') {
    add_action('wp_print_scripts', function () {
      echo '<script type="module" src="http://localhost:5173/js/main.js" id="tincho-dev-js"></script>';
    });
    return;
  }

  $manifest_path = get_template_directory() . '/build/manifest.json';
  if (!file_exists($manifest_path)) {
    error_log('[enqueue] manifest.json no encontrado'); 
    return;
  }
  $manifest = json_decode(file_get_contents($manifest_path), true);

  // ⇩ Claves candidatas: con y sin .js (según cómo nombró Vite)
  $candidates = ['js/main', 'js/main.js', '/js/main', '/js/main.js'];
  $entryKey = null;
  foreach ($candidates as $key) {
    if (!empty($manifest[$key]['file'])) { $entryKey = $key; break; }
  }
  if (!$entryKey) {
    error_log('[enqueue] no encontré la entrada js/main en el manifest. Keys: ' . implode(', ', array_keys($manifest)));
    return;
  }

  $base_uri = trailingslashit(get_template_directory_uri()) . 'build/';
  $entry    = $manifest[$entryKey];

  // CSS generado por esa entrada (si importás SCSS en main.js)
  if (!empty($entry['css']) && is_array($entry['css'])) {
    foreach ($entry['css'] as $cssRelPath) {
      wp_enqueue_style('tincho-style', $base_uri . $cssRelPath, [], null);
    }
  }

  // Script ESM principal
  wp_enqueue_script('tincho-script', $base_uri . $entry['file'], [], null, true);
}, 10);

// Fuerza type="module" y crossorigin
add_filter('script_loader_tag', function($tag, $handle, $src) {
  if ($handle === 'tincho-script' || $handle === 'tincho-dev') {
    return sprintf('<script type="module" crossorigin src="%s" id="%s-js"></script>', esc_url($src), esc_attr($handle));
  }
  return $tag;
}, 10, 3);
