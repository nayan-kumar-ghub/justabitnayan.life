<?php
/**
 * Freedom functions and definitions
 *
 * This file contains all the functions and it's defination that particularly can't be
 * in other files.
 * 
 * @package ThemeGrill
 * @subpackage Freedom
 * @since Freedom 1.0
 */

/****************************************************************************************/

add_action( 'wp_enqueue_scripts', 'freedom_scripts_styles_method' );
/**
 * Register jquery scripts
 */
function freedom_scripts_styles_method() {
   /**
	* Loads our main stylesheet.
	*/
	wp_enqueue_style( 'freedom_style', get_stylesheet_uri() );

  	wp_register_style( 'freedom_googlefonts', 'http://fonts.googleapis.com/css?family=Fira+Sans|Vollkorn' );
  	wp_enqueue_style( 'freedom_googlefonts' );

	/**
	 * Adds JavaScript to pages with the comment form to support
	 * sites with threaded comments (when in use).
	 */
	if ( is_singular() && comments_open() && get_option( 'thread_comments' ) )
		wp_enqueue_script( 'comment-reply' );

	/**
	 * Register JQuery cycle js file for slider.
	 */
	wp_register_script( 'jquery_cycle', FREEDOM_JS_URL . '/jquery.cycle.all.min.js', array( 'jquery' ), '2.9999.5', true );
	
	/**
	 * Enqueue Slider setup js file.	 
	 */
	if ( is_front_page() && of_get_option( 'freedom_activate_slider', '0' ) == '1' ) {
		wp_enqueue_script( 'freedom_slider', FREEDOM_JS_URL . '/freedom-slider-setting.js', array( 'jquery_cycle' ), false, true );
	}
	wp_enqueue_script( 'freedom-navigation', FREEDOM_JS_URL . '/navigation.js', array( 'jquery' ), false, true );
	wp_enqueue_script( 'freedom-custom', FREEDOM_JS_URL. '/freedom-custom.js', array( 'jquery' ) );

	wp_enqueue_style( 'freedom-fontawesome', get_template_directory_uri().'/fontawesome/css/font-awesome.css', array(), '4.2.1' );

	wp_enqueue_style( 'google_fonts' );

   $freedom_user_agent = strtolower($_SERVER['HTTP_USER_AGENT']);
	if(preg_match('/(?i)msie [1-8]/',$freedom_user_agent)) {
		wp_enqueue_script( 'html5', FREEDOM_JS_URL . '/html5shiv.min.js', true );
	}

}

add_action( 'admin_print_styles-appearance_page_options-framework', 'freedom_admin_styles' );
/**
 * Enqueuing some styles.
 *
 * @uses wp_enqueue_style to register stylesheets.
 * @uses wp_enqueue_style to add styles.
 */
function freedom_admin_styles() {
	wp_enqueue_style( 'freedom_admin_style', FREEDOM_ADMIN_CSS_URL. '/admin.css' );
}

/****************************************************************************************/

add_filter( 'excerpt_length', 'freedom_excerpt_length' );
/**
 * Sets the post excerpt length to 40 words.
 *
 * function tied to the excerpt_length filter hook.
 *
 * @uses filter excerpt_length
 */
function freedom_excerpt_length( $length ) {
	return 40;
}

add_filter( 'excerpt_more', 'freedom_continue_reading' );
/**
 * Returns a "Continue Reading" link for excerpts
 */
function freedom_continue_reading() {
	return '';
}

/****************************************************************************************/

/**
 * Removing the default style of wordpress gallery
 */
add_filter( 'use_default_gallery_style', '__return_false' );

/**
 * Filtering the size to be medium from thumbnail to be used in WordPress gallery as a default size
 */
function freedom_gallery_atts( $out, $pairs, $atts ) {
	$atts = shortcode_atts( array(
	'size' => 'medium',
	), $atts );

	$out['size'] = $atts['size'];
	 
	return $out;
 
}
add_filter( 'shortcode_atts_gallery', 'freedom_gallery_atts', 10, 3 );

/****************************************************************************************/

add_filter( 'body_class', 'freedom_body_class' );
/**
 * Filter the body_class
 *
 * Throwing different body class for the different layouts in the body tag
 */
