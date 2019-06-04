<?php 
function mbpl_return_the_excerpt($excerpt){	 
	if(mbpl_is_add(get_the_ID())){$text="delete";}else
	$text="add" ;
	if ( (is_home() || is_archive()) && is_user_logged_in() ) {return $excerpt. "<br><p class='mbpl-hidden'>Обработка...</p><a href='#' class='mbpl-link' data-mbpl-action='".$text."' data-mbpl-id='".get_the_ID()."'>".$text."</a>";}
	return $excerpt;
}

function mbpl_return_the_content($content){
	if(mbpl_is_add(get_the_ID())){$text="delete";}else
	$text="add" ;
	if ( is_user_logged_in() && (is_home() || is_archive()) ) {return $content. "<p class='mbpl-hidden'>Обработка...</p><a href='#' class='mbpl-link' data-mbpl-action='".$text."' data-mbpl-id='".get_the_ID()."'>".$text."</a>";}
	return $content;	
}

function mbpl_return_the_title($title){
	if(mbpl_is_add(get_the_ID())){$text="delete";}else
	$text="add" ;
	if ( is_user_logged_in() && (is_home() || is_archive()) ) {return $title. "<p class='mbpl-hidden'>Обработка...</p><a href='#' class='mbpl-link' data-mbpl-action='".$text."' data-mbpl-id='".get_the_ID()."'>".$text."</a>";}
	return $title;	
}

function mbpl_enqueue_scripts(){
	if ( is_user_logged_in() && (is_home() || is_archive() || is_page_template('MBPL-favourite') ) ){
		wp_enqueue_script('mbpl-ajax', plugins_url('../public/js/mbpl-ajax.js', __FILE__), array('jquery'), 1, true);
		wp_enqueue_style('mbpl-style', plugins_url('../public/css/mbpl-style.css', __FILE__));		
		wp_localize_script('mbpl-ajax', 'mbplAjax',  [
				'ajaxurl' => admin_url('admin-ajax.php'),
				'nonce' => wp_create_nonce('mbpl-nonce'),				
			]);
	}		
}

function mbpl_admin_enqueue_scripts(){
	if (is_admin()) { wp_enqueue_style( 'mbpl-admin-style', plugins_url('../admin/css/mbpl-admin-style.css', __FILE__) );}
}

function mbpl_ajax_add(){
	
	if( !wp_verify_nonce( $_POST['nonce'], 'mbpl-nonce') ){
		wp_die('NONCE PZDC');
	}	
	$current_user = wp_get_current_user();
	$post_id = $_POST["postId"];	
	
	if(mbpl_is_add($post_id)) wp_die('Ошибка добавления');
	if(add_user_meta( $current_user->ID, 'mbpl_post_add', $post_id )){wp_die('Добавлено');}

	wp_die('ERROR ADD'); 
}

function mbpl_ajax_delete(){
	
	if( !wp_verify_nonce( $_POST['nonce'], 'mbpl-nonce') ){
		wp_die('NONCE ERROR');
	}	
	$current_user = wp_get_current_user();
	$post_id = $_POST["postId"];	
	
	if(!mbpl_is_add($post_id)) wp_die('Ошибка удаления');
	if(delete_user_meta( $current_user->ID, 'mbpl_post_add', $post_id )){		
		wp_die('Удалено');
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

function mbpl_admin_widget(){
	wp_add_dashboard_widget('mbpl_admin_widget', 'Список избранных постов', 'mbpl_admin_widget_content');
}

function mbpl_admin_widget_content(){
	$current_user = wp_get_current_user();
	$add_posts = get_user_meta($current_user->ID, 'mbpl_post_add');
	if(!$add_posts){
		echo "NO FAVOURITE_POST";
		return;
	}else{
		foreach ($add_posts as $add_post) {
			echo "<a class='mbpl_admin-h3' href='".get_permalink($add_post)."'>".get_the_title($add_post)."</a>";
		}
	}
}


