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

//Charge le script Ajax.js et création de ajaxurl et ajaxNonce

function ajax_enqueue_scripts() {
    wp_enqueue_script('custom-ajax', get_template_directory_uri() . '/js/ajax.js', array(), '1.0', true);
	wp_add_inline_script( 'custom-ajax', 'const MYSCRIPT = ' . json_encode( array(
		'ajaxurl' => admin_url( 'admin-ajax.php' ),
        'ajaxNonce' => wp_create_nonce( 'ajaxNonce' )
        // 'ajaxNonce' => 'test'
	) ), 'before' );
}

add_action('wp_enqueue_scripts', 'ajax_enqueue_scripts');

// post ajax
add_action('wp_ajax_load_more_photos', 'load_more_photos');
add_action('wp_ajax_nopriv_load_more_photos', 'load_more_photos');

add_action('wp_ajax_load_filtre_photos', 'load_filtre_photos');
add_action('wp_ajax_nopriv_load_filtre_photos', 'load_filtre_photos');

function load_more_photos() {
    //vérifie le jeton nonce
    check_ajax_referer( 'ajaxNonce', 'nonce');

    $categorie = array('concert', 'mariage', 'reception', 'television');
    $format = array('paysage', 'portrait');
    $order = 'DESC';
    $nbrPost = '8'; //nombre de post en plus quand on clic sur le btn
    //$nbrPostOrigin = '8' //nombre de post a l'origine
    $index = isset($_POST['index']) ? sanitize_text_field($_POST['index']) : null;
    $offset = $nbrPostOrigin + ($nbrPost * ($index)); // calcul de l'offset a revoir

    $query = new WP_Query([
        'post_type' => 'photo',
        'posts_per_page' => $nbrPost,
        'order' => $order,
        'orderby' => 'date',
        'offset' => $offset,
        'tax_query' => array(
            'relation' => 'AND',
            array(
                'taxonomy' => 'custom_categorie',
                'field' => 'slug',
                'terms' => $categorie,
            ),
            array(
                'taxonomy' => 'custom_format',
                'field' => 'slug',
                'terms' => $format,
            )
        ),
    ]);

    $posts = array();
    while ($query->have_posts()) : $query->the_post();
        ob_start();
        get_template_part('templates_part/photo_block');
        $posts[] = ob_get_clean();
    endwhile;

    $totalPosts = $query->found_posts; // Nombre total de publications correspondantes à la requête

    $response = array(
        'posts' => $posts,
        'has_more_posts' => ($totalPosts > $offset + $nbrPost) // Vérifie s'il y a encore des publications à charger
    );

    echo json_encode($response);

    exit;
}



//fonction filtre
function load_filtre_photos() {
    //vérifie le jeton nonce
    check_ajax_referer( 'ajaxNonce', 'nonce');

    $categorie = isset($_POST['valeurFiltreCategorie']) && !empty($_POST['valeurFiltreCategorie']) ? sanitize_text_field($_POST['valeurFiltreCategorie']) : array('concert', 'mariage', 'reception', 'television');
    $format = isset($_POST['valeurFiltreFormat']) && !empty($_POST['valeurFiltreFormat'])? sanitize_text_field($_POST['valeurFiltreFormat']) : array('paysage', 'portrait');
    $order = isset($_POST['valeurFiltreTrier']) && !empty($_POST['valeurFiltreTrier'])? sanitize_text_field($_POST['valeurFiltreTrier']) : 'DESC';
    $nbrPost = '8'; //nombre de post en plus quand on clic sur le btn
    $nbrPostOrigin = '8'; //nombre de post a l'origine
    $index = isset($_POST['index']) ? sanitize_text_field($_POST['index']) : null;
    $offset = $nbrPostOrigin + ($nbrPost * ($index - 1)); // calcul de l'offset

    $query = new WP_Query([
        'post_type' => 'photo',
        'posts_per_page' => '8',
        'order' => $order,
        'orderby' => 'date',
        'offset' => '0',
        'tax_query' => array(
            'relation' => 'AND',
            array(
                'taxonomy' => 'custom_categorie',
                'field' => 'slug',
                'terms' => $categorie,
            ),
            array(
                'taxonomy' => 'custom_format',
                'field' => 'slug',
                'terms' => $format,
            )
        ),
    ]);

    $posts = array();
    while ($query->have_posts()) : $query->the_post();
        ob_start();
        get_template_part('templates_part/photo_block');
        $posts[] = ob_get_clean();
    endwhile;

    $totalPosts = $query->found_posts; // Nombre total de publications correspondantes à la requête

    $response = array(
        'posts' => $posts,
        'has_more_posts' => ($totalPosts > $offset + $nbrPost) // Vérifie s'il y a encore des publications à charger
    );

    echo json_encode($response);

    exit;
}