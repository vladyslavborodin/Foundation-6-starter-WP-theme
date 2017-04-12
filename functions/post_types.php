<?php
	
	/* The Custom Post Types */
	

	function bg_register_post_type_team() {
		$labels = array(
			'name'               => __('Team','blueglass'),
			'singular_name'      => __('Team','blueglass'),
			'add_new'            => __('Add memeber','blueglass'),
			'add_new_item'       => __('Add new memeber','blueglass'),
			'new_item'           => __('New memeber','blueglass'),
			'edit_item'          => __('Update memeber','blueglass'),
			'view_item'          => __('View memeber','blueglass'),
			'all_items'          => __('All memebers','blueglass'),
		);
		register_post_type( 'team',
			array( 
				'labels' => $labels,
				'menu_position' => 21,
				'_builtin' => false,
				'exclude_from_search' => true, // Exclude from Search Results
				'capability_type' => 'post',
				'public' => true, 
				'show_ui' => true,
				'show_in_nav_menus' => false,
				'rewrite' => array(
					'slug' => 'team',
					'with_front' => false,
				),
				'query_var' => "team", // This goes to the WP_Query schema
				'menu_icon' => 'dashicons-groups',
				'supports' => array(
					'title',
					'editor' => false,
				),
			)
		);
		/*
		register_taxonomy('case_studies_category', 'case_studies', array(
				'hierarchical' => true, 
				'label' => __('Categories','blueglass'), 
				'singular_name' => __('Category','blueglass'), 
				"rewrite" => true, "query_var" => true
				));
		*/
	}

	add_action('init', 'bg_register_post_type_team');