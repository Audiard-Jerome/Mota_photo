<?php
/**
 * Le modèle de hero.
 *
 * @package mona-photo
 */

$tagline = get_bloginfo('description');

$query = new WP_Query([
                'post_type' => 'photo',
                'posts_per_page' => 1,
                'orderby' => 'rand',
                'tax_query' => [
                    [
                    'taxonomy' => 'custom_format',
                    'field' => 'slug',
                    'terms' => 'paysage',
                    ]
                 ],
                ]);
while ($query->have_posts()) : $query->the_post();
    echo '<div class="containerHero">';
    echo '<h1>' . $tagline . '</h1>';
    the_post_thumbnail('full');
    echo '</div>';
    endwhile;
wp_reset_postdata(); 
?>
