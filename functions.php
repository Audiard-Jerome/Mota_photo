<?php 

//  Ajouter CSS + JS
add_action( 'wp_enqueue_scripts', 'theme_enqueue_styles' );
function theme_enqueue_styles(){
	//css du theme
	wp_enqueue_style('theme-style', get_stylesheet_directory_uri() . '/css/theme.min.css', array(), filemtime(get_stylesheet_directory() . '/css/theme.min.css'));
	//Script JS menu burger
	wp_enqueue_script( 'script_burger', get_stylesheet_directory_uri() . '/js/burger.js', array(), filemtime(get_stylesheet_directory() . '/js/burger.js'), true );
	//Script JS modale
	wp_enqueue_script( 'script_modale', get_stylesheet_directory_uri() . '/js/scripts.js', array(), filemtime(get_stylesheet_directory() . '/js/scripts.js'), true );
	//Script JS gestion du survol des liens de navigation dans la page d'info d'une photo.
	wp_enqueue_script( 'script_mouseover', get_stylesheet_directory_uri() . '/js/mouseover.js', array(), filemtime(get_stylesheet_directory() . '/js/mouseover.js'), true );
}

// Ajouter la prise en charge des images mises en avant
add_theme_support( 'post-thumbnails' );

// Ajouter le custom logo.
function mota_custom_logo_setup() {
	$defaults = array(
		'flex-height'          => true,
		'flex-width'           => true,
		'unlink-homepage-logo' => true, 
	);
	add_theme_support( 'custom-logo', $defaults );
}
add_action( 'after_setup_theme', 'mota_custom_logo_setup' );

// custom logo on login page
function mota_custom_logo_login() {
	if ( has_custom_logo() ) :
		$image = wp_get_attachment_image_src( get_theme_mod( 'custom_logo' ), 'full' );
		?>
		<style type="text/css">
			.login h1 a {
				background-image: url(<?php echo esc_url( $image[0] ); ?>);
				-webkit-background-size: <?php echo absint( $image[1] )?>px;
				background-size: <?php echo absint( $image[1] ) ?>px;
				height: <?php echo absint( $image[2] ) ?>px;
				width: <?php echo absint( $image[1] ) ?>px;
			}
		</style>
		<?php
	endif;
}

add_action( 'login_head', 'mota_custom_logo_login', 100 );

// Ajout des Menus dans le header et le fotter
function mota_menu() {
	add_theme_support('menu');
	register_nav_menus( array( 
                        'header_menu' => 'En tête du menu',
                        'footer_menu'  => 'Pied de page',
    ));
}
add_action( 'after_setup_theme', 'mota_menu' );

// Ajout du bouton contact dans le menu header.
function add_custom_menu_header_item($items, $args) {
    if ($args->theme_location == 'header_menu') { 
        $items .= '<li class="menu-item menu-item-type-post_type menu-item-object-page js-modal"><a href="#modal1">Contact</a></li>';
    }
    return $items;
}
add_filter('wp_nav_menu_items', 'add_custom_menu_header_item', 10, 2);

// Ajout du texte tout droits réservé dans le menu footer
function add_custom_menu_footer_item($items, $args) {
    if ($args->theme_location == 'footer_menu') { 
        $items .= '<li class="menu-item menu-item-type-post_type menu-item-object-page"><p>Tous droits réservés</p></li>';
    }
    return $items;
}
add_filter('wp_nav_menu_items', 'add_custom_menu_footer_item', 10, 2);

// Bloque JS et CSS de WPCF7. Le JC et CSS n'est chargé que lorsqu'on charge la modale
add_filter( 'wpcf7_load_js', '__return_false' );
add_filter( 'wpcf7_load_css', '__return_false' );

