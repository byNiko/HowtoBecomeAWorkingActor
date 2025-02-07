<?php

/**
 * byniko functions and definitions
 *
 * @link https://developer.wordpress.org/themes/basics/theme-functions/
 *
 * @package byniko
 */

if (!defined('_S_VERSION')) {
	// Replace the version number of the theme on each release.
	define('_S_VERSION', '1.0.0');
}

require __DIR__ . '/inc/autoload.php';
require __DIR__ . '/inc/Byniko.php';



/*
|--------------------------------------------------------------------------
| Register Theme Files 
|--------------------------------------------------------------------------
| Simply add (or remove) files from the array below to change what
| is registered alongside this theme.
|
*/

$include_theme_customizations = [
	'template-functions',
	'template-tags'
];
foreach ($include_theme_customizations as $file) {
	if (!locate_template($file = "inc/{$file}.php", true, true)) {
		wp_die(
			/* translators: %s is replaced with the relative file path */
			sprintf(__('Error locating <code>%s</code> for inclusion.', 'sage'), $file)
		);
	}
};

/*
|--------------------------------------------------------------------------
| Register PMPRO Files 
|--------------------------------------------------------------------------
*/

$include_pmpro_customizations = [
	"Byniko_Membership"
];
foreach ($include_pmpro_customizations as $file) {
	if (!locate_template($file = "inc/Byniko_Membership/{$file}.php", true, true)) {
		wp_die(
			/* translators: %s is replaced with the relative file path */
			sprintf(__('Error locating <code>%s</code> for inclusion.', 'sage'), $file)
		);
	}
};

/**
 * Sets up theme defaults and registers support for various WordPress features.
 *
 * Note that this function is hooked into the after_setup_theme hook, which
 * runs before the init hook. The init hook is too late for some features, such
 * as indicating support for post thumbnails.
 */
