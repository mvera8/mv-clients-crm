<?php
/**
 * Theme Options for mv-clients-crm
 */

if ( ! defined('ABSPATH') ) exit;

const TINCHO_SETTINGS_OPTION = 'tincho_base_theme_settings';
const TINCHO_SETTINGS_PAGE   = 'tincho-theme-settings';
const TINCHO_TEXTDOMAIN      = 'mv-clients-crm';

/**
 * Valores por defecto
 */
function tincho_default_settings(): array {
	return [
		'email'     => '',
		'phone'     => '',
		'website'   => '',
		'linkedin'  => '',
		'instagram' => '',
	];
}

/**
 * Asegura que el option exista y quede con autoload = yes (rápido para runtime).
 */
add_action('after_setup_theme', function () {
	$exists = get_option(TINCHO_SETTINGS_OPTION, null);
	if ($exists === null) {
		add_option(TINCHO_SETTINGS_OPTION, tincho_default_settings(), '', 'yes'); // autoload=yes
	}
});

/**
 * Página de menú bajo "Apariencia"
 */
add_action('admin_menu', function () {
	add_theme_page(
		__('Theme Settings', TINCHO_TEXTDOMAIN),
		__('Theme Settings', TINCHO_TEXTDOMAIN),
		'manage_options',
		TINCHO_SETTINGS_PAGE,
		'tincho_render_settings_page'
	);
});

/**
 * Registro de la setting y campos
 */
add_action('admin_init', function () {
	register_setting(
		'tincho_settings_group',
		TINCHO_SETTINGS_OPTION,
		[
			'type'              => 'array',
			'sanitize_callback' => 'tincho_sanitize_settings',
			'default'           => tincho_default_settings(),
			// Nota: el autoload queda definido por el add_option inicial.
		]
	);

	add_settings_section(
		'tincho_main_section',
		__('Datos de contacto y redes', TINCHO_TEXTDOMAIN),
		function () {
			echo '<p>'.esc_html__('Completa los datos. Se guardan en un único option para máximo rendimiento.', TINCHO_TEXTDOMAIN).'</p>';
		},
		TINCHO_SETTINGS_PAGE
	);

	// Campos
	add_settings_field('email', __('Email', TINCHO_TEXTDOMAIN),    'tincho_field_email',    TINCHO_SETTINGS_PAGE, 'tincho_main_section');
	add_settings_field('phone', __('Teléfono', TINCHO_TEXTDOMAIN), 'tincho_field_phone',    TINCHO_SETTINGS_PAGE, 'tincho_main_section');
	add_settings_field('linkedin', __('Linkedin URL', TINCHO_TEXTDOMAIN), 'tincho_field_linkedin', TINCHO_SETTINGS_PAGE, 'tincho_main_section');
	add_settings_field('instagram', __('Instagram URL', TINCHO_TEXTDOMAIN), 'tincho_field_instagram', TINCHO_SETTINGS_PAGE, 'tincho_main_section');
	add_settings_field('website', __('Website URL', TINCHO_TEXTDOMAIN), 'tincho_field_website', TINCHO_SETTINGS_PAGE, 'tincho_main_section');
});

/**
 * Sanitización
 */
function tincho_sanitize_settings($input): array {
	$clean = tincho_default_settings();

	if (is_array($input)) {
		$clean['email']     = sanitize_email($input['email'] ?? '');
		// Permitimos +, espacios y paréntesis; dejamos que el front lo presente bonito
		$clean['phone']     = preg_replace('/[^0-9\+\s\-\(\)]/','', $input['phone'] ?? '');
		$clean['linkedin']  = esc_url_raw($input['linkedin'] ?? '');
		$clean['instagram'] = esc_url_raw($input['instagram'] ?? '');
	}

	return $clean;
}

/**
 * Helpers de campo
 */
function tincho_get_settings(): array {
	// Cache en estático: una sola lectura por request
	static $cache = null;
	if ($cache !== null) return $cache;

	$opts  = get_option(TINCHO_SETTINGS_OPTION, tincho_default_settings());
	// Garantiza que existan todas las keys
	$cache = wp_parse_args((array) $opts, tincho_default_settings());
	return $cache;
}

function tincho_field_email() {
	$opts = tincho_get_settings();
	printf(
		'<input type="email" class="regular-text" name="%1$s[email]" value="%2$s" placeholder="hola@tusitio.com" />',
		esc_attr(TINCHO_SETTINGS_OPTION),
		esc_attr($opts['email'])
	);
}

function tincho_field_phone() {
	$opts = tincho_get_settings();
	printf(
		'<input type="text" class="regular-text" name="%1$s[phone]" value="%2$s" placeholder="+598 99 123 456" />',
		esc_attr(TINCHO_SETTINGS_OPTION),
		esc_attr($opts['phone'])
	);
}

function tincho_field_linkedin() {
	$opts = tincho_get_settings();
	printf(
		'<input type="url" class="regular-text" name="%1$s[linkedin]" value="%2$s" placeholder="https://linkedin.com/tu-pagina" />',
		esc_attr(TINCHO_SETTINGS_OPTION),
		esc_attr($opts['linkedin'])
	);
}

function tincho_field_instagram() {
	$opts = tincho_get_settings();
	printf(
		'<input type="url" class="regular-text" name="%1$s[instagram]" value="%2$s" placeholder="https://instagram.com/tu-cuenta" />',
		esc_attr(TINCHO_SETTINGS_OPTION),
		esc_attr($opts['instagram'])
	);
}

function tincho_field_website() {
	$opts = tincho_get_settings();
	printf(
		'<input type="url" class="regular-text" name="%1$s[website]" value="%2$s" placeholder="https://tusitio.com" />',
		esc_attr(TINCHO_SETTINGS_OPTION),
		esc_attr($opts['website'])
	);
}

/**
 * Render de la página
 */
function tincho_render_settings_page() {
	if ( ! current_user_can('manage_options') ) return; ?>
	<div class="wrap">
		<h1><?php esc_html_e('Theme Settings', TINCHO_TEXTDOMAIN); ?></h1>
		<?php settings_errors(); ?>
		<form method="post" action="options.php">
			<?php
				settings_fields('tincho_settings_group');
				do_settings_sections(TINCHO_SETTINGS_PAGE);
				submit_button(__('Guardar cambios', TINCHO_TEXTDOMAIN));
			?>
		</form>
	</div>
<?php }
