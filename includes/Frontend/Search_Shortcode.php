<?php
namespace LBD\Frontend;

class Search_Shortcode {

    public function __construct() {
        add_shortcode( 'business_directory_search', [ $this, 'render_search_shortcode' ] );
        add_shortcode( 'business_directory_list', [ $this, 'render_list_shortcode' ] );
        add_action( 'wp_ajax_lbd_search_businesses', [ $this, 'ajax_search' ] );
        add_action( 'wp_ajax_nopriv_lbd_search_businesses', [ $this, 'ajax_search' ] );
    }

    public function render_search_shortcode( $atts ) {
        $atts = shortcode_atts( [], $atts, 'business_directory_search' );

        wp_enqueue_style( 'lbd-frontend' );
        wp_enqueue_script( 'lbd-frontend' );

        $rubros     = get_terms( [ 'taxonomy' => 'business_rubro', 'hide_empty' => false ] );
        $categorias = get_terms( [ 'taxonomy' => 'business_categoria', 'hide_empty' => false ] );
        $zonas      = get_terms( [ 'taxonomy' => 'business_zona', 'hide_empty' => false ] );

        ob_start();
        ?>
        <div class="lbd-search-wrapper">
            <form class="lbd-search-form" id="lbd-search-form">
                <div class="lbd-search-fields">
                    <div class="lbd-search-field">
                        <label for="lbd-search-keyword">Buscar</label>
                        <input type="text" id="lbd-search-keyword" name="keyword" placeholder="Nombre del negocio...">
                    </div>
                    <div class="lbd-search-field">
                        <label for="lbd-search-rubro">Rubro</label>
                        <select id="lbd-search-rubro" name="rubro">
                            <option value="">Todos los rubros</option>
                            <?php foreach ( $rubros as $rubro ) : ?>
                                <option value="<?php echo esc_attr( $rubro->slug ); ?>"><?php echo esc_html( $rubro->name ); ?></option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                    <div class="lbd-search-field">
                        <label for="lbd-search-categoria">Categoría</label>
                        <select id="lbd-search-categoria" name="categoria">
                            <option value="">Todas las categorías</option>
                            <?php foreach ( $categorias as $cat ) : ?>
                                <option value="<?php echo esc_attr( $cat->slug ); ?>"><?php echo esc_html( $cat->name ); ?></option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                    <div class="lbd-search-field">
                        <label for="lbd-search-zona">Zona / Localidad</label>
                        <select id="lbd-search-zona" name="zona">
                            <option value="">Todas las zonas</option>
                            <?php foreach ( $zonas as $zona ) : ?>
                                <option value="<?php echo esc_attr( $zona->slug ); ?>"><?php echo esc_html( $zona->name ); ?></option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                    <div class="lbd-search-field lbd-search-btn-wrapper">
                        <button type="submit" class="lbd-search-btn" id="lbd-search-submit">Buscar</button>
                    </div>
                </div>
            </form>
        </div>
        <?php
        return ob_get_clean();
    }

    public function render_list_shortcode( $atts ) {
        $atts = shortcode_atts( [
            'per_page' => 12,
        ], $atts, 'business_directory_list' );

        wp_enqueue_style( 'lbd-frontend' );
        wp_enqueue_script( 'lbd-frontend' );

        ob_start();
        ?>
        <div class="lbd-list-wrapper">
            <div class="lbd-results-info" id="lbd-results-info" style="display:none;">
                <p><span id="lbd-results-count">0</span> negocios encontrados</p>
            </div>

            <div class="lbd-results-grid" id="lbd-results-grid">
                <?php
                $this->load_initial_results( $atts['per_page'] );
                ?>
            </div>

            <div class="lbd-pagination" id="lbd-pagination"></div>
        </div>
        <?php
        return ob_get_clean();
    }

    private function load_initial_results( $per_page ) {
        $args = [
            'post_type'      => 'business',
            'posts_per_page' => $per_page,
            'post_status'    => 'publish',
            'meta_key'       => '_lbd_featured',
            'orderby'        => [ 'meta_value_num' => 'DESC', 'title' => 'ASC' ],
            'order'          => 'ASC',
        ];

        $query = new \WP_Query( $args );

        if ( $query->have_posts() ) :
            while ( $query->have_posts() ) : $query->the_post();
                $this->render_business_card( get_the_ID() );
            endwhile;
            wp_reset_postdata();
        else :
            echo '<div class="lbd-no-results"><p>No se encontraron negocios. Agregá el primer negocio desde el panel de WordPress.</p></div>';
        endif;
    }

