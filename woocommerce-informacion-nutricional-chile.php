<?php
/**
 * Plugin Name: Woocommerce - Información Nutricional Chile
 * Plugin URI: http://tech4in.com
 * Description: Añade información nutricional y sellos de advertencia a los productos de WooCommerce, según la normativa chilena.
 * Version: 1.0.2
 * Author: Tech4In
 * Author URI: http://tech4in.com
 * Text Domain: woocommerce-informacion-nutricional-chile
 * Domain Path: /languages
 *
 * @package WP_Productos_Alimenticios_Chile
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

/**
 * Archivo principal del plugin.
 *
 * Este archivo se encarga de:
 * - Definir la información general del plugin (nombre, descripción, versión, etc.).
 * - Incluir los archivos necesarios del plugin (metaboxes, frontend, etc.).
 * - Inicializar las clases principales del plugin.
 */

if ( ! class_exists( 'WP_Productos_Alimenticios_Chile' ) ) :

	/**
	 * Clase principal del plugin: WP_Productos_Alimenticios_Chile.
	 */
	class WP_Productos_Alimenticios_Chile {

		/**
		 * Instancia única del plugin.
		 *
		 * @var WP_Productos_Alimenticios_Chile
		 */
		protected static $_instance = null;

		/**
		 * Main WP_Productos_Alimenticios_Chile Instance.
		 *
		 * Asegura que sólo se instancie una copia de WP_Productos_Alimenticios_Chile.
		 *
		 * @return WP_Productos_Alimenticios_Chile - Main instance.
		 */
		public static function instance() {
			if ( is_null( self::$_instance ) ) {
				self::$_instance = new self();
			}
			return self::$_instance;
		}

		/**
		 * WP_Productos_Alimenticios_Chile Constructor.
		 */
		public function __construct() {
			$this->define_constants();
			$this->includes();
			$this->init_hooks();

			do_action( 'wp_productos_alimenticios_chile_loaded' );
		}

		/**
		 * Define las constantes del plugin.
		 *
		 * @return void
		 */
		private function define_constants() {
			define( 'WP_PRODUCTOS_ALIMENTICIOS_CHILE_PLUGIN_FILE', __FILE__ );
			define( 'WP_PRODUCTOS_ALIMENTICIOS_CHILE_VERSION', '1.0.2' ); // Puedes ajustar la versión si lo deseas
			define( 'WP_PRODUCTOS_ALIMENTICIOS_CHILE_PLUGIN_URL', plugin_dir_url( __FILE__ ) );
			define( 'WP_PRODUCTOS_ALIMENTICIOS_CHILE_PLUGIN_DIR', plugin_dir_path( __FILE__ ) );
			define( 'WP_PRODUCTOS_ALIMENTICIOS_CHILE_ASSETS_URL', WP_PRODUCTOS_ALIMENTICIOS_CHILE_PLUGIN_URL . 'assets/' );
		}

		/**
		 * Incluye los archivos necesarios para el plugin.
		 *
		 * @return void
		 */
		private function includes() {
			include_once( WP_PRODUCTOS_ALIMENTICIOS_CHILE_PLUGIN_DIR . 'includes/admin/class-metaboxes.php' );
			include_once( WP_PRODUCTOS_ALIMENTICIOS_CHILE_PLUGIN_DIR . 'includes/frontend/class-frontend-display.php' );
		}

		/**
		 * Inicializa los hooks (acciones y filtros) de WordPress.
		 *
		 * @return void
		 */
		private function init_hooks() {
			add_action( 'wp_enqueue_scripts', array( $this, 'enqueue_frontend_styles' ) );
			add_action( 'admin_enqueue_scripts', array( $this, 'enqueue_admin_styles' ) ); // Hook para encolar estilos en el admin
		}


		/**
		 * Encola los estilos CSS para el frontend.
		 *
		 * @return void
		 */
		public function enqueue_frontend_styles() {
			wp_enqueue_style( 'productos-alimenticios-chile-frontend-styles', WP_PRODUCTOS_ALIMENTICIOS_CHILE_ASSETS_URL . 'css/frontend-styles.css', array(), WP_PRODUCTOS_ALIMENTICIOS_CHILE_VERSION );
		}

		/**
		 * Encola los estilos CSS para el admin (backend).
		 *
		 * @param string $hook_suffix Sufijo del hook de la página actual.
		 * @return void
		 */
		public function enqueue_admin_styles( $hook_suffix ) {
			$screen = get_current_screen(); // Obtiene la pantalla actual de WordPress

			if ( isset( $screen->post_type ) && $screen->post_type === 'product' ) { // Verifica si es la pantalla de edición de un producto
				wp_enqueue_style( 'productos-alimenticios-chile-admin-styles', WP_PRODUCTOS_ALIMENTICIOS_CHILE_ASSETS_URL . 'css/admin/admin-styles.css', array(), WP_PRODUCTOS_ALIMENTICIOS_CHILE_VERSION );
			}
		}

		/**
		 * Devuelve la URL base del plugin (para usar en otros archivos si es necesario).
		 *
		 * @return string URL del plugin.
		 */
		public function plugin_url() {
			return untrailingslashit( WP_PRODUCTOS_ALIMENTICIOS_CHILE_PLUGIN_URL );
		}

		/**
		 * Devuelve la ruta base del plugin en el sistema de archivos.
		 *
		 * @return string Ruta del directorio del plugin.
		 */
		public function plugin_path() {
			return untrailingslashit( WP_PRODUCTOS_ALIMENTICIOS_CHILE_PLUGIN_DIR );
		}


	}

endif;

/**
 * Función principal para acceder a la instancia única del plugin.
 *
 * @return WP_Productos_Alimenticios_Chile
 */
function WP_Productos_Alimenticios_Chile() { // phpcs:ignore WordPress.NamingConventions.ValidFunctionName.FunctionNameInvalid
	return WP_Productos_Alimenticios_Chile::instance();
}

// Inicia el plugin.
WP_Productos_Alimenticios_Chile();