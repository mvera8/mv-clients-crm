<?php
// Función para contar posts de cualquier tipo
function contar_posts_por_tipo($post_type) {
    $count = wp_count_posts($post_type);
    return $count->publish; // Solo posts publicados
}