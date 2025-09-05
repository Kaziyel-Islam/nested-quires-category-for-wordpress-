// Nested Categories

<?php

function kaz_nested_categories_shortcode( $atts ) {
    $atts = shortcode_atts( array(
        'taxonomy' => 'service_category', // your custom taxonomy
        'title'    => 'Service Categories',
    ), $atts, 'nested_categories' );

    ob_start();

    echo '<div class="kaz-nested-categories">';
    echo '<h3>' . esc_html( $atts['title'] ) . '</h3>';
    echo '<ul>';

    // Get top-level categories (parent = 0)
    $terms = get_terms( array(
        'taxonomy'   => $atts['taxonomy'],
        'hide_empty' => false,
        'parent'     => 0,
    ));

    if ( !empty($terms) && !is_wp_error($terms) ) {
        foreach ( $terms as $term ) {
            echo '<li><a href="' . esc_url( get_term_link( $term ) ) . '">';
            echo esc_html( $term->name );
            echo '</a></li>';
        }
    }

    echo '</ul>';
    echo '</div>';

    return ob_get_clean();
}
add_shortcode( 'nested_categories', 'kaz_nested_categories_shortcode' );

?>
