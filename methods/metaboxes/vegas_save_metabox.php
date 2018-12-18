<?php
if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

global $post; 
if (defined('DOING_AUTOSAVE') && DOING_AUTOSAVE)
return;

if ($post->post_type != 'vegas'){
    return;
}

if (!current_user_can('edit_post', $post_id))
return;

if ( isset( $_POST['imgIDs'] ) ) {
	$imgIDs = sanitize_text_field( $_POST['imgIDs'] );
	add_post_meta($post_id, "imgIDs", $imgIDs, true) or update_post_meta( $post_id, "imgIDs", $imgIDs );
}

if ( isset( $_POST['vegas_selected_checkbox'] ) ) {
	$enabled = $_POST['vegas_selected_checkbox'] == 'on' ? 1 : 0;
	
	if ( $_POST['vegas_selected_checkbox'] == 'on' ) {
		$posts = get_posts(['post_type' => 'vegas', 'numberposts' => -1,]);
        foreach ($posts as $p) {
            add_post_meta($p->ID, "vegas-enabled", 0, true) or update_post_meta( $p->ID, "vegas-enabled", 0 );
        }
    }
    add_post_meta($post_id, "vegas-enabled", $enabled, true) or update_post_meta( $post_id, "vegas-enabled", $enabled );
}

if ( isset( $_POST['vegas_events_checkbox'] ) ) {
	$events_enabled = $_POST['vegas_events_checkbox'] == 'on' ? 1 : 0;
	
	if ( $_POST['vegas_events_checkbox'] == 'on' ) {
		$posts = get_posts(['post_type' => 'vegas', 'numberposts' => -1,]);
        foreach ($posts as $p) {
            add_post_meta($p->ID, "vegas-events-enabled", 0, true) or update_post_meta( $p->ID, "vegas-events-enabled", 0 );
        }
    }
    add_post_meta($post_id, "vegas-events-enabled", $enabled, true) or update_post_meta( $post_id, "vegas-events-enabled", $enabled );
}

if ( isset( $_POST['genShortcode'] ) ) {
    $genShortcode = sanitize_text_field( $_POST['genShortcode'] );
    add_post_meta($post_id, "genShortcode", $genShortcode, true) or update_post_meta( $post_id, "genShortcode", $genShortcode );
}
