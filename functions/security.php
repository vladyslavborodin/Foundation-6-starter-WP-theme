<?php 
	/* Security Best Practices */

	function blueglass_security_disable_xmlrpc(){
		add_filter(	'xmlrpc_enabled', '__return_false'	);
		add_filter( 'wp_headers', 'disable_x_pingback' );
		add_filter(	'pings_open', '__return_false', PHP_INT_MAX	);
	}

	function disable_x_pingback( $headers ) {
	    unset( $headers['X-Pingback'] );
		return $headers;
	}

	// Remove comments feed
	function blueglass_security_remove_rss_links() { 
		remove_action('wp_head', 'rsd_link');
		remove_action('wp_head', 'feed_links_extra', 3 );
		remove_action('wp_head', 'feed_links', 2 );
		add_filter( 'feed_links_show_comments_feed', '__return_false' );
		remove_action('wp_head', 'wlwmanifest_link');
		remove_action('wp_head', 'wp_shortlink_wp_head');
	}


	function blueglass_security_disable_rest_api() {    
		add_filter( 'rest_authentication_errors', 'blueglass_only_allow_logged_in_rest_access' );
		blueglass_Disable_Via_Filters();
	}

	/**
	 * This function gets called if the current version of WordPress is less than 4.7
	 * We are able to make use of filters to actually disable the functionality entirely
	 */
	function blueglass_Disable_Via_Filters() {
	    
		// Filters for WP-API version 1.x
	    add_filter( 'json_enabled', '__return_false' );
	    add_filter( 'json_jsonp_enabled', '__return_false' );

	    // Filters for WP-API version 2.x
	    add_filter( 'rest_enabled', '__return_false' );
	    add_filter( 'rest_jsonp_enabled', '__return_false' );

	    // Remove REST API info from head and headers
	    remove_action( 'xmlrpc_rsd_apis', 'rest_output_rsd' );
	    remove_action( 'wp_head', 'rest_output_link_wp_head', 10 );
	    remove_action( 'template_redirect', 'rest_output_link_header', 11 );

	    // Disable REST API link tag
		remove_action('wp_head', 'rest_output_link_wp_head', 10);

		// Disable oEmbed Discovery Links
		remove_action('wp_head', 'wp_oembed_add_discovery_links', 10);

		// Disable REST API link in HTTP headers
		remove_action('template_redirect', 'rest_output_link_header', 11, 0);
		
	}

	/**
	 * Returning an authentication error if a user who is not logged in tries to query the REST API
	 * @param $access
	 * @return WP_Error
	 */
	function blueglass_only_allow_logged_in_rest_access( $access ) {

		if( ! is_user_logged_in() ) {
	        return new WP_Error( 'rest_cannot_access', __( 'Only authenticated users can access the REST API.', 'disable-json-api' ), array( 'status' => rest_authorization_required_code() ) );
	    }

	    return $access;
		
	}

	// Disallow file edit
	function blueglass_security_dissalow_file_edit() {
		define( 'DISALLOW_FILE_EDIT', true );
	}
	
	/* Hide WP version strings from scripts and styles
	 * @return {string} $src
	 * @filter script_loader_src
	 * @filter style_loader_src
	 */
	function bgsecure_remove_wp_version_strings( $src ) {
	     global $wp_version;
	     parse_str(parse_url($src, PHP_URL_QUERY), $query);
	     if ( !empty($query['ver']) && $query['ver'] === $wp_version ) {
	          $src = remove_query_arg('ver', $src);
	     }
	     return $src;
	}

	/* Hide WP version strings from generator meta tag */
	function bgsecure_remove_version() {
		return false;
	}

	function blueglass_security_remove_wp_version_string() {
		add_filter('the_generator', 'bgsecure_remove_version');
		add_filter( 'script_loader_src', 'bgsecure_remove_wp_version_strings' );
		add_filter( 'style_loader_src', 'bgsecure_remove_wp_version_strings' );

		
		//wpml
		global $sitepress;
		remove_action( 'wp_head', array( $sitepress, 'meta_generator_tag', 20 ) );
        
        // Remove All Yoast HTML Comments
        // https://gist.github.com/paulcollett/4c81c4f6eb85334ba076
        if (defined('WPSEO_VERSION')){
          add_action('get_header',function (){ ob_start(function ($comment){
          return preg_replace('/\n?<.*?yoast.*?>/mi','',$comment); }); });
          add_action('wp_head',function (){ ob_end_flush(); }, 999);
        }
	}
?>