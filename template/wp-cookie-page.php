<!----- GDPR gate -------->
<?php
	global $bcCOO_cookie_exists;
	if (get_option( 'bcCOO_gate_background_image' )!=0 OR get_option( 'bcCOO_gate_background_image' )!=''){
		$background_image = ' style="background-image: url('.bcCOO_get_image(get_option( 'bcCOO_gate_background_image' )).');"';
	}else{
		$background_image = "";
	}

	if (get_option( 'bcCOO_gate_logo' )!=0){
		$logo_image = '<img src="'.bcCOO_get_image(get_option( 'bcCOO_gate_logo' )).'" class="bcCOO_gate_logo" alt="'.get_bloginfo('name').'" /> <br />';
	}else{
		$logo_image = "";
	}

?>
<div id="bcCOO_container"<?php echo $background_image; ?>>
	<div class="bcCOO_message_box_wrapper">
        <div class="bcCOO_message_box">
            <form id="bcCOO_form" name="bcCOO_form" method="post">
				
            
				<?php echo $logo_image; ?>
				<?php if($bcCOO_error_message!=""){ ?>
	
					<div class="bcCOO_error_message">
						<?php echo $bcCOO_error_message; ?>
					</div>
				<?php } ?>
			
				<div class="bcCOO_age_message">	
					<?php echo esc_html(get_option('bcCOO_gate_message')); ?>
				</div>
                
				<?php wp_nonce_field( 'wps-frontend-post' ); ?>
                <input type="submit" value="<?php _e("Accept the cookies and continue",'betacookie'); ?>" tabindex="6" id="bcCOO_submit" name="submit" />

                
                <?php if(get_option('bcCOO_gate_message_footer')!=''){ ?>
                    <div class="bcCOO_age_message_footer">	
                        <?php echo esc_html(get_option('bcCOO_gate_message_footer')); ?>
                    </div>
               <?php } ?>

            </form>
		</div>
    </div>
</div>
<!----- GDPR gate -------->