function byniko_setup() {
	/*
		* Make theme available for translation.
		* Translations can be filed in the /languages/ directory.
		* If you're building a theme based on byniko, use a find and replace
		* to change 'byniko' to the name of your theme in all the template files.
		*/
	// load_theme_textdomain('byniko', get_template_directory() . '/languages');

	// Add default posts and comments RSS feed links to head.
	// add_theme_support('automatic-feed-links');

	/*
		* Let WordPress manage the document title.
		* By adding theme support, we declare that this theme does not use a
		* hard-coded <title> tag in the document head, and expect WordPress to
		* provide it for us.
		*/
	add_theme_support('title-tag');

	/*
		* Enable support for Post Thumbnails on posts and pages.
		*
		* @link https://developer.wordpress.org/themes/functionality/featured-images-post-thumbnails/
		*/
	add_theme_support('post-thumbnails');

	// This theme uses wp_nav_menu() in one location.
	register_nav_menus(
		array(
			'menu-1' => esc_html__('Primary', 'byniko'),
			'menu-2' => esc_html__('Secondary', 'byniko'),
			'footer-1' => esc_html__('Footer 1', 'byniko'),
			'footer-2' => esc_html__('Footer 2', 'byniko'),
			'footer-3' => esc_html__('Footer 3', 'byniko'),
			
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

	// Add theme support for selective refresh for widgets.
	// add_theme_support('customize-selective-refresh-widgets');

	// /**
	//  * Add support for core custom logo.
	//  *
	//  * @link https://codex.wordpress.org/Theme_Logo
	//  */
	// add_theme_support(
	// 	'custom-logo',
	// 	array(
	// 		'height'      => 250,
	// 		'width'       => 250,
	// 		'flex-width'  => true,
	// 		'flex-height' => true,
	// 	)
	// );

	/* `add_theme_support( 'responsive-embeds' );` is a function call in WordPress that adds support for
	responsive embeds in the theme. This means that when this function is called in the theme setup,
	WordPress will automatically make embedded content, such as videos or other media, responsive to
	different screen sizes. This helps ensure that embedded content looks good and functions properly
	across various devices and screen sizes. */
	add_theme_support('responsive-embeds');
}
add_action('after_setup_theme', 'byniko_setup');

/**
 * Set the content width in pixels, based on the theme's design and stylesheet.
 *
 * Priority 0 to make it available to lower priority callbacks.
 *
 * @global int $content_width
 */
function byniko_content_width() {
	$GLOBALS['content_width'] = apply_filters('byniko_content_width', 640);
}
add_action('after_setup_theme', 'byniko_content_width', 0);

/**
 * Register widget area.
 *
 * @link https://developer.wordpress.org/themes/functionality/sidebars/#registering-a-sidebar
 */
// function byniko_widgets_init() {
// 	register_sidebar(
// 		array(
// 			'name'          => esc_html__('Sidebar', 'byniko'),
// 			'id'            => 'sidebar-1',
// 			'description'   => esc_html__('Add widgets here.', 'byniko'),
// 			'before_widget' => '<section id="%1$s" class="widget %2$s">',
// 			'after_widget'  => '</section>',
// 			'before_title'  => '<h2 class="widget-title">',
// 			'after_title'   => '</h2>',
// 		)
// 	);
// }
// add_action('widgets_init', 'byniko_widgets_init');

/**
 * Enqueue scripts and styles.
 */
function byniko_scripts() {
	// asset versioning from npm build process
	$asset_file = get_template_part((get_stylesheet_directory() . '/dist/main.asset')) ?: array('version' => '0.0.0');
	wp_enqueue_style(
		'byniko-style',
		get_stylesheet_directory_uri() . "/dist/main.css",
		array(),
		$asset_file['version']
	);
	wp_enqueue_style(
		'byniko-fonts',
		"//fonts.googleapis.com/css2?family=Montserrat:ital,wght@0,100..900;1,100..900&display=swap",
		array(),
		$asset_file['version']
	);

	wp_enqueue_script(
		'byniko-script',
		get_template_directory_uri() . '/dist/main.js',
		array(),
		$asset_file['version'],
		true
	);

	if (is_singular() && comments_open() && get_option('thread_comments')) {
		wp_enqueue_script('comment-reply');
	}
}
add_action('wp_enqueue_scripts', 'byniko_scripts');



add_filter( 'is_post_type_viewable', 'byniko_hide_cpt_single', 10, 2 );
function byniko_hide_cpt_single( $is_viewable, $post_type ) {
	$hide = array(
		'testimonial',
		'faq'
	);
    if ( in_array($post_type->name, $hide) ) {
        return false;
    }
    return $is_viewable;
}


add_filter('use_block_editor_for_post_type', 'byniko_disable_gutenberg', 10, 2);
function byniko_disable_gutenberg($current_status, $post_type)
{
    // Use your post type key instead of 'product'
    if ($post_type === 'student-type') return false;
    return $current_status;
}


function get_questionnaire_modal_trigger($class = 'button secondary', $CTA = 'Sign Up With Us!') {
	if(byniko\has_membership_level('2')) return;
	return "<button class='$class' data-micromodal-trigger='modal-questionairre'>$CTA</button>";
}
function get_questionnaire_modal() {
	$form = FrmFormsController::get_form_shortcode(array('id' => 2, 'title'=>true, 'description'=>true));
	return makeModal('questionairre', $form);
}
function the_questionnaire_modal_trigger($class = 'button secondary', $CTA = 'Sign Up With Us!') {
	echo get_questionnaire_modal_trigger($class, $CTA);
}
function the_questionnaire_modal_trigger_shortcode() {
	return get_questionnaire_modal_trigger();
}

add_shortcode('questionnaire-trigger', 'the_questionnaire_modal_trigger_shortcode');

add_action('acf/input/admin_enqueue_scripts', 'my_acf_admin_enqueue_scripts');

function my_acf_admin_enqueue_scripts() {
        wp_enqueue_style( 'my-acf-input-css', get_stylesheet_directory_uri() . '/dist/my-acf-input.css', false, '1.0.0' );
        // wp_enqueue_script( 'my-acf-input-js', get_stylesheet_directory_uri() . '/js/my-acf-input.js', false, '1.0.0' );
    }

	add_action( 'wp_before_admin_bar_render', 'byniko_custom_admin_bar' ); 

function byniko_custom_admin_bar()
{
    global $wp_admin_bar;
	$wp_admin_bar->remove_menu('comments');
    $wp_admin_bar->remove_menu('customize');
}


function add_custom_user_role_pending() {
	if ( ! wp_roles()->is_role( 'pending' ) ) {
		add_role( 'pending', 'Pending', array() );
	}
}
add_action('init', 'add_custom_user_role_pending');

/**
 * Bypass the reset password page PMPro uses and use the default WordPress reset password page.
 * This is useful if you're using another frontend login process and have the log in page set to this. 
 * Add this code to your site by following this guide - https://www.paidmembershipspro.com/create-a-plugin-for-pmpro-customizations/
 */

 remove_action( 'login_form_rp', 'pmpro_reset_password_redirect' );
 remove_action( 'login_form_resetpass', 'pmpro_reset_password_redirect' );
 remove_filter( 'retrieve_password_message', 'pmpro_password_reset_email_filter', 20, 3 );
 remove_filter( 'wp_new_user_notification_email', 'pmpro_password_reset_email_filter', 10, 3 );

//  global $pmpro_invite_required_levels;
// $pmpro_invite_required_levels = array(1);



/**
 * Share taxonomy pdf-groups with posts
 *
 * @return void
 */
// function namespace_share_category_with_pages() {
// 	register_taxonomy_for_object_type( 'category', 'pmpro_lesson' );
// }

// add_action( 'init', 'namespace_share_category_with_pages' );

function byniko( $query ) {
    if ( $query->is_category() && $query->is_main_query() ) {
        $query->set( 'post_type', array( 'post', 'pmpro_lesson' ) );
    }
}
add_action( 'pre_get_posts', 'byniko' );


/*
	Tell PMPro to filter the_content a bit later.
	
	This will sometimes fix issues where theme or plugin elements (e.g. videos)
	are not being filtered by PMPro. Note that this sometimes will cause
	some things (e.g. share links) to be filtered that you don't want to be
	filtered... and sometimes edits to the theme or a child theme are
	required to get the desired effect.
	
	Add this to your active theme's fucntions.php or a custom plugin.
*/
function my_init_change_pmpro_content_filter_priority()
{
	remove_filter('the_content', 'pmpro_membership_content_filter', 5);
	add_filter('the_content', 'pmpro_membership_content_filter',0);
}
// add_action('init', 'my_init_change_pmpro_content_filter_priority');

