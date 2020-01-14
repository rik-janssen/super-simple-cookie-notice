<?php 
/**
* Plugin Name: Super Simple Cookie Notice
* Plugin URI: https://betacore.tech/plugins/super-simple-age-gate-for-wordpress/
* Description:  Completely hide your website from people that don't want to accept cookies but allow crawlers to do their job.
* Version: 1
* Author: Rik Janssen (Beta)
* Author URI: https://betacore.tech/
* Text Domain: betacookie
* Domain Path: /lang
**/

/* Includes */
include_once('inc/functions-nav.php'); // the wp-admin navigation
include_once('inc/functions-wp-admin.php'); // the wp-admin navigation
include_once('inc/functions-cookie.php'); // cookie notice stuff


/* make the plugin page row better */

function bcCOO_pl_links( $links ) {

	$links = array_merge( array(
		'<a href="' . esc_url( 'https://www.paypal.com/donate/?token=y9x2_N0_18pSbdHE9l9jivsqB3aTKgWQ3qGgxg_t6VUUmSU6B2H1hUcANUBzhX5xV0qg2G&country.x=NL&locale.x=NL' ) . '">' . __( 'Donate', 'betagate' ) . '</a>'
    ), $links );

    $links = array_merge( array(
		'<a href="' . esc_url( admin_url( '/options-general.php?page=bcCOO_cookie_settings' ) ) . '">' . __( 'Settings', 'betacookie' ) . '</a>'
    ), $links );
    
	return $links;
}

add_action( 'plugin_action_links_' . plugin_basename( __FILE__ ), 'bcCOO_pl_links' );
?>
