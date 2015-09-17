<?php
//* Start the engine
include_once( get_template_directory() . '/lib/init.php' );

//* Child theme (do not remove)
define( 'CHILD_THEME_NAME', 'Treehouse Hueman Genesis' );
define( 'CHILD_THEME_URL', 'http://www.teamtreehouse.com' );
define( 'CHILD_THEME_VERSION', '1.0.0' );

//* Add HTML5 markup structure
add_theme_support( 'html5', array( 'search-form', 'comment-form', 'comment-list' ) );

//* Add viewport meta tag for mobile browsers
add_theme_support( 'genesis-responsive-viewport' );

//* Enqueue scripts and styles
add_action( 'wp_enqueue_scripts', 'hueman_scripts_styles' );
function hueman_scripts_styles() {
	wp_enqueue_style( 'font-awesome', '//maxcdn.bootstrapcdn.com/font-awesome/4.3.0/css/font-awesome.min.css', array(), 'treehouse-hueman-genesis' );
	wp_enqueue_script( 'global', get_stylesheet_directory_uri() . '/js//min/global-min.js', array( 'jquery', 'matchHeights' ), '1.0', true );
	wp_enqueue_script( 'matchHeights', get_stylesheet_directory_uri() . '/js/min/jquery.matchHeight-min.js', array( 'jquery' ), '0.5.2', true );
}

//* Add support for structural wraps
add_theme_support( 'genesis-structural-wraps', array(
	'header', 'nav', 'subnav', 'main', 'footer-widgets', 'footer',
) );

//* Rename menus
add_theme_support( 'genesis-menus', array(
	'primary' => __( 'Header Top Navigation Menu', 'treehouse-hueman-genesis' ),
	'secondary' => __( 'Header Bottom Navigation Menu', 'treehouse-hueman-genesis' )
) );

//* Relocate Primary (top) Navigation
remove_action( 'genesis_after_header', 'genesis_do_nav' );
add_action( 'genesis_before', 'genesis_do_nav', 4 );

//* Relocate Header outside Site Container
remove_action( 'genesis_header', 'genesis_header_markup_open', 5 );
remove_action( 'genesis_header', 'genesis_do_header' );
remove_action( 'genesis_header', 'genesis_header_markup_close', 15 );
add_action( 'genesis_before', 'genesis_header_markup_open', 5 );
add_action( 'genesis_before', 'genesis_do_header' );
add_action( 'genesis_before', 'genesis_header_markup_close', 15 );

//* Relocate Secondary (bottom) Navigation
remove_action( 'genesis_after_header', 'genesis_do_subnav' );
add_action( 'genesis_before', 'genesis_do_subnav', 14 );

//* Move the Primary Sidebar before the Content DIV.
remove_action( 'genesis_after_content', 'genesis_get_sidebar' );
add_action( 'genesis_before_content', 'genesis_get_sidebar' );

//* Move the Secondary Sidebar into the Content Sidebar Wrap area.
remove_action( 'genesis_after_content_sidebar_wrap', 'genesis_get_sidebar_alt' );
add_action( 'genesis_after_content', 'genesis_get_sidebar_alt' );

//* Add new image sizes
add_image_size( 'home-top', 780, 354, TRUE );
add_image_size( 'home-bottom', 375, 175, TRUE );

//* Customize the post info function
add_filter( 'genesis_post_info', 'hueman_post_info_filter' );
function hueman_post_info_filter($post_info) {
	if ( !is_page() ) {
		$post_info = 'by [post_author_posts_link] [post_date] ';
		return $post_info;
	}
}

//* Remove the entry footer markup (requires HTML5 theme support)
remove_action( 'genesis_entry_footer', 'genesis_entry_footer_markup_open', 5 );
remove_action( 'genesis_entry_footer', 'genesis_post_meta' );
remove_action( 'genesis_entry_footer', 'genesis_entry_footer_markup_close', 15 );

//* Add Page Title area above Content
get_template_part('lib/page-title');

//* Modify Comments Title text in comments
add_filter( 'genesis_title_comments', 'hueman_title_comments' );
function hueman_title_comments() {
	return '<h3>' . get_comments_number() . ' Responses to ' . get_the_title() . '</h3>';
}

//* Customize search form input box text
add_filter( 'genesis_search_text', 'hueman_search_text' );
function hueman_search_text( $text ) {
	return esc_attr( 'To search, type and hit enter' );
}

//* Add support for 3-column footer widgets
add_theme_support( 'genesis-footer-widgets', 3 );

//* Reposition the site footer
remove_action( 'genesis_footer', 'genesis_footer_markup_open', 5 );
remove_action( 'genesis_footer', 'genesis_do_footer' );
remove_action( 'genesis_footer', 'genesis_footer_markup_close', 15 );
add_action( 'genesis_after', 'genesis_footer_markup_open', 5 );
add_action( 'genesis_after', 'genesis_do_footer' );
add_action( 'genesis_after', 'genesis_footer_markup_close', 15 );

// Footer Copyright notice
add_filter('genesis_footer_output', 'hueman_genesis_footer_output_filter', 10, 3);
function hueman_genesis_footer_output_filter() {

	echo '<div class="footer-menu">';
	echo wp_nav_menu( array('menu' => 'Footer Nav') );
	echo '</div>';
	echo '<a href="#" rel="nofollow" class="gototop"><i class="arrow-up"></i></a>';

	$creds = '<p>Copyright &copy;2014&ndash;' . date('Y'). ' - <a href="' . trailingslashit( get_bloginfo('url') ) . '" title="' . esc_attr( get_bloginfo('name') ) . '" rel="nofollow">Hueman for Genesis</a><br />Powered by <a href="http://www.wordpress.org" target="_blank">WordPress</a>. Theme by <a href="http://www.teamtreehouse.com" target="_blank">Jesse Petersen for Treehouse</a>';

	$output = '<div class="creds">' . $creds . '</div></div>';

	return $output;

}

//* Add smooth scrolling for any link having the class of "top"
add_action('wp_footer', 'hueman_genesis_go_to_top');
function hueman_genesis_go_to_top() { ?>
	<script type="text/javascript">
		jQuery(function($) {
			$('a.gototop').click(function() {
				$('html, body').animate({scrollTop:0}, 'slow');
				return false;
			});
		});
	</script>
<?php }

//* Register widget areas
genesis_register_sidebar( array(
	'id'          => 'home-top',
	'name'        => __( 'Home Top', 'treehouse-hueman-genesis' ),
	'description' => __( 'Widgets in this section will display in the top widget area on the homepage.', 'treehouse-hueman-genesis' ),
) );
genesis_register_sidebar( array(
	'id'          => 'home-bottom',
	'name'        => __( 'Home Bottom', 'treehouse-hueman-genesis' ),
	'description' => __( 'Widgets in this section will display in the bottom widget area on the homepage.', 'treehouse-hueman-genesis' ),
) );