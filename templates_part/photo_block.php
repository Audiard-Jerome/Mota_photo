<?php
/**
 * Template part for displaying photo.
 *
 * @package Mona-photo
 */
?>
<div class = "photo_block opacity">
    <?php the_post_thumbnail('medium_large'); ?>
    <div class="iconEye opacity"></div>
    <div class="iconFullscreen opacity"></div>
    <div class="refPhoto txt opacity">
    <?php
        $custom_fields = get_post_custom();
        foreach ($custom_fields as $key => $value) {
            if ($key === 'reference') {
            echo implode(', ', $value);
             }
        }
    ?>
    </div>
    <div class="catPhoto txt opacity">
        <?php
        $taxonomies_categorie = get_the_terms( $post->ID, 'custom_categorie' );
            foreach ($taxonomies_categorie as $key) {
            echo $key -> name;
            }
                    
        ?>
    </div>
</div> 