    public function ajax_search() {
        check_ajax_referer( 'lbd_search_nonce', 'nonce' );

        $keyword   = sanitize_text_field( wp_unslash( $_POST['keyword'] ?? '' ) );
        $rubro     = sanitize_text_field( wp_unslash( $_POST['rubro'] ?? '' ) );
        $categoria = sanitize_text_field( wp_unslash( $_POST['categoria'] ?? '' ) );
        $zona      = sanitize_text_field( wp_unslash( $_POST['zona'] ?? '' ) );
        $page      = absint( $_POST['page'] ?? 1 );
        $per_page  = absint( $_POST['per_page'] ?? 12 );

        $args = [
            'post_type'      => 'business',
            'posts_per_page' => $per_page,
            'paged'          => $page,
            'post_status'    => 'publish',
            'meta_key'       => '_lbd_featured',
            'orderby'        => [ 'meta_value_num' => 'DESC', 'title' => 'ASC' ],
            'order'          => 'ASC',
        ];

        if ( $keyword ) {
            $args['s'] = $keyword;
        }

        $tax_query = [ 'relation' => 'AND' ];
        if ( $rubro ) {
            $tax_query[] = [
                'taxonomy' => 'business_rubro',
                'field'    => 'slug',
                'terms'    => $rubro,
            ];
        }
        if ( $categoria ) {
            $tax_query[] = [
                'taxonomy' => 'business_categoria',
                'field'    => 'slug',
                'terms'    => $categoria,
            ];
        }
        if ( $zona ) {
            $tax_query[] = [
                'taxonomy' => 'business_zona',
                'field'    => 'slug',
                'terms'    => $zona,
            ];
        }

        if ( count( $tax_query ) > 1 ) {
            $args['tax_query'] = $tax_query;
        }

        $query = new \WP_Query( $args );

        ob_start();
        if ( $query->have_posts() ) :
            while ( $query->have_posts() ) : $query->the_post();
                $this->render_business_card( get_the_ID() );
            endwhile;
        else :
            echo '<div class="lbd-no-results"><p>No se encontraron negocios con esos filtros.</p></div>';
        endif;
        $html = ob_get_clean();
        wp_reset_postdata();

        wp_send_json_success( [
            'html'       => $html,
            'total'      => $query->found_posts,
            'total_pages' => $query->max_num_pages,
            'current_page' => $page,
        ] );
    }

