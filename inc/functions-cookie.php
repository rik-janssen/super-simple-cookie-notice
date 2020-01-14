<?php

/* ---------------------------------------- */
/* creating age gate form functionality     */

function bcCOO_age_gate(){

	global $bcCOO_cookie_exists;
	global $bcCOO_error_message;
	global $bcCOO_minimum_age;
  global $bcCOO_cookie_time;
	
  // check if the age-gate already ran, if not. go for the prompt.
  

	if (get_option('bcCOO_cookie_active')==1){
    if($bcCOO_cookie_exists!=1){
			if (bcCOO_bot()==false){
                $bcCOO_page_id = get_queried_object_id();

                if(get_option('bcCOO_page_cookie')==$bcCOO_page_id AND $bcCOO_page_id!=0 ){
                }elseif(get_option('bcCOO_page_privacy')==$bcCOO_page_id AND $bcCOO_page_id!=0 ){
                }elseif(get_option('bcCOO_page_disclaimer')==$bcCOO_page_id AND $bcCOO_page_id!=0 ){
                }else{  
			      	    include plugin_dir_path( __DIR__ ).'template/wp-cookie-page.php';
                }

			}
    }
    
        
  }
  
	
}
add_action('wp_footer', 'bcCOO_age_gate');

// remove all scripts 


function bcCOO_removejs_header()
{
  if (isset($_COOKIE['bcCOO_accepted_cookies'])) { 
    $bcCOO_required = substr(intval($_COOKIE['bcCOO_accepted_cookies']),0,1); 
  }else{ 
        $bcCOO_required = false;
  }	    


  // mke output clean
  if ($bcCOO_required==1){
    $bcCOO_cookie_exists = 1;	
  }else{
    $bcCOO_cookie_exists = 0;		
  }
  if (get_option('bcCOO_cookie_active')==1){
    if($bcCOO_cookie_exists!=1){
    global $wp_scripts;
    $leave_alone = array(
        // Put the scripts you don't want to remove in here.
    );

    foreach ( $wp_scripts->queue as $handle )
    {
        // Here we skip/leave-alone those, that we added above ↑
        if ( in_array( $handle, $leave_alone ) )
            continue;

        $wp_scripts->remove( $handle );
    }

  }}
}
add_action( 'wp_print_styles', 'bcCOO_removejs_header', 0 );
add_action( 'wp_print_scripts', 'bcCOO_removejs_header', 0 );

/* ---------------------------------------- */
/* creating age gate check functionality    */

function bcCOO_gate_check() {
	
	global $bcCOO_cookie_exists;
	global $bcCOO_error_message;
	global $bcCOO_minimum_age;
    global $bcCOO_cookie_time;
	
    
    // --------
    // output (not) existing cookie
    if (isset($_COOKIE['bcCOO_accepted_cookies'])) { 
      $bcCOO_required = substr(intval($_COOKIE['bcCOO_accepted_cookies']),0,1); 
    }else{ 
          $bcCOO_required = false;
    }	    

	
    // mke output clean
    if ($bcCOO_required==1){
      $bcCOO_cookie_exists = 1;	
    }else{
      $bcCOO_cookie_exists = 0;		
    }
    
    // ------
    // get the cookie length from the settings
	if(get_option('bcCOO_gate_cookietime')!=''){
        $bcCOO_cookie_time = time()+3600*get_option('bcCOO_gate_cookietime');
    }else{
        $bcCOO_cookie_time = time()+3600*24*30; // 1 month standard
    }
    
    
    // ------
    // define some vars for messaging
	$bcCOO_error_message = "";
	$bcCOO_cookies = "";
	

        if ( !isset($_POST['submit'])) { return; }
       // if ( !isset($_POST['bcCOO_submit'])) { $bcCOO_age_check_int = 0; return; }
    
    
    
    // Check that the nonce was set and valid
    if( !wp_verify_nonce($_POST['_wpnonce'], 'wps-frontend-post') ) {
       $bcCOO_error_message = __("Did not save because your form seemed to be invalid. Sorry",'betacookie');
       return;
    }



	
	if (isset($_POST['submit'])){
					
				setcookie( 'bcCOO_accepted_cookies', '1', $bcCOO_cookie_time, '/', COOKIE_DOMAIN, false);
				$bcCOO_age_check_int = 1;


		
	}
    
    
 
}
add_action( 'init', 'bcCOO_gate_check' );


/* ---------------------------------------- */
/* Fetch image information by ID            */

function bcCOO_get_image($img_ID){
	
	
	$imgid = (isset( $img_ID )) ? $img_ID : "";
	$img   = wp_get_attachment_image_src($imgid, 'full');
	
	return $img[0];
	
}


/* ---------------------------------------- */
/* Quick check if we are on a login page    */

function bcCOO_is_login_page() {
	
    return in_array($GLOBALS['pagenow'], array('wp-login.php', 'wp-register.php'));
	
}

/* ---------------------------------------- */
/* Google bot detection                     */
function bcCOO_bot() {
  return (
    isset($_SERVER['HTTP_USER_AGENT'])
    && preg_match('/bot|crawl|slurp|spider|mediapartners/i', $_SERVER['HTTP_USER_AGENT'])
  );
}
?>