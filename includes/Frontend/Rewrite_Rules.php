<?php
namespace LBD\Frontend;

class Rewrite_Rules {

    public function __construct() {
        add_filter( "query_vars", [ $this, "add_query_vars" ] );
        add_filter( "post_type_link", [ $this, "business_permalink" ], 10, 2 );
        add_filter( "redirect_canonical", [ $this, "stop_redirect" ], 10, 2 );
        add_action( "template_redirect", [ $this, "redirect_old_query" ] );
        add_filter( "wp_sitemaps_post_types", [ $this, "add_to_wp_sitemaps" ] );
        add_filter( "google_sitemap_generator_post_types", [ $this, "add_to_google_sitemap" ] );
    }

    public function add_query_vars( $vars ) {
        $vars[] = "business";
        return $vars;
    }

    public function business_permalink( $url, $post ) {
        if ( $post->post_type === "business" ) {
            return home_url( "/negocio/" . $post->post_name . "/" );
        }
        return $url;
    }

    public function stop_redirect( $redirect_url, $requested_url ) {
        if ( is_admin() ) {
            return $redirect_url;
        }

        $path = trim( parse_url( $_SERVER["REQUEST_URI"], PHP_URL_PATH ), "/" );
        if ( strpos( $path, "negocio/" ) === 0 ) {
            return false;
        }

        return $redirect_url;
    }

    public function redirect_old_query() {
        if ( is_admin() ) {
            return;
        }

        if ( ! empty( $_GET["business"] ) ) {
            $business = sanitize_title( wp_unslash( $_GET["business"] ) );
            if ( ! empty( $business ) ) {
                $posts = get_posts( [
                    "name"           => $business,
                    "post_type"      => "business",
                    "post_status"    => "publish",
                    "posts_per_page" => 1,
                ] );
                if ( ! empty( $posts ) ) {
                    wp_redirect( home_url( "/negocio/" . $posts[0]->post_name . "/" ), 301 );
                    exit;
                }
            }
        }
    }

    public function add_to_wp_sitemaps( $post_types ) {
        $post_types["business"] = new \WP_Sitemaps_Posts( "business" );
        return $post_types;
    }

    public function add_to_google_sitemap( $post_types ) {
        $post_types[] = "business";
        return $post_types;
    }
}
