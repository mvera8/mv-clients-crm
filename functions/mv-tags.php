<?php
function mv_status_tag($status) {
    $color = '';
    if ($status) {
        switch ($status) {
            case 'En Proceso':
                $color = 'primary';
                $label = 'En Proceso';
                break;
            case 'Completada':
                $color = 'success';
                $label = 'Completada';
                break;
            case 'Bloqueada':
                $color = 'danger';
                $label = 'Bloqueada';
                break;
            case 'Cancelada':
                $color = 'danger';
                $label = 'Cancelada';
                break;
            case 'Entregada':
                $color = 'info';
                $label = 'Entregada';
                break;
            default:
                $label = ucfirst($status);
                $color = 'secondary';
        }
        return '<span class="badge bg-' . $color . '">' . esc_html($label) . '</span>';
    }
}

function mv_priority_tag($priority) {
    $color = '';
    if ($priority) {
        switch ($priority) {
            case 'baja':
            case 'Baja':
                $color = 'info';
                $icon = '<svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="icon icon-tabler icons-tabler-outline icon-tabler-chevrons-down"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M7 7l5 5l5 -5" /><path d="M7 13l5 5l5 -5" /></svg>';
                break;
            case 'media':
            case 'Media':
                $color = 'warning';
                $icon = '<svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="icon icon-tabler icons-tabler-outline icon-tabler-equal"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M5 10h14" /><path d="M5 14h14" /></svg>';
                break;
            case 'alta':
            case 'Alta':
                $color = 'danger';
                $icon = '<svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="icon icon-tabler icons-tabler-outline icon-tabler-chevrons-up"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M7 11l5 -5l5 5" /><path d="M7 17l5 -5l5 5" /></svg>';
                break;
            default:
                $icon = ucfirst($priority);
                $color = 'background: #999; color: white;';
        }
        return '<span class="badge rounded-pill text-' . $color . '">' . $icon . '</span>';
    }
}