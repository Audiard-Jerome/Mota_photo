<?php get_header(); ?>
<main>
<!-- Recuperer le block hero -->
<?php get_template_part('templates_part/hero'); ?>

<div class="filtreContainer">
        <div class="filtreCategorie flexColumn">
        <p class="btnFiltre">catégories</p>
        <!-- récuperer tout les termes de la taxonomie custom_categorie -->         
        <?php $custom_categories = get_terms(['taxonomy' => 'custom_categorie']);
        foreach($custom_categories as $custom_categorie):
            echo '<p class="filtreItems" data-categorie="' . $custom_categorie->slug . '">' . $custom_categorie->name . '</p>';
        endforeach;
        ?>
    </div>
    <div class="filtreFormat flexColumn">
        <p class="btnFiltre">Format</p>
        <!-- récuperer tout les termes de la taxonomie custom_format -->         
        <?php $custom_formats = get_terms(['taxonomy' => 'custom_format']);
        foreach($custom_formats as $custom_format):
            echo '<p class="filtreItems" data-format="' . $custom_format->slug . '">' . $custom_format->name . '</p>';
        endforeach;
        ?>
    </div>
    <div class="filtreTrier flexColumn">
        <p class="btnFiltre">Tier par</p>
        <p class="filtreItems" data-trier="desc" >A partir des plus récentes</p>
        <p class="filtreItems" data-trier="asc" >A partir des plus anciennes</p>
    </div>
</div>

<div id="posts-container" class="CatalogueContainer">
<?php 
//catégorie a afficher
$categorie = array('concert', 'mariage', 'reception', 'television');
//format a afficher
$format = array('paysage', 'portrait');
//ordre 'DESC' = décroissant 'ASC' = croissant
$order = 'DESC';
//Nombre de photo a afficher
$nbrPost = '8';

$query = new WP_Query([
    'post_type' => 'photo',
    'posts_per_page' => $nbrPost,
    'order' => $order,
    'orderby' => 'date',
    'tax_query' => array(
        'relation' => 'AND',
        array(
            'taxonomy' => 'custom_categorie',
            'field' => 'slug',
            'terms' => $categorie,
        ),
        array(
            'taxonomy' => 'custom_format',
            'field' => 'slug',
            'terms' => $format,
        )
        ),
    ]);
    while ($query->have_posts()) : $query->the_post();
        get_template_part('templates_part/photo_block');
    endwhile;
    wp_reset_postdata(); ?>
</div>
<div class="btnContainer">
    <button id="load-more-btn" class="btn">Charger plus</button> 
</div>

</main>

<?php get_footer(); ?>