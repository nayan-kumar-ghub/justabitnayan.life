<?php
/**
 * A unique identifier is defined to store the options in the database and reference them from the theme.
 * By default it uses the theme name, in lowercase and without spaces, but this can be changed if needed.
 * If the identifier changes, it'll appear as if the options have been reset.
 *
 */

function optionsframework_option_name() {
	$optionsframework_settings = get_option('optionsframework');
	$optionsframework_settings['id'] = 'freedom';
	update_option('optionsframework', $optionsframework_settings);
}

/**
 * Defines an array of options that will be used to generate the settings page and be saved in the database.
 * When creating the 'id' fields, make sure to use all lowercase and no spaces.
 *
 */

function optionsframework_options() {

	$options = array();

	// Header Options Area
	$options[] = array(
		'name' => __( 'Header', 'freedom' ),
		'type' => 'heading'
	);

	// Header Logo upload option
	$options[] = array(
		'name' 	=> __( 'Header Logo', 'freedom' ),
		'desc' 	=> __( 'Upload logo for your header.', 'freedom' ),
		'id' 		=> 'freedom_header_logo_image',
		'type' 	=> 'upload'
	);

	// Header logo and text display type option
	$header_display_array = array(
		'logo_only' 	=> __( 'Header Logo Only', 'freedom' ),
		'text_only' 	=> __( 'Header Text Only', 'freedom' ),
		'both' 	=> __( 'Show Both', 'freedom' ),
		'none'		 	=> __( 'Disable', 'freedom' )
	);
	$options[] = array(
		'name' 		=> __( 'Show', 'freedom' ),
		'desc' 		=> __( 'Choose the option that you want.', 'freedom' ),
		'id' 			=> 'freedom_show_header_logo_text',
		'std' 		=> 'text_only',
		'type' 		=> 'radio',
		'options' 	=> $header_display_array 
	);

	// Header Image replace postion
	$options[] = array(
		'name' => __( 'Need to replace Header Image?', 'freedom' ),
		'desc' => sprintf( __( '<a href="%1$s">Click Here</a>', 'freedom' ), admin_url('themes.php?page=custom-header') ),
		'type' => 'info'
	);

	/*************************************************************************/

	$options[] = array(
		'name' => __( 'Design', 'freedom' ),
		'type' => 'heading'
	);

	$options[] = array(
		'name' 		=> __( 'Site Layout', 'freedom' ),
		'desc' 		=> __( 'Choose your site layout. The change is reflected in whole site.', 'freedom' ),
		'id' 			=> 'freedom_site_layout',
		'std' 		=> 'wide',
		'type' 		=> 'radio',
		'options' 	=> array(
							'box' 	=> __( 'Boxed layout', 'freedom' ),
							'wide' 	=> __( 'Wide layout', 'freedom' )
						)
	);

	$options[] = array(
		'name' 		=> __( 'Default layout', 'freedom' ),
		'desc' 		=> __( 'Select default layout. This layout will be reflected in whole site archives, categories, search page etc. The layout for a single post and page can be controlled from below options.', 'freedom' ),
		'id' 			=> 'freedom_default_layout',
		'std' 		=> 'no_sidebar_full_width',
		'type' 		=> 'images',
		'options' 	=> array(
								'right_sidebar' 	=> FREEDOM_ADMIN_IMAGES_URL . '/right-sidebar.png',
								'left_sidebar' 		=> FREEDOM_ADMIN_IMAGES_URL . '/left-sidebar.png',
								'no_sidebar_full_width'				=> FREEDOM_ADMIN_IMAGES_URL . '/no-sidebar-full-width-layout.png',
								'no_sidebar_content_centered'		=> FREEDOM_ADMIN_IMAGES_URL . '/no-sidebar-content-centered-layout.png',
							)
	);

	$options[] = array(
		'name' 		=> __( 'Default layout for pages only', 'freedom' ),
		'desc' 		=> __( 'Select default layout for pages. This layout will be reflected in all pages unless unique layout is set for specific page.', 'freedom' ),
		'id' 			=> 'freedom_pages_default_layout',
		'std' 		=> 'right_sidebar',
		'type' 		=> 'images',
		'options' 	=> array(
								'right_sidebar' 	=> FREEDOM_ADMIN_IMAGES_URL . '/right-sidebar.png',
								'left_sidebar' 		=> FREEDOM_ADMIN_IMAGES_URL . '/left-sidebar.png',
								'no_sidebar_full_width'				=> FREEDOM_ADMIN_IMAGES_URL . '/no-sidebar-full-width-layout.png',
								'no_sidebar_content_centered'		=> FREEDOM_ADMIN_IMAGES_URL . '/no-sidebar-content-centered-layout.png',
							)
	);

	$options[] = array(
		'name' 		=> __( 'Default layout for single posts only', 'freedom' ),
		'desc' 		=> __( 'Select default layout for single posts. This layout will be reflected in all single posts unless unique layout is set for specific post.', 'freedom' ),
		'id' 			=> 'freedom_single_posts_default_layout',
		'std' 		=> 'right_sidebar',
		'type' 		=> 'images',
		'options' 	=> array(
								'right_sidebar' 	=> FREEDOM_ADMIN_IMAGES_URL . '/right-sidebar.png',
								'left_sidebar' 		=> FREEDOM_ADMIN_IMAGES_URL . '/left-sidebar.png',
								'no_sidebar_full_width'				=> FREEDOM_ADMIN_IMAGES_URL . '/no-sidebar-full-width-layout.png',
								'no_sidebar_content_centered'		=> FREEDOM_ADMIN_IMAGES_URL . '/no-sidebar-content-centered-layout.png',
							)
	);

	$options[] = array(
		'name' 		=> __( 'Posts page listing display type', 'freedom' ),
		'desc' 		=> __( 'Choose the display type for the latest posts view or posts page view (static front page).', 'freedom' ),
		'id' 			=> 'freedom_posts_page_display_type',
		'std' 		=> 'photo_blogging_two_column',
		'type' 		=> 'radio',
		'options' 	=> array(
							'photo_blogging_two_column' 	=> __( 'Photo blogging view (two column)', 'freedom' ),
							'normal_view' 	=> __( 'Normal view', 'freedom' )
						)
	);

	$options[] = array(
		'name' 		=> __( 'Archive/Category posts listing display type', 'freedom' ),
		'desc' 		=> __( 'Choose the display type for the archive/category view.', 'freedom' ),
		'id' 			=> 'freedom_archive_display_type',
		'std' 		=> 'photo_blogging_two_column',
		'type' 		=> 'radio',
		'options' 	=> array(
							'photo_blogging_two_column' 	=> __( 'Photo blogging view (two column)', 'freedom' ),
							'normal_view' 	=> __( 'Normal view', 'freedom' )
						)
	);

	// Site primary color option
	$options[] = array(
		'name' 		=> __( 'Primary color option', 'freedom' ),
		'desc' 		=> __( 'This will reflect in links, buttons and many others. Choose a color to match your site.', 'freedom' ),
		'id' 			=> 'freedom_primary_color',
		'std' 		=> '#46c9be',
		'type' 		=> 'color' 
	);

	$options[] = array(
		'name' 		=> __( 'Need to replace default background?', 'freedom' ),
		'desc' 		=> sprintf( __( '<a href="%1$s">Click Here</a>', 'freedom' ), admin_url('themes.php?page=custom-background') ).'&nbsp;&nbsp;&nbsp;'.__( 'Note: The background will only be seen if you choose any of the boxed layout option in site layout option.', 'freedom' ),
		'type' 		=> 'info'
	);

	$options[] = array(
		'name' 		=> __( 'Custom CSS', 'freedom' ),
		'desc' 		=> __( 'Write your custom css.', 'freedom' ),
		'id' 			=> 'freedom_custom_css',
		'std' 		=> '',
		'type' 		=> 'textarea'
	);

	/*************************************************************************/

	$options[] = array(
		'name' => __( 'Slider', 'freedom' ),
		'type' => 'heading'
	);

	// Slider activate option
	$options[] = array(
		'name' 		=> __( 'Activate slider', 'freedom' ),
		'desc' 		=> __( 'Check to activate slider.', 'freedom' ),
		'id' 			=> 'freedom_activate_slider',
		'std' 		=> '0',
		'type' 		=> 'checkbox'
	);

	// Slide options
	for( $i=1; $i<=4; $i++) {
		$options[] = array(
			'name' 	=>	sprintf( __( 'Slider #%1$s', 'freedom' ), $i ),
			'desc' 	=> __( 'Upload image', 'freedom' ),
			'id' 		=> 'freedom_slider_image'.$i,
			'type' 	=> 'upload'
		);
		$options[] = array(
			'desc' 	=> __( 'Enter title for this slide', 'freedom' ),
			'id' 		=> 'freedom_slider_title'.$i,
			'std' 	=> '',
			'type' 	=> 'text'
		);
		$options[] = array(
			'desc' 	=> __( 'Enter description for this slide', 'freedom' ),
			'id' 		=> 'freedom_slider_text'.$i,
			'std' 	=> '',
			'type' 	=> 'textarea'
		);
		$options[] = array(
			'desc' 	=> __( 'Enter the button text.', 'spacious' ),
			'id' 		=> 'freedom_slider_button_text'.$i,
			'std' 	=> '',
			'type' 	=> 'text'
		);
		$options[] = array(
			'desc' 	=> __( 'Enter link to redirect for the slide', 'freedom' ),
			'id' 		=> 'freedom_slider_link'.$i,
			'std' 	=> '',
			'type' 	=> 'text'
		);
	}

	/*************************************************************************/

	return $options;
}

