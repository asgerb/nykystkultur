<?php
/**
 * Ny Kystkultur functions and definitions
 *
 * @link https://developer.wordpress.org/themes/basics/theme-functions/
 *
 * @package Ny_Kystkultur
 */

if ( ! defined( '_S_VERSION' ) ) {
	// Replace the version number of the theme on each release.
	define( '_S_VERSION', '1.0.0' );
}

/**
 * Sets up theme defaults and registers support for various WordPress features.
 *
 * Note that this function is hooked into the after_setup_theme hook, which
 * runs before the init hook. The init hook is too late for some features, such
 * as indicating support for post thumbnails.
 */
function ny_kystkultur_setup() {
	/*
		* Make theme available for translation.
		* Translations can be filed in the /languages/ directory.
		* If you're building a theme based on Ny Kystkultur, use a find and replace
		* to change 'ny-kystkultur' to the name of your theme in all the template files.
		*/
	load_theme_textdomain( 'ny-kystkultur', get_template_directory() . '/languages' );

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
			'menu-1' => esc_html__( 'Primary', 'ny-kystkultur' ),
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
			'ny_kystkultur_custom_background_args',
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
			'height'      => 250,
			'width'       => 250,
			'flex-width'  => true,
			'flex-height' => true,
		)
	);
}
add_action( 'after_setup_theme', 'ny_kystkultur_setup' );

/**
 * Set the content width in pixels, based on the theme's design and stylesheet.
 *
 * Priority 0 to make it available to lower priority callbacks.
 *
 * @global int $content_width
 */
function ny_kystkultur_content_width() {
	$GLOBALS['content_width'] = apply_filters( 'ny_kystkultur_content_width', 640 );
}
add_action( 'after_setup_theme', 'ny_kystkultur_content_width', 0 );

/**
 * Register widget area.
 *
 * @link https://developer.wordpress.org/themes/functionality/sidebars/#registering-a-sidebar
 */
function ny_kystkultur_widgets_init() {
	register_sidebar(
		array(
			'name'          => esc_html__( 'Sidebar', 'ny-kystkultur' ),
			'id'            => 'sidebar-1',
			'description'   => esc_html__( 'Add widgets here.', 'ny-kystkultur' ),
			'before_widget' => '<section id="%1$s" class="widget %2$s">',
			'after_widget'  => '</section>',
			'before_title'  => '<h2 class="widget-title">',
			'after_title'   => '</h2>',
		)
	);
}
add_action( 'widgets_init', 'ny_kystkultur_widgets_init' );

/**
 * Enqueue scripts and styles.
 */
function ny_kystkultur_scripts() {
	wp_enqueue_style( 'ny-kystkultur-style', get_stylesheet_uri(), array(), _S_VERSION );
	wp_style_add_data( 'ny-kystkultur-style', 'rtl', 'replace' );

	wp_enqueue_script( 'ny-kystkultur-navigation', get_template_directory_uri() . '/js/navigation.js', array(), _S_VERSION, true );

	if ( is_singular() && comments_open() && get_option( 'thread_comments' ) ) {
		wp_enqueue_script( 'comment-reply' );
	}
}
add_action( 'wp_enqueue_scripts', 'ny_kystkultur_scripts' );

function ny_kystkultur_get_the_title($post) {
  $custom_title = get_post_meta( $post, 'custom_title', true );
  if ( !empty($custom_title) ) {
    return $custom_title;
  } else {
    return get_the_title($post);
  }
}

/**
 * Breadcrumbs feature.
 */
