<?php
/**
 * Preload assets (Vite) — solo lo necesario.
 */
function mv_preload_assets() {
  if (is_404()) return;

  // En dev, que Vite haga su magia sin preloads manuales
  if (defined('WP_ENV') && WP_ENV === 'development') {
    return;
  }

  $theme_dir = wp_normalize_path(get_template_directory());
  $theme_uri = trailingslashit(get_template_directory_uri());
  $manifest_path = $theme_dir . '/build/manifest.json';
  if (!file_exists($manifest_path)) return;

  $manifest = json_decode(file_get_contents($manifest_path), true);
  $entryKey = 'js/main.js';
  if (empty($manifest[$entryKey])) return;

  $entry   = $manifest[$entryKey];
  $baseURI = $theme_uri . 'build/';

  // 1) Modulepreload SOLO de los imports ESM del entry (no del legacy)
  if (!empty($entry['imports']) && is_array($entry['imports'])) {
    foreach ($entry['imports'] as $impKey) {
      if (!empty($manifest[$impKey]['file'])) {
        $file = $manifest[$impKey]['file'];
        if (strpos($file, '-legacy') !== false) continue; // evitar legacy
        printf("<link rel='modulepreload' href='%s' crossorigin>\n", esc_url($baseURI . $file));
      }
    }
  }

  // 2) Preload de CSS generado por la entrada principal (opcional pero útil)
  if (!empty($entry['css']) && is_array($entry['css'])) {
    foreach ($entry['css'] as $cssRelPath) {
      printf("<link rel='preload' href='%s' as='style' type='text/css'>\n", esc_url($baseURI . $cssRelPath));
    }
  }

  // 3) Fonts (woff2) con crossorigin
  foreach (['Montserrat-Light', 'Poppins-Bold'] as $base) {
    $matches = glob($theme_dir . "/build/assets/{$base}-*.woff2");
    if ($matches) {
      $abs = wp_normalize_path($matches[0]);
      $rel = ltrim(str_replace($theme_dir, '', $abs), '/'); // p.ej. build/assets/Poppins-Bold-xxx.woff2
      printf("<link rel='preload' href='%s' as='font' type='font/woff2' crossorigin>\n", esc_url($theme_uri . $rel));
    }
  }
}
add_action('wp_head', 'mv_preload_assets', 0);
