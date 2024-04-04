<?php 

//  Ajouter CSS + JS
add_action( 'wp_enqueue_scripts', 'theme_enqueue_styles' );
function theme_enqueue_styles(){
    wp_enqueue_style('parent-style', get_template_directory_uri() . '/style.css');
	wp_enqueue_style('theme-style', get_stylesheet_directory_uri() . '/css/theme.min.css', array(), filemtime(get_stylesheet_directory() . '/css/theme.min.css'));
	wp_enqueue_script( 'script', get_stylesheet_directory_uri() . '/js/burger.js', array(), filemtime(get_stylesheet_directory() . '/js/burger.js'), true );
}



// Ajouter la prise en charge des images mises en avant
add_theme_support( 'post-thumbnails' );

// Ajouter le custom logo.
function mota_custom_logo_setup() {
	$defaults = array(
		'height'               => 22,
		'width'                => 345,
		'flex-height'          => true,
		'flex-width'           => true,
		'header-text'          => array( 'site-title', 'site-description' ),
		'unlink-homepage-logo' => true, 
	);
	add_theme_support( 'custom-logo', $defaults );
}
add_action( 'after_setup_theme', 'mota_custom_logo_setup' );

// Menu
function mota_menu() {
	add_theme_support('menu');
	register_nav_menus( array( 
                        'header_menu' => 'En tête du menu',
                        'footer_menu'  => 'Pied de page',
    ));
}
add_action( 'after_setup_theme', 'mota_menu' );

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

//Cacher le spinner de WPCF7
add_filter( 'wpcf7_load_js', '__return_false' );
