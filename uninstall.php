<?php
// if uninstall.php is not called by WordPress, die
if (!defined('WP_UNINSTALL_PLUGIN')) {
    die();
}else{

	delete_option( 'bcCOO_cookie_active' );
	delete_option( 'bcCOO_gate_cookietime' );
	delete_option( 'bcCOO_gate_theme' );
	delete_option( 'bcCOO_gate_logo' );
    delete_option( 'bcCOO_gate_message' );
	delete_option( 'bcCOO_gate_message_footer' );
	delete_option( 'bcCOO_gate_background_image' );
	delete_option( 'bcCOO_gate_css' );
    delete_option( 'bcCOO_gate_cookietime' );
	delete_option( 'bcCOO_page_cookie' );
	delete_option( 'bcCOO_page_privacy' );
    delete_option( 'bcCOO_page_disclaimer' );

	
}
?>