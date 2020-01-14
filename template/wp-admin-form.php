<div class="wrap">
		
    <h1>GDPR cookie notice</h1>

    <form method="post" action="options.php">
        <?php settings_fields( 'bcCOO_agegatesettings' ); ?>
        <?php do_settings_sections( 'bcCOO_agegatesettings' ); ?>
        <table class="bcCOO_forms form-table">
			
	            <tr valign="top">
                <th scope="row">
                    <?php _e("Activate Cookie Screen", 'betacookie'); ?>
                </th>
                 <td>
					 

                    <?php 
                    $check_vars = array( 'name'=>'cookie_active',
                                         'val'=>'1',
                                         'selected'=>get_option('bcCOO_cookie_active')
                                       );

                    bcCOO_check_input($check_vars,"This will create a page in front of your website without the loaded javascript so ther should not be any cookies loaded yet."); ?>
		
			
                </td>
            </tr> 
   		    <tr valign="top">
                <th scope="row">
                    <?php _e("Cookie Time", 'betacookie'); ?>
                </th>
                 <td>
                <?php 
				$select_vars = array( 'name'=>'gate_cookietime',
									 'options'=>array(
													array('op_name'=>'1 day', 'op_value'=>'24'),
													array('op_name'=>'3 days', 'op_value'=>'72'),
                                                    array('op_name'=>'1 week', 'op_value'=>'168'),
                                                    array('op_name'=>'2 weeks', 'op_value'=>'336'),
                                                    array('op_name'=>'1 month', 'op_value'=>'744'),
                                                    array('op_name'=>'3 months', 'op_value'=>'2232'),
                                                    array('op_name'=>'1 year', 'op_value'=>'8928')
													),
									 'selected'=>get_option('bcCOO_gate_cookietime')
								   );

				bcCOO_select_box($select_vars); ?>
                </td>
            </tr> 
        
		</table>
		<br />
		<h2><?php _e('Styling','betacookie'); ?></h2>
		<table class="bcCOO_forms form-table">
              <tr valign="top">
                <th scope="row">
                    <?php _e("Select theme", 'betacookie'); ?>
                </th>
                <td>
				<?php 
				$select_vars = array( 'name'=>'gate_theme',
									 'options'=>array(
													array('op_name'=>'Classic Light', 'op_value'=>'0'),
													array('op_name'=>'Classic Dark', 'op_value'=>'classic_dark'),
                                                    array('op_name'=>'Black and White', 'op_value'=>'rum')
													),
									 'selected'=>get_option('bcCOO_gate_theme')
								   );

				bcCOO_select_box($select_vars); ?>
					<p><?php _e("Select the theme you'd like to display on the cookie page.",'betacookie'); ?></p>
                </td>
            </tr> 
             <tr valign="top">
                <th scope="row">
                    <?php _e("Logo", 'betacookie'); ?>
                </th>
                 <td>
				<?php 
				$input_vars = array( 'name'=>'gate_logo',
									 'selected'=>get_option('bcCOO_gate_logo')
								   );

				bcCOO_imageselect_field($input_vars); ?>
                </td>
            </tr>  
             <tr valign="top">
                <th scope="row">
                    <?php _e("The message people see", 'betacookie'); ?>
                </th>
                 <td>
					 <p><?php _e('Write a message for the people that visit your site when cookie notice is enabled. You can use HTML in this field but no javascript. If you like to return to the original message, just empty this field and save.','betacookie'); ?></p><br />
				<?php 
					 
				if (get_option('bcCOO_gate_message')==""){
					$get_a_message = __( 'In order to comply with the GDPR rules you will have to accept cookies in order to see our content.', 'betacookie'  );
				}else{
					$get_a_message = get_option('bcCOO_gate_message');
				}
					 
				$textarea_vars = array( 'name'=>'gate_message',
									 'selected'=>$get_a_message
								   );

				bcCOO_textarea_field($textarea_vars); ?>
				 </td>
            </tr>  
            <tr valign="top">
                <th scope="row">
                    <?php _e("The footer message", 'betacookie'); ?>
                </th>
                 <td>
					 <p><?php _e('Add a disclaimer here.','betacookie'); ?></p><br />
				<?php 
					 
				if (get_option('bcCOO_gate_message_footer')==""){
					$get_a_message = __( 'Sorry for the inconvenience.', 'betacookie' );
				}else{
					$get_a_message = get_option('bcCOO_gate_message_footer');
				}
					 
				$textarea_vars = array( 'name'=>'gate_message_footer',
									 'selected'=>$get_a_message
								   );

				bcCOO_textarea_field($textarea_vars); ?>
				 </td>
            </tr>
		    <tr valign="top">
                <th scope="row">
                    <?php _e("Background image", 'betacookie'); ?>
                </th>
                 <td>
				<?php 
				$input_vars = array( 'name'=>'gate_background_image',
									 'selected'=>get_option('bcCOO_gate_background_image')
								   );
					 
							bcCOO_imageselect_field($input_vars); ?>
                </td>
            </tr> 
             <tr valign="top">
                <th scope="row">
                    <?php _e("Some custom CSS", 'betacookie'); ?>
                </th>
                 <td>
					 <p><?php _e('If you like to change some things on the homepage, use this CSS box to do so. You will not lose changes when this plugin is updated.','betacookie'); ?></p><br />
				<?php 
				if(get_option('bcCOO_gate_css')==''){
                    $custom_css_content = "";
                }else{
                    $custom_css_content = get_option('bcCOO_gate_css');   
                }
					 
				$textarea_vars = array( 'name'=>'gate_css',
									 'selected'=>$custom_css_content 
								   );

				bcCOO_textarea_field($textarea_vars); ?>
				 </td>
            </tr>  
		</table>	
		<br />
		<h2><?php _e('Whitelisted pages','betacookie'); ?></h2>
        <p><?php _e('Unhide some of the pages like the cookies page or the privacy policy page.','betacookie'); ?></p>
        <?php
        
        $args = array(
                'post_type' => 'page'
        );	
        $query = new WP_Query( $args );
        $count = 0;
        $select_vars_list[$count]['op_name'] = __('None','betacookie');
        $select_vars_list[$count]['op_value'] = 0;
        $count++;
        if ( $query->have_posts() ) {
            while ( $query->have_posts() ) {

            $query->the_post();
            // now $query->post is WP_Post Object, use:
            // $query->post->ID, $query->post->post_title, etc.
            $select_vars_list[$count]['op_name'] = $query->post->post_title;
            $select_vars_list[$count]['op_value'] = $query->post->ID;
            $count++;
            }
        }
        ?>
		<table class="bcSOFF_forms form-table">
		    <tr valign="top">
                <th scope="row">
                    <?php _e("Disclaimer", 'betacookie'); ?>
                </th>
                 <td>
				<?php 
                $select_vars = array( 'name'=>'page_disclaimer',
                                     'options'=> $select_vars_list,
									 'selected'=>get_option('bcCOO_page_disclaimer')
								   );
				bcCOO_select_box($select_vars); ?>
                </td>
            </tr> 
    		    <tr valign="top">
                <th scope="row">
                    <?php _e("Privacy Policy", 'betacookie'); ?>
                </th>
                 <td>
				<?php 
                $select_vars = array( 'name'=>'page_privacy',
                                     'options'=> $select_vars_list,
									 'selected'=>get_option('bcCOO_page_privacy')
								   );
				bcCOO_select_box($select_vars); ?>                     
                </td>
            </tr> 
            <tr valign="top">
                <th scope="row">
                    <?php _e("Cookie policy", 'betacookie'); ?>
                </th>
                 <td>

				<?php 
                $select_vars = array( 'name'=>'page_cookie',
                                     'options'=> $select_vars_list,
									 'selected'=>get_option('bcCOO_page_cookie')
								   );
				bcCOO_select_box($select_vars); ?>
                </td>

            </tr> 
        </table>
		<br />
		<h2><?php _e('Support Beta','betacookie'); ?></h2>
		<table class="bcSOFF_forms form-table">
		    <tr valign="top">
                <th scope="row">
                    <?php _e("Show this plugin some love", 'betacookie'); ?>
                </th>
                 <td>
					<a href="https://wordpress.org/plugins/super-simple-age-gate-beta/" target="_blank"><?php _e('Write a review and rate this plugin.','betacookie'); ?></a>
                </td>
            </tr> 
        </table>
        <?php submit_button(); ?>
        </form>
			
