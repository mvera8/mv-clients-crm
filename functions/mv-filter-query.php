<?php
function filtrar_projects_por_type( $query ) {
    // Solo en frontend y en la query principal
    if ( ! is_admin() && $query->is_main_query() && is_post_type_archive( 'projects' ) ) {

        if ( isset( $_GET['type'] ) && ! empty( $_GET['type'] ) ) {

            $query->set( 'tax_query', array(
                array(
                    'taxonomy' => 'type',
                    'field'    => 'slug',
                    'terms'    => sanitize_text_field( $_GET['type'] ),
                ),
            ));

        }
    }
}
add_action( 'pre_get_posts', 'filtrar_projects_por_type' );
