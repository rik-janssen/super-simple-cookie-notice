<?php


/* ---------------------------------------- */
/* Setting up the navigation */

function bcCOO_admin_menu_sub_agegate() {
    
    // add the sub menu page for the plugin
	// https://codex.wordpress.org/Adding_Administration_Menus
    add_submenu_page( 
        'options-general.php', 
        'GDPR Settings', 
        'GDPR Settings', 
        'manage_options', 
        'bcCOO_cookie_settings', 
        'bcCOO_function_for_sub'  // this should correspond with the function name
    ); 
}

add_action( 'admin_menu', 'bcCOO_admin_menu_sub_agegate' );



?>