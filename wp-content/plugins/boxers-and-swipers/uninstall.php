<?php
/**
 * Uninstall
 *
 * @package Add Multiple User
 */

if ( ! defined( 'WP_UNINSTALL_PLUGIN' ) ) {
	exit();
}

global $wpdb;
$option_names = array();
$wp_options = $wpdb->get_results(
	"
				SELECT option_name
				FROM $wpdb->options
				WHERE option_name LIKE '%%boxersandswipers_%%'
				"
);
foreach ( $wp_options as $wp_option ) {
	$option_names[] = $wp_option->option_name;
}

$args = array(
	'post_type' => 'any',
	'numberposts' => -1,
);
$allposts = get_posts( $args );

/* For Single site */
if ( ! is_multisite() ) {
	foreach ( $option_names as $option_name ) {
		delete_option( $option_name );
	}
	foreach ( $allposts as $postinfo ) {
		delete_post_meta( $postinfo->ID, 'boxersandswipers_exclude' );
	}
} else {
	/* For Multisite */
	global $wpdb;
	$blog_ids = $wpdb->get_col( "SELECT blog_id FROM $wpdb->blogs" );
	$original_blog_id = get_current_blog_id();
	foreach ( $blog_ids as $blogid ) {
		switch_to_blog( $blogid );
		foreach ( $option_names as $option_name ) {
			delete_option( $option_name );
		}
		foreach ( $allposts as $postinfo ) {
			delete_post_meta( $postinfo->ID, 'boxersandswipers_exclude' );
		}
	}
	switch_to_blog( $original_blog_id );

	/* For site options. */
	foreach ( $option_names as $option_name ) {
		delete_site_option( $option_name );
	}
	foreach ( $allposts as $postinfo ) {
		delete_post_meta( $postinfo->ID, 'boxersandswipers_exclude' );
	}
}


