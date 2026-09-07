<?php
namespace LBD\Frontend;

class Rewrite_Rules {

    public function __construct() {
        add_action( 'template_redirect', [ $this, 'handle_business_slug' ] );
    }

    public function handle_business_slug() {
        if ( is_admin() ) {
            return;
        }

        global $wp_query;

        if ( ! $wp_query->is_main_query() ) {
            return;
        }

        $path = trim( parse_url( $_SERVER['REQUEST_URI'], PHP_URL_PATH ), '/' );
        if ( empty( $path ) || strpos( $path, '/' ) !== false ) {
            return;
        }

        $posts = get_posts( [
            'name'           => $path,
            'post_type'      => 'business',
            'post_status'    => 'publish',
            'posts_per_page' => 1,
        ] );

        if ( ! empty( $posts ) ) {
            status_header( 200 );
            nocache_headers();

            query_posts( [ 'p' => $posts[0]->ID, 'post_type' => 'business' ] );

            include LBD_PLUGIN_DIR . 'templates/single-business.php';
            exit;
        }
    }
}