function freedom_body_class( $classes ) {
	global $post;

	if( $post ) { $layout_meta = get_post_meta( $post->ID, 'freedom_page_layout', true ); }

	if( is_home() ) {
		$queried_id = get_option( 'page_for_posts' );
		$layout_meta = get_post_meta( $queried_id, 'freedom_page_layout', true ); 
	}
	if( empty( $layout_meta ) || is_archive() || is_search() ) { $layout_meta = 'default_layout'; }
	$freedom_default_layout = of_get_option( 'freedom_default_layout', 'no_sidebar_full_width' );

	$freedom_default_page_layout = of_get_option( 'freedom_pages_default_layout', 'right_sidebar' );
	$freedom_default_post_layout = of_get_option( 'freedom_single_posts_default_layout', 'right_sidebar' );

	if( $layout_meta == 'default_layout' ) {
		if( is_page() ) {
			if( $freedom_default_page_layout == 'right_sidebar' ) { $classes[] = ''; }
			elseif( $freedom_default_page_layout == 'left_sidebar' ) { $classes[] = 'left-sidebar'; }
			elseif( $freedom_default_page_layout == 'no_sidebar_full_width' ) { $classes[] = 'no-sidebar-full-width'; }
			elseif( $freedom_default_page_layout == 'no_sidebar_content_centered' ) { $classes[] = 'no-sidebar'; }
		}
		elseif( is_single() ) {
			if( $freedom_default_post_layout == 'right_sidebar' ) { $classes[] = ''; }
			elseif( $freedom_default_post_layout == 'left_sidebar' ) { $classes[] = 'left-sidebar'; }
			elseif( $freedom_default_post_layout == 'no_sidebar_full_width' ) { $classes[] = 'no-sidebar-full-width'; }
			elseif( $freedom_default_post_layout == 'no_sidebar_content_centered' ) { $classes[] = 'no-sidebar'; }
		}
		elseif( $freedom_default_layout == 'right_sidebar' ) { $classes[] = ''; }
		elseif( $freedom_default_layout == 'left_sidebar' ) { $classes[] = 'left-sidebar'; }
		elseif( $freedom_default_layout == 'no_sidebar_full_width' ) { $classes[] = 'no-sidebar-full-width'; }
		elseif( $freedom_default_layout == 'no_sidebar_content_centered' ) { $classes[] = 'no-sidebar'; }
	}
	elseif( $layout_meta == 'right_sidebar' ) { $classes[] = ''; }
	elseif( $layout_meta == 'left_sidebar' ) { $classes[] = 'left-sidebar'; }
	elseif( $layout_meta == 'no_sidebar_full_width' ) { $classes[] = 'no-sidebar-full-width'; }
	elseif( $layout_meta == 'no_sidebar_content_centered' ) { $classes[] = 'no-sidebar'; }
	
	if( of_get_option( 'freedom_site_layout', 'wide' ) == 'wide' ) {
		$classes[] = 'wide';
	}
	elseif( of_get_option( 'freedom_site_layout', 'wide' ) == 'box' ) {
		$classes[] = '';
	}

	return $classes;
}

/****************************************************************************************/

if ( ! function_exists( 'freedom_sidebar_select' ) ) :
/**
 * Fucntion to select the sidebar
 */
function freedom_sidebar_select() {
	global $post;

	if( $post ) { $layout_meta = get_post_meta( $post->ID, 'freedom_page_layout', true ); }

	if( is_home() ) {
		$queried_id = get_option( 'page_for_posts' );
		$layout_meta = get_post_meta( $queried_id, 'freedom_page_layout', true );
	}

	if( empty( $layout_meta ) || is_archive() || is_search() ) { $layout_meta = 'default_layout'; }
	$freedom_default_layout = of_get_option( 'freedom_default_layout', 'no_sidebar_full_width' );

	$freedom_default_page_layout = of_get_option( 'freedom_pages_default_layout', 'right_sidebar' );
	$freedom_default_post_layout = of_get_option( 'freedom_single_posts_default_layout', 'right_sidebar' );

	if( $layout_meta == 'default_layout' ) {
		if( is_page() ) {
			if( $freedom_default_page_layout == 'right_sidebar' ) { get_sidebar(); }
			elseif ( $freedom_default_page_layout == 'left_sidebar' ) { get_sidebar( 'left' ); }
		}
		if( is_single() ) {
			if( $freedom_default_post_layout == 'right_sidebar' ) { get_sidebar(); }
			elseif ( $freedom_default_post_layout == 'left_sidebar' ) { get_sidebar( 'left' ); }
		}
		elseif( $freedom_default_layout == 'right_sidebar' ) { get_sidebar(); }
		elseif ( $freedom_default_layout == 'left_sidebar' ) { get_sidebar( 'left' ); }
	}
	elseif( $layout_meta == 'right_sidebar' ) { get_sidebar(); }
	elseif( $layout_meta == 'left_sidebar' ) { get_sidebar( 'left' ); }
}
endif;

