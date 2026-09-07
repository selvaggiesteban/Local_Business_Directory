<?php
/**
 * Plugin Name: Local Business Directory
 * Plugin URI: https://github.com/selvaggiesteban/Local_Business_Directory
 * Description: Directorio de negocios locales organizado por rubro, categoría y zona. Incluye CPT Negocio, taxonomías, metaboxes nativos y buscador AJAX.
 * Version: 1.0.0
 * Author: Esteban Selvaggi
 * Author URI: https://selvaggiesteban.com
 * License: GPL-2.0-or-later
 * License URI: https://www.gnu.org/licenses/gpl-2.0.html
 * Text Domain: local-business-directory
 * Domain Path: /languages
 * Requires at least: 6.4
 * Requires PHP: 8.2
 */

if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

define( 'LBD_VERSION', '1.0.0' );
define( 'LBD_PLUGIN_DIR', plugin_dir_path( __FILE__ ) );
define( 'LBD_PLUGIN_URL', plugin_dir_url( __FILE__ ) );
define( 'LBD_PLUGIN_FILE', __FILE__ );

/**
 * Autoloader simple para clases del plugin
 */
spl_autoload_register( function ( $class ) {
    $prefix = 'LBD\\';
    $base_dir = LBD_PLUGIN_DIR . 'includes/';

    $len = strlen( $prefix );
    if ( strncmp( $prefix, $class, $len ) !== 0 ) {
        return;
    }

    $relative_class = substr( $class, $len );
    $file = $base_dir . str_replace( '\\', '/', $relative_class ) . '.php';

    if ( file_exists( $file ) ) {
        require_once $file;
    }
} );

/**
 * Inicialización principal del plugin
 */
function lbd_init() {
    // Cargar textdomain
    load_plugin_textdomain( 'local-business-directory', false, dirname( plugin_basename( __FILE__ ) ) . '/languages' );

    // Inicializar módulos
    new LBD\PostTypes\Business();
    new LBD\Taxonomies\Rubro();
    new LBD\Taxonomies\Categoria();
    new LBD\Taxonomies\Zona();
    new LBD\Metaboxes\Business_Metaboxes();
    new LBD\Admin\Menu();
    new LBD\Frontend\Search_Shortcode();
    new LBD\Frontend\Rewrite_Rules();
    new LBD\Assets\Frontend_Assets();
}
add_action( 'plugins_loaded', 'lbd_init' );

/**
 * Activación del plugin
 */
function lbd_activate() {
    // Registrar CPT y taxonomías primero
    LBD\PostTypes\Business::register();
    LBD\Taxonomies\Rubro::register();
    LBD\Taxonomies\Categoria::register();
    LBD\Taxonomies\Zona::register();

    // Flush rewrite rules
    flush_rewrite_rules();
}
register_activation_hook( __FILE__, 'lbd_activate' );

/**
 * Desactivación del plugin
 */
function lbd_deactivate() {
    flush_rewrite_rules();
}
register_deactivation_hook( __FILE__, 'lbd_deactivate' );