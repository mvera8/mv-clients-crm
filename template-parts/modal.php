<?php
/**
 * Template Part: Add Modal
 */

// Exit if accessed directly.
defined( 'ABSPATH' ) || exit;

// Procesar el formulario.
if ( isset( $_POST['add_item_nonce'] ) ) {
    $name        = sanitize_text_field( $_POST['item_name']            ?? '' );
    $type        = sanitize_key( $_POST['item_type']                   ?? '' );
    $description = sanitize_textarea_field( $_POST['item_description'] ?? '' );

    $allowed_types = [ 'clients', 'projects', 'tasks', 'payments' ];

    if ( empty( $name ) || ! in_array( $type, $allowed_types, true ) ) {
        $redirect = add_query_arg( 'item_status', 'invalid_fields', get_permalink() );
    } else {
        $post_id = wp_insert_post( [
            'post_title'   => $name,
            'post_content' => $description,
            'post_type'    => $type,
            'post_status'  => 'publish',
        ] );

        if ( is_wp_error( $post_id ) ) {
            $redirect = add_query_arg( 'item_status', 'error', get_permalink() );
        } else {
            $redirect = add_query_arg( 'item_status', 'success', get_permalink() );
        }
    }
}

// Leer el status de la URL.
$status  = $_GET['item_status'] ?? '';
$messages = [
    'success'        => [ 'class' => 'alert-success', 'text' => 'Item guardado correctamente.'                    ],
    'error'          => [ 'class' => 'alert-danger',  'text' => 'No se pudo guardar el item. Intente nuevamente.' ],
    'invalid_fields' => [ 'class' => 'alert-warning', 'text' => 'Por favor complete todos los campos requeridos.' ],
];

$items = [
    [ 'type' => 'clients',  'name' => 'Cliente'   ],
    [ 'type' => 'projects', 'name' => 'Proyectos' ],
    [ 'type' => 'tasks',    'name' => 'Tareas'    ],
    [ 'type' => 'payments', 'name' => 'Pagos'     ],
];
?>

<!-- Modal -->
<div
    class="modal fade"
    id="addItemModal"
    tabindex="-1"
    aria-labelledby="addItemModalLabel"
    aria-hidden="true"
>
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">

            <div class="modal-header">
                <h1 class="modal-title fs-5" id="addItemModalLabel">Agregar Item</h1>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>

            <div class="modal-body">
                <form id="add-item-form" method="POST" action="">
                    <?php wp_nonce_field( 'add_item_action', 'add_item_nonce' ); ?>

                    <div class="mb-3">
                        <label for="item-name" class="form-label">Nombre del Item</label>
                        <input
                            type="text"
                            class="form-control"
                            id="item-name"
                            name="item_name"
                            placeholder="Nombre..."
                            required
                        >
                    </div>

                    <div class="mb-3">
                        <label for="item-type" class="form-label">Tipo</label>
                        <select class="form-select" id="item-type" name="item_type" required>
                            <option value="">- Seleccionar -</option>
                            <?php foreach ( $items as $item ) : ?>
                                <option value="<?php echo esc_attr( $item['type'] ); ?>">
                                    <?php echo esc_html( $item['name'] ); ?>
                                </option>
                            <?php endforeach; ?>
                        </select>
                    </div>

                    <div class="mb-3">
                        <label for="item-description" class="form-label">Descripción del Item</label>
                        <textarea
                            class="form-control"
                            id="item-description"
                            name="item_description"
                            rows="3"
                            placeholder="Ingrese la descripción del item"
                        ></textarea>
                    </div>
                </form>
            </div>

            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                <button type="submit" form="add-item-form" class="btn btn-primary">
                    Guardar
                </button>
            </div>

        </div>
    </div>
</div>
