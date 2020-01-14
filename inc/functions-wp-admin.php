<?php 
/* ---------------------------------------- */
/* adding the stylesheet to WP-admin */

function bcCOO_css_admin() {
	wp_enqueue_style('beta-gate-admin', plugin_dir_url( __DIR__ ).'css/admin.css');
}
add_action('admin_enqueue_scripts', 'bcCOO_css_admin');


function bcCOO_css_frontend() {
    //if (get_option('bcCOO_gate_active')==1){
        if(get_option('bcCOO_gate_theme')=='classic_dark'){
            wp_enqueue_style( 'beta-cookie', plugin_dir_url( __DIR__ ).'css/style-classicdark.css');
        }elseif(get_option('bcCOO_gate_theme')=='rum'){
            wp_enqueue_style( 'beta-cookie', plugin_dir_url( __DIR__ ).'css/style-rum.css');
        }else{
            wp_enqueue_style( 'beta-cookie', plugin_dir_url( __DIR__ ).'css/style.css');
        }
    //}
}
add_action('init', 'bcCOO_css_frontend', 100);


function bcCOO_css_custom(){
if(get_option('bcCOO_gate_css')!=''){
echo '<style type="text/css">
';
echo esc_html(get_option('bcCOO_gate_css'),'betacookie');
echo '
</style>';
}	
}
add_action('wp_head', 'bcCOO_css_custom', 100);


/* ---------------------------------------- */
/* the WP-admin page with the settings */

function bcCOO_function_for_sub(){
	
	// this is the page itself that you will find under the wp-admin
	// settings > Offline button
	include plugin_dir_path( __DIR__ ).'template/wp-admin-form.php';
	
}


/* ---------------------------------------- */
/* Add form data to the database after	    */
/* sanitising the input.	                */ 

function bcCOO_settings_register() {
	
	// this corresponds to some information added at the top of the form
	$setting_name = 'bcCOO_agegatesettings';
	
	// sanitize settings
    $args_html = array(
            'type' => 'string', 
            'sanitize_callback' => 'wp_kses_post',
            'default' => NULL,
            );	
	
    $args_int = 'intval';
	
    $args_text = array(
            'type' => 'string', 
            'sanitize_callback' => 'sanitize_text_field',
            'default' => NULL,
            );
	
	// adding the information to the database as options
    register_setting( $setting_name, 'bcCOO_cookie_active', $args_int ); // radio
	register_setting( $setting_name, 'bcCOO_gate_theme', $args_text ); // radio
	register_setting( $setting_name, 'bcCOO_gate_logo', $args_text ); // radio
	register_setting( $setting_name, 'bcCOO_gate_message', $args_html ); // radio
    register_setting( $setting_name, 'bcCOO_gate_message_footer', $args_html ); // radio
	register_setting( $setting_name, 'bcCOO_gate_background_image', $args_text ); // radio
	register_setting( $setting_name, 'bcCOO_gate_css', $args_html ); // radio
    register_setting( $setting_name, 'bcCOO_gate_cookietime', $args_int ); // radio
    register_setting( $setting_name, 'bcCOO_page_cookie', $args_int ); // radio
    register_setting( $setting_name, 'bcCOO_page_privacy', $args_int ); // radio
    register_setting( $setting_name, 'bcCOO_page_disclaimer', $args_int ); // radio
	
    
        
        
}

add_action( 'admin_init', 'bcCOO_settings_register' );


/* ---------------------------------------- */
/* ---------------------------------------- */
/* input forms and functions                */



/* ---------------------------------------- */
/* This one is a check button for the wpadm */

function bcCOO_check_input($arg, $label=''){
	if ($arg['selected']==''){
		$arg['selected']=0;
	}
?>
<div class="bcCOO_check_wrapper">
	<label>
		<input type="checkbox" 
			   name="bcCOO_<?php echo $arg['name']; ?>" 
			   value="<?php echo $arg['val']; ?>"
			   <?php 
				if($arg['selected']==$arg['val']){ echo "checked"; } ?> />
		<span></span>
		<?php if ($label!=''){ echo "<label>".__($label,'betacookie')."</label>"; } ?>
	</label>
</div>
<?php
}


/* ---------------------------------------- */
/* This one is a select dropdown            */

function bcCOO_select_box($arg){

?>
<div class="bcCOO_select_wrapper">
	<select name="bcCOO_<?php echo $arg['name']; ?>">
		<?php // making a list of the options
		foreach($arg['options'] as $name => $value){
			if($value['op_value']==$arg['selected']){$checkme=' selected';}else{$checkme='';}
			?><option value="<?php echo $value['op_value']; ?>"<?php echo $checkme; ?>><?php echo $value['op_name']; ?></option><?php
		} ?>
	</select>
</div>
<?php
}


/* ---------------------------------------- */
/* This one is an input field               */

function bcCOO_input_field($arg){
?>
<div class="bcCOO_input_wrapper">
	<input type="text"
		   name="bcCOO_<?php echo $arg['name']; ?>"
		   value="<?php echo $arg['selected']; ?>"
		   class="regular-text"
		   />
</div>
<?php	
}


/* ---------------------------------------- */
/* This one is a textarea field             */

function bcCOO_textarea_field($arg){
?>
<div class="bcCOO_textarea_wrapper">
	<textarea name="bcCOO_<?php echo $arg['name']; ?>" 
			  class="large-text code"
			  rows="10"
			  cols="50"><?php echo $arg['selected']; ?></textarea>
</div>
<?php	
}

// the more complex image select field
add_action ( 'admin_enqueue_scripts', function () {
    if (is_admin ())
        wp_enqueue_media ();
} );


/* ---------------------------------------- */
/* This one is an image select field        */

function bcCOO_imageselect_field($arg){
	
	$imgid =(isset( $arg[ 'selected' ] )) ? $arg[ 'selected' ] : "";
	$img    = wp_get_attachment_image_src($imgid, 'thumbnail');

	?>
	<script type="text/javascript">
	jQuery(document).ready(function() {
		var $ = jQuery;
		if ($('.<?php echo 'bcCOO_'.$arg['name']; ?>').length > 0) {
			if ( typeof wp !== 'undefined' && wp.media && wp.media.editor) {
				$('.<?php echo 'bcCOO_'.$arg['name']; ?>').on('click', function(e) {
					e.preventDefault();
					var button = $(this);
					var id = button.prev();
					wp.media.editor.send.attachment = function(props, attachment) {
						id.val(attachment.id);
					};
					wp.media.editor.open(button);
					return false;
				});
			}
		}
	});
	</script>
	<div class="bcCOO_select_wrapper">
	<?php 
	if($img != "") { ?>
	<div class="bcCOO_thumbnail">
		<img src="<?= $img[0]; ?>" width="80px" />
		<p><?php _e('The currently selected image.','betacookie'); ?></p>
	</div>
	<p><?php _e('Select a new image or paste a image ID to replace the one above:','betacookie'); ?></p>

	<?php }else{ ?>
	<p><?php _e('Select an image or paste an image ID:','betacookie'); ?></p>	
	<?php }	?>
	<input type="text" 
		   value="<?php echo $arg['selected']; ?>" 
		   class="regular-text process_custom_images" 
		   id="process_custom_images" 
		   name="<?php echo 'bcCOO_'.$arg['name']; ?>" 
		   max="" 
		   min="1" 
		   step="1" />
	<button class="<?php echo 'bcCOO_'.$arg['name']; ?> button"><?php _e('Media library','betacookie'); ?></button>
	</div>
	<?php
}

?>