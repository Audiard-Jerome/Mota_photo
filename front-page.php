<?php get_header(); ?>
<main>
<!-- Recuperer le block hero -->
<?php get_template_part('templates_part/hero'); ?>

<div class="filtreContainer">
        <div class="filtreCategorie flexColumn filtre">
        <p class="btnFiltre ">Catégories<span class="chevron"></span></p>
        <div class="filtreItems">
            <!-- récuperer tout les termes de la taxonomie custom_categorie -->         
            <?php $custom_categories = get_terms(['taxonomy' => 'custom_categorie']);
            $categorie = array(); 
            foreach($custom_categories as $custom_categorie):
                echo '<p class="filtreItem" data-categorie="' . $custom_categorie->slug . '">' . $custom_categorie->name . '</p>';
                $categorie[] = $custom_categorie->name; // stock tout les termes de la taxonomie catégorie dans une variable
            endforeach;
            ?>
        </div>
    </div>
    <div class="filtreFormat flexColumn filtre">
        <p class="btnFiltre">Formats<span class="chevron"></span></p>
        <div class="filtreItems">
            <!-- récuperer tout les termes de la taxonomie custom_format -->         
            <?php $custom_formats = get_terms(['taxonomy' => 'custom_format']);
            $format = array();
            foreach($custom_formats as $custom_format):
                echo '<p class="filtreItem" data-format="' . $custom_format->slug . '">' . $custom_format->name . '</p>';
                $format[] = $custom_format->name;// stock tout les termes de la taxonomie format dans une variable
            endforeach;
            ?>
        </div>
    </div>
    <div class="filtreTrier flexColumn filtre">
        <p class="btnFiltre">Trier par<span class="chevron"></span></p>
        <div class="filtreItems">
            <p class="filtreItem" data-trier="desc" >A partir des plus récentes</p>
            <p class="filtreItem" data-trier="asc" >A partir des plus anciennes</p>
        </div>
    </div>
</div>

<div id="posts-container" class="CatalogueContainer">
<?php 

// load_filtre_photos()
$query = new WP_Query([
    'post_type' => 'photo',
    'posts_per_page' => '8',
    'order' => 'DESC',
    'orderby' => 'date',
    'post_status' => 'publish',
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
    wp_reset_postdata(); 
    
    ?>
</div>
<div class="btnContainer">
    <button id="load-more-btn" class="btn">Charger plus</button> 
</div>




</main>

<?php get_footer(); ?>