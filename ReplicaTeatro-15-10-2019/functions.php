<?php
/**
 * starter functions and definitions
 *
 * @link https://developer.wordpress.org/themes/basics/theme-functions/
 *
 * @package starter
 */

if ( ! function_exists( 'starter_theme_setup' ) ) :
	/**
	 * Sets up theme defaults and registers support for various WordPress features.
	 *
	 * Note that this function is hooked into the after_setup_theme hook, which
	 * runs before the init hook. The init hook is too late for some features, such
	 * as indicating support for post thumbnails.
	 */
	function starter_theme_setup() {
		/*
		 * Make theme available for translation.
		 * Translations can be filed in the /languages/ directory.
		 * If you're building a theme based on starter, use a find and replace
		 * to change 'starter-theme' to the name of your theme in all the template files.
		 */
		load_theme_textdomain( 'starter-theme', get_template_directory() . '/languages' );

		// Add default posts and comments RSS feed links to head.
		add_theme_support( 'automatic-feed-links' );

		/*
		 * Let WordPress manage the document title.
		 * By adding theme support, we declare that this theme does not use a
		 * hard-coded <title> tag in the document head, and expect WordPress to
		 * provide it for us.
		 */
		add_theme_support( 'title-tag' );

		/*
		 * Enable support for Post Thumbnails on posts and pages.
		 *
		 * @link https://developer.wordpress.org/themes/functionality/featured-images-post-thumbnails/
		 */
		add_theme_support( 'post-thumbnails' );

		// This theme uses wp_nav_menu() in one location.
		register_nav_menus( array(
			'menu-1' => esc_html__( 'Primary', 'starter-theme' ),
		) );

		/*
		 * Switch default core markup for search form, comment form, and comments
		 * to output valid HTML5.
		 */
		add_theme_support( 'html5', array(
			'search-form',
			'comment-form',
			'comment-list',
			'gallery',
			'caption',
		) );

		// Set up the WordPress core custom background feature.
		add_theme_support( 'custom-background', apply_filters( 'starter_theme_custom_background_args', array(
			'default-color' => 'ffffff',
			'default-image' => '',
		) ) );

		// Add theme support for selective refresh for widgets.
		add_theme_support( 'customize-selective-refresh-widgets' );

		/**
		 * Add support for core custom logo.
		 *
		 * @link https://codex.wordpress.org/Theme_Logo
		 */
		add_theme_support( 'custom-logo', array(
			'height'      => 250,
			'width'       => 250,
			'flex-width'  => true,
			'flex-height' => true,
		) );
	}
endif;

$sage_includes = [
  'lib/dashboard/rc-admin.php',
  'lib/dashboard/rc-dashboard.php',
];

foreach ($sage_includes as $file) {
    if (!$filepath = locate_template($file)) {
        trigger_error(sprintf(__('Error locating %s for inclusion', 'sage'), $file), E_USER_ERROR);
    }

    require_once $filepath;
}
unset($file, $filepath);

add_action( 'after_setup_theme', 'starter_theme_setup' );

/**
 * Set the content width in pixels, based on the theme's design and stylesheet.
 *
 * Priority 0 to make it available to lower priority callbacks.
 *
 * @global int $content_width
 */
function starter_theme_content_width() {
	// This variable is intended to be overruled from themes.
	// Open WPCS issue: {@link https://github.com/WordPress-Coding-Standards/WordPress-Coding-Standards/issues/1043}.
	// phpcs:ignore WordPress.NamingConventions.PrefixAllGlobals.NonPrefixedVariableFound
	$GLOBALS['content_width'] = apply_filters( 'starter_theme_content_width', 640 );
}
add_action( 'after_setup_theme', 'starter_theme_content_width', 0 );

/**
 * Register widget area.
 *
 * @link https://developer.wordpress.org/themes/functionality/sidebars/#registering-a-sidebar
 */
function starter_theme_widgets_init() {
	register_sidebar( array(
		'name'          => esc_html__( 'Sidebar', 'starter-theme' ),
		'id'            => 'sidebar-1',
		'description'   => esc_html__( 'Add widgets here.', 'starter-theme' ),
		'before_widget' => '<section id="%1$s" class="widget %2$s">',
		'after_widget'  => '</section>',
		'before_title'  => '<h2 class="widget-title">',
		'after_title'   => '</h2>',
	) );


	register_sidebar(array (
            'name' 						=> esc_html__( 'Custom', 'starter-theme' ),
            'id' 						=> 'custom-side-bar',
            'description' 				=> esc_html__( 'Custom Sidebar', 'starter-theme' ),
            'before_widget' 			=> '<section id="%1$s" class="widget %2$s">',
            'after_widget' 				=> "</seciton>",
            'before_title' 				=> '<h2 class="widget-title">',
            'after_title' 				=> '</h2>',
    ) );

/* Register dynamic sidebar 'new_sidebar' */

    register_sidebar(array(
       		'id' 			=> 'new_sidebar',
       		'name' 			=> __( 'New Sidebar' ),
        	'description' 	=> __( 'A short description of the sidebar.' ),
            'before_widget' 			=> '<section id="%1$s" class="widget %2$s">',
            'after_widget' 				=> "</seciton>",
            'before_title' 				=> '<h2 class="widget-title">',
            'after_title' 				=> '</h2>',
    )
    );

        register_sidebar(array(
       		'id' 			=> 'new_sidebar2',
       		'name' 			=> __( 'New Sidebar2' ),
        	'description' 	=> __( 'A short description of the sidebar.' ),
            'before_widget' 			=> '<section id="%1$s" class="widget %2$s">',
            'after_widget' 				=> "</seciton>",
            'before_title' 				=> '<h2 class="widget-title">',
            'after_title' 				=> '</h2>',
    )
    );

/* Repeat the code pattern above for additional sidebars. */

    
}
add_action( 'widgets_init', 'starter_theme_widgets_init' );


