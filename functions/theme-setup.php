<?php
add_action('after_setup_theme', function() {
  // Theme supports
  add_theme_support( 'custom-logo' );
  add_theme_support('title-tag');
  add_theme_support('post-thumbnails');
  add_theme_support('html5', ['search-form', 'comment-form', 'comment-list', 'gallery', 'caption']);
  add_theme_support('menus');

  // Menus
  register_nav_menus([
      'primary-nav'  => __('Primary Navigation'),
      'footer-nav' => __('Footer Navigation'),
  ]);
});
