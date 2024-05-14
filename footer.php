<?php wp_footer(); ?>
<footer>
<?php wp_nav_menu([
				'theme_location' => 'footer_menu',
                "menu-class" => 'menu-footer',
                'container'  => false,
                    ]); 
?>
<?php get_template_part('templates_part/lightbox'); ?>
</footer>
</body>
</html>