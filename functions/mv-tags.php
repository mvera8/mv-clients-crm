<?php
function mv_status_tag($status) {
    if ($status) {
        $color = '';
        switch ($status) {
            case 'en_proceso':
            case 'En Proceso':
                $color = 'bg-primary';
                $label = 'En Proceso';
                break;
            case 'completada':
            case 'Completada':
                $color = 'bg-success';
                $label = 'Completada';
                break;
            case 'cancelada':
            case 'Cancelada':
                $color = 'bg-danger';
                $label = 'Cancelada';
                break;
            default:
                $label = ucfirst($status);
                $color = 'bg-secondary';
        }
        return '<span class="badge ' . $color . '">' . esc_html($label) . '</span>';
    }
}

function mv_priority_tag($priority) {
    if ($priority) {
        $color = '';
        switch ($priority) {
            case 'baja':
            case 'Baja':
                $color = 'bg-info';
                $label = 'Baja';
                break;
            case 'media':
            case 'Media':
                $color = 'bg-warning';
                $label = 'Media';
                break;
            case 'alta':
            case 'Alta':
                $color = 'bg-danger';
                $label = 'Alta';
                break;
            default:
                $label = ucfirst($priority);
                $color = 'background: #999; color: white;';
        }
        return '<span class="badge ' . $color . '">' . esc_html($label) . '</span>';
    }
}