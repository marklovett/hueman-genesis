<?php

//* Add Page Title area above Content
add_action( 'genesis_before_loop', 'hueman_page_title' );
function hueman_page_title() {
	echo "<div class='page-title pad group'>";
	if ( is_front_page() ) {
		echo "<h2>" . get_bloginfo( 'name' ) . "</h2>";
	}
	if ( is_single() ) { ?>
		<ul class='meta-single'>
			<li class='category'><?php the_category(' <span>/</span> '); ?></li>
			<?php	if ( comments_open() ) { ?>
				<li class='comments'><a href='<?php comments_link() ; ?>'><i class='fa fa-comments-o'></i><?php comments_number( '0', '1', '%' ) ; ?></a></li>
			<?php	} ?>
		</ul> <?php
	}
	if ( is_page() ) {
		echo "<h2>" . genesis_do_post_title() . "</h2>";
	}
	if ( is_search() ) {
		echo "<span>";
		if ( have_posts() ) {
			echo "<i class='fa fa-search'></i>";
		}
		if ( ! have_posts() ) {
			echo "<i class='fa fa-exclamation-circle'></i>";
		}
		$search_results = $wp_query->found_posts;
		if ( $search_results == 1 ) {
			echo $search_results . ' ' . __( 'Search result', 'hueman-genesis' );
		} else {
			echo $search_results . ' ' . __( 'Search results', 'hueman-genesis' );
		}
		echo "</span>";
	}
	if ( is_404() ) {
		echo "<span class='page-title-name'><i class='fa fa-exclamation-circle'></i>" . __('Error 404.  ','hueman-genesis') . "<span>" . _e('Page not found!','hueman-genesis') . "</span></span>";
	}
	if ( is_author() ) {
		$author = get_userdata( get_query_var('author') );
		echo "<span class='page-title-name'>" . __('Author:  ','hueman-genesis') . "<i class='fa fa-user'></i><span>" . $author->display_name . "</span></span>";
	}
	if ( is_category() ) {
		echo "<span class='page-title-name'>" . __( 'Category:  ', 'hueman-genesis' ) . "<i class='fa fa-folder-open'></i><span>" . single_cat_title( '', false ) . "</span></span>";
	}
	if ( is_tag() ) {
		echo "<span class='page-title-name'>" . __('Tagged:  ','hueman-genesis') . "<i class='fa fa-tags'></i><span>" . single_tag_title('', false) ."</span></span>";
	}
	if ( is_day() ) {
		echo "<span class='page-title-name'>" . __('Daily Archive:  ','hueman-genesis') . "<i class='fa fa-calendar'></i><span>" . get_the_time('F j, Y') . "</span></span>";
	}
	if ( is_month() ) {
		echo "<span class='page-title-name'>" . __('Monthly Archive:  ','hueman-genesis') . "<i class='fa fa-calendar'></i><span>" . get_the_time('F Y') . "</span></span>";
	}
	if ( is_year() ) {
		echo "<span class='page-title-name'>" . __('Yearly Archive:  ','hueman-genesis') . "<i class='fa fa-calendar'></i><span>" . get_the_time('Y') . "</span></span>";
	}
	echo "</div><!--/.page-title-->";
}