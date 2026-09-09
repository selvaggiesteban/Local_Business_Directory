<?php
namespace LBD\Metaboxes;

class Business_Metaboxes {

    public function __construct() {
        add_action( 'add_meta_boxes', [ $this, 'add_metaboxes' ] );
        add_action( 'save_post_business', [ $this, 'save_metaboxes' ] );
        add_action( 'admin_enqueue_scripts', [ $this, 'enqueue_admin_assets' ] );
    }

    public function add_metaboxes() {
        add_meta_box(
            'lbd_contact_info',
            'Datos de Contacto',
            [ $this, 'render_contact_info' ],
            'business',
            'normal',
            'high'
        );

        add_meta_box(
            'lbd_social_media',
            'Redes Sociales',
            [ $this, 'render_social_media' ],
            'business',
            'normal',
            'default'
        );

        add_meta_box(
            'lbd_schedule',
            'Horarios de Atención',
            [ $this, 'render_schedule' ],
            'business',
            'normal',
            'default'
        );

        add_meta_box(
            'lbd_about',
            'Quiénes Somos',
            [ $this, 'render_about' ],
            'business',
            'normal',
            'default'
        );

        add_meta_box(
            'lbd_gallery',
            'Galería de Imágenes',
            [ $this, 'render_gallery' ],
            'business',
            'normal',
            'default'
        );

        add_meta_box(
            'lbd_featured',
            'Negocio Destacado',
            [ $this, 'render_featured' ],
            'business',
            'side',
            'high'
        );
    }

