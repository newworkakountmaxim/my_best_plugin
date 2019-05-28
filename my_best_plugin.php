<?php
/*
Plugin Name: MyBestPlugin
Plugin URI: http://
Description: Тестовый плагин. Позволяет добавлять статьи в избранное
Version: 1.0
Author: Максим Ященко
Author URI: http://
*/


function my_test_the_content($the_content){
	return 'aaa'.get_the_ID();
}

function my_test_the_title($title){
	return $title.get_the_ID();
}

function mbpl_return_the_excerpt($excerpt){
	if (!is_archive() || !is_user_logged_in()) {return $excerpt.'!!!!!FUCK!!!!!';}
	return $excerpt.'<a href="#">BUTTON</a>';
}

function mbpl_return_the_content($content){
	if (!is_archive() || !is_user_logged_in()) {return $content.'!!!!!FUCK!!!!!';}
	return $content.'<a href="#">BUTTON</a>';
}


function my_test_the_archive_title($archive_title){
	return 'archive_title'.get_the_ID();
}


add_filter('the_content', 'my_test_the_content');
add_filter('the_title', 'my_test_the_title');
add_filter('the_archive_title', 'my_test_the_archive_title');
add_filter('the_excerpt', 'mbpl_return_the_excerpt');
add_filter('the_content', 'mbpl_return_the_content');
 
function my_install()
{    
    flush_rewrite_rules();
}
register_activation_hook( __FILE__, 'my_install' );

function my_deactivation()
{
    
    flush_rewrite_rules();
}
register_deactivation_hook( __FILE__, 'my_deactivation' );
