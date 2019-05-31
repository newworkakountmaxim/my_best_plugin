<?php
/*
Plugin Name: MyBestPlugin
Plugin URI: http://
Description: Тестовый плагин. Позволяет добавлять статьи в избранное
Version: 1.0
Author: Максим Ященко
Author URI: http://
*/

require_once( __DIR__ . '/includes/create_template_core.php' );
require_once( __DIR__ . '/includes/favourite_core.php' );



add_filter('the_excerpt', 'mbpl_return_the_excerpt');
add_filter('the_content', 'mbpl_return_the_content');
add_action('wp_enqueue_scripts', 'mbpl_enqueue_scripts');
add_action('wp_ajax_mbpl_ajax_add', 'mbpl_ajax_add');
add_action('wp_ajax_mbpl_ajax_delete', 'mbpl_ajax_delete');

