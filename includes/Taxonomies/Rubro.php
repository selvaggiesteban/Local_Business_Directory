<?php
namespace LBD\Taxonomies;

class Rubro {

    public function __construct() {
        add_action( 'init', [ $this, 'register' ] );
    }

    public static function register() {
        $labels = [
            'name'              => 'Rubros',
            'singular_name'     => 'Rubro',
            'search_items'      => 'Buscar Rubros',
            'all_items'         => 'Todos los Rubros',
            'parent_item'       => null,
            'parent_item_colon' => null,
            'edit_item'         => 'Editar Rubro',
            'update_item'       => 'Actualizar Rubro',
            'add_new_item'      => 'Agregar Nuevo Rubro',
            'new_item_name'     => 'Nombre del Nuevo Rubro',
            'menu_name'         => 'Rubros',
        ];

        $args = [
            'labels'            => $labels,
            'hierarchical'      => false,
            'public'            => true,
            'show_ui'           => true,
            'show_in_rest'      => true,
            'rest_base'         => 'business_rubro',
            'show_admin_column' => true,
            'rewrite'           => [ 'slug' => 'rubro' ],
            'query_var'         => true,
        ];

        register_taxonomy( 'business_rubro', [ 'business' ], $args );
    }
}