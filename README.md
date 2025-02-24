# Woocommerce - Información Nutricional Chile

**Versión:** 1.0.2  
**Autor:** Tech4In  
**Plugin URI:** https://tu-sitio.com/mi-plugin  
**Author URI:** https://tu-sitio.com  
**Text Domain:** woocommerce-informacion-nutricional-chile  
**Domain Path:** /languages

## Descripción

El plugin "Woocommerce - Información Nutricional Chile" añade información nutricional y sellos de advertencia a los productos de WooCommerce según la normativa chilena. Permite especificar datos como porciones, energía, proteínas, grasas, hidratos de carbono, azúcares y sodio, además de marcar alérgenos y activar sellos de advertencia.

## Instalación

1. **Requisitos:**  
   - WordPress 5.0 o superior.  
   - WooCommerce 3.0 o superior.  
   - PHP 7.0 o superior.

2. **Subir e Instalar el Plugin:**  
   - Descarga el archivo ZIP del plugin.  
   - En el panel de administración de WordPress, ve a **Plugins > Añadir nuevo** y haz clic en **Subir plugin**.  
   - Selecciona el archivo ZIP, instala y activa el plugin.

3. **Configuración Inicial:**  
   - Tras la activación, edita un producto para visualizar las nuevas secciones (metaboxes) que añade el plugin.

## Configuración

El plugin añade tres metaboxes en la pantalla de edición de productos de WooCommerce:

- **Sellos de Advertencia:**  
  Permite activar opciones como “Alto en Sodio”, “Alto en Azúcares”, “Alto en Grasas Saturadas” y “Alto en Calorías”.

- **Tabla Nutricional:**  
  Permite ingresar:
  - Descripción de la porción.
  - Porción en gramos.
  - Porciones por envase.
  - Valores de energía, proteínas, grasa total, hidratos de carbono, azúcares y sodio.
  - Listado de ingredientes.

- **Tabla de Alérgenos:**  
  Permite marcar, mediante checkboxes, los alérgenos presentes (como gluten, crustáceos, huevos, etc.).

## Uso

1. **Edición del Producto:**  
   - Al editar un producto en WooCommerce, encontrarás las secciones de "Sellos de Advertencia", "Tabla Nutricional" y "Tabla de Alérgenos".
   - Marca las opciones correspondientes para los sellos y alérgenos.
   - Ingresa los datos nutricionales en la tabla.
   
2. **Visualización en el Frontend:**  
   - La información ingresada se mostrará en la página del producto, debajo del resumen.
   - Se presentará una tabla nutricional comparando valores por porción y por 100g, además de imágenes de los sellos activos.

## Preguntas Frecuentes (FAQ)

**P: ¿El plugin es compatible con todas las versiones de WooCommerce?**  
R: El plugin ha sido desarrollado para funcionar con WooCommerce 3.0 o superior. Se recomienda usar la versión más reciente para garantizar la compatibilidad.

**P: ¿Los datos ingresados se eliminan al desactivar el plugin?**  
R: No, los metadatos se mantienen en la base de datos. Para eliminarlos, se debe realizar una limpieza manual o mediante un script de desinstalación.

**P: ¿Puedo personalizar el estilo de la tabla nutricional?**  
R: Sí, puedes editar el archivo CSS ubicado en `assets/css/frontend-styles.css` para modificar la apariencia.

## Changelog

**1.0.2**  
- Unificación de la versión en la cabecera (actualizado a 1.0.2).  
- Correcciones menores en la visualización de metaboxes.  
- Mejoras en la validación y sanitización de entradas.

**1.0.1**  
- Primera versión estable con funcionalidades básicas.

## Licencia

Este plugin se distribuye bajo la licencia GPLv2 o superior.

## Soporte

Para soporte, visita [Tu sitio de soporte](https://tu-sitio.com/soporte) o envía un correo a [soporte@tu-sitio.com](mailto:soporte@tu-sitio.com).