/****************************************************************************************/

if ( ! function_exists( 'freedom_entry_meta' ) ) :
/**
 * Shows meta information of post. 
 */
function freedom_entry_meta() {
	echo '<div class="entry-meta">';
	?>
	<span class="byline"><span class="author vcard"><i class="fa fa-user"></i><a class="url fn n" href="<?php echo esc_url( get_author_posts_url( get_the_author_meta( 'ID' ) ) ); ?>" title="<?php echo get_the_author(); ?>"><?php echo esc_html( get_the_author() ); ?></a></span></span>
	<?php 

	$categories_list = get_the_category_list( __( ', ', 'freedom' ) );
	if ( $categories_list )	printf( __( '<span class="cat-links"><i class="fa fa-folder-open"></i>%1$s</span>', 'freedom' ), $categories_list );

	echo '<span class="sep"></span>';

	$time_string = '<time class="entry-date published" datetime="%1$s">%2$s</time>';
	$time_string = sprintf( $time_string,
		esc_attr( get_the_date( 'c' ) ),
		esc_html( get_the_date() )
	);
	printf( __( '<span class="posted-on"><a href="%1$s" title="%2$s" rel="bookmark"><i class="fa fa-calendar-o"></i> %3$s</a></span>', 'freedom' ),
		esc_url( get_permalink() ),
		esc_attr( get_the_time() ),
		$time_string
	);

	$tags_list = get_the_tag_list( '<span class="tag-links"><i class="fa fa-tags"></i>', __( ', ', 'freedom' ), '</span>' );
	if ( $tags_list ) echo $tags_list;

	if ( ! post_password_required() && comments_open() ) { ?>
		<span class="comments-link"><?php comments_popup_link( __( '<i class="fa fa-comment"></i> 0 Comment', 'freedom' ), __( '<i class="fa fa-comment"></i> 1 Comment', 'freedom' ), __( '<i class="fa fa-comments"></i> % Comments', 'freedom' ) ); ?></span>
	<?php }

	edit_post_link( __( 'Edit', 'freedom' ), '<span class="edit-link"><i class="fa fa-edit"></i>', '</span>' );

	echo '</div>';
}
endif;


if ( ! function_exists( 'freedom_home_entry_meta' ) ) :
/**
 * Shows post meta information in photo blogging view for archives.
 */
function freedom_home_entry_meta() {
	echo '<div class="entry-meta">';

	$time_string = '<time class="entry-date published" datetime="%1$s">%2$s</time>';
	$time_string = sprintf( $time_string,
		esc_attr( get_the_date( 'c' ) ),
		esc_html( get_the_date() )
	);
	printf( __( '<span class="posted-on"><a href="%1$s" title="%2$s" rel="bookmark"><i class="fa fa-calendar-o"></i> %3$s</a></span>', 'freedom' ),
		esc_url( get_permalink() ),
		esc_attr( get_the_time() ),
		$time_string
	);

	$categories_list = get_the_category_list( __( ', ', 'freedom' ) );
		if ( $categories_list )	printf( __( '<span class="cat-links"><i class="fa fa-folder-open"></i>%1$s</span>', 'freedom' ), $categories_list );

	echo '</div>';
}
endif;

/****************************************************************************************/

add_action('wp_head', 'freedom_custom_css');
/**
 * Hooks the Custom Internal CSS to head section
 */
