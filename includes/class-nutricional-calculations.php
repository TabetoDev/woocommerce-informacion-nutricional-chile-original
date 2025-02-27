<?php
/**
 * Clase para cálculos y validaciones nutricionales según normativa chilena
 */

if (!defined('ABSPATH')) {
    exit;
}

class Nutricional_Calculations {

    public function __construct() {
        // Hook para guardar/actualizar productos
        add_action('save_post_product', array($this, 'calcular_y_validar_nutricion'), 10, 3);
    }

    /**
     * Calcula sellos "ALTO EN" y valida campos requeridos
     */
    public function calcular_y_validar_nutricion($post_id, $post, $update) {
        if (defined('DOING_AUTOSAVE') && DOING_AUTOSAVE) return;
        if (!current_user_can('edit_post', $post_id)) return;

        // 1. Obtener valores
        $tipo_alimento = get_post_meta($post_id, '_nutricional_tipo_alimento', true);
        $valores = get_post_meta($post_id, '_nutricional_valores', true);
        
        // 2. Validaciones básicas
        $this->validar_campos_requeridos($valores);
        
        // 3. Aplicar redondeo normativo
        $valores = $this->aplicar_redondeo_nutricional($valores);
        update_post_meta($post_id, '_nutricional_valores', $valores);

        // 4. Calcular sellos automáticos
        $sellos = $this->calcular_sellos($valores, $tipo_alimento);
        update_post_meta($post_id, '_nutricional_sellos', $sellos);
    }

    /**
     * Lógica principal de cálculo de sellos
     */
    private function calcular_sellos($valores, $tipo_alimento) {
        $umbrales = $this->obtener_umbrales($tipo_alimento);
        $sellos = array();

        foreach ($umbrales as $nutriente => $umbral) {
            if (!isset($valores[$nutriente])) continue;
            
            if ($valores[$nutriente] >= $umbral) {
                $sellos[] = $this->mapear_sello($nutriente);
            }
        }

        return array_unique($sellos);
    }

    /**
     * Define umbrales según tipo de alimento
     */
    private function obtener_umbrales($tipo) {
        return ($tipo === 'liquido') ? [
            'energia'       => 100,    // kcal/100ml
            'azucares'      => 6,      // g
            'sodio'         => 100,    // mg
            'grasas_sat'    => 3,
            'grasas_trans'  => 0.5
        ] : [
            'energia'       => 350,    // kcal/100g
            'azucares'      => 15,
            'sodio'         => 800,
            'grasas_sat'   => 6,
            'grasas_trans'  => 0.5
        ];
    }

    /**
     * Validación de campos condicionales
     */
    private function validar_campos_requeridos($valores) {
        // Regla 1: Si grasas totales ≥3g → campos específicos requeridos
        if (isset($valores['grasas_totales']) && $valores['grasas_totales'] >= 3) {
            $campos_grasas = ['grasas_sat', 'grasas_trans'];
            foreach ($campos_grasas as $campo) {
                if (!isset($valores[$campo]) {
                    wp_die(__('Error: Debe especificar ' . $campo . ' para productos con grasas totales ≥3g', 'nutritional-info-chile'));
                }
            }
        }

        // Regla 2: Si azúcares ≥5g → azúcares añadidos requeridos
        if (isset($valores['azucares']) && $valores['azucares'] >= 5 && empty($valores['azucares_anadidos'])) {
            wp_die(__('Error: Debe especificar azúcares añadidos cuando los azúcares totales son ≥5g', 'nutritional-info-chile'));
        }
    }

    /**
     * Aplica reglas de redondeo del MINSAL
     */
    private function aplicar_redondeo_nutricional($valores) {
        $redondeados = array();
        
        foreach ($valores as $nutriente => $valor) {
            switch($nutriente) {
                case 'energia':
                    $redondeados[$nutriente] = round($valor); // Entero
                    break;
                    
                case 'grasas_totales':
                case 'grasas_sat':
                case 'azucares':
                    $redondeados[$nutriente] = ($valor < 5) ? round($valor, 1) : round($valor); // <5g → 1 decimal
                    break;
                    
                case 'sodio':
                    $redondeados[$nutriente] = ($valor < 5) ? round($valor, 1) : round($valor); // <5mg → 1 decimal
                    break;
                    
                default:
                    $redondeados[$nutriente] = $valor;
            }
        }
        
        return $redondeados;
    }

    /**
     * Mapea nutrientes a nombres de sellos
     */
    private function mapear_sello($nutriente) {
        $mapeo = [
            'energia'      => 'alto-en-calorias',
            'azucares'     => 'alto-en-azucares',
            'sodio'        => 'alto-en-sodio',
            'grasas_sat'   => 'alto-en-grasas-saturadas',
            'grasas_trans' => 'alto-en-grasas-trans'
        ];
        
        return $mapeo[$nutriente] ?? '';
    }

}

// Inicializar la clase
new Nutricional_Calculations();
