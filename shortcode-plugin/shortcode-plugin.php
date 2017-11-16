<?php 

/**

Plugin Name: CMS 2 Labb 1 Shortcode / Uppgift 1
Author: Oskar och Tobias

*/


//Register css
function pluginShortcodeStyle() {
	wp_enqueue_style( 'button-style',  plugin_dir_url( __FILE__ ) . 'css/style.css' );
}
add_action( 'wp_enqueue_scripts', 'pluginShortcodeStyle' );

//Shortcode with attributes
function addButton($atts) {
	$a = shortcode_atts([
		'text' 	=> 'knapp',
		'color' => 'grey',
		'url'	=> null,
		'width'	=> null,
		'class'	=> null,
		'style'	=> null
	], $atts);


	//Check if attributes are set
	if (isset($atts['url'])) {
		$url = 'href="'. $atts['url'] .'"';
	} 

	if (isset($atts['width'])) {
		$width = ' width:'. $atts['width'] .'px;'; 
	}

	if (isset($atts['class'])) {
		$class = ' class="'. $atts['class'] .'"';
	}

	if (isset($atts['style'])) {
		$style = $atts['style'];
	}

	$text = isset($atts['text']) ? $atts['text'] : $a['text'];
	$color = isset($atts['color']) ? $atts['color'] : $a['color'];
	

	
	return '<div class="button"><a '.$url . $class .' style="background-color:'. $color .';'. $width . $style .'">'. $text .'</a></div>';

}

add_shortcode('button', 'addButton');