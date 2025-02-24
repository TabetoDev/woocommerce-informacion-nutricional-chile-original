<?php
/**
 * Metaboxes Class (Clase para los Metaboxes)
 *
 * Este archivo define la clase que se encarga de crear y gestionar
 * los metaboxes (cuadros) personalizados en la página de edición de productos
 * de WooCommerce, para ingresar la información nutricional y de etiquetado.
 */

if ( ! defined( 'ABSPATH' ) ) {
    exit; // Exit if accessed directly.
}

if ( ! class_exists( 'WP_Productos_Alimenticios_Chile_Metaboxes' ) ) :

    /**
     * WP_Productos_Alimenticios_Chile_Metaboxes Class
     * Clase para crear y gestionar los metaboxes en la edición de productos.
     */
    class WP_Productos_Alimenticios_Chile_Metaboxes {

        /**
         * Constructor.
         */
        public function __construct() {
            add_action( 'add_meta_boxes', array( $this, 'add_product_metaboxes' ) );
            add_action( 'save_post_product', array( $this, 'save_product_metaboxes' ), 10, 2 );
        }

        /**
         * Añade los metaboxes personalizados al panel de edición de productos.
         */
        public function add_product_metaboxes() {
            add_meta_box(
                'productos_alimenticios_chile_sellos',          // ID del metabox (sellos)
                __( 'Sellos de Advertencia', 'woocommerce-productos-alimenticios-chile' ), // Título del metabox (sellos)
                array( $this, 'display_sellos_metabox' ),      // Callback function para mostrar el contenido del metabox (sellos)
                'product',                                     // Post type al que se añade el metabox (productos)
                'normal',                                       // Contexto (posición) del metabox: normal, side, advanced
                'default'                                      // Prioridad del metabox: default, high, low, core
            );

            add_meta_box(
                'productos_alimenticios_chile_tabla_nutricional', // ID del metabox (tabla nutricional)
                __( 'Tabla Nutricional', 'woocommerce-productos-alimenticios-chile' ), // Título del metabox (tabla nutricional)
                array( $this, 'display_tabla_nutricional_metabox' ), // Callback function para mostrar el contenido del metabox (tabla nutricional)
                'product',                                     // Post type al que se añade el metabox (productos)
                'normal',                                       // Contexto (posición) del metabox: normal, side, advanced
                'default'                                      // Prioridad del metabox: default, high, low, core
            );

            add_meta_box(
                'productos_alimenticios_chile_alergenos',       // ID del metabox (alergenos)
                __( 'Tabla de Alérgenos', 'woocommerce-productos-alimenticios-chile' ), // Título del metabox (alergenos)
                array( $this, 'display_alergenos_metabox' ),    // Callback function para mostrar el contenido del metabox (alergenos)
                'product',                                     // Post type al que se añade el metabox (productos)
                'normal',                                       // Contexto (posición) del metabox: normal, side, advanced
                'default'                                      // Prioridad del metabox: default, high, low, core
            );
        }

        /**
         * Muestra el contenido del metabox de Sellos de Advertencia.
         * Genera los checkboxes para los sellos de advertencia.
         *
         * @param WP_Post $post Objeto del producto actual.
         */
        public function display_sellos_metabox( $post ) {
            // --- Añade seguridad nonce para protección ---
            wp_nonce_field( 'productos_alimenticios_chile_save_metaboxes', 'productos_alimenticios_chile_sellos_nonce' );

            // --- Recupera los valores actuales de los checkboxes (si existen) ---
            $alto_en_sodio_value      = get_post_meta( $post->ID, '_alto_en_sodio', true );
            $alto_en_azucares_value    = get_post_meta( $post->ID, '_alto_en_azucares', true );
            $alto_en_grasas_sat_value  = get_post_meta( $post->ID, '_alto_en_grasas_sat', true );
            $alto_en_calorias_value    = get_post_meta( $post->ID, '_alto_en_calorias', true );

            echo '<div class="sellos-metabox-container">'; // Contenedor para los checkboxes de sellos

                echo '<p><label for="_alto_en_sodio">';
                echo '<input type="checkbox" id="_alto_en_sodio" name="_alto_en_sodio" value="yes" ' . checked( $alto_en_sodio_value, 'yes', false ) . ' />';
                echo esc_html__( 'Alto en Sodio', 'woocommerce-productos-alimenticios-chile' ) . '</label></p>';

                echo '<p><label for="_alto_en_azucares">';
                echo '<input type="checkbox" id="_alto_en_azucares" name="_alto_en_azucares" value="yes" ' . checked( $alto_en_azucares_value, 'yes', false ) . ' />';
                echo esc_html__( 'Alto en Azúcares', 'woocommerce-productos-alimenticios-chile' ) . '</label></p>';

                echo '<p><label for="_alto_en_grasas_sat">';
                echo '<input type="checkbox" id="_alto_en_grasas_sat" name="_alto_en_grasas_sat" value="yes" ' . checked( $alto_en_grasas_sat_value, 'yes', false ) . ' />';
                echo esc_html__( 'Alto en Grasas Saturadas', 'woocommerce-productos-alimenticios-chile' ) . '</label></p>';

                echo '<p><label for="_alto_en_calorias">';
                echo '<input type="checkbox" id="_alto_en_calorias" name="_alto_en_calorias" value="yes" ' . checked( $alto_en_calorias_value, 'yes', false ) . ' />';
                echo esc_html__( 'Alto en Calorías', 'woocommerce-productos-alimenticios-chile' ) . '</label></p>';

            echo '</div>'; // Fin contenedor sellos-metabox-container
        }


        /**
         * Muestra el contenido del metabox de Tabla Nutricional.
         * Genera los campos para ingresar la información de la tabla nutricional.
         *
         * @param WP_Post $post Objeto del producto actual.
         */
        public function display_tabla_nutricional_metabox( $post ) {
            // --- Añade seguridad nonce para protección ---
            wp_nonce_field( 'productos_alimenticios_chile_save_metaboxes', 'productos_alimenticios_chile_tabla_nutricional_nonce' );

            // --- Recupera los valores actuales de los campos (si existen) ---
            $porcion_texto_value              = get_post_meta( $post->ID, '_porcion_texto', true );
            $porcion_gramos_value             = get_post_meta( $post->ID, '_porcion_gramos', true );
            $porciones_por_envase_value       = get_post_meta( $post->ID, '_porciones_por_envase', true );
            $energia_porcion_value            = get_post_meta( $post->ID, '_energia_porcion', true );
            $proteinas_porcion_value          = get_post_meta( $post->ID, '_proteinas_porcion', true );
            $grasa_total_porcion_value        = get_post_meta( $post->ID, '_grasa_total_porcion', true );
            $hidratos_carbono_porcion_value   = get_post_meta( $post->ID, '_hidratos_carbono_porcion', true );
            $azucares_totales_porcion_value  = get_post_meta( $post->ID, '_azucares_totales_porcion', true );
            $sodio_porcion_value              = get_post_meta( $post->ID, '_sodio_porcion', true );
            $ingredientes_value               = get_post_meta( $post->ID, '_ingredientes', true );


            echo '<div class="tabla-nutricional-metabox-container">'; // Contenedor para los campos de tabla nutricional

                echo '<p><label for="_porcion_texto">' . esc_html__( 'Descripción de la Porción (ej. 1 cucharadita, 2 unidades):', 'woocommerce-productos-alimenticios-chile' ) . '</label><br>';
                echo '<textarea id="_porcion_texto" name="_porcion_texto" rows="2" style="width:100%">' . esc_textarea( $porcion_texto_value ) . '</textarea></p>';

                echo '<p><label for="_porcion_gramos">' . esc_html__( 'Porción en gramos (solo número entero):', 'woocommerce-productos-alimenticios-chile' ) . '</label>';
                echo '<input type="number" id="_porcion_gramos" name="_porcion_gramos" value="' . esc_attr( $porcion_gramos_value ) . '" style="width:100px;" /></p>';

                echo '<p><label for="_porciones_por_envase">' . esc_html__( 'Porciones por Envase:', 'woocommerce-productos-alimenticios-chile' ) . '</label>';
                echo '<input type="number" id="_porciones_por_envase" name="_porciones_por_envase" value="' . esc_attr( $porciones_por_envase_value ) . '" style="width:100px;" /></p>';

                echo '<hr>'; // Separador visual

                echo '<p><label for="_energia_porcion">' . esc_html__( 'Energía (kcal) por Porción (ej. 15.5):', 'woocommerce-productos-alimenticios-chile' ) . '</label>';
                echo '<input type="number" step="0.1" id="_energia_porcion" name="_energia_porcion" value="' . esc_attr( $energia_porcion_value ) . '" style="width:100px;" /></p>';

                echo '<p><label for="_proteinas_porcion">' . esc_html__( 'Proteínas (g) por Porción (ej. 0.1):', 'woocommerce-productos-alimenticios-chile' ) . '</label>';
                echo '<input type="number" step="0.1" id="_proteinas_porcion" name="_proteinas_porcion" value="' . esc_attr( $proteinas_porcion_value ) . '" style="width:100px;" /></p>';

                echo '<p><label for="_grasa_total_porcion">' . esc_html__( 'Grasa Total (g) por Porción (ej. 0.0):', 'woocommerce-productos-alimenticios-chile' ) . '</label>';
                echo '<input type="number" step="0.1" id="_grasa_total_porcion" name="_grasa_total_porcion" value="' . esc_attr( $grasa_total_porcion_value ) . '" style="width:100px;" /></p>';

                echo '<p><label for="_hidratos_carbono_porcion">' . esc_html__( 'Hidratos de Carbono disp. (g) por Porción (ej. 3.8):', 'woocommerce-productos-alimenticios-chile' ) . '</label>';
                echo '<input type="number" step="0.1" id="_hidratos_carbono_porcion" name="_hidratos_carbono_porcion" value="' . esc_attr( $hidratos_carbono_porcion_value ) . '" style="width:100px;" /></p>';

                echo '<p><label for="_azucares_totales_porcion">' . esc_html__( 'Azúcares Totales (g) por Porción (ej. 3.7):', 'woocommerce-productos-alimenticios-chile' ) . '</label>';
                echo '<input type="number" step="0.1" id="_azucares_totales_porcion" name="_azucares_totales_porcion" value="' . esc_attr( $azucares_totales_porcion_value ) . '" style="width:100px;" /></p>';

                echo '<p><label for="_sodio_porcion">' . esc_html__( 'Sodio (mg) por Porción (ej. 3):', 'woocommerce-productos-alimenticios-chile' ) . '</label>';
                echo '<input type="number" id="_sodio_porcion" name="_sodio_porcion" value="' . esc_attr( $sodio_porcion_value ) . '" style="width:100px;" /></p>';

                echo '<hr>'; // Separador visual

                echo '<p><label for="_ingredientes">' . esc_html__( 'Listado de Ingredientes:', 'woocommerce-productos-alimenticios-chile' ) . '</label><br>';
                echo '<textarea id="_ingredientes" name="_ingredientes" rows="4" style="width:100%">' . esc_textarea( $ingredientes_value ) . '</textarea></p>';


            echo '</div>'; // Fin contenedor tabla-nutricional-metabox-container
        }


        /**
 * Muestra el contenido del metabox de Tabla de Alérgenos en formato de tabla.
 *
 * @param WP_Post $post Objeto del producto actual.
 */
public function display_alergenos_metabox( $post ) {
    // Añade seguridad nonce para protección.
    wp_nonce_field( 'productos_alimenticios_chile_save_metaboxes', 'productos_alimenticios_chile_alergenos_nonce' );

    // Recupera los valores actuales de los checkboxes.
    $alergeno_gluten_ingrediente        = get_post_meta( $post->ID, '_alergeno_gluten_ingrediente', true );
    $alergeno_gluten_contaminacion      = get_post_meta( $post->ID, '_alergeno_gluten_contaminacion', true );
    $alergeno_crustaceos_ingrediente    = get_post_meta( $post->ID, '_alergeno_crustaceos_ingrediente', true );
    $alergeno_crustaceos_contaminacion  = get_post_meta( $post->ID, '_alergeno_crustaceos_contaminacion', true );
    $alergeno_huevos_ingrediente        = get_post_meta( $post->ID, '_alergeno_huevos_ingrediente', true );
    $alergeno_huevos_contaminacion      = get_post_meta( $post->ID, '_alergeno_huevos_contaminacion', true );
    $alergeno_pescado_ingrediente       = get_post_meta( $post->ID, '_alergeno_pescado_ingrediente', true );
    $alergeno_pescado_contaminacion     = get_post_meta( $post->ID, '_alergeno_pescado_contaminacion', true );
    $alergeno_mani_ingrediente          = get_post_meta( $post->ID, '_alergeno_mani_ingrediente', true );
    $alergeno_mani_contaminacion        = get_post_meta( $post->ID, '_alergeno_mani_contaminacion', true );
    $alergeno_soya_ingrediente          = get_post_meta( $post->ID, '_alergeno_soya_ingrediente', true );
    $alergeno_soya_contaminacion        = get_post_meta( $post->ID, '_alergeno_soya_contaminacion', true );
    $alergeno_leche_ingrediente         = get_post_meta( $post->ID, '_alergeno_leche_ingrediente', true );
    $alergeno_leche_contaminacion       = get_post_meta( $post->ID, '_alergeno_leche_contaminacion', true );
    $alergeno_nueces_ingrediente        = get_post_meta( $post->ID, '_alergeno_nueces_ingrediente', true );
    $alergeno_nueces_contaminacion      = get_post_meta( $post->ID, '_alergeno_nueces_contaminacion', true );
    $alergeno_sulfitos_ingrediente      = get_post_meta( $post->ID, '_alergeno_sulfitos_ingrediente', true );
    $alergeno_sulfitos_contaminacion    = get_post_meta( $post->ID, '_alergeno_sulfitos_contaminacion', true );

    // Inicio de la tabla.
    echo '<table class="alergenos-table" style="width:100%; border-collapse: collapse;">';
        echo '<thead>';
            echo '<tr style="background-color:#f7f7f7;">';
                echo '<th style="padding:8px; border:1px solid #ddd;">' . esc_html__( 'Alergeno', 'woocommerce-productos-alimenticios-chile' ) . '</th>';
                echo '<th style="padding:8px; border:1px solid #ddd;">' . esc_html__( 'Como ingrediente', 'woocommerce-productos-alimenticios-chile' ) . '</th>';
                echo '<th style="padding:8px; border:1px solid #ddd;">' . esc_html__( 'Posible contaminación cruzada', 'woocommerce-productos-alimenticios-chile' ) . '</th>';
            echo '</tr>';
        echo '</thead>';
        echo '<tbody>';

            // Fila para Cereales que contengan gluten.
            echo '<tr>';
                echo '<td style="padding:8px; border:1px solid #ddd;">' . esc_html__( 'Cereales con gluten y productos derivados', 'woocommerce-productos-alimenticios-chile' ) . '</td>';
                echo '<td style="text-align:center; padding:8px; border:1px solid #ddd;">';
                    echo '<input type="checkbox" id="_alergeno_gluten_ingrediente" name="_alergeno_gluten_ingrediente" value="yes" ' . checked( $alergeno_gluten_ingrediente, 'yes', false ) . ' />';
                echo '</td>';
                echo '<td style="text-align:center; padding:8px; border:1px solid #ddd;">';
                    echo '<input type="checkbox" id="_alergeno_gluten_contaminacion" name="_alergeno_gluten_contaminacion" value="yes" ' . checked( $alergeno_gluten_contaminacion, 'yes', false ) . ' />';
                echo '</td>';
            echo '</tr>';

            // Fila para Crustáceos.
            echo '<tr>';
                echo '<td style="padding:8px; border:1px solid #ddd;">' . esc_html__( 'Crustáceos y productos derivados', 'woocommerce-productos-alimenticios-chile' ) . '</td>';
                echo '<td style="text-align:center; padding:8px; border:1px solid #ddd;">';
                    echo '<input type="checkbox" id="_alergeno_crustaceos_ingrediente" name="_alergeno_crustaceos_ingrediente" value="yes" ' . checked( $alergeno_crustaceos_ingrediente, 'yes', false ) . ' />';
                echo '</td>';
                echo '<td style="text-align:center; padding:8px; border:1px solid #ddd;">';
                    echo '<input type="checkbox" id="_alergeno_crustaceos_contaminacion" name="_alergeno_crustaceos_contaminacion" value="yes" ' . checked( $alergeno_crustaceos_contaminacion, 'yes', false ) . ' />';
                echo '</td>';
            echo '</tr>';

            // Fila para Huevos.
            echo '<tr>';
                echo '<td style="padding:8px; border:1px solid #ddd;">' . esc_html__( 'Huevos y productos derivados', 'woocommerce-productos-alimenticios-chile' ) . '</td>';
                echo '<td style="text-align:center; padding:8px; border:1px solid #ddd;">';
                    echo '<input type="checkbox" id="_alergeno_huevos_ingrediente" name="_alergeno_huevos_ingrediente" value="yes" ' . checked( $alergeno_huevos_ingrediente, 'yes', false ) . ' />';
                echo '</td>';
                echo '<td style="text-align:center; padding:8px; border:1px solid #ddd;">';
                    echo '<input type="checkbox" id="_alergeno_huevos_contaminacion" name="_alergeno_huevos_contaminacion" value="yes" ' . checked( $alergeno_huevos_contaminacion, 'yes', false ) . ' />';
                echo '</td>';
            echo '</tr>';

            // Fila para Pescado.
            echo '<tr>';
                echo '<td style="padding:8px; border:1px solid #ddd;">' . esc_html__( 'Pescado y productos derivados', 'woocommerce-productos-alimenticios-chile' ) . '</td>';
                echo '<td style="text-align:center; padding:8px; border:1px solid #ddd;">';
                    echo '<input type="checkbox" id="_alergeno_pescado_ingrediente" name="_alergeno_pescado_ingrediente" value="yes" ' . checked( $alergeno_pescado_ingrediente, 'yes', false ) . ' />';
                echo '</td>';
                echo '<td style="text-align:center; padding:8px; border:1px solid #ddd;">';
                    echo '<input type="checkbox" id="_alergeno_pescado_contaminacion" name="_alergeno_pescado_contaminacion" value="yes" ' . checked( $alergeno_pescado_contaminacion, 'yes', false ) . ' />';
                echo '</td>';
            echo '</tr>';

            // Fila para Maní.
            echo '<tr>';
                echo '<td style="padding:8px; border:1px solid #ddd;">' . esc_html__( 'Maní y productos derivados', 'woocommerce-productos-alimenticios-chile' ) . '</td>';
                echo '<td style="text-align:center; padding:8px; border:1px solid #ddd;">';
                    echo '<input type="checkbox" id="_alergeno_mani_ingrediente" name="_alergeno_mani_ingrediente" value="yes" ' . checked( $alergeno_mani_ingrediente, 'yes', false ) . ' />';
                echo '</td>';
                echo '<td style="text-align:center; padding:8px; border:1px solid #ddd;">';
                    echo '<input type="checkbox" id="_alergeno_mani_contaminacion" name="_alergeno_mani_contaminacion" value="yes" ' . checked( $alergeno_mani_contaminacion, 'yes', false ) . ' />';
                echo '</td>';
            echo '</tr>';

            // Fila para Soya.
            echo '<tr>';
                echo '<td style="padding:8px; border:1px solid #ddd;">' . esc_html__( 'Soya y productos derivados', 'woocommerce-productos-alimenticios-chile' ) . '</td>';
                echo '<td style="text-align:center; padding:8px; border:1px solid #ddd;">';
                    echo '<input type="checkbox" id="_alergeno_soya_ingrediente" name="_alergeno_soya_ingrediente" value="yes" ' . checked( $alergeno_soya_ingrediente, 'yes', false ) . ' />';
                echo '</td>';
                echo '<td style="text-align:center; padding:8px; border:1px solid #ddd;">';
                    echo '<input type="checkbox" id="_alergeno_soya_contaminacion" name="_alergeno_soya_contaminacion" value="yes" ' . checked( $alergeno_soya_contaminacion, 'yes', false ) . ' />';
                echo '</td>';
            echo '</tr>';

            // Fila para Leche.
            echo '<tr>';
                echo '<td style="padding:8px; border:1px solid #ddd;">' . esc_html__( 'Leche y productos derivados (incluida la lactosa)', 'woocommerce-productos-alimenticios-chile' ) . '</td>';
                echo '<td style="text-align:center; padding:8px; border:1px solid #ddd;">';
                    echo '<input type="checkbox" id="_alergeno_leche_ingrediente" name="_alergeno_leche_ingrediente" value="yes" ' . checked( $alergeno_leche_ingrediente, 'yes', false ) . ' />';
                echo '</td>';
                echo '<td style="text-align:center; padding:8px; border:1px solid #ddd;">';
                    echo '<input type="checkbox" id="_alergeno_leche_contaminacion" name="_alergeno_leche_contaminacion" value="yes" ' . checked( $alergeno_leche_contaminacion, 'yes', false ) . ' />';
                echo '</td>';
            echo '</tr>';

            // Fila para Nueces.
            echo '<tr>';
                echo '<td style="padding:8px; border:1px solid #ddd;">' . esc_html__( 'Nueces y productos derivados', 'woocommerce-productos-alimenticios-chile' ) . '</td>';
                echo '<td style="text-align:center; padding:8px; border:1px solid #ddd;">';
                    echo '<input type="checkbox" id="_alergeno_nueces_ingrediente" name="_alergeno_nueces_ingrediente" value="yes" ' . checked( $alergeno_nueces_ingrediente, 'yes', false ) . ' />';
                echo '</td>';
                echo '<td style="text-align:center; padding:8px; border:1px solid #ddd;">';
                    echo '<input type="checkbox" id="_alergeno_nueces_contaminacion" name="_alergeno_nueces_contaminacion" value="yes" ' . checked( $alergeno_nueces_contaminacion, 'yes', false ) . ' />';
                echo '</td>';
            echo '</tr>';

            // Fila para Sulfitos.
            echo '<tr>';
                echo '<td style="padding:8px; border:1px solid #ddd;">' . esc_html__( 'Anhídrido sulfuroso y sulfitos (> 10 mg/kg o 10 mg/L SO2)', 'woocommerce-productos-alimenticios-chile' ) . '</td>';
                echo '<td style="text-align:center; padding:8px; border:1px solid #ddd;">';
                    echo '<input type="checkbox" id="_alergeno_sulfitos_ingrediente" name="_alergeno_sulfitos_ingrediente" value="yes" ' . checked( $alergeno_sulfitos_ingrediente, 'yes', false ) . ' />';
                echo '</td>';
                echo '<td style="text-align:center; padding:8px; border:1px solid #ddd;">';
                    echo '<input type="checkbox" id="_alergeno_sulfitos_contaminacion" name="_alergeno_sulfitos_contaminacion" value="yes" ' . checked( $alergeno_sulfitos_contaminacion, 'yes', false ) . ' />';
                echo '</td>';
            echo '</tr>';

        echo '</tbody>';
    echo '</table>';
}

        /**
         * Guarda los datos de los metaboxes del producto.
         *
         * @param int     $post_id ID del producto que se está guardando.
         * @param WP_Post $post    Objeto del producto que se está guardando.
         */
        public function save_product_metaboxes( $post_id, $post ) {

            // --- Verifica nonces para seguridad ---
            if ( ! isset( $_POST['productos_alimenticios_chile_sellos_nonce'] ) || ! wp_verify_nonce( $_POST['productos_alimenticios_chile_sellos_nonce'], 'productos_alimenticios_chile_save_metaboxes' ) ) {
                return;
            }
            if ( ! isset( $_POST['productos_alimenticios_chile_tabla_nutricional_nonce'] ) || ! wp_verify_nonce( $_POST['productos_alimenticios_chile_tabla_nutricional_nonce'], 'productos_alimenticios_chile_save_metaboxes' ) ) {
                return;
            }
             if ( ! isset( $_POST['productos_alimenticios_chile_alergenos_nonce'] ) || ! wp_verify_nonce( $_POST['productos_alimenticios_chile_alergenos_nonce'], 'productos_alimenticios_chile_save_metaboxes' ) ) {
                return;
            }

            // --- Verifica que el usuario actual tenga permiso para editar el producto ---
            if ( ! current_user_can( 'edit_product', $post_id ) ) {
                return;
            }

            // --- Verifica si es un auto-guardado ---
            if ( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE ) {
                return;
            }

            // --- Guarda los datos de los Sellos de Advertencia ---
            if ( isset( $_POST['_alto_en_sodio'] ) ) {
                update_post_meta( $post_id, '_alto_en_sodio', sanitize_text_field( $_POST['_alto_en_sodio'] ) );
            } else {
                delete_post_meta( $post_id, '_alto_en_sodio' ); // Si no está marcado, elimina el meta
            }
            if ( isset( $_POST['_alto_en_azucares'] ) ) {
                update_post_meta( $post_id, '_alto_en_azucares', sanitize_text_field( $_POST['_alto_en_azucares'] ) );
            } else {
                delete_post_meta( $post_id, '_alto_en_azucares' );
            }
            if ( isset( $_POST['_alto_en_grasas_sat'] ) ) {
                update_post_meta( $post_id, '_alto_en_grasas_sat', sanitize_text_field( $_POST['_alto_en_grasas_sat'] ) );
            } else {
                delete_post_meta( $post_id, '_alto_en_grasas_sat' );
            }
            if ( isset( $_POST['_alto_en_calorias'] ) ) {
                update_post_meta( $post_id, '_alto_en_calorias', sanitize_text_field( $_POST['_alto_en_calorias'] ) );
            } else {
                delete_post_meta( $post_id, '_alto_en_calorias' );
            }


            // --- Guarda los datos de la Tabla Nutricional ---
            if ( isset( $_POST['_porcion_texto'] ) ) {
                update_post_meta( $post_id, '_porcion_texto', sanitize_textarea_field( $_POST['_porcion_texto'] ) );
            }
            if ( isset( $_POST['_porcion_gramos'] ) ) {
                update_post_meta( $post_id, '_porcion_gramos', sanitize_text_field( $_POST['_porcion_gramos'] ) );
            }
            if ( isset( $_POST['_porciones_por_envase'] ) ) {
                update_post_meta( $post_id, '_porciones_por_envase', sanitize_text_field( $_POST['_porciones_por_envase'] ) );
            }
            if ( isset( $_POST['_energia_porcion'] ) ) {
                update_post_meta( $post_id, '_energia_porcion', sanitize_text_field( $_POST['_energia_porcion'] ) );
            }
            if ( isset( $_POST['_proteinas_porcion'] ) ) {
                update_post_meta( $post_id, '_proteinas_porcion', sanitize_text_field( $_POST['_proteinas_porcion'] ) );
            }
            if ( isset( $_POST['_grasa_total_porcion'] ) ) {
                update_post_meta( $post_id, '_grasa_total_porcion', sanitize_text_field( $_POST['_grasa_total_porcion'] ) );
            }
            if ( isset( $_POST['_hidratos_carbono_porcion'] ) ) {
                update_post_meta( $post_id, '_hidratos_carbono_porcion', sanitize_text_field( $_POST['_hidratos_carbono_porcion'] ) );
            }
            if ( isset( $_POST['_azucares_totales_porcion'] ) ) {
                update_post_meta( $post_id, '_azucares_totales_porcion', sanitize_text_field( $_POST['_azucares_totales_porcion'] ) );
            }
            if ( isset( $_POST['_sodio_porcion'] ) ) {
                update_post_meta( $post_id, '_sodio_porcion', sanitize_text_field( $_POST['_sodio_porcion'] ) );
            }
            if ( isset( $_POST['_ingredientes'] ) ) {
                update_post_meta( $post_id, '_ingredientes', sanitize_textarea_field( $_POST['_ingredientes'] ) );
            }


            // --- Guarda los datos de la Tabla de Alérgenos ---
            if ( isset( $_POST['_alergeno_gluten_ingrediente'] ) ) {
                update_post_meta( $post_id, '_alergeno_gluten_ingrediente', sanitize_text_field( $_POST['_alergeno_gluten_ingrediente'] ) );
            } else {
                delete_post_meta( $post_id, '_alergeno_gluten_ingrediente' );
            }
            if ( isset( $_POST['_alergeno_gluten_contaminacion'] ) ) {
                update_post_meta( $post_id, '_alergeno_gluten_contaminacion', sanitize_text_field( $_POST['_alergeno_gluten_contaminacion'] ) );
            } else {
                delete_post_meta( $post_id, '_alergeno_gluten_contaminacion' );
            }
            // Repetir el bloque de guardado y eliminación para cada alérgeno... (crustaceos, huevos, pescado, mani, soya, leche, nueces, sulfitos)
            if ( isset( $_POST['_alergeno_crustaceos_ingrediente'] ) ) {
                update_post_meta( $post_id, '_alergeno_crustaceos_ingrediente', sanitize_text_field( $_POST['_alergeno_crustaceos_ingrediente'] ) );
            } else {
                delete_post_meta( $post_id, '_alergeno_crustaceos_ingrediente' );
            }
            if ( isset( $_POST['_alergeno_crustaceos_contaminacion'] ) ) {
                update_post_meta( $post_id, '_alergeno_crustaceos_contaminacion', sanitize_text_field( $_POST['_alergeno_crustaceos_contaminacion'] ) );
            } else {
                delete_post_meta( $post_id, '_alergeno_crustaceos_contaminacion' );
            }

            if ( isset( $_POST['_alergeno_huevos_ingrediente'] ) ) {
                update_post_meta( $post_id, '_alergeno_huevos_ingrediente', sanitize_text_field( $_POST['_alergeno_huevos_ingrediente'] ) );
            } else {
                delete_post_meta( $post_id, '_alergeno_huevos_ingrediente' );
            }
            if ( isset( $_POST['_alergeno_huevos_contaminacion'] ) ) {
                update_post_meta( $post_id, '_alergeno_huevos_contaminacion', sanitize_text_field( $_POST['_alergeno_huevos_contaminacion'] ) );
            } else {
                delete_post_meta( $post_id, '_alergeno_huevos_contaminacion' );
            }

             if ( isset( $_POST['_alergeno_pescado_ingrediente'] ) ) {
                update_post_meta( $post_id, '_alergeno_pescado_ingrediente', sanitize_text_field( $_POST['_alergeno_pescado_ingrediente'] ) );
            } else {
                delete_post_meta( $post_id, '_alergeno_pescado_ingrediente' );
            }
            if ( isset( $_POST['_alergeno_pescado_contaminacion'] ) ) {
                update_post_meta( $post_id, '_alergeno_pescado_contaminacion', sanitize_text_field( $_POST['_alergeno_pescado_contaminacion'] ) );
            } else {
                delete_post_meta( $post_id, '_alergeno_pescado_contaminacion' );
            }

            if ( isset( $_POST['_alergeno_mani_ingrediente'] ) ) {
                update_post_meta( $post_id, '_alergeno_mani_ingrediente', sanitize_text_field( $_POST['_alergeno_mani_ingrediente'] ) );
            } else {
                delete_post_meta( $post_id, '_alergeno_mani_ingrediente' );
            }
            if ( isset( $_POST['_alergeno_mani_contaminacion'] ) ) {
                update_post_meta( $post_id, '_alergeno_mani_contaminacion', sanitize_text_field( $_POST['_alergeno_mani_contaminacion'] ) );
            } else {
                delete_post_meta( $post_id, '_alergeno_mani_contaminacion' );
            }

            if ( isset( $_POST['_alergeno_soya_ingrediente'] ) ) {
                update_post_meta( $post_id, '_alergeno_soya_ingrediente', sanitize_text_field( $_POST['_alergeno_soya_ingrediente'] ) );
            } else {
                delete_post_meta( $post_id, '_alergeno_soya_ingrediente' );
            }
            if ( isset( $_POST['_alergeno_soya_contaminacion'] ) ) {
                update_post_meta( $post_id, '_alergeno_soya_contaminacion', sanitize_text_field( $_POST['_alergeno_soya_contaminacion'] ) );
            } else {
                delete_post_meta( $post_id, '_alergeno_soya_contaminacion' );
            }

            if ( isset( $_POST['_alergeno_leche_ingrediente'] ) ) {
                update_post_meta( $post_id, '_alergeno_leche_ingrediente', sanitize_text_field( $_POST['_alergeno_leche_ingrediente'] ) );
            } else {
                delete_post_meta( $post_id, '_alergeno_leche_ingrediente' );
            }
            if ( isset( $_POST['_alergeno_leche_contaminacion'] ) ) {
                update_post_meta( $post_id, '_alergeno_leche_contaminacion', sanitize_text_field( $_POST['_alergeno_leche_contaminacion'] ) );
            } else {
                delete_post_meta( $post_id, '_alergeno_leche_contaminacion' );
            }

            if ( isset( $_POST['_alergeno_nueces_ingrediente'] ) ) {
                update_post_meta( $post_id, '_alergeno_nueces_ingrediente', sanitize_text_field( $_POST['_alergeno_nueces_ingrediente'] ) );
            } else {
                delete_post_meta( $post_id, '_alergeno_nueces_ingrediente' );
            }
            if ( isset( $_POST['_alergeno_nueces_contaminacion'] ) ) {
                update_post_meta( $post_id, '_alergeno_nueces_contaminacion', sanitize_text_field( $_POST['_alergeno_nueces_contaminacion'] ) );
            } else {
                delete_post_meta( $post_id, '_alergeno_nueces_contaminacion' );
            }

            if ( isset( $_POST['_alergeno_sulfitos_ingrediente'] ) ) {
                update_post_meta( $post_id, '_alergeno_sulfitos_ingrediente', sanitize_text_field( $_POST['_alergeno_sulfitos_ingrediente'] ) );
            } else {
                delete_post_meta( $post_id, '_alergeno_sulfitos_ingrediente' );
            }
            if ( isset( $_POST['_alergeno_sulfitos_contaminacion'] ) ) {
                update_post_meta( $post_id, '_alergeno_sulfitos_contaminacion', sanitize_text_field( $_POST['_alergeno_sulfitos_contaminacion'] ) );
            } else {
                delete_post_meta( $post_id, '_alergeno_sulfitos_contaminacion' );
            }


        }

    }

    new WP_Productos_Alimenticios_Chile_Metaboxes();

endif;