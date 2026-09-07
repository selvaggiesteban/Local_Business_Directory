<?php
namespace LBD\PostTypes;

class Business {

    public function __construct() {
        add_action( 'init', [ $this, 'register' ] );
        add_filter( 'manage_business_posts_columns', [ $this, 'admin_columns' ] );
        add_action( 'manage_business_posts_custom_column', [ $this, 'admin_columns_content' ], 10, 2 );
    }

    public static function register() {
        $labels = [
            'name'                  => 'Negocios',
            'singular_name'         => 'Negocio',
            'menu_name'             => 'Agregar Negocio',
            'add_new'               => 'Agregar Nuevo',
            'add_new_item'          => 'Agregar Nuevo Negocio',
            'edit_item'             => 'Editar Negocio',
            'new_item'              => 'Nuevo Negocio',
            'view_item'             => 'Ver Negocio',
            'search_items'          => 'Buscar Negocios',
            'not_found'             => 'No se encontraron negocios',
            'not_found_in_trash'    => 'No se encontraron negocios en la papelera',
            'all_items'             => 'Todos los Negocios',
            'archives'              => 'Archivo de Negocios',
            'featured_image'        => 'Foto de Portada',
            'set_featured_image'    => 'Establecer foto de portada',
            'remove_featured_image' => 'Eliminar foto de portada',
            'use_featured_image'    => 'Usar como foto de portada',
        ];

        $args = [
            'labels'              => $labels,
            'public'              => true,
            'publicly_queryable'  => true,
            'show_ui'             => true,
            'show_in_menu'        => false,
            'menu_position'       => 5,
            'menu_icon'           => 'dashicons-store',
            'show_in_rest'        => true,
            'rest_base'           => 'business',
            'has_archive'         => true,
            'hierarchical'        => false,
            'capability_type'     => 'post',
            'map_meta_cap'        => true,
            'supports'            => [ 'title', 'editor', 'thumbnail', 'excerpt' ],
            'rewrite'             => [
                'slug'       => '',
                'with_front' => false,
                'feeds'      => true,
            ],
            'taxonomies'          => [ 'business_rubro', 'business_categoria', 'business_zona' ],
        ];

        register_post_type( 'business', $args );
    }

    public function admin_columns( $columns ) {
        $new_columns = [];
        foreach ( $columns as $key => $value ) {
            if ( $key === 'title' ) {
                $new_columns['business_logo'] = 'Logo';
                $new_columns['business_name'] = 'Nombre';
            }
            $new_columns[ $key ] = $value;
            if ( $key === 'title' ) {
                $new_columns['business_rubro'] = 'Rubro';
                $new_columns['business_zona'] = 'Zona';
            }
        }
        return $new_columns;
    }

    public function admin_columns_content( $column, $post_id ) {
        switch ( $column ) {
            case 'business_logo':
                $logo = get_post_meta( $post_id, '_lbd_logo', true );
                if ( $logo ) {
                    echo wp_get_attachment_image( $logo, [ 50, 50 ] );
                }
                break;
            case 'business_rubro':
                $terms = get_the_terms( $post_id, 'business_rubro' );
                if ( $terms && ! is_wp_error( $terms ) ) {
                    echo esc_html( $terms[0]->name );
                }
                break;
            case 'business_zona':
                $terms = get_the_terms( $post_id, 'business_zona' );
                if ( $terms && ! is_wp_error( $terms ) ) {
                    echo esc_html( $terms[0]->name );
                }
                break;
        }
    }
}