<?php
/**
 * Plugin Name: Woocommerce - Información Nutricional Chile
 * Plugin URI: http://tech4in.com
 * Description: Añade información nutricional y sellos de advertencia a los productos de WooCommerce, según la normativa chilena.
 * Version: 1.0.3
 * Author: Tech4In
 * Author URI: http://tech4in.com
 * Text Domain: woocommerce-informacion-nutricional-chile
 * Domain Path: /languages
 *
 * @package WP_Productos_Alimenticios_Chile
 */

if (!defined('ABSPATH')) {
    exit; // Exit if accessed directly.
}

/**
 * Archivo principal del plugin (v1.0.3)
 * Nuevas características:
 * - Cálculo automático de sellos "ALTO EN"
 * - Validación de campos según normativa chilena
 * - Tipo de alimento (sólido/líquido) para umbrales
 */

if (!class_exists('WP_Productos_Alimenticios_Chile')) :

    class WP_Productos_Alimenticios_Chile {

        protected static $_instance = null;

        public static function instance() {
            if (is_null(self::$_instance)) {
                self::$_instance = new self();
            }
            return self::$_instance;
        }

        public function __construct() {
            $this->define_constants();
            $this->includes();
            $this->init_hooks();
            do_action('wp_productos_alimenticios_chile_loaded');
        }

        private function define_constants() {
            define('WP_PRODUCTOS_ALIMENTICIOS_CHILE_PLUGIN_FILE', __FILE__);
            define('WP_PRODUCTOS_ALIMENTICIOS_CHILE_VERSION', '1.0.3');
            define('WP_PRODUCTOS_ALIMENTICIOS_CHILE_PLUGIN_URL', plugin_dir_url(__FILE__));
            define('WP_PRODUCTOS_ALIMENTICIOS_CHILE_PLUGIN_DIR', plugin_dir_path(__FILE__));
            define('WP_PRODUCTOS_ALIMENTICIOS_CHILE_ASSETS_URL', WP_PRODUCTOS_ALIMENTICIOS_CHILE_PLUGIN_URL . 'assets/');
        }

        private function includes() {
            include_once(WP_PRODUCTOS_ALIMENTICIOS_CHILE_PLUGIN_DIR . 'includes/admin/class-metaboxes.php');
            include_once(WP_PRODUCTOS_ALIMENTICIOS_CHILE_PLUGIN_DIR . 'includes/frontend/class-frontend-display.php');
            include_once(WP_PRODUCTOS_ALIMENTICIOS_CHILE_PLUGIN_DIR . 'includes/class-nutricional-calculations.php'); // Nuevo archivo añadido
        }

        private function init_hooks() {
            add_action('wp_enqueue_scripts', array($this, 'enqueue_frontend_styles'));
            add_action('admin_enqueue_scripts', array($this, 'enqueue_admin_styles'));
            
            // Nueva acción para guardado personalizado
            add_action('save_post_product', array($this, 'validar_campos_nutricionales'), 20, 3);
        }

        // Función de validación añadida (se implementará en otro archivo)
        public function validar_campos_nutricionales($post_id, $post, $update) {
            // Lógica implementada en class-nutricional-calculations.php
        }

        /* 
         * El resto del código permanece igual (métodos enqueue_frontend_styles, enqueue_admin_styles, etc)
         * ¡La tabla de alérgenos no se modifica!
         */

        public function enqueue_frontend_styles() {
            wp_enqueue_style('productos-alimenticios-chile-frontend-styles', 
                WP_PRODUCTOS_ALIMENTICIOS_CHILE_ASSETS_URL . 'css/frontend-styles.css', 
                array(), 
                WP_PRODUCTOS_ALIMENTICIOS_CHILE_VERSION
            );
        }

        public function enqueue_admin_styles($hook_suffix) {
            $screen = get_current_screen();
            if (isset($screen->post_type) && $screen->post_type === 'product') {
                wp_enqueue_style('productos-alimenticios-chile-admin-styles', 
                    WP_PRODUCTOS_ALIMENTICIOS_CHILE_ASSETS_URL . 'css/admin/admin-styles.css', 
                    array(), 
                    WP_PRODUCTOS_ALIMENTICIOS_CHILE_VERSION
                );
            }
        }

        public function plugin_url() {
            return untrailingslashit(WP_PRODUCTOS_ALIMENTICIOS_CHILE_PLUGIN_URL);
        }

        public function plugin_path() {
            return untrailingslashit(WP_PRODUCTOS_ALIMENTICIOS_CHILE_PLUGIN_DIR);
        }
    }

endif;

// Función principal permanece igual
function WP_Productos_Alimenticios_Chile() {
    return WP_Productos_Alimenticios_Chile::instance();
}

// Inicia el plugin
WP_Productos_Alimenticios_Chile();
