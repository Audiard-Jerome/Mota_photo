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
    //Script JS Lightbox
    wp_enqueue_script( 'script_lightbox', get_stylesheet_directory_uri() . '/js/lightbox.js', array(), filemtime(get_stylesheet_directory() . '/js/lightbox.js'), true );
}

// Ajouter la prise en charge des images mises en avant
add_theme_support( 'post-thumbnails' );
add_theme_support( "title-tag" );


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

//Charge le script Ajax.js et création de ajaxurl et ajaxNonce

function ajax_enqueue_scripts() {
    if ( is_front_page() ) {
    wp_enqueue_script('custom-ajax', get_template_directory_uri() . '/js/ajax.js', array(), '1.0', true);
	wp_add_inline_script( 'custom-ajax', 'const MYSCRIPT = ' . json_encode( array(
		'ajaxurl' => admin_url( 'admin-ajax.php' ),
        'ajaxNonce' => wp_create_nonce( 'ajaxNonce' )
        // 'ajaxNonce' => 'test'
	) ), 'before' );
    }   ;
}

add_action('wp_enqueue_scripts', 'ajax_enqueue_scripts');

// post ajax

add_action('wp_ajax_load_filtre_photos', 'load_filtre_photos');
add_action('wp_ajax_nopriv_load_filtre_photos', 'load_filtre_photos');


//fonction filtre
function load_filtre_photos() {
    //vérifie le jeton nonce
    check_ajax_referer( 'ajaxNonce', 'nonce');

    $custom_categories = get_terms(['taxonomy' => 'custom_categorie']);
    $categorie = array(); 
    foreach($custom_categories as $custom_categorie):
        $categorie[] = $custom_categorie->name; // stock tout les termes de la taxonomie catégorie dans une variable
    endforeach;
    
    $custom_formats = get_terms(['taxonomy' => 'custom_format']);
    $format = array();
    foreach($custom_formats as $custom_format):
        $format[] = $custom_format->name;// stock tout les termes de la taxonomie format dans une variable
    endforeach;

    $filtreCategorie = isset($_POST['valeurFiltreCategorie']) && !empty($_POST['valeurFiltreCategorie']) ? sanitize_text_field($_POST['valeurFiltreCategorie']) : $categorie;
    $filtreFormat = isset($_POST['valeurFiltreFormat']) && !empty($_POST['valeurFiltreFormat'])? sanitize_text_field($_POST['valeurFiltreFormat']) : $format;
    $order = isset($_POST['valeurFiltreTrier']) && !empty($_POST['valeurFiltreTrier'])? sanitize_text_field($_POST['valeurFiltreTrier']) : 'DESC';
    $offset = isset($_POST['nbrPhotoAffiche']) && !empty($_POST['nbrPhotoAffiche'])? sanitize_text_field($_POST['nbrPhotoAffiche']) : '0';
    $nbrPhotoAffiche = $offset + 8;
    $query = new WP_Query([
        'post_type' => 'photo',
        'posts_per_page' => '8',
        'order' => $order,
        'orderby' => 'date',
        'offset' => $offset,
        'post_status' => 'publish',
        'tax_query' => array(
            'relation' => 'AND',
            array(
                'taxonomy' => 'custom_categorie',
                'field' => 'slug',
                'terms' => $filtreCategorie,
            ),
            array(
                'taxonomy' => 'custom_format',
                'field' => 'slug',
                'terms' => $filtreFormat,
            )
        ),
    ]);

    $posts = array();
    
    if ($query->have_posts()) {
        while ($query->have_posts()) : $query->the_post();
            ob_start();
            get_template_part('templates_part/photo_block');
            $posts[] = ob_get_clean();
        endwhile;
    } else {
        ob_start();
        echo 'Aucune photo trouvée. Essayez de changer de critères.';
        $posts[] = ob_get_clean();
    }

    $totalPosts = $query->found_posts; // Nombre total de publications correspondantes à la requête

    $response = array(
        'posts' => $posts,
        'has_more_posts' => ($totalPosts > $nbrPhotoAffiche), // Vérifie s'il y a encore des publications à charger
        'nbrPhoto' => $nbrPhotoAffiche
    );

    echo json_encode($response);

    exit;

    wp_die();
}