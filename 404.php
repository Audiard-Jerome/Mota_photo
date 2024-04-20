<?php

get_header();
?>
<main>
<div>
    <?php get_template_part('templates_part/hero'); ?>
</div>
<section class="max_width">
    <h1 >Oops! Page non trouvée</h1>
    <div>
    <p>Désolé, la page que vous recherchez semble introuvable.</p>
    <p>Il est possible que le lien que vous avez suivi soit rompu ou que la page ait été supprimée.</p>
    <p>Vous pouvez essayer de rechercher à nouveau ou revenir à la <a href="<?php echo esc_url( home_url( '/' ) ); ?>">page d'accueil</a>.</p>
    </div>
</section>
</main>
<?php
get_footer();