    public function render_business_card( $post_id ) {
        $title    = get_the_title( $post_id );
        $logo     = get_post_meta( $post_id, '_lbd_logo', true );
        $tagline  = get_post_meta( $post_id, '_lbd_tagline', true );
        $address  = get_post_meta( $post_id, '_lbd_address', true );
        $phone    = get_post_meta( $post_id, '_lbd_phone', true );
        $whatsapp = get_post_meta( $post_id, '_lbd_whatsapp', true );
        $featured = get_post_meta( $post_id, '_lbd_featured', true );
        $url      = get_permalink( $post_id );
        $thumb    = get_the_post_thumbnail_url( $post_id, 'medium' );

        $rubros     = get_the_terms( $post_id, 'business_rubro' );
        $categorias = get_the_terms( $post_id, 'business_categoria' );
        $zonas      = get_the_terms( $post_id, 'business_zona' );
        ?>
        <div class="lbd-card<?php echo $featured ? ' lbd-card-featured' : ''; ?>" data-id="<?php echo esc_attr( $post_id ); ?>">
            <div class="lbd-card-image">
                <?php if ( $featured ) : ?>
                    <span class="lbd-card-featured-badge">Destacado</span>
                <?php endif; ?>
                <?php if ( $thumb ) : ?>
                    <a href="<?php echo esc_url( $url ); ?>">
                        <img src="<?php echo esc_url( $thumb ); ?>" alt="<?php echo esc_attr( $title ); ?>" loading="lazy">
                    </a>
                <?php else : ?>
                    <a href="<?php echo esc_url( $url ); ?>" class="lbd-card-no-image">
                        <?php echo esc_html( mb_substr( $title, 0, 2 ) ); ?>
                    </a>
                <?php endif; ?>
                <?php if ( $logo ) : ?>
                    <div class="lbd-card-logo">
                        <?php echo wp_get_attachment_image( $logo, [ 60, 60 ] ); ?>
                    </div>
                <?php endif; ?>
            </div>
            <div class="lbd-card-body">
                <h3 class="lbd-card-title">
                    <a href="<?php echo esc_url( $url ); ?>"><?php echo esc_html( $title ); ?></a>
                </h3>
                <?php if ( $tagline ) : ?>
                    <p class="lbd-card-tagline"><?php echo esc_html( $tagline ); ?></p>
                <?php endif; ?>
                <div class="lbd-card-meta">
                    <?php if ( $address ) : ?>
                        <span class="lbd-card-address">
                            <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M21 10c0 7-9 13-9 13s-9-6-9-13a9 9 0 0118 0z"/><circle cx="12" cy="10" r="3"/></svg>
                            <?php echo esc_html( $address ); ?>
                        </span>
                    <?php endif; ?>
                    <?php if ( $rubros && ! is_wp_error( $rubros ) ) : ?>
                        <span class="lbd-card-rubro"><?php echo esc_html( $rubros[0]->name ); ?></span>
                    <?php endif; ?>
                    <?php if ( $zonas && ! is_wp_error( $zonas ) ) : ?>
                        <span class="lbd-card-zona"><?php echo esc_html( $zonas[0]->name ); ?></span>
                    <?php endif; ?>
                </div>
                <div class="lbd-card-actions">
                    <?php if ( $phone ) : ?>
                        <a href="tel:<?php echo esc_attr( $phone ); ?>" class="lbd-card-btn lbd-btn-phone" title="Llamar">
                            <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M22 16.92v3a2 2 0 01-2.18 2 19.79 19.79 0 01-8.63-3.07 19.5 19.5 0 01-6-6 19.79 19.79 0 01-3.07-8.67A2 2 0 014.11 2h3a2 2 0 012 1.72c.127.96.361 1.903.7 2.81a2 2 0 01-.45 2.11L8.09 9.91a16 16 0 006 6l1.27-1.27a2 2 0 012.11-.45c.907.339 1.85.573 2.81.7A2 2 0 0122 16.92z"/></svg>
                        </a>
                    <?php endif; ?>
                    <?php if ( $whatsapp ) : ?>
                        <a href="https://wa.me/<?php echo esc_attr( $whatsapp ); ?>" target="_blank" rel="noopener" class="lbd-card-btn lbd-btn-whatsapp" title="WhatsApp">
                            <svg width="16" height="16" viewBox="0 0 24 24" fill="currentColor"><path d="M17.472 14.382c-.297-.149-1.758-.867-2.03-.967-.273-.099-.471-.148-.67.15-.197.297-.767.966-.94 1.164-.173.199-.347.223-.644.075-.297-.15-1.255-.463-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.298-.347.446-.52.149-.174.198-.298.298-.497.099-.198.05-.371-.025-.52-.075-.149-.669-1.612-.916-2.207-.242-.579-.487-.5-.669-.51-.173-.008-.371-.01-.57-.01-.198 0-.52.074-.792.372-.272.297-1.04 1.016-1.04 2.479 0 1.462 1.065 2.875 1.213 3.074.149.198 2.096 3.2 5.077 4.487.709.306 1.262.489 1.694.625.712.227 1.36.195 1.871.118.571-.085 1.758-.719 2.006-1.413.248-.694.248-1.289.173-1.413-.074-.124-.272-.198-.57-.347m-5.421 7.403h-.004a9.87 9.87 0 01-5.031-1.378l-.361-.214-3.741.982.998-3.648-.235-.374a9.86 9.86 0 01-1.51-5.26c.001-5.45 4.436-9.884 9.888-9.884 2.64 0 5.122 1.03 6.988 2.898a9.825 9.825 0 012.893 6.994c-.003 5.45-4.437 9.884-9.885 9.884m8.413-18.297A11.815 11.815 0 0012.05 0C5.495 0 .16 5.335.157 11.892c0 2.096.547 4.142 1.588 5.945L.057 24l6.305-1.654a11.882 11.882 0 005.683 1.448h.005c6.554 0 11.89-5.335 11.893-11.893a11.821 11.821 0 00-3.48-8.413z"/></svg>
                        </a>
                    <?php endif; ?>
                    <a href="<?php echo esc_url( $url ); ?>" class="lbd-card-btn lbd-btn-view" title="Ver más">Ver más</a>
                </div>
            </div>
        </div>
        <?php
    }
}
