<?php
namespace LBD\Admin;

class Menu {

    public function __construct() {
        add_action( 'admin_menu', [ $this, 'add_admin_menu' ] );
        add_filter( 'admin_title', [ $this, 'custom_admin_title' ], 10, 2 );
    }

    public function add_admin_menu() {
        // Menú principal: Agregar Negocio (共创一个新 post)
        add_menu_page(
            'Agregar Negocio',
            'Agregar Negocio',
            'edit_posts',
            'lbd-add-business',
            [ $this, 'page_add_business' ],
            'dashicons-store',
            5
        );

        // Submenú: Todos los Negocios
        add_submenu_page(
            'lbd-add-business',
            'Todos los Negocios',
            'Todos los Negocios',
            'edit_posts',
            'edit.php?post_type=business',
            ''
        );

        // Submenú: Agregar Nuevo
        add_submenu_page(
            'lbd-add-business',
            'Agregar Nuevo',
            'Agregar Nuevo',
            'edit_posts',
            'post-new.php?post_type=business',
            ''
        );

        // Submenú: Rubros
        add_submenu_page(
            'lbd-add-business',
            'Rubros',
            'Rubros',
            'manage_categories',
            'edit-tags.php?taxonomy=business_rubro',
            ''
        );

        // Submenú: Categorías
        add_submenu_page(
            'lbd-add-business',
            'Categorías',
            'Categorías',
            'manage_categories',
            'edit-tags.php?taxonomy=business_categoria',
            ''
        );

        // Submenú: Zonas
        add_submenu_page(
            'lbd-add-business',
            'Zonas / Localidades',
            'Zonas',
            'manage_categories',
            'edit-tags.php?taxonomy=business_zona',
            ''
        );
    }

    public function page_add_business() {
        // Redirigir al editor de posts del CPT business
        wp_redirect( admin_url( 'post-new.php?post_type=business' ) );
        exit;
    }

    public function custom_admin_title( $title, $screen ) {
        if ( $screen === 'toplevel_page_lbd-add-business' ) {
            return 'Agregar Negocio';
        }
        return $title;
    }
}