function ny_kystkultur_breadcrumbs() {
  $delimiter = ' > ';

  if (is_front_page()) return;

  // Start the breadcrumb with a link to your homepage
  echo '<nav aria-label="breadcrumbs" class="breadcrumbs content-width-m">';
  echo '<a href="'.get_option('home').'">';
  bloginfo('name');
  echo '</a>';
  echo $delimiter;

  $parent = wp_get_post_parent_id(get_the_ID());
  if ($parent) {
    echo '<a href="'.get_permalink( $parent ).'">'.ny_kystkultur_get_the_title($parent).'</a>';
    echo $delimiter;
  }

  // Check if the current page is a category, an archive or a single page. If so show the category or archive name.
  if (is_category() || is_single() ){
    the_category('title_li=');
  } elseif (is_archive() || is_single()){
    if ( is_day() ) {
      printf( __( '%s', 'text_domain' ), get_the_date() );
    } elseif ( is_month() ) {
      printf( __( '%s', 'text_domain' ), get_the_date( _x( 'F Y', 'monthly archives date format', 'text_domain' ) ) );
    } elseif ( is_year() ) {
      printf( __( '%s', 'text_domain' ), get_the_date( _x( 'Y', 'yearly archives date format', 'text_domain' ) ) );
    } else {
      _e( 'Blog Archives', 'text_domain' );
    }
  }

  // If the current page is a single post, show its title with the separator
  if (is_single()) {
    echo ny_kystkultur_get_the_title(get_the_ID());
    // $custom_title = get_post_meta( get_the_ID(), 'custom_title', true );
    // if ( !empty($custom_title) ) {
    //   echo $custom_title;
    // } else {
    //   echo the_title();
    // }
  }

  // If the current page is a static page, show its title.
  if (is_page()) {
    // $custom_title = get_post_meta( get_the_ID(), 'custom_title', true );
    // if ( !empty($custom_title) ) {
    //   echo $custom_title;
    // } else {
    //   echo the_title();
    // }
    echo ny_kystkultur_get_the_title(get_the_ID());
  }

  // if you have a static page assigned to be you posts list page. It will find the title of the static page and display it. i.e Home >> Blog
  if (is_home()){
    global $post;
    $page_for_posts_id = get_option('page_for_posts');
    if ( $page_for_posts_id ) {
      $post = get_post($page_for_posts_id);
      setup_postdata($post);
      the_title();
      rewind_posts();
    }
  }

  echo '</nav>';
}

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
 * Use custom title, if set, to override the page's title.
 */
function modify_document_title( $title ) {
  if ( is_singular() ) {
    $custom_title = get_post_meta( get_the_ID(), 'custom_title', true );

    if ( !empty($custom_title) ) {
      $title['title'] = $custom_title;
    }
  }

  return $title;
}
add_filter( 'document_title_parts', 'modify_document_title' );

/**
 * Add submenu toggle to menu items with children.
 */
class Custom_Walker_Nav_Menu extends Walker_Nav_Menu {
  function start_lvl( &$output, $depth = 0, $args = null ) {
    if ( isset( $args->item_spacing ) && 'discard' === $args->item_spacing ) {
      $t = '';
      $n = '';
    } else {
      $t = "\t";
      $n = "\n";
    }
    $indent = str_repeat( $t, $depth );
    $output .= "{$n}{$indent}<ul class='sub-menu' data-toggle-target='content'>{$n}";
  }

  function start_el( &$output, $item, $depth = 0, $args = null, $id = 0 ) {
    if ( isset( $args->item_spacing ) && 'discard' === $args->item_spacing ) {
      $t = '';
      $n = '';
    } else {
      $t = "\t";
      $n = "\n";
    }
    $indent = ( $depth ) ? str_repeat( $t, $depth ) : '';

    $classes = empty( $item->classes ) ? array() : (array) $item->classes;
    $class_names = join( ' ', apply_filters( 'nav_menu_css_class', array_filter( $classes ), $item, $args, $depth ) );
    $class_names = $class_names ? ' class="' . esc_attr( $class_names ) . '"' : '';

    $has_sub_menu = in_array( 'menu-item-has-children', $item->classes );

    $data = $has_sub_menu ? ' data-controller="toggle"' : '';

    $output .= $indent . '<li' . $data . $class_names .'>';

    $atts = array();
    $atts['title']  = ! empty( $item->attr_title ) ? $item->attr_title : '';
    $atts['target'] = ! empty( $item->target )     ? $item->target     : '';
    $atts['rel']    = ! empty( $item->xfn )        ? $item->xfn        : '';
    $atts['href']   = ! empty( $item->url )        ? $item->url        : '';

    $atts = apply_filters( 'nav_menu_link_attributes', $atts, $item, $args, $depth );

    $attributes = '';
    foreach ( $atts as $attr => $value ) {
      if ( ! empty( $value ) ) {
        $value = ( 'href' === $attr ) ? esc_url( $value ) : esc_attr( $value );
        $attributes .= ' ' . $attr . '="' . $value . '"';
      }
    }

    $title = apply_filters( 'the_title', $item->title, $item->ID );
    $title = apply_filters( 'nav_menu_item_title', $title, $item, $args, $depth );

    $item_output = $args->before;
    $item_output .= '<a'. $attributes .'>';
    $item_output .= $args->link_before . $title . $args->link_after;
    $item_output .= '</a>';

    // Add toggle button if menu item has children
    if ( $has_sub_menu ) {
      $item_output .= '<button class="sub-menu-toggle" aria-label="Toggle submenu" data-toggle-target="button" data-action="click->toggle#toggle">';
      $item_output .= '<svg width="20px" height="20px" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg"><polyline points="4,8 10,15 16,8" fill="none" stroke="black" stroke-width="2"/></svg>';
      $item_output .= '</button>';
    }

    $item_output .= $args->after;

    $output .= apply_filters( 'walker_nav_menu_start_el', $item_output, $item, $depth, $args );
  }
}
