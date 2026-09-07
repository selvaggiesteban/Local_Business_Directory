<?php
namespace LBD\Assets;

class Frontend_Assets {

    public function __construct() {
        add_action( 'wp_enqueue_scripts', [ $this, 'enqueue_frontend' ] );
        add_filter( 'single_template', [ $this, 'load_single_template' ] );
        add_filter( 'archive_template', [ $this, 'load_archive_template' ] );
        add_filter( 'template_include', [ $this, 'load_search_template' ] );
    }

    public function enqueue_frontend() {
        wp_enqueue_style(
            'lbd-frontend',
            LBD_PLUGIN_URL . 'assets/css/frontend.css',
            [],
            LBD_VERSION . '.' . time()
        );

        wp_enqueue_script(
            'lbd-frontend',
            LBD_PLUGIN_URL . 'assets/js/frontend.js',
            [ 'jquery' ],
            LBD_VERSION,
            true
        );

        wp_localize_script( 'lbd-frontend', 'lbdFrontend', [
            'ajaxUrl' => admin_url( 'admin-ajax.php' ),
            'nonce'   => wp_create_nonce( 'lbd_search_nonce' ),
        ] );
    }

    public function load_single_template( $template ) {
        if ( is_singular( 'business' ) ) {
            $plugin_template = LBD_PLUGIN_DIR . 'templates/single-business.php';
            if ( file_exists( $plugin_template ) ) {
                return $plugin_template;
            }
        }
        return $template;
    }

    public function load_archive_template( $template ) {
        if ( is_post_type_archive( 'business' ) || is_tax( 'business_rubro' ) || is_tax( 'business_categoria' ) || is_tax( 'business_zona' ) ) {
            $plugin_template = LBD_PLUGIN_DIR . 'templates/archive-business.php';
            if ( file_exists( $plugin_template ) ) {
                return $plugin_template;
            }
        }
        return $template;
    }

    public function load_search_template( $template ) {
        if ( is_search() && isset( $_GET['post_type'] ) && $_GET['post_type'] === 'business' ) {
            $plugin_template = LBD_PLUGIN_DIR . 'templates/search-business.php';
            if ( file_exists( $plugin_template ) ) {
                return $plugin_template;
            }
        }
        return $template;
    }
}