<!DOCTYPE html>
<html <?php language_attributes(); ?>>
<head>
    <meta charset="<?php bloginfo('charset'); ?>">
    <meta name="viewport" content="width=device-width, initial-scale=1"/>
    <title>Nathalie Mota Photo</title>
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
                        <nav id="menu" role="navigation" >
                            <?php wp_nav_menu([
							    'theme_location' => 'header_menu',
                                "menu-class" => 'menu-item',
                                'container'  => false,
                                ]); 
                            ?>
                            <div class="burger">
                                <span></span>
                            </div>
                        </nav>    
                </header>