function freedom_custom_css() {
	$freedom_internal_css = '';	

	$primary_color = of_get_option( 'freedom_primary_color', '#46c9be' );	
	if( $primary_color != '#46c9be' ) {
		$freedom_internal_css .= ' .feedom-button,blockquote,button,input[type=button],input[type=reset],input[type=submit]{background-color:'.$primary_color.'}#site-title a:hover,.next a:hover,.previous a:hover,a{color:'.$primary_color.'}#search-form span{background-color:'.$primary_color.'}.main-navigation a:hover,.main-navigation ul li ul li a:hover,.main-navigation ul li ul li:hover>a,.main-navigation ul li.current-menu-ancestor a,.main-navigation ul li.current-menu-item a,.main-navigation ul li.current-menu-item ul li a:hover,.main-navigation ul li.current_page_ancestor a,.main-navigation ul li.current_page_item a,.main-navigation ul li:hover>a,.site-header .menu-toggle:before{color:'.$primary_color.'}.main-small-navigation li a:hover,.main-small-navigation .current-menu-item a,.main-small-navigation .current_page_item a{background-color:'.$primary_color.'}#featured-slider .entry-title a:hover{color:'.$primary_color.'}#featured-slider .slider-read-more-button a{background-color:'.$primary_color.'}.slider-nav i:hover{color:'.$primary_color.'}.format-link .entry-content a,.pagination span{background-color:'.$primary_color.'}.pagination a span:hover{color:'.$primary_color.';border-color:'.$primary_color.'}#content .comments-area a.comment-edit-link:hover,#content .comments-area a.comment-permalink:hover,#content .comments-area article header cite a:hover,.comments-area .comment-author-link a:hover{color:'.$primary_color.'}.comments-area .comment-author-link span{background-color:'.$primary_color.'}.comment .comment-reply-link:hover,.nav-next a,.nav-previous a{color:'.$primary_color.'}#secondary h3.widget-title{border-bottom:2px solid '.$primary_color.'}#wp-calendar #today{color:'.$primary_color.'}.entry-meta .byline i,.entry-meta .cat-links i,.entry-meta a,.footer-socket-wrapper .copyright a:hover,.footer-widgets-area a:hover,.post .entry-title a:hover,.search .entry-title a:hover,.post-box .entry-meta .cat-links a:hover,.post-box .entry-meta .posted-on a:hover,.post.post-box .entry-title a:hover,a#scroll-up i{color:'.$primary_color.'}.entry-meta .post-format i{background-color:'.$primary_color.'}.entry-meta .comments-link a:hover,.entry-meta .edit-link a:hover,.entry-meta .posted-on a:hover,.entry-meta .tag-links a:hover{color:'.$primary_color.'}.more-link span{background-color:'.$primary_color.'}.single #content .tags a:hover{color:'.$primary_color.'}.no-post-thumbnail{background-color:'.$primary_color.'}@media screen and (max-width:768px){.top-menu-toggle:before{color:'.$primary_color.'}}';
	}

	if( !empty( $freedom_internal_css ) ) {
		echo '<!-- '.get_bloginfo('name').' Internal Styles -->';
		?><style type="text/css"><?php echo $freedom_internal_css; ?></style>
<?php
	}

	$freedom_custom_css = of_get_option( 'freedom_custom_css', '' );
	if( !empty( $freedom_custom_css ) ) {
		echo '<!-- '.get_bloginfo('name').' Custom Styles -->';
		?><style type="text/css"><?php echo $freedom_custom_css; ?></style><?php
	}
}

/**************************************************************************************/

add_filter('the_content_more_link', 'freedom_remove_more_jump_link');
/**
 * Removing the more link jumping to middle of content
 */
function freedom_remove_more_jump_link($link) { 
	$offset = strpos($link, '#more-');
	if ($offset) {
		$end = strpos($link, '"',$offset);
	}
	if ($end) {
		$link = substr_replace($link, '', $offset, $end-$offset);
	}
	return $link;
}

/**************************************************************************************/

if ( ! function_exists( 'freedom_content_nav' ) ) :
/**
 * Display navigation to next/previous pages when applicable
 */
function freedom_content_nav( $nav_id ) {
	global $wp_query, $post;

	// Don't print empty markup on single pages if there's nowhere to navigate.
	if ( is_single() ) {
		$previous = ( is_attachment() ) ? get_post( $post->post_parent ) : get_adjacent_post( false, '', true );
		$next = get_adjacent_post( false, '', false );

		if ( ! $next && ! $previous )
			return;
	}

	// Don't print empty markup in archives if there's only one page.
	if ( $wp_query->max_num_pages < 2 && ( is_home() || is_archive() || is_search() ) )
		return;

	$nav_class = ( is_single() ) ? 'post-navigation' : 'paging-navigation';

	?>
	<nav role="navigation" id="<?php echo esc_attr( $nav_id ); ?>" class="<?php echo $nav_class; ?>">
		<h1 class="screen-reader-text"><?php _e( 'Post navigation', 'freedom' ); ?></h1>

	<?php if ( is_single() ) : // navigation links for single posts ?>

		<?php previous_post_link( '<div class="nav-previous">%link</div>', '<span class="meta-nav">' . _x( '&larr;', 'Previous post link', 'freedom' ) . '</span> %title' ); ?>
		<?php next_post_link( '<div class="nav-next">%link</div>', '%title <span class="meta-nav">' . _x( '&rarr;', 'Next post link', 'freedom' ) . '</span>' ); ?>

	<?php elseif ( $wp_query->max_num_pages > 1 && ( is_home() || is_archive() || is_search() ) ) : // navigation links for home, archive, and search pages ?>

		<?php if ( get_next_posts_link() ) : ?>
		<div class="nav-previous"><?php next_posts_link( __( '<span class="meta-nav">&larr;</span> Older posts', 'freedom' ) ); ?></div>
		<?php endif; ?>

		<?php if ( get_previous_posts_link() ) : ?>
		<div class="nav-next"><?php previous_posts_link( __( 'Newer posts <span class="meta-nav">&rarr;</span>', 'freedom' ) ); ?></div>
		<?php endif; ?>

	<?php endif; ?>

	</nav><!-- #<?php echo esc_html( $nav_id ); ?> -->
	<?php
}
endif; // freedom_content_nav

