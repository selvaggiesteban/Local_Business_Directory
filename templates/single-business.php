<?php
/**
 * Template Name: Single Business
 * Template for displaying individual business listings
 */

get_header();

global $post;
if ( $post ) :
    $post_id    = $post->ID;
    $title      = $post->post_title;
    $content    = $post->post_content;
    $logo       = get_post_meta( $post_id, '_lbd_logo', true );
    $tagline    = get_post_meta( $post_id, '_lbd_tagline', true );
    $address    = get_post_meta( $post_id, '_lbd_address', true );
    $phone      = get_post_meta( $post_id, '_lbd_phone', true );
    $whatsapp   = get_post_meta( $post_id, '_lbd_whatsapp', true );
    $maps_url   = get_post_meta( $post_id, '_lbd_maps_url', true );
    $latitude   = get_post_meta( $post_id, '_lbd_latitude', true );
    $longitude  = get_post_meta( $post_id, '_lbd_longitude', true );
    $instagram  = get_post_meta( $post_id, '_lbd_instagram', true );
    $facebook   = get_post_meta( $post_id, '_lbd_facebook', true );
    $twitter    = get_post_meta( $post_id, '_lbd_twitter', true );
    $youtube    = get_post_meta( $post_id, '_lbd_youtube', true );
    $tiktok     = get_post_meta( $post_id, '_lbd_tiktok', true );
    $linkedin   = get_post_meta( $post_id, '_lbd_linkedin', true );
    $website    = get_post_meta( $post_id, '_lbd_website', true );
    $schedule   = get_post_meta( $post_id, '_lbd_schedule', true );
    $about      = get_post_meta( $post_id, '_lbd_about', true );
    $services   = get_post_meta( $post_id, '_lbd_services', true );
    $gallery    = get_post_meta( $post_id, '_lbd_gallery', true );
    $cover      = get_the_post_thumbnail_url( $post_id, 'full' );

    $rubros     = get_the_terms( $post_id, 'business_rubro' );
    $categorias = get_the_terms( $post_id, 'business_categoria' );
    $zonas      = get_the_terms( $post_id, 'business_zona' );