</div>
<?php 

/* ------------------------ */
/* THE FOOTER.              */

$bcALG_my_plugins = array(
    array(
        'slug'=>'rebranded-pro-the-agency-toolkit',
        'name'=>'Re:Branded Pro | The Agency Toolkit',
        'features'=>'https://betacore.tech/plugins/rebranded-pro-agency-toolkit/',
        'content'=>'This is a total rebranding package for the WordPress admin built for for agencies, designers and website builders. This plugin also protects essential parts of the WordPress installation in order to create an awesome user experience for the client on the WP-admin dashboard. My other plugins (Super Simple Age Gate, Super Simple Site Offline, Simple Analytics Tag) hook right in! So it feels as if they are part of Re:Branded. Or are they?' ),
    array(
        'slug'=>'super-simple-site-offline-beta',
        'name'=>'Super Simple Site Offline',
        'features'=>'https://betacore.tech/plugins/super-simple-site-offline-for-wordpress/',
        'content'=>'Site offline plugins are made awesome again with this piece of code. While most site offline plugins are bulky, intrusive and annoying this one is as light as a feather and has no paid options. The nav item is neatly tucked away within the settings menu so it feels like it is part of WordPress.' ),
    array(
        'slug'=>'super-simple-recaptcha-v3',
        'name'=>'Super Simple Recapthca V3',
        'features'=>'https://betacore.tech/plugins/super-simple-recaptcha-v3/',
        'content'=>'Got spammers? Add Recaptcha V3 in an instant! Works for any contact form. Uses Google Recaptcha V3. A how-to is included.' ),
    array(
        'slug'=>'simple-analytics-tag-beta',
        'name'=>'Simple Analytics Tag',
        'features'=>'https://betacore.tech/plugins/simple-analytics-tag-for-wordpress/',
        'content'=>'Simple Analytics Tag helps you get up and running quick. This plugin has a non-intrusive interface and fits very well within the Wordpress Settings menu. Just paste in the ID from Google Tagmanager or Google Analytics and you are good to go.' ),
    array(
        'slug'=>'super-simple-age-gate-beta',
        'name'=>'Super Simple Age Gate',
        'features'=>'https://betacore.tech/plugins/super-simple-age-gate-for-wordpress/',
        'content'=>"Do you have to filter out younger visitors? With this super simple age gate you'll fix those age restrictions quickly. Ment for webshops and other types of websites that has to have a curtain where people below your set age can't peek behind.." ),
    array(
        'slug'=>'age-checkbox-for-woocommerce',
        'name'=>'Age Checkbox for Woocommerce',
        'features'=>'https://betacore.tech/plugins/age-checkbox-for-woocommerce/',
        'content'=>"Complementary to the Super Simple Age Gate this adds an additional checkbox to the checkout form so customers have to confirm that they are age 18 (you can modify the age) or up." )

);
// get the slug of this plugin
$get_slug = explode('/', plugin_basename( __FILE__ ));
?>
<div class="bcALG_footer">

    <div class="bcALG_mailinglist">
        <form action="https://oneweekendwebsite.us20.list-manage.com/subscribe/post?u=72e22e9c5e66e05351f6c92af&amp;id=87b9e508b0" method="post" id="mc-embedded-subscribe-form" name="mc-embedded-subscribe-form" class="validate" target="_blank" novalidate>
            <h2>Are you running Wordpress inefficient? <span>Betacore is developing plugins to fix that!</span></h2>
            <p>Get an email when new plugins arrive! The only thing you'll have to do is subscribe to the mailing list now!</p>
            <ul class="bcALG_mailingform">
                <li>
                    
			
					<input type="text" value="" name="FNAME" class="" id="mce-FNAME" required>
					<label for="mce-FNAME">First Name</label>
                </li>
                <li>
                    
                    
					
					<input type="text" value="" name="EMAIL" class="required email" id="mce-EMAIL" required/>
					<label for="mce-EMAIL">Email Address</label>
                </li>
                <li>
					<input type="submit" value="Join!" name="subscribe" id="mc-embedded-subscribe" />
                </li>
				

    <!-- real people should not fill this in and expect good things - do not remove this or risk form bot signups-->
    <div style="position: absolute; left: -5000px;" aria-hidden="true"><input type="text" name="b_72e22e9c5e66e05351f6c92af_87b9e508b0" tabindex="-1" value=""></div>


            </ul>
        </form>
    </div>