/**************************************************************************************/

if ( ! function_exists( 'freedom_comment' ) ) :
/**
 * Template for comments and pingbacks.
 *
 * Used as a callback by wp_list_comments() for displaying the comments.
 */
function freedom_comment( $comment, $args, $depth ) {
	$GLOBALS['comment'] = $comment;
	switch ( $comment->comment_type ) :
		case 'pingback' :
		case 'trackback' :
		// Display trackbacks differently than normal comments.
	?>
	<li <?php comment_class(); ?> id="comment-<?php comment_ID(); ?>">
		<p><?php _e( 'Pingback:', 'freedom' ); ?> <?php comment_author_link(); ?> <?php edit_comment_link( __( '(Edit)', 'freedom' ), '<span class="edit-link">', '</span>' ); ?></p>
	<?php
			break;
		default :
		// Proceed with normal comments.
		global $post;
	?>
	<li <?php comment_class(); ?> id="li-comment-<?php comment_ID(); ?>">
		<article id="comment-<?php comment_ID(); ?>" class="comment">
			<header class="comment-meta comment-author vcard">
				<?php
					echo get_avatar( $comment, 74 );
					printf( '<div class="comment-author-link"><i class="fa fa-user"></i>%1$s%2$s</div>',
						get_comment_author_link(),
						// If current post author is also comment author, make it known visually.
						( $comment->user_id === $post->post_author ) ? '<span>' . __( 'Post author', 'freedom' ) . '</span>' : ''
					);
					printf( '<div class="comment-date-time"><i class="fa fa-calendar-o"></i>%1$s</div>',
						sprintf( __( '%1$s at %2$s', 'freedom' ), get_comment_date(), get_comment_time() )
					);
					printf( '<a class="comment-permalink" href="%1$s"><i class="fa fa-link"></i>Permalink</a>', esc_url( get_comment_link( $comment->comment_ID ) ) );
					edit_comment_link();
				?>
			</header><!-- .comment-meta -->

			<?php if ( '0' == $comment->comment_approved ) : ?>
				<p class="comment-awaiting-moderation"><?php _e( 'Your comment is awaiting moderation.', 'freedom' ); ?></p>
			<?php endif; ?>

			<section class="comment-content comment">
				<?php comment_text(); ?>
				<?php comment_reply_link( array_merge( $args, array( 'reply_text' => __( 'Reply', 'freedom' ), 'after' => '', 'depth' => $depth, 'max_depth' => $args['max_depth'] ) ) ); ?>
			</section><!-- .comment-content -->
			
		</article><!-- #comment-## -->
	<?php
		break;
	endswitch; // end comment_type check
}
endif;

/**************************************************************************************/

add_action( 'freedom_footer_copyright', 'freedom_footer_copyright', 10 );
/**
 * function to show the footer info, copyright information
 */
function freedom_footer_copyright() {
	$site_link = '<a href="' . esc_url( home_url( '/' ) ) . '" title="' . esc_attr( get_bloginfo( 'name', 'display' ) ) . '" ><span>' . get_bloginfo( 'name', 'display' ) . '</span></a>';
	$wp_link = '<a href="'.esc_url( 'http://wordpress.org' ).'" target="_blank" title="' . esc_attr__( 'WordPress', 'freedom' ) . '"><span>' . __( 'WordPress', 'freedom' ) . '</span></a>';
	$tg_link =  '<a href="'.esc_url( 'http://themegrill.com/themes/freedom' ).'" target="_blank" title="'.esc_attr__( 'ThemeGrill', 'freedom' ).'" ><span>'.__( 'ThemeGrill', 'freedom') .'</span></a>';

	$default_footer_value = __( 'Copyright &copy; ', 'freedom' ). date( 'Y' ).'&nbsp'.$site_link.__( '.&nbsp;Powered by&nbsp;', 'freedom' ).$wp_link.'&nbsp;and&nbsp;'.$tg_link.__( '.', 'freedom' );
	$freedom_footer_copyright = '<div class="copyright">'.$default_footer_value.'</div>';

	echo $freedom_footer_copyright;
}

/**************************************************************************************/

?>