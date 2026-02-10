<?php
add_filter( 'document_title_parts', function( $title ) {
    // Si estamos en la home (página de inicio)
    if ( is_front_page() || is_home() ) {
        // Solo mostrar el nombre del sitio
        $title['title'] = get_bloginfo( 'name' );
        unset( $title['tagline'] ); // opcional: quita el tagline si lo hubiera
    } else {
        // Para páginas internas -> "Nombre página | Nombre sitio"
        $title['title'] = single_post_title( '', false );
        $title['site']  = get_bloginfo( 'name' );
    }

    return $title;
});
