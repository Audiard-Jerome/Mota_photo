<?php get_header(); ?>

<!-- Recuperer le block hero -->
<?php get_template_part('templates_part/hero'); ?>

<div class="filtreContainer">
        <div class="filtreCategorie flexColumn">
        <p class="btnFiltre">catégories</p>
        <!-- récuperer tout les termes de la taxonomie custom_categorie -->         
        <?php $custom_categories = get_terms(['taxonomy' => 'custom_categorie']);
        foreach($custom_categories as $custom_categorie):
            echo '<p class="filtreItems">' . $custom_categorie->name . '</p>';
        endforeach;
        ?>
    </div>
    <div class="filtreFormat flexColumn">
        <p class="btnFiltre">Format</p>
        <!-- récuperer tout les termes de la taxonomie custom_format -->         
        <?php $custom_formats = get_terms(['taxonomy' => 'custom_format']);
        foreach($custom_formats as $custom_format):
            echo '<p class="filtreItems">' . $custom_format->name . '</p>';
        endforeach;
        ?>
    </div>
    <div class="filtreTrier flexColumn">
        <p class="btnFiltre">Tier par</p>
        <p class="filtreItems">A partir des plus récentes</p>
        <p class="filtreItems">A partir des plus anciennes</p>
    </div>
</div>

<div class="CatalogueContainer">
<?php 
$query = new WP_Query([
    'post_type' => 'photo',
    'posts_per_page' => 8,
    'orderby' => 'date',
    // 'tax_query' => [
    //     [
    //     'taxonomy' => 'custom_categorie',
    //     'terms' => $categorie,
    //     ],
    //     [
    //     'taxonomy' => 'custom_format',
    //     'terms' => $format,
    //         ]
    // ],
    ]);
    while ($query->have_posts()) : $query->the_post();
        get_template_part('templates_part/photo_block');
    endwhile;
    wp_reset_postdata(); ?>
</div>

<div class="btnContainer">
    <div class="btn">Charger plus</div>
</div>



<?php get_footer(); ?>