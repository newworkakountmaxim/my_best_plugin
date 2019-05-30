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
	if(mbpl_is_add(get_the_ID())){$text="del";}else
	$text="add" ;
	if ( (is_home() || is_archive()) && is_user_logged_in() ) {return $excerpt. "<br><p class='mbpl-hidden'>Обработка...</p><a href='#' class='mbpl-link' data-mbpl-id='".get_the_ID()."'>".$text."</a>";}
	return $excerpt.'!!!!!FUCK!!!!!';
}

function mbpl_return_the_content($content){
	if(mbpl_is_add(get_the_ID())){$text="del";}else
	$text="add" ;
	if ( is_user_logged_in() && (is_home() || is_archive()) ) {return $content. "<p class='mbpl-hidden'>Обработка...</p><a href='#' class='mbpl-link' data-mbpl-id='".get_the_ID()."'>".$text."</a>";}
	return $content."<p class='mbpl-hidden'>Обработка...</p><a href='#' class='mbpl-link' data-mbpl-id='".get_the_ID()."'>".$text."</a>";	
}

function mbpl_enqueue_scripts(){
	// if ( is_user_logged_in() && (is_home() || is_archive()) ){
		wp_enqueue_script('mbpl-ajax', plugins_url('/public/js/mbpl-ajax.js', __FILE__), array('jquery'), 1, true);
		wp_enqueue_style('mbpl-style', plugins_url('/public/css/mbpl-style.css', __FILE__));
		//global $post;
		wp_localize_script('mbpl-ajax', 'mbplAjax',  [
				'ajaxurl' => admin_url('admin-ajax.php'),
				'nonce' => wp_create_nonce('mbpl-nonce'),
				//'postId' => $post->ID,
				//'content' => $content,
			]);
	//}	
}

function mbpl_ajax_link(){
	
	if( !wp_verify_nonce( $_POST['nonce'], 'mbpl-nonce') ){
		wp_die('NONCE PZDC');
	}	
	$current_user = wp_get_current_user();
	$post_id = $_POST["postId"];
	
	//mbpl_is_add($post_id);
	if(mbpl_is_add($post_id)) wp_die('Так не пойдет!!!!!');
	if(add_user_meta( $current_user->ID, 'mbpl_post_add', $post_id )){wp_die('Добавлено с ИД: '.$post_id);}

	wp_die('ERROR'); 
}

function mbpl_is_add($post_id){
	$current_user = wp_get_current_user();
	$add_posts = get_user_meta($current_user->ID, 'mbpl_post_add');
	foreach ($add_posts as $add_post) {
		if ($add_post == $post_id) {return true;}		
		//echo "uzhe".$add_post."/new".$post_id."<br>";		
	}
	return false;
}

add_filter('the_excerpt', 'mbpl_return_the_excerpt');
add_filter('the_content', 'mbpl_return_the_content');
add_action('wp_enqueue_scripts', 'mbpl_enqueue_scripts');
add_action('wp_ajax_mbpl_ajax_link', 'mbpl_ajax_link');
 

