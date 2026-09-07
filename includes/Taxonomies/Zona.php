<?php
namespace LBD\Taxonomies;

class Zona {

    public function __construct() {
        add_action( 'init', [ $this, 'register' ] );
    }

    public static function register() {
        $labels = [
            'name'              => 'Zonas / Localidades',
            'singular_name'     => 'Zona / Localidad',
            'search_items'      => 'Buscar Zonas',
            'all_items'         => 'Todas las Zonas',
            'parent_item'       => null,
            'parent_item_colon' => null,
            'edit_item'         => 'Editar Zona',
            'update_item'       => 'Actualizar Zona',
            'add_new_item'      => 'Agregar Nueva Zona',
            'new_item_name'     => 'Nombre de la Nueva Zona',
            'menu_name'         => 'Zonas',
        ];

        $args = [
            'labels'            => $labels,
            'hierarchical'      => false,
            'public'            => true,
            'show_ui'           => true,
            'show_in_rest'      => true,
            'rest_base'         => 'business_zona',
            'show_admin_column' => true,
            'rewrite'           => [ 'slug' => 'zona' ],
            'query_var'         => true,
        ];

        register_taxonomy( 'business_zona', [ 'business' ], $args );
    }
}