add_action( 'optionsframework_after','freedom_options_display_sidebar' );

/**
 * Freedom admin sidebar
 */
function freedom_options_display_sidebar() { ?>
	<div id="optionsframework-sidebar">
		<div class="metabox-holder">
	    	<div class="postbox">
	    		<h3><?php esc_attr_e( 'Freedom', 'freedom' ); ?></h3>
      			<div class="inside"> 
      				<div class="option-btn"><a class="btn upgrade" target="_blank" href="<?php echo esc_url( 'http://themegrill.com/themes/freedom-pro/' ); ?>"><?php esc_attr_e( 'Upgrade to Pro' , 'freedom' ); ?></a></div>
					<div class="option-btn"><a class="btn support" target="_blank" href="<?php echo esc_url( 'http://themegrill.com/support-forum/' ); ?>"><?php esc_attr_e( 'Support Forum' , 'freedom' ); ?></a></div>
					<div class="option-btn"><a class="btn doc" target="_blank" href="<?php echo esc_url( 'http://themegrill.com/theme-instruction/freedom/' ); ?>"><?php esc_attr_e( 'Documentation' , 'freedom' ); ?></a></div>
					<div class="option-btn"><a class="btn demo" target="_blank" href="<?php echo esc_url( 'http://demo.themegrill.com/freedom/' ); ?>"><?php esc_attr_e( 'View Demo' , 'freedom' ); ?></a></div>
      			</div><!-- inside -->
	    	</div><!-- .postbox -->
	  	</div><!-- .metabox-holder -->
	</div><!-- #optionsframework-sidebar -->
<?php
}
?>