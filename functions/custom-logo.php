<?php
function add_custom_class_to_logo( $attr, $attachment, $size ) {
    // Check if the image being filtered is the custom logo
    if ( isset( $attr['class'] ) && strpos( $attr['class'], 'custom-logo' ) !== false ) {
        $attr['class'] .= ' img-fluid'; // Add your desired class here
    }
    return $attr;
}

add_filter( 'wp_get_attachment_image_attributes', 'add_custom_class_to_logo', 10, 3 );