<br />
    <h2>Making Wordpress more awesome <span>with useful plugins like these...</span></h2>
    
    <ul class="bcALG_plugins">
        <?php foreach($bcALG_my_plugins as $bc_id => $bc_value){ 
            if($get_slug[0] != $bc_value['slug']){
        ?>
            <li>
                <img src="<?php echo plugin_dir_url( __DIR__ ).'img/'.$bc_value['slug'].'.png'; ?>" title="<?php echo $bc_value['name']; ?> by Beta" class="bcALG_icon" />
                <h3><a href="https://wordpress.org/plugins/<?php echo $bc_value['slug']; ?>/" target="_blank"><?php echo $bc_value['name']; ?></a></h3>
                <p><?php echo $bc_value['content']; ?></p>
                <a href="https://wordpress.org/plugins/<?php echo $bc_value['slug']; ?>/" class="button" target="_blank"><?php _e('Plugin page'); ?></a>
                <?php if (isset($bc_value['features'])){ ?>
                <a href="<?php echo $bc_value['features']; ?>" class="button" target="_blank"><?php _e('Features'); ?></a>
                <?php } ?>
                <a href="<?php bloginfo('wpurl'); ?>/wp-admin/plugin-install.php?tab=plugin-information&plugin=<?php echo $bc_value['slug']; ?>&TB_iframe=false" class="button button-primary" target="_blank"><?php _e('Install'); ?></a>
            </li>
    
        <?php }} ?>
    </ul>


	<div class="bcALG_logobar">
    <a href="https://beta-media.com/super-simple-age-gate-wordpress-plugin/"><img src="<?php echo plugin_dir_url( __DIR__ ); ?>img/betalogo-b.png" /></a>
    <p class="bcALG_url"><span>By:</span> <a href="https://www.betacore.tech" target="_blank">www.betacore.tech</a></p>
	</div>
</div>