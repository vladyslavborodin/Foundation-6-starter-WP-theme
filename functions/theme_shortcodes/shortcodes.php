<?php


function do_step($atts, $content = null){
	extract(shortcode_atts(
        array(
            'num' => '1',
    ), $atts));

    $output = '<div class="process clearfix process-step-'.$num.'">';
	    $output .= '<div class="wrap">';
	   		$output .= do_shortcode($content);
	    $output .= '</div>';
    $output .= '</div>';

    return $output;
}


add_shortcode('step', 'do_step');





function do_clearfix($atts, $content = null){
	extract(shortcode_atts(
        array(
            'class' => ''
    ), $atts));


    $output = '<div class="clearfix '.$class.'">';
	   	$output .= do_shortcode($content);
    $output .= '</div>';

    return $output;
}
add_shortcode('clearfix', 'do_clearfix');


function do_row($atts, $content = null){
    extract($atts);

    $output = '<div class="row">';
	   	$output .= do_shortcode($content);
    $output .= '</div>';

    return $output;
}
add_shortcode('row', 'do_row');


function do_box($atts, $content = null){
    extract($atts);
    
    $output = '<div class="box">';
	   	$output .= do_shortcode($content);
    $output .= '</div>';

    return $output;
}
add_shortcode('box', 'do_box');


function do_grid($atts, $content = null){
	extract(shortcode_atts(
        array(
            'large' => '4',
            'medium' => '6',
            'class' => ''
    ), $atts));

    $output = '<div class="columns medium-'.$medium.' large-'.$large.' '.$class.'">';
	    $output .= '<div class="wrap">';
	   		$output .= do_shortcode($content);
	    $output .= '</div>';
    $output .= '</div>';

    return $output;
}


add_shortcode('grid', 'do_grid');


function do_name($atts){
	extract(shortcode_atts(
        array(
            'title' => 'Илья Семёнов',
            'subtitle' => 'Руководитель компании «МузКафе»',
            'class' => 'green'
    ), $atts));

    $output = '<div class="thename '.$class.'">';
	    $output .= '<h3 class="name">';
	   		$output .= $title;
	    $output .= '</h3>';
	    $output .= '<h5 class="name">';
	   		$output .= $subtitle;
	    $output .= '</h5>';
    $output .= '</div>';

    return $output;
}


add_shortcode('name', 'do_name');


function do_hide_on_mobile($atts, $content = null){
    extract($atts);
    
	$output = '<div class="show-for-medium-up">';
	   	$output .= do_shortcode($content);
    $output .= '</div>';

    return $output;
}
add_shortcode('hide_on_mobile', 'do_hide_on_mobile');



function do_button($atts){
	extract(shortcode_atts(
        array(
            'title' => 'Кнопка',
            'url' => '#',
            'class' => 'red'
    ), $atts));
	$output = '';
	if($class == 'guru2') $output .= '<span class="preguru">';
    	$output .= '<a href="'.$url.'" class="content-btn '.$class.'">'.$title.'</a>';
    if($class == 'guru2') $output .= '</span>';
    return $output;
}


add_shortcode('button', 'do_button');


/**
 * Dropcap
 *
 */

function dropcap_shortcode($atts) {

    extract(shortcode_atts(
        array(
            'num' => '1',
            'heading' => '',
            'text' => '',
            'class' => 'white'
    ), $atts));

    //$svg = get_bloginfo('template_url') . '/i/dropcap.svg';
    //$svg = file_get_contents($svg);

    $output = '<div class="dropcap columns medium-12 color-'.$class.' fix_dropcap">';
	    $output .= '<div class="cap">';
	    	$output .= '<div class="num">'.$num.'</div>'; 	
	    	//$output .= $svg;
	    $output .= '</div>';
	    $output .= '<div class="wr">';
	    	$output .= '<h3>'.$heading.'</h3>';
	    	$output .= '<p>'.$text.'</p>';
	    $output .= '</div>';
    $output .= '</div><!-- .dropcap (end) -->';

    return $output;

}

add_shortcode('dropcap', 'dropcap_shortcode');


	
//Tag Cloud

function shortcode_tags() {

	$output = '<div class="tags-cloud clearfix">';

	$tags = wp_tag_cloud('smallest=8&largest=8&format=array');

	foreach($tags as $tag){
			$output .= $tag.' ';
	}

	$output .= '</div><!-- .tags-cloud (end) -->';

	return $output;

}

add_shortcode('tags', 'shortcode_tags');





//add_action( 'after_setup_theme', 'my_setup' );
?>