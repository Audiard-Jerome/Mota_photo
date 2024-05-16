<?php

get_header();
?>
<main>
<div>
    <?php get_template_part('templates_part/hero'); ?>
</div>
<section>
    <?php
        the_post();
        // Afficher le titre du post
        the_title('<h2>', '</h2>');
        // Afficher le contenu du post
        the_content();
    ?>
    </div>
</main>
<?php
get_footer();