<?php
/**
 * Template Name: Business Archive
 * Template for displaying business listings archive and taxonomy pages
 */

get_header();

$taxonomy_name = '';
$taxonomy_title = '';
$taxonomy_description = '';

if ( is_tax( 'business_rubro' ) ) {
    $term = get_queried_object();
    $taxonomy_name = 'business_rubro';
    $taxonomy_title = $term->name;
    $taxonomy_description = $term->description;
} elseif ( is_tax( 'business_categoria' ) ) {
    $term = get_queried_object();
    $taxonomy_name = 'business_categoria';
    $taxonomy_title = $term->name;
    $taxonomy_description = $term->description;
} elseif ( is_tax( 'business_zona' ) ) {
    $term = get_queried_object();
    $taxonomy_name = 'business_zona';
    $taxonomy_title = $term->name;
    $taxonomy_description = $term->description;
}
?>

<div class="lbd-single-wrapper">

    <!-- Header -->
    <div class="lbd-archive-header">
        <?php if ( $taxonomy_title ) : ?>
            <h1><?php echo esc_html( $taxonomy_title ); ?></h1>
            <?php if ( $taxonomy_description ) : ?>
                <p><?php echo esc_html( $taxonomy_description ); ?></p>
            <?php endif; ?>
        <?php else : ?>
            <h1>Directorio de Negocios</h1>
            <p>Encontrá los mejores negocios de tu zona</p>
        <?php endif; ?>
    </div>

    <!-- Search Shortcode -->
    <?php echo do_shortcode( '[business_directory_search]' ); ?>

</div>

<?php get_footer();