/**
 * Enqueue scripts and styles.
 */
function starter_theme_scripts() {
	////JQUERY UI//
	wp_enqueue_style( 'jquery-ui', get_template_directory_uri() .'/css/jquery-ui.css',false,'1.1','all');
	wp_enqueue_style( 'jquery-ui.theme', get_template_directory_uri() .'/css/jquery-ui.theme.css',false,'1.1','all');
	wp_enqueue_style( 'jquery-ui.structure', get_template_directory_uri() .'/css/jquery-ui.structure.css',false,'1.1','all');		

	wp_register_script( 'jquery-ui', 'https://code.jquery.com/ui/1.12.1/jquery-ui.js', null, null, true );
	////JQUERY UI//

	//STYLE//
	wp_enqueue_style( 'starter-theme-style', get_template_directory_uri() .'/css/style.css',false,'1.1','all');
	//STYLE//

	//MARQUEE//
	wp_enqueue_script( 'marquee', get_template_directory_uri() . '/js/marquee3k.js', array ( 'jquery' ), 1.1, true);
	//MARQUEE//

	//COOKIE//
	wp_enqueue_script( 'cookie', get_template_directory_uri() . '/js/jquery.ihavecookies.js', array ( 'jquery' ), 1.1, true);
	//COOKIE//

	//LATERAL MENU//
	wp_enqueue_script( 'lateral_menu', get_template_directory_uri() . '/js/lateral_menu_collapse.js', array ( 'jquery' ), 1.1, true);
	//LATERAL MENU//

	////FLEXBOXGRID//
	wp_register_style( 'flexboxgrid', 'https://cdnjs.cloudflare.com/ajax/libs/flexboxgrid/6.3.1/flexboxgrid.min.css' );
	wp_enqueue_style('flexboxgrid');
	////FLEXBOXGRID//

	////FANCYBOX//
	wp_register_style( 'fancybox-css', 'https://cdn.jsdelivr.net/gh/fancyapps/fancybox@3.5.7/dist/jquery.fancybox.min.css' );
	wp_enqueue_style('fancybox-css');
	
	wp_register_script( 'fancybox-js', 'https://cdn.jsdelivr.net/gh/fancyapps/fancybox@3.5.7/dist/jquery.fancybox.min.js', null, null, true );
		wp_enqueue_script('fancybox-js');
	////FANCYBOX//

	////FULLPAGE//
	wp_register_style( 'swiper-css', 'https://cdnjs.cloudflare.com/ajax/libs/Swiper/4.5.0/css/swiper.min.css' );
	wp_enqueue_style('swiper-css');
	wp_register_script( 'swiper-js', 'https://cdnjs.cloudflare.com/ajax/libs/Swiper/4.5.0/js/swiper.min.js', null, null, true );
		wp_enqueue_script('swiper-js');
	////FULLPAGE//
	
	////ACCORDION//
	wp_enqueue_script( 'accordion', get_template_directory_uri() . '/js/accordion.js', array ( 'jquery' ), 1.1, true);
	////ACCORDION//




	wp_enqueue_script( 'starter-theme-navigation', get_template_directory_uri() . '/js/navigation.js', array(), '20151215', true );

	wp_enqueue_script( 'starter-theme-skip-link-focus-fix', get_template_directory_uri() . '/js/skip-link-focus-fix.js', array(), '20151215', true );

	if ( is_singular() && comments_open() && get_option( 'thread_comments' ) ) {
		wp_enqueue_script( 'comment-reply' );
	}
}
add_action( 'wp_enqueue_scripts', 'starter_theme_scripts' );

/**
 * Implement the Custom Header feature.
 */
require get_template_directory() . '/inc/custom-header.php';

/**
 * Custom template tags for this theme.
 */
require get_template_directory() . '/inc/template-tags.php';

/**
 * Functions which enhance the theme by hooking into WordPress.
 */
require get_template_directory() . '/inc/template-functions.php';

/**
 * Customizer additions.
 */
require get_template_directory() . '/inc/customizer.php';

/**
 * Load Jetpack compatibility file.
 */
if ( defined( 'JETPACK__VERSION' ) ) {
	require get_template_directory() . '/inc/jetpack.php';
}


/* CRUZESTUDIO*/

function jose_scripts(){
	wp_enqueue_script('a_calendario_ajax', get_template_directory_uri() . '/js/a_calendario_ajax.js', array('jquery'));
	wp_localize_script('a_calendario_ajax','dcms_vars',['ajaxurl'=>admin_url('admin-ajax.php')]);
}

add_action('wp_enqueue_scripts', 'jose_scripts');
add_action('admin_enqueue_scripts', 'jose_scripts');



//Devolver datos a archivo js
add_action('wp_ajax_nopriv_obtener_eventos_teatro','obtener_eventos_teatro');
add_action('wp_ajax_obtener_eventos_teatro','obtener_eventos_teatro');

function obtener_eventos_teatro()
{
	require (__DIR__ . '/lib/a_calendario_ajax.php');
	echo enviar_eventos_del_mes($_POST['mes_calendario']);
	die();
}


add_action( 'init', 'create_cpt_evento_teatro' );
function create_cpt_evento_teatro() {
	$args = array(
		'public' => true,
		'label' => 'Eventos'
	);
	register_post_type( 'eventos', $args );
}





