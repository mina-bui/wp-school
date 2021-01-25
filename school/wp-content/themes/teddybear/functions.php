<?php
/**
 * Teddybear functions and definitions
 *
 * @link https://developer.wordpress.org/themes/basics/theme-functions/
 *
 * @package Teddybear
 */

if ( ! defined( '_S_VERSION' ) ) {
	// Replace the version number of the theme on each release.
	define( '_S_VERSION', '1.0.0' );
}

if ( ! function_exists( 'teddybear_setup' ) ) :
	/**
	 * Sets up theme defaults and registers support for various WordPress features.
	 *
	 * Note that this function is hooked into the after_setup_theme hook, which
	 * runs before the init hook. The init hook is too late for some features, such
	 * as indicating support for post thumbnails.
	 */
	function teddybear_setup() {
		/*
		 * Make theme available for translation.
		 * Translations can be filed in the /languages/ directory.
		 * If you're building a theme based on Teddybear, use a find and replace
		 * to change 'teddybear' to the name of your theme in all the template files.
		 */
		load_theme_textdomain( 'teddybear', get_template_directory() . '/languages' );

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
		register_nav_menus(
			array(
				'menu-1' => esc_html__( 'Primary', 'teddybear' ),
			)
		);

		/*
		 * Switch default core markup for search form, comment form, and comments
		 * to output valid HTML5.
		 */
		add_theme_support(
			'html5',
			array(
				'search-form',
				'comment-form',
				'comment-list',
				'gallery',
				'caption',
				'style',
				'script',
			)
		);

		// Set up the WordPress core custom background feature.
		add_theme_support(
			'custom-background',
			apply_filters(
				'teddybear_custom_background_args',
				array(
					'default-color' => 'ffffff',
					'default-image' => '',
				)
			)
		);

		// Add theme support for selective refresh for widgets.
		add_theme_support( 'customize-selective-refresh-widgets' );

		/**
		 * Add support for core custom logo.
		 *
		 * @link https://codex.wordpress.org/Theme_Logo
		 */
		add_theme_support(
			'custom-logo',
			array(
				'height'      => 50,
				'width'       => 50,
				'flex-width'  => true,
				'flex-height' => true,
			)
		);
	}
endif;
add_action( 'after_setup_theme', 'teddybear_setup' );

/**
 * Set the content width in pixels, based on the theme's design and stylesheet.
 *
 * Priority 0 to make it available to lower priority callbacks.
 *
 * @global int $content_width
 */
function teddybear_content_width() {
	$GLOBALS['content_width'] = apply_filters( 'teddybear_content_width', 640 );
}
add_action( 'after_setup_theme', 'teddybear_content_width', 0 );

/**
 * Register widget area.
 *
 * @link https://developer.wordpress.org/themes/functionality/sidebars/#registering-a-sidebar
 */
function teddybear_widgets_init() {
	register_sidebar(
		array(
			'name'          => esc_html__( 'Sidebar', 'teddybear' ),
			'id'            => 'sidebar-1',
			'description'   => esc_html__( 'Add widgets here.', 'teddybear' ),
			'before_widget' => '<section id="%1$s" class="widget %2$s">',
			'after_widget'  => '</section>',
			'before_title'  => '<h2 class="widget-title">',
			'after_title'   => '</h2>',
		)
	);
}
add_action( 'widgets_init', 'teddybear_widgets_init' );

/**
 * Enqueue scripts and styles.
 */
function teddybear_scripts() {
	wp_enqueue_style( 'teddybear-style', get_stylesheet_uri(), array(), _S_VERSION );
	wp_style_add_data( 'teddybear-style', 'rtl', 'replace' );

	wp_enqueue_script( 'teddybear-navigation', get_template_directory_uri() . '/js/navigation.js', array(), _S_VERSION, true );

	if ( is_singular() && comments_open() && get_option( 'thread_comments' ) ) {
		wp_enqueue_script( 'comment-reply' );
	}
}
add_action( 'wp_enqueue_scripts', 'teddybear_scripts' );

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

/**
 * Custom Post Types & Taxonomies
 */
require get_template_directory() . '/inc/cpt-taxonomy.php';

// Add Theme Color Meta Tag
function ms_theme_color() {
	echo '<meta name="theme-color" content="$FFF200">';
}
add_action( 'wp_head', 'ms_theme_color' );

// Change the_excerpt length
function ms_excerpt_length( $length ) {
	return 20;
}
add_filter( 'excerpt_length', 'ms_excerpt_length', 999 );

// Change the_excerpt more text
function ms_excerpt_more( $more ) {
	return '... <a class="read-more" href="' . get_permalink() . '"><br>Continue Reading "' . get_the_title() . '"</a>';
}
add_filter( 'excerpt_more', 'ms_excerpt_more' );

// Remove Editor from Homepage
function ms_post_filter( $use_block_editor, $post ) {
	if ( 5 === $post->ID ) {
		return false;
	}
	return $use_block_editor;
}
add_filter( 'use_block_editor_for_post', 'ms_post_filter', 10, 2 );

// Change the_excerpt more text ONLY for "The Class" Students Page
function ms_excerpt_more_students( $more ) {
	return '... <a class="read-more" href="' . get_permalink() . '">';
}
add_filter( 'excerpt_more_students', 'ms_excerpt_more_students' );

// Custom Excerpt function for Advanced Custom Fields - "The Class" Students Page
function custom_field_excerpt() {
	global $post;
	$text = get_field('student_profile_content'); // Function can be reused by replacing content with whatever field you're looking to get the excerpt of
	if ( '' != $text ) {
		$text = strip_shortcodes( $text );
		$text = apply_filters('the_content', $text);
		$text = str_replace(']]>', ']]>', $text);
			$excerpt_length = 25; // 25 words
		$excerpt_more = apply_filters('excerpt_more_students', ' ' . '[...]');
		$text = wp_trim_words( $text, $excerpt_length, $excerpt_more );
	}
	return apply_filters('the_excerpt', $text);
}

// Add New Image Size
function wpse_setup_theme() {
   add_theme_support( 'post-thumbnails' );
   add_image_size( 'student-thumbnails', 200, 300, true );
}
 
add_action( 'after_setup_theme', 'wpse_setup_theme' );

/**
 * Register support for Gutenberg wide images in your theme
 */
function mytheme_setup() {
  add_theme_support( 'align-wide' );
}
add_action( 'after_setup_theme', 'mytheme_setup' );
