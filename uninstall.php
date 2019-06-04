<?php 
if (!defined('WP_UNINSTALL_PLUGIN')) {
    die;
}
 
$current_user = wp_get_current_user();

delete_user_meta( $current_user->ID, 'mbpl_post_add');