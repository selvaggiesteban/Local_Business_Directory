<?php
namespace LBD\Frontend;

class Rewrite_Rules {

    public function __construct() {
        add_action( 'template_redirect', [ $this, 'handle_business_slug' ], 1 );
        add_filter( 'redirect_canonical', [ $this, 'stop_redirect' ], 10, 2 );
    }

    public function stop_redirect( $redirect_url, $requested_url ) {
        $path = trim( parse_url( $_SERVER['REQUEST_URI'], PHP_URL_PATH ), '/' );
        if ( empty( $path ) || strpos( $path, '/' ) !== false ) {
            return $redirect_url;
        }

        $posts = get_posts( [
            'name'           => $path,
            'post_type'      => 'business',
            'post_status'    => 'publish',
            'posts_per_page' => 1,
        ] );

        if ( ! empty( $posts ) ) {
            return false;
        }

        return $redirect_url;
    }

    public function handle_business_slug() {
        if ( is_admin() ) {
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

            global $post;
            $post = $posts[0];
            setup_postdata( $post );

            $clean_url = home_url( '/' . $post->post_name . '/' );

            remove_action( 'wp_head', 'rel_canonical' );
            add_action( 'wp_head', function() use ( $clean_url ) {
                echo '<link rel="canonical" href="' . esc_url( $clean_url ) . '" />' . "\n";
            }, 1 );

            include LBD_PLUGIN_DIR . 'templates/single-business.php';
            exit;
        }
    }
}
