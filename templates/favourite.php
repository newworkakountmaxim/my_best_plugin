<?php
/**
    * Template Name: mbpl_favourite_template
    * @package
    * @copyright
*/
get_header();
echo "<main><div class='mbpl-content'>";
echo "<h1 class='mbpl-h1'>Избранные посты!</h1><hr>";
$current_user = wp_get_current_user();
$add_posts = get_user_meta($current_user->ID, 'mbpl_post_add');
if(!$add_posts){
	echo "<h2>NO FAVOURITE POSTS</h2>";
	return;
}else{
	foreach ($add_posts as $add_post) {		
		wp_reset_postdata();		
		echo "<div><h2>".get_the_title($add_post)."</h2>".get_the_excerpt($add_post)."</div>";
	}
}
echo "</div></main>";
get_footer();