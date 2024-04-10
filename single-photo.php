<?php
/**
 * Le modèle de publication unique pour les photos.
 *
 * @package votre-theme
 */

get_header();


if (have_posts()) {
    while (have_posts()) {
        the_post();
// Récupérer le titre de la photo
$photo_title = get_the_title();

// Récupérer les taxonomies de la photo
$photo_format = get_the_term_list($post->ID, 'format', '', ', ', '');
$photo_category = get_the_term_list($post->ID, 'categorie', '', ', ', '');

// Récupérer des groupes de champs personnalisés associés à la photo
$custom_fields = get_post_custom();

        ?>
        <div class="singlePhotoContainer">
            <div class="photoContainer">
                <div class="infoContainer descriptionPhoto">
                    <!-- affiche le Titre -->
                    <h2><?php echo $photo_title; ?></h2> 
                    <!-- affiche le custom field référence -->
                    <?php
                        foreach ($custom_fields as $key => $value) {
                            // Vérifier si la clé est égale à "reference"
                            if ($key === 'reference') {
                            echo '<p>' . $key . ': ' . implode(', ', $value) . '</p>';
                            }
                        }
                    ?>
                    <!-- affiche la taxonomie "cathégorie" -->
                    <p>cathégorie :</p>
                    <!-- affiche la taxonomie "Format" -->
                    <p>Format :</p>
                    <!-- affiche le custom field type -->
                    <?php
                        foreach ($custom_fields as $key => $value) {
                            // Vérifier si la clé est égale à "type"
                            if ($key === 'type') {
                            echo '<p>' . $key . ': ' . implode(', ', $value) . '</p>';
                            }
                        }
                    ?>
                    <!-- affiche la date -->
                    <p>Année: <?php echo get_the_date('Y'); ?></p>
                </div>
                <div class="photo">
                    <?php the_post_thumbnail('large')?>
                </div>
            </div>
        <div class="contactContainer">
            <p>Container contact</p>
        </div>
        <div class="otherContainer">
            <p>Autre info</p>
        </div>
    </div>


        
        <?php
    }
}

get_footer();