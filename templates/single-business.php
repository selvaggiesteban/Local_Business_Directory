<?php
/**
 * Template Name: Single Business
 * Template for displaying individual business listings
 */

get_header();

global $post;
if ( $post ) :

    echo '<style>
    .lbd-gallery-carousel{position:relative;overflow:hidden;padding:20px 0;width:100%}
    .lbd-gallery-track{display:flex;gap:20px;width:max-content;will-change:transform;transition:transform .4s cubic-bezier(.25,.46,.45,.94)}
    .lbd-gallery-item{flex:0 0 50vw;max-width:560px;height:400px;border-radius:8px;overflow:hidden;cursor:pointer;transition:opacity .4s,transform .4s;opacity:.45;transform:scale(.93)}
    .lbd-gallery-item.active{opacity:1;transform:scale(1)}
    .lbd-gallery-item img{width:100%;height:100%;object-fit:cover;transition:transform .4s}
    .lbd-gallery-item:hover img{transform:scale(1.05)}
    .lbd-gallery-item.lbd-clone{opacity:.3}
    .lbd-gallery-arrow{position:absolute;top:50%;transform:translateY(-50%);width:44px;height:44px;border-radius:50%;border:1px solid #d1d5db;background:rgba(255,255,255,.95)!important;color:#374151!important;cursor:pointer;display:flex;align-items:center;justify-content:center;z-index:10;transition:all .3s;padding:0;font-size:0;line-height:0;text-decoration:none;outline:none}
    .lbd-gallery-arrow:hover{background:#f3f4f6!important;border-color:#9ca3af;transform:translateY(-50%) scale(1.1)}
    .lbd-gallery-prev{left:16px}
    .lbd-gallery-next{right:16px}
    .lbd-gallery-dots{display:flex;justify-content:center;gap:8px;margin-top:16px}
    .lbd-gallery-dot{width:8px;height:8px;border-radius:50%;background:#d1d5db;border:none;cursor:pointer;transition:all .3s}
    .lbd-gallery-dot.active{background:#374151;width:24px;border-radius:4px}
    .lbd-lightbox{position:fixed;top:0;left:0;width:100%;height:100%;background:rgba(0,0,0,.92);z-index:100000;display:flex;align-items:center;justify-content:center;animation:lbFadeIn .25s ease}
    @keyframes lbFadeIn{from{opacity:0}to{opacity:1}}
    .lbd-lb-img-wrap{max-width:85vw;max-height:85vh;display:flex;align-items:center;justify-content:center}
    .lbd-lb-img{max-width:85vw;max-height:85vh;object-fit:contain;border-radius:4px}
    .lbd-lb-close{position:absolute;top:16px;right:20px;background:none;border:none;color:#fff;font-size:36px;cursor:pointer;width:44px;height:44px;display:flex;align-items:center;justify-content:center;border-radius:50%;transition:background .2s;line-height:1}
    .lbd-lb-close:hover{background:rgba(255,255,255,.15)}
    .lbd-lb-prev,.lbd-lb-next{position:absolute;top:50%;transform:translateY(-50%);background:rgba(255,255,255,.1);border:1px solid rgba(255,255,255,.25);color:#fff;font-size:28px;cursor:pointer;width:48px;height:48px;display:flex;align-items:center;justify-content:center;border-radius:50%;transition:background .2s}
    .lbd-lb-prev:hover,.lbd-lb-next:hover{background:rgba(255,255,255,.25)}
    .lbd-lb-prev{left:20px}
    .lbd-lb-next{right:20px}
    .lbd-lb-counter{position:absolute;bottom:20px;left:50%;transform:translateX(-50%);color:rgba(255,255,255,.7);font-size:14px}
    @media(max-width:768px){.lbd-gallery-item{flex:0 0 70vw;max-width:none;height:320px}.lbd-gallery-arrow{width:36px;height:36px}.lbd-gallery-prev{left:8px}.lbd-gallery-next{right:8px}}
    @media(max-width:480px){.lbd-gallery-item{flex:0 0 82vw;max-width:none;height:260px}}
    .lbd-search-toggle{position:absolute;top:20px;right:20px;z-index:10;width:48px;height:48px;border-radius:50%;border:none;background:rgba(0,0,0,.5);backdrop-filter:blur(8px);color:#fff;cursor:pointer;display:flex;align-items:center;justify-content:center;transition:background .2s,transform .2s}
    .lbd-search-toggle:hover{background:rgba(0,0,0,.7);transform:scale(1.1)}
    .lbd-search-overlay{position:fixed!important;top:0!important;left:0!important;width:100%!important;height:100%!important;background:#fff!important;z-index:100000!important;display:none;overflow-y:auto;animation:lbdFadeIn .25s ease}
    .lbd-search-overlay.active{display:block!important}
    .lbd-search-close{position:fixed;top:20px;right:24px;z-index:100001;background:#000;border:none;color:#fff;font-size:28px;cursor:pointer;width:48px;height:48px;display:flex;align-items:center;justify-content:center;border-radius:50%;transition:transform .2s}
    .lbd-search-close:hover{transform:scale(1.1)}
    .lbd-search-overlay-inner{width:100%;max-width:1100px;margin:0 auto;padding:80px 20px 40px;color:#1f2937}
    .lbd-search-overlay-inner h2{color:#000;margin:0 0 24px;font-size:28px}
    .lbd-search-overlay-inner .lbd-search-form{background:#f9fafb;border-radius:12px;padding:24px;margin-bottom:24px}
    .lbd-search-overlay-inner .lbd-search-field input,.lbd-search-overlay-inner .lbd-search-field select{border-radius:8px}
    .lbd-search-overlay-inner .lbd-search-btn{background:#000;color:#fff;border:none;border-radius:8px;padding:10px 28px;font-size:14px;font-weight:600;cursor:pointer}
    .lbd-search-overlay-inner .lbd-search-btn:hover{background:#333}
    .lbd-search-overlay-inner .lbd-results-grid{display:grid;grid-template-columns:repeat(auto-fill,minmax(300px,1fr));gap:20px}
    .lbd-search-overlay-inner .lbd-results-info{color:#6b7280;margin-bottom:16px}
    .lbd-search-overlay-inner .lbd-pagination{display:flex;justify-content:center;gap:8px;margin-top:24px}
    .lbd-search-overlay-inner .lbd-pagination button{padding:8px 16px;border:1px solid #d1d5db;border-radius:8px;background:#fff;color:#1f2937;font-size:14px;cursor:pointer;transition:all .2s}
    .lbd-search-overlay-inner .lbd-pagination button:hover{border-color:#000;color:#000}
    .lbd-search-overlay-inner .lbd-pagination button.active{background:#000;color:#fff;border-color:#000}
    .lbd-search-overlay-inner .lbd-no-results{text-align:center;padding:40px;color:#9ca3af;grid-column:1/-1}
    </style>';
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
        <button class="lbd-search-toggle" id="lbd-search-toggle" aria-label="Buscar">
            <svg width="22" height="22" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><circle cx="11" cy="11" r="8"/><line x1="21" y1="21" x2="16.65" y2="16.65"/></svg>
        </button>
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

    <!-- Full-Screen Search Overlay -->
    <div class="lbd-search-overlay" id="lbd-search-overlay">
        <button class="lbd-search-close" id="lbd-search-close" aria-label="Cerrar">
            <svg width="28" height="28" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><line x1="18" y1="6" x2="6" y2="18"/><line x1="6" y1="6" x2="18" y2="18"/></svg>
        </button>
        <div class="lbd-search-overlay-inner">
            <h2>Buscar Negocios</h2>
            <?php
            $all_rubros     = get_terms( [ 'taxonomy' => 'business_rubro', 'hide_empty' => false ] );
            $all_categorias = get_terms( [ 'taxonomy' => 'business_categoria', 'hide_empty' => false ] );
            $all_zonas      = get_terms( [ 'taxonomy' => 'business_zona', 'hide_empty' => false ] );
            ?>
            <form class="lbd-search-form" id="lbd-overlay-search-form">
                <div class="lbd-search-fields">
                    <div class="lbd-search-field">
                        <label for="lbd-overlay-search-keyword">Buscar</label>
                        <input type="text" id="lbd-overlay-search-keyword" name="keyword" placeholder="Nombre del negocio...">
                    </div>
                    <div class="lbd-search-field">
                        <label for="lbd-overlay-search-rubro">Rubro</label>
                        <select id="lbd-overlay-search-rubro" name="rubro">
                            <option value="">Todos los rubros</option>
                            <?php foreach ( $all_rubros as $r ) : ?>
                                <option value="<?php echo esc_attr( $r->slug ); ?>"><?php echo esc_html( $r->name ); ?></option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                    <div class="lbd-search-field">
                        <label for="lbd-overlay-search-categoria">Categoría</label>
                        <select id="lbd-overlay-search-categoria" name="categoria">
                            <option value="">Todas las categorías</option>
                            <?php foreach ( $all_categorias as $c ) : ?>
                                <option value="<?php echo esc_attr( $c->slug ); ?>"><?php echo esc_html( $c->name ); ?></option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                    <div class="lbd-search-field">
                        <label for="lbd-overlay-search-zona">Zona / Localidad</label>
                        <select id="lbd-overlay-search-zona" name="zona">
                            <option value="">Todas las zonas</option>
                            <?php foreach ( $all_zonas as $z ) : ?>
                                <option value="<?php echo esc_attr( $z->slug ); ?>"><?php echo esc_html( $z->name ); ?></option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                    <div class="lbd-search-field lbd-search-btn-wrapper">
                        <button type="submit" class="lbd-search-btn">Buscar</button>
                    </div>
                </div>
            </form>
            <div class="lbd-results-info" id="lbd-overlay-results-info" style="display:none;">
                <p><span id="lbd-overlay-results-count">0</span> negocios encontrados</p>
            </div>
            <div class="lbd-results-grid" id="lbd-overlay-results-grid"></div>
            <div class="lbd-pagination" id="lbd-overlay-pagination"></div>
        </div>
    </div>

    <?php if ( $whatsapp ) : ?>
    <!-- Floating WhatsApp Button -->
    <a href="https://wa.me/<?php echo esc_attr( $whatsapp ); ?>" target="_blank" rel="noopener" class="lbd-whatsapp-float" title="WhatsApp">
        <img src="<?php echo esc_url( LBD_PLUGIN_URL . 'assets/img/whatsapp.svg' ); ?>" alt="WhatsApp">
    </a>
    <?php endif; ?>

<script>
(function(){
    var toggle = document.getElementById('lbd-search-toggle');
    var overlay = document.getElementById('lbd-search-overlay');
    var close = document.getElementById('lbd-search-close');
    if (!toggle || !overlay) return;

    toggle.addEventListener('click', function(){
        overlay.style.cssText='position:fixed;top:0;left:0;width:100vw;height:100vh;background:#fff;z-index:100000;display:block;overflow-y:auto';
    });
    close.addEventListener('click', function(){ overlay.style.display='none'; });
    overlay.addEventListener('click', function(e){ if(e.target===overlay) overlay.style.display='none'; });
    document.addEventListener('keydown', function(e){ if(e.key==='Escape') overlay.style.display='none'; });

    var form = document.getElementById('lbd-overlay-search-form');
    var grid = document.getElementById('lbd-overlay-results-grid');
    var info = document.getElementById('lbd-overlay-results-info');
    var countEl = document.getElementById('lbd-overlay-results-count');
    var pag = document.getElementById('lbd-overlay-pagination');
    var curPage = 1;

    function doSearch(page){
        curPage = page || 1;
        var data = new FormData();
        data.append('action','lbd_search_businesses');
        data.append('nonce','<?php echo wp_create_nonce("lbd_search_nonce"); ?>');
        data.append('keyword', document.getElementById('lbd-overlay-search-keyword').value);
        data.append('rubro', document.getElementById('lbd-overlay-search-rubro').value);
        data.append('categoria', document.getElementById('lbd-overlay-search-categoria').value);
        data.append('zona', document.getElementById('lbd-overlay-search-zona').value);
        data.append('page', curPage);
        data.append('per_page', 12);

        grid.style.opacity = '0.5';
        fetch('<?php echo admin_url("admin-ajax.php"); ?>', {method:'POST', body:data})
            .then(function(r){return r.json();})
            .then(function(res){
                grid.style.opacity = '1';
                if(res.success){
                    grid.innerHTML = res.data.html;
                    countEl.textContent = res.data.total;
                    info.style.display = res.data.total > 0 ? 'block' : 'none';
                    renderPag(res.data.total_pages, res.data.current_page);
                }
            }).catch(function(){ grid.style.opacity = '1'; });
    }

    function renderPag(total, cur){
        pag.innerHTML = '';
        if(total<=1) return;
        for(var i=1;i<=total;i++){
            (function(p){
                var btn = document.createElement('button');
                btn.textContent = p;
                if(p===cur) btn.className='active';
                btn.addEventListener('click',function(){doSearch(p);});
                pag.appendChild(btn);
            })(i);
        }
    }

    form.addEventListener('submit',function(e){e.preventDefault();doSearch(1);});
    document.getElementById('lbd-overlay-search-keyword').addEventListener('input',function(){
        clearTimeout(this._t); var self=this; this._t=setTimeout(function(){doSearch(1);},400);
    });
    document.getElementById('lbd-overlay-search-rubro').addEventListener('change',function(){doSearch(1);});
    document.getElementById('lbd-overlay-search-categoria').addEventListener('change',function(){doSearch(1);});
    document.getElementById('lbd-overlay-search-zona').addEventListener('change',function(){doSearch(1);});
})();
</script>

<?php endif; ?>

<?php
get_footer();