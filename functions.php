<?php
	//
	// BlueGlass Interactive
	//
	
	$theme_version		= '1.0';
	$functions_path 	= TEMPLATEPATH . '/functions/';	
	$template_url 		= get_bloginfo('template_url');


	// Security best practices
	include_once($functions_path . '/security.php');

	// Theme ajax functions
	include_once($functions_path . '/ajax.php');
	
	// Theme sidebars
	include_once($functions_path . '/sidebars.php');

	// Helper functions
	include_once($functions_path . '/helpers.php');

	//Post types
	//include_once($functions_path . 'post_types.php');

	//Category meta
	//include_once($functions_path . 'category_meta.php');

	//Shortcodes
	require_once $functions_path . 'theme_shortcodes/shortcodes.php';
	//include_once($functions_path . 'theme_shortcodes/alert.php');
	include_once($functions_path . 'theme_shortcodes/tabs.php');
	include_once($functions_path . 'theme_shortcodes/toggle.php');
	//include_once($functions_path . 'theme_shortcodes/html.php');

	if( is_admin() ){
		// Taxonomy custom fields
		//include_once($functions_path . 'category-meta.php');

		//tinyMCE includes
		include_once($functions_path . 'theme_shortcodes/tinymce_shortcodes.php');
		include_once($functions_path . '/add_thumbs_to_admin.php');
	}


	//
	// Security Best Practices ( Comment function to disable )
	// 
	blueglass_security_disable_xmlrpc();
 	blueglass_security_disable_rest_api();
 	blueglass_security_remove_rss_links();
 	blueglass_security_dissalow_file_edit();
 	blueglass_security_remove_wp_version_string();
 	//




	// Get language code from WPML if one of plugin is enabled
	if( function_exists('icl_get_languages')){
		$lang = ICL_LANGUAGE_CODE;
	}else{
		$default_lang = explode('-', get_bloginfo( 'language' ));
		$lang = $default_lang[0];
	}

	
	// Setups
	add_action( 'after_setup_theme', 're_setup_template' );
	function re_setup_template(){
		add_theme_support( 'post-thumbnails' );

		add_theme_support( 'post-formats', array('aside', 'gallery', 'image', 'quote', 'video')); 
		
		//add_image_size( 'tiny', 78, 81, true );

		register_nav_menus( array( 'top-menu' => __( 'Top menu', 'blueglass')  ) );
	}




    add_action('admin_init', 'blueglass_admin_JS_init_method');
	function blueglass_admin_JS_init_method() {
		global $template_url;

		wp_enqueue_script('adminjs', $template_url . '/functions/admin_js.js', 'jquery', false);
		wp_enqueue_style('adminjs', $template_url . '/functions/admin_css.css', 'jquery', false);		
	}



	
	if ( !function_exists( 'mighty_enqueue_head_scripts' ) ) {
		add_action( 'get_header', 'blueglass_enqueue_head_scripts' );
		function blueglass_enqueue_head_scripts() {
			global $template_url, $theme_version;

			wp_enqueue_style( 'app-styles', $template_url ."/css/app.css", false, $theme_version );
			//wp_enqueue_style( 'fancybox', $template_url ."/css/jquery.fancybox.css", FALSE, $theme_version ); 
			//wp_enqueue_style( 'slick', $template_url ."/css/idangerous.swiper.css", FALSE, $theme_version ); 
		}
	}
	
	/*
		Remember to switch "production" parameter to "true" in gulpfile.js before going live. 
		This will minify all js files in "src/js" folder
	*/
	add_action('get_footer', 'blueglass_JS_init_method');
	function blueglass_JS_init_method() {
		global $template_url;

		// Load jQuery
		if ( !is_admin() ) {

			$localized_scripts = array( 'ajaxurl' => admin_url( 'admin-ajax.php' ) );
			//$localized_scripts['custom'] = 'variable';

			wp_enqueue_script('jquery');
			
			// Foundation Core
			wp_enqueue_script('theme-foundation', $template_url.'/bower_components/foundation-sites/dist/js/foundation.min.js', 'jquery');
			//wp_enqueue_script('theme-mousewheel', $template_url.'/js/jquery.mousewheel-3.0.6.pack.js', 'jquery');
			//wp_enqueue_script('theme-fancybox', $template_url.'/js/jquery.fancybox.js', 'jquery');
			//wp_enqueue_script('theme-fancybox-media', $template_url.'/js/jquery.fancybox-media.js', 'jquery');


			wp_enqueue_script( 'theme-javascript', $template_url.'/js/app.js', 'theme-scripts' );
//			wp_localize_script('theme-javascript', 'scripts_localized', $localized_scripts );

		}
	}

    

	

?>