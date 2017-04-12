<?php  
	/*
	Theme Ajax functions
	
	Hint:
	filter_input(INPUT_POST, 'var_name') 	instead of $_POST['var_name']
	filter_input_array(INPUT_POST) 			instead of $_POST
	
	*/


	// Ajax example

	add_action('wp_ajax_re_update_guru', 're_update_guru');
	add_action('wp_ajax_nopriv_re_update_guru', 're_update_guru' );
	
	function re_update_guru() {
		$input_post = filter_input_array(INPUT_POST);
		unset( $input_post['action'] );

		$response = 'not ok';

		if( isset($input_post['step-1']) and isset($input_post['step-6']) ){

			$var = filter_input(INPUT_POST, 'var_name');
			
			$response = 'ok';
		}

		/////
		echo $response;
		wp_die();
	}

?>