?>

    <!-- Hero / Cover Full Width -->
    <?php
    $cover_style = '';
    if ( $cover ) {
        $cover_style = 'background-image:url(' . esc_url( $cover ) . ');background-size:cover;background-position:center center;background-repeat:no-repeat;';
    } else {
        $cover_style = 'background:linear-gradient(135deg,#2563eb,#7c3aed);';
    }
    ?>
    <div class="lbd-single-hero" style="<?php echo $cover_style; ?>">
        <div class="lbd-single-hero-overlay">
            <?php if ( $logo ) : ?>
                <div class="lbd-single-logo-wrap">
                    <?php echo wp_get_attachment_image( $logo, 'medium', false, [ 'class' => 'lbd-single-logo' ] ); ?>
                </div>
            <?php endif; ?>
            <h1><?php echo esc_html( $title ); ?></h1>
            <?php if ( $address ) : ?>
                <p class="lbd-single-address">Dirección: <?php echo esc_html( $address ); ?></p>
            <?php endif; ?>
            <?php if ( $tagline ) : ?>
                <p class="lbd-single-tagline"><?php echo esc_html( $tagline ); ?></p>
            <?php endif; ?>
            <div class="lbd-single-tags">
                <?php if ( $rubros && ! is_wp_error( $rubros ) ) : ?>
                    <?php foreach ( $rubros as $r ) : ?>
                        <span class="lbd-tag"><?php echo esc_html( $r->name ); ?></span>
                    <?php endforeach; ?>
                <?php endif; ?>
                <?php if ( $zonas && ! is_wp_error( $zonas ) ) : ?>
                    <?php foreach ( $zonas as $z ) : ?>
                        <span class="lbd-tag"><?php echo esc_html( $z->name ); ?></span>
                    <?php endforeach; ?>
                <?php endif; ?>
            </div>
        </div>
    </div>

    <!-- Contact Bar -->
    <div class="lbd-single-contact-bar">
        <?php if ( $phone ) : ?>
            <a href="tel:<?php echo esc_attr( $phone ); ?>" class="lbd-single-contact-item phone">
                <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M22 16.92v3a2 2 0 01-2.18 2 19.79 19.79 0 01-8.63-3.07 19.5 19.5 0 01-6-6 19.79 19.79 0 01-3.07-8.67A2 2 0 014.11 2h3a2 2 0 012 1.72c.127.96.361 1.903.7 2.81a2 2 0 01-.45 2.11L8.09 9.91a16 16 0 006 6l1.27-1.27a2 2 0 012.11-.45c.907.339 1.85.573 2.81.7A2 2 0 0122 16.92z"/></svg>
                <?php echo esc_html( $phone ); ?>
            </a>
        <?php endif; ?>
        <?php if ( $whatsapp ) : ?>
            <a href="https://wa.me/<?php echo esc_attr( $whatsapp ); ?>" target="_blank" rel="noopener" class="lbd-single-contact-item whatsapp">
                <svg width="18" height="18" viewBox="0 0 24 24" fill="currentColor"><path d="M17.472 14.382c-.297-.149-1.758-.867-2.03-.967-.273-.099-.471-.148-.67.15-.197.297-.767.966-.94 1.164-.173.199-.347.223-.644.075-.297-.15-1.255-.463-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.298-.347.446-.52.149-.174.198-.298.298-.497.099-.198.05-.371-.025-.52-.075-.149-.669-1.612-.916-2.207-.242-.579-.487-.5-.669-.51-.173-.008-.371-.01-.57-.01-.198 0-.52.074-.792.372-.272.297-1.04 1.016-1.04 2.479 0 1.462 1.065 2.875 1.213 3.074.149.198 2.096 3.2 5.077 4.487.709.306 1.262.489 1.694.625.712.227 1.36.195 1.871.118.571-.085 1.758-.719 2.006-1.413.248-.694.248-1.289.173-1.413-.074-.124-.272-.198-.57-.347m-5.421 7.403h-.004a9.87 9.87 0 01-5.031-1.378l-.361-.214-3.741.982.998-3.648-.235-.374a9.86 9.86 0 01-1.51-5.26c.001-5.45 4.436-9.884 9.888-9.884 2.64 0 5.122 1.03 6.988 2.898a9.825 9.825 0 012.893 6.994c-.003 5.45-4.437 9.884-9.885 9.884m8.413-18.297A11.815 11.815 0 0012.05 0C5.495 0 .16 5.335.157 11.892c0 2.096.547 4.142 1.588 5.945L.057 24l6.305-1.654a11.882 11.882 0 005.683 1.448h.005c6.554 0 11.89-5.335 11.893-11.893a11.821 11.821 0 00-3.48-8.413z"/></svg>
                WhatsApp
            </a>
        <?php endif; ?>
        <?php if ( $maps_url ) : ?>
            <a href="<?php echo esc_url( $maps_url ); ?>" target="_blank" rel="noopener" class="lbd-single-contact-item directions">
                <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M21 10c0 7-9 13-9 13s-9-6-9-13a9 9 0 0118 0z"/><circle cx="12" cy="10" r="3"/></svg>
                Cómo llegar
            </a>
        <?php endif; ?>
        <?php if ( $website ) : ?>
            <a href="<?php echo esc_url( $website ); ?>" target="_blank" rel="noopener" class="lbd-single-contact-item" style="background:#f3e8ff;color:#7c3aed;">
                <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><circle cx="12" cy="12" r="10"/><path d="M2 12h20"/><path d="M12 2a15.3 15.3 0 014 10 15.3 15.3 0 01-4 10 15.3 15.3 0 01-4-10 15.3 15.3 0 014-10z"/></svg>
                Sitio Web
            </a>
        <?php endif; ?>
    </div>

    <!-- Content Inner -->
    <div class="lbd-single-inner">

    <!-- Quiénes Somos -->
    <?php if ( $about ) : ?>
    <div class="lbd-single-section">
        <h2>Quiénes Somos</h2>
        <div class="lbd-about-card">
            <div class="lbd-single-content">
                <?php echo wp_kses_post( wpautop( $about ) ); ?>
            </div>
        </div>
    </div>
    <?php endif; ?>

    <!-- Descripción y Servicios -->
    <?php if ( $services ) : ?>
    <div class="lbd-single-section">
        <h2>Descripción y Servicios</h2>
        <div class="lbd-single-content">
            <?php echo wp_kses_post( wpautop( $services ) ); ?>
        </div>
    </div>
    <?php endif; ?>

    <!-- Dirección -->
    <?php if ( $address ) : ?>
    <div class="lbd-single-section">
        <h2>Ubicación</h2>
        <p style="font-size:16px;color:#374151;">
            <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" style="vertical-align:middle;margin-right:6px;"><path d="M21 10c0 7-9 13-9 13s-9-6-9-13a9 9 0 0118 0z"/><circle cx="12" cy="10" r="3"/></svg>
            <?php echo esc_html( $address ); ?>
        </p>
        <?php if ( $lat && $lng ) : ?>
        <div class="lbd-single-map">
            <iframe
                src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3280.0!2d<?php echo esc_attr( $lng ); ?>!3d<?php echo esc_attr( $lat ); ?>!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x0%3A0x0!2zMTLCsDI0JzI0LjAiUyA1OeHJp7sVw4Kp!5e0!3m2!1ses!2sar!4v1700000000000!5m2!1ses!2sar"
                width="100%"
                height="350"
                style="border:0;border-radius:12px;margin-top:12px;"
                allowfullscreen=""
                loading="lazy"
                referrerpolicy="no-referrer-when-downgrade">
            </iframe>
        </div>
        <?php elseif ( $maps_url ) : ?>
        <div class="lbd-single-map">
            <iframe
                src="https://maps.google.com/maps?q=<?php echo urlencode( $address ); ?>&t=&z=16&ie=UTF8&iwloc=&output=embed"
                width="100%"
                height="350"
                style="border:0;border-radius:12px;margin-top:12px;"
                allowfullscreen=""
                loading="lazy"
                referrerpolicy="no-referrer-when-downgrade">
            </iframe>
        </div>
        <?php endif; ?>
    </div>
    <?php endif; ?>

    <!-- Horarios -->
    <?php if ( ! empty( $schedule ) && is_array( $schedule ) ) : ?>
    <div class="lbd-single-section">
        <h2>Horarios de Atención</h2>
        <div class="lbd-schedule-grid">
            <?php
            $dias = [ 'lunes', 'martes', 'miercoles', 'jueves', 'viernes', 'sabado', 'domingo' ];
            $nombres = [ 'Lunes', 'Martes', 'Miércoles', 'Jueves', 'Viernes', 'Sábado', 'Domingo' ];
            foreach ( $dias as $i => $dia ) :
                $active = ! empty( $schedule[ $dia ]['active'] );
                $open   = $schedule[ $dia ]['open'] ?? '';
                $close  = $schedule[ $dia ]['close'] ?? '';
            ?>
                <div class="lbd-schedule-day <?php echo $active ? '' : 'closed'; ?>">
                    <span class="day-name"><?php echo esc_html( $nombres[ $i ] ); ?></span>
                    <span class="day-hours">
                        <?php if ( $active && $open && $close ) : ?>
                            <?php echo esc_html( $open . ' - ' . $close ); ?>
                        <?php else : ?>
                            Cerrado
                        <?php endif; ?>
                    </span>
                </div>
            <?php endforeach; ?>
        </div>
    </div>
    <?php endif; ?>

    <!-- Galería -->
    <?php if ( ! empty( $gallery ) && is_array( $gallery ) ) : ?>
    <div class="lbd-single-section lbd-gallery-section">
        <h2>Galería de Imágenes</h2>
        <div class="lbd-gallery-carousel" data-count="<?php echo count( $gallery ); ?>">
            <div class="lbd-gallery-track">
                <?php foreach ( $gallery as $i => $image_id ) : ?>
                    <?php $img_url = wp_get_attachment_image_url( $image_id, 'large' ); ?>
                    <?php if ( $img_url ) : ?>
                    <div class="lbd-gallery-item<?php echo $i === 0 ? ' active' : ''; ?>" data-index="<?php echo $i; ?>">
                        <img src="<?php echo esc_url( $img_url ); ?>" alt="" loading="lazy">
                    </div>
                    <?php endif; ?>
                <?php endforeach; ?>
            </div>
            <?php if ( count( $gallery ) > 1 ) : ?>
            <button class="lbd-gallery-arrow lbd-gallery-prev" aria-label="Anterior">
                <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M15 18l-6-6 6-6"/></svg>
            </button>
            <button class="lbd-gallery-arrow lbd-gallery-next" aria-label="Siguiente">
                <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M9 18l6-6-6-6"/></svg>
            </button>
            <div class="lbd-gallery-dots">
                <?php foreach ( $gallery as $i => $image_id ) : ?>
                    <span class="lbd-gallery-dot<?php echo $i === 0 ? ' active' : ''; ?>" data-index="<?php echo $i; ?>"></span>
                <?php endforeach; ?>
            </div>
            <?php endif; ?>
        </div>
    </div>
    <?php endif; ?>

    <!-- Redes Sociales -->
    <?php
    $social_links = [];
    if ( $instagram ) $social_links[] = [ 'url' => $instagram, 'name' => 'Instagram', 'icon' => '<svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><rect x="2" y="2" width="20" height="20" rx="5" ry="5"/><path d="M16 11.37A4 4 0 1112.63 8 4 4 0 0116 11.37z"/><line x1="17.5" y1="6.5" x2="17.51" y2="6.5"/></svg>' ];
    if ( $facebook ) $social_links[] = [ 'url' => $facebook, 'name' => 'Facebook', 'icon' => '<svg width="18" height="18" viewBox="0 0 24 24" fill="currentColor"><path d="M18 2h-3a5 5 0 00-5 5v3H7v4h3v8h4v-8h3l1-4h-4V7a1 1 0 011-1h3z"/></svg>' ];
    if ( $twitter ) $social_links[] = [ 'url' => $twitter, 'name' => 'X / Twitter', 'icon' => '<svg width="18" height="18" viewBox="0 0 24 24" fill="currentColor"><path d="M18.244 2.25h3.308l-7.227 8.26 8.502 11.24H16.17l-5.214-6.817L4.99 21.75H1.68l7.73-8.835L1.254 2.25H8.08l4.713 6.231zm-1.161 17.52h1.833L7.084 4.126H5.117z"/></svg>' ];
    if ( $youtube ) $social_links[] = [ 'url' => $youtube, 'name' => 'YouTube', 'icon' => '<svg width="18" height="18" viewBox="0 0 24 24" fill="currentColor"><path d="M19.615 3.184c-3.604-.246-11.631-.245-15.23 0-3.897.266-4.356 2.62-4.385 8.816.029 6.185.484 8.549 4.385 8.816 3.6.245 11.626.246 15.23 0 3.897-.266 4.356-2.62 4.385-8.816-.029-6.185-.484-8.549-4.385-8.816zM9 16V8l8 4-8 4z"/></svg>' ];
    if ( $tiktok ) $social_links[] = [ 'url' => $tiktok, 'name' => 'TikTok', 'icon' => '<svg width="18" height="18" viewBox="0 0 24 24" fill="currentColor"><path d="M19.59 6.69a4.83 4.83 0 01-3.77-4.25V2h-3.45v13.67a2.89 2.89 0 01-2.88 2.5 2.89 2.89 0 01-2.89-2.89 2.89 2.89 0 012.89-2.89c.28 0 .54.04.79.1V9a6.33 6.33 0 00-.79-.05 6.34 6.34 0 00-6.34 6.34 6.34 6.34 0 006.34 6.34A6.34 6.34 0 0015.8 14.94V9.13a8.16 8.16 0 004.79 1.53V7.2a4.85 4.85 0 01-1-.51z"/></svg>' ];
    if ( $linkedin ) $social_links[] = [ 'url' => $linkedin, 'name' => 'LinkedIn', 'icon' => '<svg width="18" height="18" viewBox="0 0 24 24" fill="currentColor"><path d="M20.447 20.452h-3.554v-5.569c0-1.328-.027-3.037-1.852-3.037-1.853 0-2.136 1.445-2.136 2.939v5.667H9.351V9h3.414v1.561h.046c.477-.9 1.637-1.85 3.37-1.85 3.601 0 4.267 2.37 4.267 5.455v6.286zM5.337 7.433c-1.144 0-2.063-.926-2.063-2.065 0-1.138.92-2.063 2.063-2.063 1.14 0 2.064.925 2.064 2.063 0 1.139-.925 2.065-2.064 2.065zm1.782 13.019H3.555V9h3.564v11.452zM22.225 0H1.771C.792 0 0 .774 0 1.729v20.542C0 23.227.792 24 1.771 24h20.451C23.2 24 24 23.227 24 22.271V1.729C24 .774 23.2 0 22.222 0h.003z"/></svg>' ];
    ?>

    <?php if ( ! empty( $social_links ) ) : ?>
    <div class="lbd-single-section">
        <h2>Redes Sociales</h2>
        <div class="lbd-social-links">
            <?php foreach ( $social_links as $social ) : ?>
                <a href="<?php echo esc_url( $social['url'] ); ?>" target="_blank" rel="noopener" class="lbd-social-link">
                    <?php echo $social['icon']; ?>
                    <?php echo esc_html( $social['name'] ); ?>
                </a>
            <?php endforeach; ?>
        </div>
    </div>
    <?php endif; ?>

    <!-- Contenido del editor (si se usa el editor de WordPress) -->
    <?php if ( $content ) : ?>
    <div class="lbd-single-section">
        <div class="lbd-single-content">
            <?php the_content(); ?>
        </div>
    </div>
    <?php endif; ?>

    </div><!-- .lbd-single-inner -->

</div>

    <?php if ( $whatsapp ) : ?>
    <!-- Floating WhatsApp Button -->
    <a href="https://wa.me/<?php echo esc_attr( $whatsapp ); ?>" target="_blank" rel="noopener" class="lbd-whatsapp-float" title="WhatsApp">
        <img src="<?php echo esc_url( LBD_PLUGIN_URL . 'assets/img/whatsapp.svg' ); ?>" alt="WhatsApp">
    </a>
    <?php endif; ?>

<?php endif; ?>

<?php
get_footer();