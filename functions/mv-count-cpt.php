<?php
function contar_posts_por_tipo($post_type, $meta_query = array()) {

    // Si no hay meta_query usamos el método rápido
    if (empty($meta_query)) {
        $count = wp_count_posts($post_type);
        return isset($count->publish) ? $count->publish : 0;
    }

    // Si hay filtros meta usamos WP_Query
    $args = array(
        'post_type'      => $post_type,
        'post_status'    => 'publish',
        'posts_per_page' => -1,
        'fields'         => 'ids',
        'meta_query'     => $meta_query,
        'no_found_rows'  => true,
    );

    $query = new WP_Query($args);

    return $query->post_count;
}
