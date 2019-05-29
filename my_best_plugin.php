<?php
/*
Plugin Name: MyBestPlugin
Plugin URI: http://
Description: Тестовый плагин. Позволяет добавлять статьи в избранное
Version: 1.0
Author: Максим Ященко
Author URI: http://
*/

function mbpl_return_the_excerpt($excerpt){
	if ( (is_home() || is_archive()) && is_user_logged_in() ) {return $excerpt. "<br><p class='mbpl-hidden'>Обработка...</p><a href='#' class='mbpl-link'>ADD TO FAVOURITE</a>";}
	return $excerpt.'!!!!!FUCK!!!!!';
}

function mbpl_return_the_content($content){
	if ( is_user_logged_in() && (is_home() || is_archive()) ) {return $content. "<p class='mbpl-hidden'>Обработка...</p><a href='#' class='mbpl-link'>ADD TO FAVOURITE</a>";}
	return $content."<p class='mbpl-hidden'>Обработка...</p><a href='#' class='mbpl-link'>ADD TO FAVOURITE</a>";	
}

function mbpl_enqueue_scripts(){
	// if ( is_user_logged_in() && (is_home() || is_archive()) ){
		wp_enqueue_script('mbpl-ajax', plugins_url('/public/js/mbpl-ajax.js', __FILE__), array('jquery'), 1, true);
		wp_enqueue_style('mbpl-style', plugins_url('/public/css/mbpl-style.css', __FILE__));
		global $post;
		wp_localize_script('mbpl-ajax', 'mbplAjax',  [
				'ajaxurl' => admin_url('admin-ajax.php'),
				'nonce' => wp_create_nonce('mbpl-nonce'),
				'postId' => $post->ID,

			]);		

	//}	
}

function mbpl_ajax_link(){
	// if( isset($_POST['test'])){
	// 	print_r($_POST);
	// }
	// wp_die('End od zapros');
	if( !wp_verify_nonce( $_POST['nonce'], 'mbpl-nonce') ){
		wp_die('NONCE PZDC');
	}
	//wp_die('End od zapros');
	echo (int)$_POST['postId'];
	wp_die(); 
}

add_filter('the_excerpt', 'mbpl_return_the_excerpt');
add_filter('the_content', 'mbpl_return_the_content');
add_action('wp_enqueue_scripts', 'mbpl_enqueue_scripts');
add_action('wp_ajax_mbpl_ajax_link', 'mbpl_ajax_link');
 