    public function render_contact_info( $post ) {
        wp_nonce_field( 'lbd_contact_info_nonce', 'lbd_contact_info_nonce_field' );

        $logo         = get_post_meta( $post->ID, '_lbd_logo', true );
        $tagline      = get_post_meta( $post->ID, '_lbd_tagline', true );
        $address      = get_post_meta( $post->ID, '_lbd_address', true );
        $phone        = get_post_meta( $post->ID, '_lbd_phone', true );
        $whatsapp     = get_post_meta( $post->ID, '_lbd_whatsapp', true );
        $maps_url     = get_post_meta( $post->ID, '_lbd_maps_url', true );
        $latitude     = get_post_meta( $post->ID, '_lbd_latitude', true );
        $longitude    = get_post_meta( $post->ID, '_lbd_longitude', true );
        ?>
        <style>
            .lbd-field-row { margin-bottom: 15px; }
            .lbd-field-row label { display: block; font-weight: 600; margin-bottom: 5px; }
            .lbd-field-row input[type="text"],
            .lbd-field-row input[type="tel"],
            .lbd-field-row textarea { width: 100%; max-width: 500px; }
            .lbd-field-row .description { color: #666; font-style: italic; margin-top: 3px; }
            .lbd-logo-preview { max-width: 150px; max-height: 150px; margin-top: 10px; border: 1px solid #ddd; border-radius: 4px; }
            .lbd-upload-btn { display: inline-block; padding: 6px 12px; background: #0073aa; color: #fff; border: none; border-radius: 4px; cursor: pointer; margin-top: 5px; }
            .lbd-upload-btn:hover { background: #005a87; }
        </style>
        <div class="lbd-field-row">
            <label for="lbd_logo">Logo del Negocio</label>
            <input type="hidden" id="lbd_logo" name="lbd_logo" value="<?php echo esc_attr( $logo ); ?>">
            <div id="lbd-logo-preview">
                <?php if ( $logo ) : ?>
                    <?php echo wp_get_attachment_image( $logo, [ 150, 150 ], false, [ 'class' => 'lbd-logo-preview' ] ); ?>
                <?php endif; ?>
            </div>
            <button type="button" class="lbd-upload-btn" id="lbd-upload-logo">Seleccionar Logo</button>
            <button type="button" class="lbd-upload-btn" id="lbd-remove-logo" style="background:#dc3545;">Eliminar</button>
            <p class="description">Subí el logo del negocio (recomendado: 300x300px).</p>
        </div>
        <div class="lbd-field-row">
            <label for="lbd_tagline">Frase debajo del nombre</label>
            <input type="text" id="lbd_tagline" name="lbd_tagline" value="<?php echo esc_attr( $tagline ); ?>" placeholder="Ej: Somos especialistas en...">
            <p class="description">Una bajada o eslogan que aparezca debajo del nombre del negocio.</p>
        </div>
        <div class="lbd-field-row">
            <label for="lbd_address">Dirección</label>
            <input type="text" id="lbd_address" name="lbd_address" value="<?php echo esc_attr( $address ); ?>" placeholder="Ej: Av. Corrientes 1234, CABA">
        </div>
        <div class="lbd-field-row">
            <label for="lbd_phone">Teléfono</label>
            <input type="tel" id="lbd_phone" name="lbd_phone" value="<?php echo esc_attr( $phone ); ?>" placeholder="Ej: 11-1234-5678">
        </div>
        <div class="lbd-field-row">
            <label for="lbd_whatsapp">WhatsApp (solo número)</label>
            <input type="tel" id="lbd_whatsapp" name="lbd_whatsapp" value="<?php echo esc_attr( $whatsapp ); ?>" placeholder="Ej: 5491112345678">
            <p class="description">Ingresar código de país sin + (ej: 5491112345678).</p>
        </div>
        <div class="lbd-field-row">
            <label for="lbd_maps_url">URL de Google Maps ("Cómo llegar")</label>
            <input type="text" id="lbd_maps_url" name="lbd_maps_url" value="<?php echo esc_attr( $maps_url ); ?>" placeholder="https://maps.google.com/?q=...">
            <p class="description">Pegá el link de Google Maps de la ubicación.</p>
        </div>
        <div class="lbd-field-row">
            <label>Coordenadas (opcional, para mapa embebido)</label>
            <input type="text" id="lbd_latitude" name="lbd_latitude" value="<?php echo esc_attr( $latitude ); ?>" placeholder="Latitud (ej: -34.6037)" style="width:200px; display:inline;">
            <input type="text" id="lbd_longitude" name="lbd_longitude" value="<?php echo esc_attr( $longitude ); ?>" placeholder="Longitud (ej: -58.3816)" style="width:200px; display:inline;">
        </div>
        <?php
    }

    public function render_social_media( $post ) {
        wp_nonce_field( 'lbd_social_media_nonce', 'lbd_social_media_nonce_field' );

        $instagram  = get_post_meta( $post->ID, '_lbd_instagram', true );
        $facebook   = get_post_meta( $post->ID, '_lbd_facebook', true );
        $twitter    = get_post_meta( $post->ID, '_lbd_twitter', true );
        $youtube    = get_post_meta( $post->ID, '_lbd_youtube', true );
        $tiktok     = get_post_meta( $post->ID, '_lbd_tiktok', true );
        $linkedin   = get_post_meta( $post->ID, '_lbd_linkedin', true );
        $website    = get_post_meta( $post->ID, '_lbd_website', true );
        ?>
        <div class="lbd-field-row">
            <label for="lbd_instagram">Instagram</label>
            <input type="text" id="lbd_instagram" name="lbd_instagram" value="<?php echo esc_attr( $instagram ); ?>" placeholder="https://instagram.com/tunegocio">
        </div>
        <div class="lbd-field-row">
            <label for="lbd_facebook">Facebook</label>
            <input type="text" id="lbd_facebook" name="lbd_facebook" value="<?php echo esc_attr( $facebook ); ?>" placeholder="https://facebook.com/tunegocio">
        </div>
        <div class="lbd-field-row">
            <label for="lbd_twitter">X / Twitter</label>
            <input type="text" id="lbd_twitter" name="lbd_twitter" value="<?php echo esc_attr( $twitter ); ?>" placeholder="https://x.com/tunegocio">
        </div>
        <div class="lbd-field-row">
            <label for="lbd_youtube">YouTube</label>
            <input type="text" id="lbd_youtube" name="lbd_youtube" value="<?php echo esc_attr( $youtube ); ?>" placeholder="https://youtube.com/@tunegocio">
        </div>
        <div class="lbd-field-row">
            <label for="lbd_tiktok">TikTok</label>
            <input type="text" id="lbd_tiktok" name="lbd_tiktok" value="<?php echo esc_attr( $tiktok ); ?>" placeholder="https://tiktok.com/@tunegocio">
        </div>
        <div class="lbd-field-row">
            <label for="lbd_linkedin">LinkedIn</label>
            <input type="text" id="lbd_linkedin" name="lbd_linkedin" value="<?php echo esc_attr( $linkedin ); ?>" placeholder="https://linkedin.com/company/tunegocio">
        </div>
        <div class="lbd-field-row">
            <label for="lbd_website">Sitio Web</label>
            <input type="text" id="lbd_website" name="lbd_website" value="<?php echo esc_attr( $website ); ?>" placeholder="https://tunegocio.com">
        </div>
        <?php
    }

    public function render_schedule( $post ) {
        wp_nonce_field( 'lbd_schedule_nonce', 'lbd_schedule_nonce_field' );

        $schedule = get_post_meta( $post->ID, '_lbd_schedule', true );
        if ( empty( $schedule ) ) {
            $schedule = [
                'lunes'      => [ 'open' => '09:00', 'close' => '18:00', 'active' => true ],
                'martes'     => [ 'open' => '09:00', 'close' => '18:00', 'active' => true ],
                'miercoles'  => [ 'open' => '09:00', 'close' => '18:00', 'active' => true ],
                'jueves'     => [ 'open' => '09:00', 'close' => '18:00', 'active' => true ],
                'viernes'    => [ 'open' => '09:00', 'close' => '18:00', 'active' => true ],
                'sabado'     => [ 'open' => '09:00', 'close' => '13:00', 'active' => true ],
                'domingo'    => [ 'open' => '', 'close' => '', 'active' => false ],
            ];
        }
        ?>
        <style>
            .lbd-schedule-table { width: 100%; border-collapse: collapse; }
            .lbd-schedule-table th { text-align: left; padding: 8px; background: #f1f1f1; }
            .lbd-schedule-table td { padding: 8px; border-bottom: 1px solid #eee; }
            .lbd-schedule-table input[type="time"] { width: 120px; }
            .lbd-schedule-table input[type="checkbox"] { margin-right: 8px; }
        </style>
        <table class="lbd-schedule-table">
            <thead>
                <tr>
                    <th>Día</th>
                    <th>Activo</th>
                    <th>Horario de apertura</th>
                    <th>Horario de cierre</th>
                </tr>
            </thead>
            <tbody>
                <?php
                $dias = [ 'lunes', 'martes', 'miercoles', 'jueves', 'viernes', 'sabado', 'domingo' ];
                $nombres = [ 'Lunes', 'Martes', 'Miércoles', 'Jueves', 'Viernes', 'Sábado', 'Domingo' ];
                foreach ( $dias as $i => $dia ) :
                    $active = ! empty( $schedule[ $dia ]['active'] ) ? 'checked' : '';
                    $open   = isset( $schedule[ $dia ]['open'] ) ? $schedule[ $dia ]['open'] : '';
                    $close  = isset( $schedule[ $dia ]['close'] ) ? $schedule[ $dia ]['close'] : '';
                ?>
                <tr>
                    <td><strong><?php echo esc_html( $nombres[ $i ] ); ?></strong></td>
                    <td><input type="checkbox" name="lbd_schedule[<?php echo esc_attr( $dia ); ?>][active]" value="1" <?php echo $active; ?>></td>
                    <td><input type="time" name="lbd_schedule[<?php echo esc_attr( $dia ); ?>][open]" value="<?php echo esc_attr( $open ); ?>"></td>
                    <td><input type="time" name="lbd_schedule[<?php echo esc_attr( $dia ); ?>][close]" value="<?php echo esc_attr( $close ); ?>"></td>
                </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
        <p class="description">Desmarcá los días en que el negocio está cerrado.</p>
        <?php
    }

    public function render_about( $post ) {
        wp_nonce_field( 'lbd_about_nonce', 'lbd_about_nonce_field' );

        $about       = get_post_meta( $post->ID, '_lbd_about', true );
        $services    = get_post_meta( $post->ID, '_lbd_services', true );
        ?>
        <div class="lbd-field-row">
            <label for="lbd_about">Quiénes Somos</label>
            <textarea id="lbd_about" name="lbd_about" rows="6" placeholder="Contá brevemente la historia del negocio..."><?php echo esc_textarea( $about ); ?></textarea>
        </div>
        <div class="lbd-field-row">
            <label for="lbd_services">Descripción y Servicios</label>
            <textarea id="lbd_services" name="lbd_services" rows="8" placeholder="Describí los servicios que ofrece el negocio..."><?php echo esc_textarea( $services ); ?></textarea>
        </div>
        <?php
    }

    public function render_gallery( $post ) {
        wp_nonce_field( 'lbd_gallery_nonce', 'lbd_gallery_nonce_field' );

        $gallery = get_post_meta( $post->ID, '_lbd_gallery', true );
        if ( empty( $gallery ) ) {
            $gallery = [];
        }
        ?>
        <style>
            .lbd-gallery-grid { display: flex; flex-wrap: wrap; gap: 10px; margin-bottom: 15px; }
            .lbd-gallery-item { position: relative; width: 120px; height: 120px; border: 1px solid #ddd; border-radius: 4px; overflow: hidden; }
            .lbd-gallery-item img { width: 100%; height: 100%; object-fit: cover; }
            .lbd-gallery-item .remove-gallery { position: absolute; top: 2px; right: 2px; background: #dc3545; color: #fff; border: none; border-radius: 50%; width: 22px; height: 22px; cursor: pointer; font-size: 12px; line-height: 20px; text-align: center; }
        </style>
        <div class="lbd-gallery-grid" id="lbd-gallery-preview">
            <?php if ( ! empty( $gallery ) ) : ?>
                <?php foreach ( $gallery as $index => $image_id ) : ?>
                    <div class="lbd-gallery-item" data-index="<?php echo esc_attr( $index ); ?>">
                        <?php echo wp_get_attachment_image( $image_id, [ 120, 120 ] ); ?>
                        <button type="button" class="remove-gallery" data-index="<?php echo esc_attr( $index ); ?>">&times;</button>
                        <input type="hidden" name="lbd_gallery[]" value="<?php echo esc_attr( $image_id ); ?>">
                    </div>
                <?php endforeach; ?>
            <?php endif; ?>
        </div>
        <button type="button" class="lbd-upload-btn" id="lbd-add-gallery">Agregar Imágenes</button>
        <p class="description">Podés agregar múltiples imágenes a la galería del negocio.</p>
        <?php
    }

    public function render_featured( $post ) {
        wp_nonce_field( 'lbd_featured_nonce', 'lbd_featured_nonce_field' );
        $featured = get_post_meta( $post->ID, '_lbd_featured', true );
        ?>
        <label style="display:flex;align-items:center;gap:8px;cursor:pointer;">
            <input type="checkbox" name="lbd_featured" value="1" <?php checked( $featured, '1' ); ?>>
            <span>Marcar como destacado</span>
        </label>
        <p class="description" style="margin-top:8px;">Los negocios destacados aparecen primero en el listado y muestran un badge especial.</p>
        <?php
    }

    public function save_metaboxes( $post_id ) {
        // Verificar nonces
        if ( ! isset( $_POST['lbd_contact_info_nonce_field'] ) || ! wp_verify_nonce( $_POST['lbd_contact_info_nonce_field'], 'lbd_contact_info_nonce' ) ) {
            return;
        }
        if ( ! isset( $_POST['lbd_social_media_nonce_field'] ) || ! wp_verify_nonce( $_POST['lbd_social_media_nonce_field'], 'lbd_social_media_nonce' ) ) {
            return;
        }
        if ( ! isset( $_POST['lbd_schedule_nonce_field'] ) || ! wp_verify_nonce( $_POST['lbd_schedule_nonce_field'], 'lbd_schedule_nonce' ) ) {
            return;
        }
        if ( ! isset( $_POST['lbd_about_nonce_field'] ) || ! wp_verify_nonce( $_POST['lbd_about_nonce_field'], 'lbd_about_nonce' ) ) {
            return;
        }
        if ( ! isset( $_POST['lbd_gallery_nonce_field'] ) || ! wp_verify_nonce( $_POST['lbd_gallery_nonce_field'], 'lbd_gallery_nonce' ) ) {
            return;
        }
        if ( ! isset( $_POST['lbd_featured_nonce_field'] ) || ! wp_verify_nonce( $_POST['lbd_featured_nonce_field'], 'lbd_featured_nonce' ) ) {
            return;
        }

        // Verificar permisos
        if ( ! current_user_can( 'edit_post', $post_id ) ) {
            return;
        }

        // Guardar campos de contacto
        $this->save_field( $post_id, '_lbd_logo', sanitize_text_field( wp_unslash( $_POST['lbd_logo'] ?? '' ) ) );
        $this->save_field( $post_id, '_lbd_tagline', sanitize_text_field( wp_unslash( $_POST['lbd_tagline'] ?? '' ) ) );
        $this->save_field( $post_id, '_lbd_address', sanitize_text_field( wp_unslash( $_POST['lbd_address'] ?? '' ) ) );
        $this->save_field( $post_id, '_lbd_phone', sanitize_text_field( wp_unslash( $_POST['lbd_phone'] ?? '' ) ) );
        $this->save_field( $post_id, '_lbd_whatsapp', sanitize_text_field( wp_unslash( $_POST['lbd_whatsapp'] ?? '' ) ) );
        $this->save_field( $post_id, '_lbd_maps_url', esc_url_raw( wp_unslash( $_POST['lbd_maps_url'] ?? '' ) ) );
        $this->save_field( $post_id, '_lbd_latitude', sanitize_text_field( wp_unslash( $_POST['lbd_latitude'] ?? '' ) ) );
        $this->save_field( $post_id, '_lbd_longitude', sanitize_text_field( wp_unslash( $_POST['lbd_longitude'] ?? '' ) ) );

        // Guardar redes sociales
        $this->save_field( $post_id, '_lbd_instagram', esc_url_raw( wp_unslash( $_POST['lbd_instagram'] ?? '' ) ) );
        $this->save_field( $post_id, '_lbd_facebook', esc_url_raw( wp_unslash( $_POST['lbd_facebook'] ?? '' ) ) );
        $this->save_field( $post_id, '_lbd_twitter', esc_url_raw( wp_unslash( $_POST['lbd_twitter'] ?? '' ) ) );
        $this->save_field( $post_id, '_lbd_youtube', esc_url_raw( wp_unslash( $_POST['lbd_youtube'] ?? '' ) ) );
        $this->save_field( $post_id, '_lbd_tiktok', esc_url_raw( wp_unslash( $_POST['lbd_tiktok'] ?? '' ) ) );
        $this->save_field( $post_id, '_lbd_linkedin', esc_url_raw( wp_unslash( $_POST['lbd_linkedin'] ?? '' ) ) );
        $this->save_field( $post_id, '_lbd_website', esc_url_raw( wp_unslash( $_POST['lbd_website'] ?? '' ) ) );

        // Guardar horarios
        $schedule = [];
        if ( ! empty( $_POST['lbd_schedule'] ) && is_array( $_POST['lbd_schedule'] ) ) {
            foreach ( $_POST['lbd_schedule'] as $dia => $data ) {
                $schedule[ sanitize_key( $dia ) ] = [
                    'active' => ! empty( $data['active'] ),
                    'open'   => sanitize_text_field( $data['open'] ?? '' ),
                    'close'  => sanitize_text_field( $data['close'] ?? '' ),
                ];
            }
        }
        update_post_meta( $post_id, '_lbd_schedule', $schedule );

        // Guardar quiénes somos y servicios
        $this->save_field( $post_id, '_lbd_about', sanitize_textarea_field( wp_unslash( $_POST['lbd_about'] ?? '' ) ) );
        $this->save_field( $post_id, '_lbd_services', sanitize_textarea_field( wp_unslash( $_POST['lbd_services'] ?? '' ) ) );

        // Guardar galería
        $gallery = [];
        if ( ! empty( $_POST['lbd_gallery'] ) && is_array( $_POST['lbd_gallery'] ) ) {
            foreach ( $_POST['lbd_gallery'] as $image_id ) {
                $gallery[] = absint( $image_id );
            }
        }
        update_post_meta( $post_id, '_lbd_gallery', $gallery );

        // Guardar destacado
        $featured = ! empty( $_POST['lbd_featured'] ) ? '1' : '';
        $this->save_field( $post_id, '_lbd_featured', $featured );
    }

    private function save_field( $post_id, $key, $value ) {
        if ( $value !== '' && $value !== null ) {
            update_post_meta( $post_id, $key, $value );
        } else {
            delete_post_meta( $post_id, $key );
        }
    }

    public function enqueue_admin_assets( $hook ) {
        global $post_type;

        if ( ( $hook === 'post-new.php' || $hook === 'post.php' ) && $post_type === 'business' ) {
            wp_enqueue_media();

            wp_enqueue_script(
                'lbd-admin',
                LBD_PLUGIN_URL . 'assets/js/admin.js',
                [ 'jquery' ],
                LBD_VERSION,
                true
            );

            wp_localize_script( 'lbd-admin', 'lbdAdmin', [
                'ajaxUrl' => admin_url( 'admin-ajax.php' ),
                'nonce'   => wp_create_nonce( 'lbd_admin_nonce' ),
            ] );
        }
    }
}