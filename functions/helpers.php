<?php 
	/*
	Theme Helper functions
	*/


	// Add RSS links to <head> section
	// add_theme_support( 'automatic-feed-links' );

	// Removes from admin bar
	function mytheme_admin_bar_render() {
		global $wp_admin_bar;
		$wp_admin_bar->remove_menu('comments');
	}
	//add_action( 'wp_before_admin_bar_render', 'mytheme_admin_bar_render' );

	

	// Clean up the <head>
	function removeHeadLinks() {
    	remove_action('wp_head', 'rsd_link');
    	remove_action('wp_head', 'wlwmanifest_link');
    }
    add_action('init', 'removeHeadLinks');
    remove_action('wp_head', 'wp_generator');



	function cc_mime_types($mimes) {
	  	$mimes['svg'] = 'image/svg+xml';
	  	return $mimes;
	}
	add_filter('upload_mimes', 'cc_mime_types');



	function fix_svg_thumb_display() {
	  echo '
	    td.media-icon img[src$=".svg"], img[src$=".svg"].attachment-post-thumbnail { 
	      width: 100% !important; 
	      height: auto !important; 
	    }
	  ';
	}
	//add_action('admin_head', 'fix_svg_thumb_display');
	
	

	function make_blog_name_from_name() {
		return get_bloginfo('name');
	}
	function make_blog_email_from_host(){
		return 'noreply@' . filter_input(INPUT_SERVER, 'SERVER_NAME', FILTER_SANITIZE_STRING);
	}
	//add_filter('wp_mail_from_name', 'make_blog_name_from_name');
	//add_filter( 'wp_mail_from', 'make_blog_email_from_host' );
	
	

	// helps clearing get/post values
	function make_safe($variable) {
	    $variable = strip_tags(trim($variable));
	    return $variable;
	}


	// Apply parent template to all subpages
	add_action('template_redirect','switch_page_template');
	function switch_page_template() {
		global $post;
		// Checks if current post type is a page, rather than a post
		if (is_page()){	
			$ancestors = $post->ancestors;

			if ($ancestors) {
				$current_template = get_post_meta($post->ID,'_wp_page_template',true);
				$parent_template = get_post_meta(end($ancestors),'_wp_page_template',true);
				$template = TEMPLATEPATH . "/{$parent_template}";
				
				//print_r($current_page_template);
				if (file_exists($template)) {
					if( $current_template == 'default' ){
						load_template($template);
					}
				}
			}
		
		}
	}
	//
	
	
		
	// text trimmer
	function wpwr_trimmer($mytitle, $length){	
		if ( mb_strlen($mytitle) >$length ){
			$mytitle = mb_substr( $mytitle,0,$length);
			return $mytitle . '...';
		}
		return $mytitle;
	}
	
	function wpwr_extrimmer($mytitle, $length){	
		if ( mb_strlen($mytitle) >$length ){
			$mytitle = mb_substr( $mytitle,0,$length);
			return $mytitle . '... <img src="'. get_bloginfo('template_directory') .'/i/arrow2.png" alt=""/>';
		}
		return $mytitle;
	} 
	
	
	#
	# Function to return post featured image or first image in post
	#
	function get_that_image_url( $postid, $imagesize = 'large'){
		$img = wp_get_attachment_image_src( get_post_thumbnail_id( $postid ), $imagesize, false, '' );
		$img = $img[0];
		if( $img == '' ){
			$img = catch_that_image();
		}
		return $img;
	}
	
	
	function catch_that_image() {
	  	global $post, $posts;
	  	$first_img = '';
	  	ob_start();
	  	ob_end_clean();
	  	$output = preg_match_all('/<img.+src=[\'"]([^\'"]+)[\'"].*>/i', $post->post_content, $matches);
	  	$first_img = $matches [1] [0];

	  	if(empty($first_img)){ //Defines a default image
			$first_img = get_bloginfo('tmplate_url') . "/i/default.jpg";
	  	}
	  	return $first_img;
	}
	
	
	function wp_corenavi() {
	  	global $wp_query;
	  	$pages = '';
	  	$max = $wp_query->max_num_pages;
	  	if (!$current = get_query_var('paged')) $current = 1;
	  	$arr = array();
	  	$arr['base'] = str_replace(999999999, '%#%', get_pagenum_link(999999999));
	  	$arr['total'] = $max;
	  	$arr['current'] = $current;

	  	$total = 1; 
	  	$arr['mid_size'] = 3; 
	  	$arr['end_size'] = 1;
	  	$arr['prev_text'] = '&laquo;'; 
	  	$arr['next_text'] = '&raquo;'; 

	  	if ($max > 1) echo '<div class="navigation column medium-12">';
	  	if ($total == 1 && $max > 1) $pages = '<span class="pages">' . __('Page', 'blueglass') . $current . ' ' . __('of', 'blueglass') . ' ' . $max . '</span>'."\r\n";
	  	echo $pages . paginate_links($arr);
	 	if ($max > 1) echo '</div>';
	}



	/* Pagination with new WP_Query bug fix */
	/*
	 * Usage ex.
	 *
	 * $articles = new WP_Query($args);
	 * if($articles->have_posts()):
	 *  while($articles->have_posts()):$articles->the_post()
	 *  ..........
	 * endwhile;wp_corenavi2($articles);endif;wp_reset_query();
	 *
	 * */
    function wp_corenavi2($loop_arr = null) {
        global $wp_query;
        $or_query = $wp_query;

        if($loop_arr) $wp_query = $loop_arr;

        $max = $wp_query->max_num_pages;
        if (!$current = get_query_var('paged')) $current = 1;

        $args = array(
            'base' => str_replace(999999999, '%#%', get_pagenum_link(999999999)),
            'total' => $max,
            'current' => $current,
            'mid_side' => 3,
            'prev_text' => '&laquo;',
            'next_text' => '&raquo;'
        );

        if($max > 1)
            echo '<div class="pagination column medium-12">' . paginate_links($args) . '</div>';

        if($loop_arr) $wp_query = $or_query;

    }

	

	//add_filter( 'gettext', 'theme_change_fields', 20, 1 );
	// ( $translated_text, $text, $domain )
	function theme_change_fields( $translated_text ) {

		switch ( $translated_text ) {
	
			case 'Some text' :
	
				$translated_text = __( 'First Name ', 'theme_text_domain' );
				break;
	
			case 'Email' :
	
				$translated_text = __( 'Email Address', 'theme_text_domain' );
				break;
		}
	
	
		return $translated_text;
	}


    function remove_spaces($string)	{
        return preg_replace('/\s+/', '', $string);
    }

    function numbers_only($string){
        return preg_replace( '/[^0-9]/', '', $string );
    }


    function relative_time($id = '') {
        if($id){
            $post_date = get_the_time('U',$id);
        }else{
            $id = get_the_ID();
            $post_date = get_the_time('U',$id);
        }
        $cur_time = intval(current_time('timestamp'));

        $delta = $cur_time - $post_date;

        if ( $delta < 60 ) {
            _e('vähem kui minut tagasi','blueglass');
        }
        elseif ($delta > 120 && $delta < (60*60)){
            echo strval(round(($delta/60),0)) .  __(' minutit tagasi', 'blueglass');
        }elseif ($delta > (60*60) && $delta < (24*60*60)){
            echo strval(round(($delta/3600),0)) .  __(' tundi tagasi', 'blueglass');
        }
        else {
            echo get_the_date('d.m.Y',$id);
        }

    }


 ?>