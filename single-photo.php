<?php
/**
 * Le modèle de publication unique pour les photos.
 *
 * @package Mona-Photo
 */

get_header();

if (have_posts()) {
    while (have_posts()) {
        the_post();
// Récupérer le titre de la photo
$photo_title = get_the_title();
$post_id = get_the_ID(); // Récupère l'ID de la publication en cours

// Récupérer les taxonomies de la photo
// $taxs = get_terms(['taxonomy' => 'format']);

// Récupérer des groupes de champs personnalisés associés à la photo
$custom_fields = get_post_custom();
$taxonomies_format = get_the_terms( $post->ID, 'custom_format' );
$taxonomies_categorie = get_the_terms( $post->ID, 'custom_categorie' );

        ?>
        <div class="singlePhotoContainer max_width">
            <div class="photoContainer">
                <div class="infoContainer descriptionPhoto">
                    <!-- affiche le Titre -->
                    <h2><?php echo $photo_title; ?></h2> 
                    <!-- affiche le custom field référence -->
                    <?php
                        foreach ($custom_fields as $key => $value) {
                            // Vérifier si la clé est égale à "reference"
                            if ($key === 'reference') {
                            echo '<p>' . $key . ' : <span class="photoRef">' . implode(', ', $value) . '</span></p>';
                            }
                        }
                    ?>
                    <!-- affiche la taxonomie "cathégorie" -->
                    <?php
                       foreach ($taxonomies_categorie as $key) {
                        echo '<p>cathégorie : ' . $key -> name . '</p>';
                       }
                    ?>
                    <!-- affiche la taxonomie "Format" -->
                    <?php
                       foreach ($taxonomies_format as $key) {
                        echo '<p>Format : ' . $key -> name . '</p>';
                       }
                    ?>
                    <!-- affiche le custom field type -->
                    <?php
                        foreach ($custom_fields as $key => $value) {
                            // Vérifier si la clé est égale à "type"
                            if ($key === 'type') {
                            echo '<p>' . $key . ' : ' . implode(', ', $value) . '</p>';
                            }
                        }
                    ?>
                    <!-- affiche la date -->
                    <p>Année : <?php echo get_the_date('Y'); ?></p>
                </div>
                <div class="photo">
                    <?php the_post_thumbnail('large')?>
                </div>
            </div>
            
        <div class="contactContainer">
            <div class="contact">
                <p>Cette photo vous intéresse ?</p>
                <a href="#modal1" class="js-modal btnContact">Contact</a>
            </div>

            <div class="pagination">
                
                <?php
                //récupere les variables
                $prev_post = get_previous_post();
                $next_post = get_next_post();
            
                ?>

                <div class="paginationPhoto">
                    <?php 
                    if ( !empty($prev_post) ) :
                        echo '<div class="paginationPhotoPrev">' . get_the_post_thumbnail( $prev_post->ID, array(80,80) ) . '</div>';
                    endif;
                    if ( !empty($next_post) ) :
                        echo '<div class="paginationPhotoNext">' . get_the_post_thumbnail( $next_post->ID, array(80,80) ) . '</div>';
                    endif;
                    ?>
                </div>
                <div class="paginationBtn">
                    <div class="previousLink">
                    <?php
                    // bouton post précédent

                    // Vérifier si l'article précédent existe.
                    if ($prev_post) {
                        echo '<a href="' . get_permalink($prev_post->ID) . '">';
                        echo '<img src="' . esc_url(get_template_directory_uri() . '/img/photoPrecedente.png') . '" alt="Photo précédente" />';
                        echo '</a>';
                    }
                    ?>
                    </div>
                    <div class="nextLink">
                    <?php
                    //bouton post suivant
                    
                    //vérifier sur l'article suivant existe.
                    if ($next_post) {
                        echo '<a href="' . get_permalink($next_post->ID) . '">';
                        echo '<img src="' . esc_url(get_template_directory_uri() . '/img/photoSuivante.png') . '" alt="Photo suivante" />';
                        echo '</a>';
                    }
                    ?>
                    </div>
                </div> 
            </div>
        </div>
        <div class="otherContainer descriptionPhoto">
            <h3>Vous aimerez aussi</h3>
            <div class="otherThumbnail">
            <?php 

            $categorie = array_map(function ($term) {
                return $term->term_id;
            }, get_the_terms(get_post(), 'custom_categorie'));


            $query = new WP_Query([
                            'post__not_in' => [get_the_ID()],
                            'post_type' => 'photo',
                            'posts_per_page' => 2,
                            'orderby' => 'rand',
                            'tax_query' => [
                                [
                                'taxonomy' => 'custom_categorie',
                                'terms' => $categorie,
                                ]
                             ],
                            ]);
                            while ($query->have_posts()) : $query->the_post();
                            get_template_part('templates_part/photo_block');
                            endwhile;
                             wp_reset_postdata(); ?>
                            
            </div>
        </div>
    </div>


        
        <?php
    }
}

get_footer();