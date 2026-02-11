<?php
/**
 * Component: Dashboard Title
 *
 * @package mv-clients-crm
 */

// Exit if accessed directly.
defined( 'ABSPATH' ) || exit;

$title = $args['title'] ?? '';
$breadcrumb = $args['breadcrumb'] ?? true;

if ($breadcrumb ) {
    get_template_part(
        'template-parts/breadcrumbs',
        null,
        array(
            'active_text' => $title,
        )
    );
}

get_template_part(
    'template-parts/title',
    'section',
    array(
        'title' => $title,
    )
);