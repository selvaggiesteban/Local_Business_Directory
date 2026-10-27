<?php
namespace LBD\Frontend;

class Rewrite_Rules {

    public function __construct() {
        add_filter( 'query_vars', [ $this, 'add_query_vars' ] );
        add_action( 'init', [ $this, 'add_rewrite_rules' ] );
        add_action( 'template_redirect', [ $this, 'handle_business_slug' ], 1 );
        add_filter( 'redirect_canonical', [ $this, 'stop_redirect' ], 10, 2 );
        add_filter( 'post_type_link', [ $this, 'business_permalink' ], 10, 2 );
    }

    public function add_query_vars( $vars ) {
        $vars[] = 'business';
        return $vars;
    }

    public function add_rewrite_rules() {
        add_rewrite_rule( '^([^/]+)/?$', 'index.php?business=$matches[1]', 'bottom' );

        if ( ! get_option( 'lbd_rewrite_flushed' ) ) {
            flush_rewrite_rules();
            update_option( 'lbd_rewrite_flushed', true );
        }
    }

    public function business_permalink( $url, $post ) {
        if ( $post->post_type === 'business' ) {
            return home_url( '/' . $post->post_name . '/' );
        }
        return $url;
    }

    public function stop_redirect( $redirect_url, $requested_url ) {
        $path = trim( parse_url( $_SERVER['REQUEST_URI'], PHP_URL_PATH ), '/' );
        if ( empty( $path ) || strpos( $path, '/' ) !== false ) {
            return $redirect_url;
        }

        $business = get_query_var( 'business' );
        if ( ! empty( $business ) ) {
            $posts = get_posts( [
                'name'           => $business,
                'post_type'      => 'business',
                'post_status'    => 'publish',
                'posts_per_page' => 1,
            ] );

            if ( ! empty( $posts ) ) {
                return false;
            }
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

        // Redirect ?business=X to /X/ for SEO
        if ( ! empty( $_GET['business'] ) ) {
            $business = sanitize_title( wp_unslash( $_GET['business'] ) );
            if ( ! empty( $business ) ) {
                $posts = get_posts( [
                    'name'           => $business,
                    'post_type'      => 'business',
                    'post_status'    => 'publish',
                    'posts_per_page' => 1,
                ] );
                if ( ! empty( $posts ) ) {
                    wp_redirect( home_url( '/' . $posts[0]->post_name . '/' ), 301 );
                    exit;
                }
            }
        }

        $business = get_query_var( 'business' );
        $path = trim( parse_url( $_SERVER['REQUEST_URI'], PHP_URL_PATH ), '/' );

        if ( empty( $business ) && ( empty( $path ) || strpos( $path, '/' ) !== false ) ) {
            return;
        }

        $slug = ! empty( $business ) ? $business : $path;

        $posts = get_posts( [
            'name'           => $slug,
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
