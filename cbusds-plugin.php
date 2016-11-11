<?php
/*
Plugin Name: CBUS Digital Signage Content
*/

if( !defined( 'WPINC' )) {
	die;
}

require_once plugin_dir_path( __FILE__ ) . 'inc/class-cbus-dsc-manager.php';

function run_cbusdsc_manager() {
	$cbusdsc = new CBUS_DSC_Manager();
	$cbusdsc->run();
}

add_action('wp_ajax_GetInfo', 'get_info_cb');
add_action('wp_ajax_nopriv_GetInfo', 'get_info_cb');
add_action('wp_ajax_GetRunningText', 'get_running_text_cb');
add_action('wp_ajax_nopriv_GetRunningText', 'get_running_text_cb');
add_action('wp_ajax_GetYoutube', 'get_youtube_cb');
add_action('wp_ajax_nopriv_GetYoutube', 'get_youtube_cb');
function get_running_text_cb() {
	$option = get_option( 'cbus_dsc_options' );

	if( $option['running_text'] !== "" && !is_null($option['running_text'])) {
		$options['running_text']['text'] = $option['running_text'];
	}
	if( $option['duration'] !== "" && !is_null($option['duration']) && $option['duration'] > 0) {
		$options['running_text']['duration'] = $option['duration'];
	}
	echo json_encode($options);
	wp_die();
}
function get_info_cb() {
	$option = get_option( 'cbus_dsc_options' );
	$options['info'] = array();
	for($i=0; $i<5; $i++) {
		// if( $option['info_text'.$i] !== "" && !is_null($option['info_text'.$i] ) ) {
			$options['info'][$i] = $option['info_text'.($i+1)];
		// }
	}
	echo json_encode($options);
	wp_die();
}
function get_youtube_cb() {
	$option = get_option('cbus_dsc_options');
	$options = array();
	if( $option['youtube_link'] !== "" && !is_null($option['youtube_link']) ) {
		$options['youtube']['link'] = $option['youtube_link'];
		$options['youtube']['status'] = true;
	}else {
		$options['youtube']['status'] = false;
	}

	echo json_encode($options);
	wp_die();
}


run_cbusdsc_manager();