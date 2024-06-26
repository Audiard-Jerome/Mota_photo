<!DOCTYPE html>
<html <?php language_attributes(); ?>>
<head>
    <meta charset="<?php bloginfo('charset'); ?>">
    <meta name="viewport" content="width=device-width, initial-scale=1"/>
    <?php wp_head(); ?>
</head>
<body <?php body_class(); ?>>
        <?php wp_body_open(); ?>
                <header>
                    <div class="logo">
                        <?php if ( function_exists( 'the_custom_logo' ) ) {
	                                    the_custom_logo();
                                    }
                        ?>
                    </div>
                    <nav class="menu" role="navigation" >
                        <?php wp_nav_menu([
							'theme_location' => 'header_menu',
                            "menu-class" => 'menuDesktop',
                            'container'  => false,
                            ]); 
                        ?>
                    </nav>   
                    <div class="burger">
                        <span></span>
                    </div>
                    <!-- charge la modale mais ne l'affiche pas -->
                    <?php get_template_part('templates_part/modale'); ?>
                    
                </header>