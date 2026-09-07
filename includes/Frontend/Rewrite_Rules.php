<?php
namespace LBD\Frontend;

class Rewrite_Rules {

    public function __construct() {
        add_action( 'init', [ $this, 'add_rewrite_rules' ] );
        add_filter( 'query_vars', [ $this, 'add_query_vars' ] );
    }

    public function add_rewrite_rules() {
        // La estrategia: usar el slug vacío en el CPT para que las URLs sean /nombre-negocio
        // Necesitamos interceptar las peticiones que no son posts/pages conocidos
        add_rewrite_rule(
            '^([^/]+)/?$',
            'index.php?business=$matches[1]',
            'top'
        );
    }

    public function add_query_vars( $vars ) {
        $vars[] = 'business';
        return $vars;
    }
}