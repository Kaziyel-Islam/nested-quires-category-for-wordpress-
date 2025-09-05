


<?php get_header(); ?>

<?php

$term = get_queried_object();

// Check if category has child terms

$children = get_terms(array(
    'taxonomy'   => $term->taxonomy,
    'parent'     => $term->term_id,
    'hide_empty' => false,
));

if (!empty($children) && !is_wp_error($children)) {
    // If there are child categories, show them
    echo '<ul class="child-categories">';
    foreach ($children as $child) {
        echo '<li><a href="' . esc_url(get_term_link($child)) . '">';
        echo esc_html($child->name);
        echo '</a></li>';
    }
    echo '</ul>';
} else {
    // No child categories, show posts under this category
    $args = array(
        'post_type' => 'service',        // your custom post type
        'tax_query' => array(
            array(
                'taxonomy' => $term->taxonomy,
                'field'    => 'term_id',
                'terms'    => $term->term_id,
            ),
        ),
        'posts_per_page' => -1,          // show all posts
        'orderby' => 'title',
        'order' => 'ASC',
    );

    $query = new WP_Query($args);

    if ($query->have_posts()) {
        echo '<div class="service-posts">';
        while ($query->have_posts()) {
            $query->the_post(); ?>
            <div class="service-item">
                 <div class="serThumb">
                    <?php the_post_thumbnail('service'); ?>
                </div>
                <h2 class="serTitle"><?php the_title(); ?></h2>
                <p><?php the_excerpt(); ?></p>
            </div>
        <?php }
        echo '</div>';
        wp_reset_postdata(); // reset after custom query
    } else {
        echo '<p>No posts found in this category.</p>';
    }
}
?>


<?php get_footer(); ?>
