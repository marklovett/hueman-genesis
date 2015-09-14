<?php
/**
 * This file adds the Home Page to the hueman Theme.
 *
 * @author StudioPress
 * @package hueman
 * @subpackage Customizations
 */
 


add_action( 'genesis_meta', 'hueman_home_genesis_meta' );
/**
 * Add widget support for homepage. If no widgets active, display the default loop.
 *
 */
function hueman_home_genesis_meta() {

	if ( is_active_sidebar( 'home-top' ) || is_active_sidebar( 'home-bottom' ) ) {

		//* Force sidebar-content-sidebar layout
		add_filter( 'genesis_site_layout', '__genesis_return_sidebar_content_sidebar' );

		//* Add hueman-home body class
		add_filter( 'body_class', 'hueman_body_class' );
		
		//* Remove breadcrumbs
		remove_action( 'genesis_before_loop', 'genesis_do_breadcrumbs' );

		//* Remove the default Genesis loop
		//remove_action( 'genesis_loop', 'genesis_do_loop' );
		
		//* Add home widgets
		add_action( 'genesis_loop', 'hueman_home_widgets' );
		
	}
}

function hueman_home_widgets() {

	echo '<div id="home-widgets" class="home-widgets">';
	
	genesis_widget_area( 'home-top', array(
		'before' => '<div class="home-top widget-area">',
		'after'  => '</div>',
	) );
	
	genesis_widget_area( 'home-bottom', array(
		'before' => '<div class="home-bottom widget-area">',
		'after'  => '</div>',
	) );
	
	echo '</div>';
}

genesis();
