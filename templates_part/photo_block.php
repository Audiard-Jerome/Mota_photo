<?php
?>
<div class = "photo_block opacity">
    <?php the_post_thumbnail('medium_large'); ?>
    <a class="iconEye opacity"  href="<?php the_permalink(); ?>"></a>
    <a class="iconFullscreen opacity js-lightbox" href="#lightbox"></a>
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
    <div class="info" 
    data-photourl='<?php the_post_thumbnail('full'); ?>'
    >
    </div>
</div> 

