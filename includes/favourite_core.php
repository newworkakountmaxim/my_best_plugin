<?php 
function mbpl_return_the_excerpt($excerpt){
	 //&#9829 &#10008
	if(mbpl_is_add(get_the_ID())){$text="delete";}else
	$text="add" ;
	if ( (is_home() || is_archive()) && is_user_logged_in() ) {return $excerpt. "<br><p class='mbpl-hidden'>Обработка...</p><a href='#' class='mbpl-link' data-mbpl-action='".$text."' data-mbpl-id='".get_the_ID()."'>".$text."</a>";}
	return $excerpt.'!!!!!FUCK!!!!!';
}

function mbpl_return_the_content($content){
	if(mbpl_is_add(get_the_ID())){$text="delete";}else
	$text="add" ;
	if ( is_user_logged_in() && (is_home() || is_archive()) ) {return $content. "<p class='mbpl-hidden'>Обработка...</p><a href='#' class='mbpl-link' data-mbpl-action='".$text."' data-mbpl-id='".get_the_ID()."'>".$text."</a>";}
	return $content."<p class='mbpl-hidden'>Обработка...</p><a href='#' class='mbpl-link' data-mbpl-action='".$text."' data-mbpl-id='".get_the_ID()."'>".$text."</a>";	
}

function mbpl_enqueue_scripts(){
	// if ( is_user_logged_in() && (is_home() || is_archive()) ){
		wp_enqueue_script('mbpl-ajax', plugins_url('../public/js/mbpl-ajax.js', __FILE__), array('jquery'), 1, true);
		wp_enqueue_style('mbpl-style', plugins_url('../public/css/mbpl-style.css', __FILE__));		
		wp_localize_script('mbpl-ajax', 'mbplAjax',  [
				'ajaxurl' => admin_url('admin-ajax.php'),
				'nonce' => wp_create_nonce('mbpl-nonce'),				
			]);
	//}	
}

function mbpl_ajax_add(){
	
	if( !wp_verify_nonce( $_POST['nonce'], 'mbpl-nonce') ){
		wp_die('NONCE PZDC');
	}	
	$current_user = wp_get_current_user();
	$post_id = $_POST["postId"];	
	
	if(mbpl_is_add($post_id)) wp_die('Так не пойдет!!!!!');
	if(add_user_meta( $current_user->ID, 'mbpl_post_add', $post_id )){wp_die('Добавлено'.$post_id);}

	wp_die('ERROR ADD'); 
}

function mbpl_ajax_delete(){
	
	if( !wp_verify_nonce( $_POST['nonce'], 'mbpl-nonce') ){
		wp_die('NONCE ERROR');
	}	
	$current_user = wp_get_current_user();
	$post_id = $_POST["postId"];	
	
	if(!mbpl_is_add($post_id)) wp_die('Так не пойдет!!!!!');
	if(delete_user_meta( $current_user->ID, 'mbpl_post_add', $post_id )){
		//var_dump( plugins_url('',__FILE__).'/templates/' );
		//var_dump( locate_template('templates/page/') );
		wp_die('Удалено'.$post_id);
	}

	wp_die('ERROR DELETE'); 
}

function mbpl_is_add($post_id){
	$current_user = wp_get_current_user();
	$add_posts = get_user_meta($current_user->ID, 'mbpl_post_add');
	foreach ($add_posts as $add_post) {
		if ($add_post == $post_id) {return true;}			
	}
	return false;
}


// add_filter('theme_page_templates', function( $templates ){
// 	$templates_dir = 'templates/page/';
// 	//$templates_dir = plugins_url('',__FILE__).'/';
// 	$templates_files = scandir(locate_template($templates_dir));
// 	//$templates_files = scandir($templates_dir);
// 	foreach ( $templates_files as $file ) {
// 		if ( $file == '.' || $file == '..') continue;
// 		$name = explode('.', $file);
// 		$templates[$templates_dir.$file] = $name[0];
// 	}
// 	return $templates; 
// });

// function wpse255804_redirect_page_template ($template) {
//     //if ('my-custom-template.php' == basename ($template))
//         $template = WP_PLUGIN_DIR . '/my_best_plugin/templates/test.php';
//     return $template;
//     }
// add_filter ('page_template', 'wpse255804_redirect_page_template');