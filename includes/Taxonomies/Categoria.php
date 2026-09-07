<?php
namespace LBD\Taxonomies;

class Categoria {

    public function __construct() {
        add_action( 'init', [ $this, 'register' ] );
    }

    public static function register() {
        $labels = [
            'name'              => 'Categorías',
            'singular_name'     => 'Categoría',
            'search_items'      => 'Buscar Categorías',
            'all_items'         => 'Todas las Categorías',
            'parent_item'       => null,
            'parent_item_colon' => null,
            'edit_item'         => 'Editar Categoría',
            'update_item'       => 'Actualizar Categoría',
            'add_new_item'      => 'Agregar Nueva Categoría',
            'new_item_name'     => 'Nombre de la Nueva Categoría',
            'menu_name'         => 'Categorías',
        ];

        $args = [
            'labels'            => $labels,
            'hierarchical'      => false,
            'public'            => true,
            'show_ui'           => true,
            'show_in_rest'      => true,
            'rest_base'         => 'business_categoria',
            'show_admin_column' => true,
            'rewrite'           => [ 'slug' => 'categoria' ],
            'query_var'         => true,
        ];

        register_taxonomy( 'business_categoria', [ 'business' ], $args );
    }
}