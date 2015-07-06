<?php add_action( 'admin_init', 'wbsf_settings_init' );

function wbsf_settings_init(){
	register_setting( 'wbsf_settings', 'wbsf_settings_options', 'wbsf_settings_validate' );
}

function wbsf_settings() {
global $wpdb;
$link = wbsf_get_url('settings');

if ( ! isset( $_REQUEST['settings-updated'] ) )
		$_REQUEST['settings-updated'] = false;
 ?>
<div class="wrap wbsf_wrap">
		﻿<div class="add_new"><div id="icon-edit-pages" class="icon32"><br></div><h2>Bookmans Signup Forms Settings</h2></div>
	<?php if ( false != $_REQUEST['settings-updated'] ) :  ?>
		<div class="updated"><p><strong><?php _e( 'Settings saved'); ?></strong></p></div>
		<?php endif; ?>
		<form method="post" action="options.php">
		<?php settings_fields( 'wbsf_settings' ); 
		$settings = get_option( 'wbsf_settings_options' ); ?>
			<table id="general-tab" class="form-table wbsf_setting_table">
				<tr valign="top"><th scope="row"><?php _e( 'Select Page'); ?></th>
					<td>
						<div class="relative">
						<select id="wbsf_settings_options_entry_edit_page" class="regular-text large" name="wbsf_settings_options[entry_edit_page]">
							<option value=""><?php echo esc_attr( __( 'Select page' ) ); ?></option> 
			<?php $pages = get_pages(); 
				 foreach ( $pages as $page ) { ?>
							<option value="<?php echo $page->ID; ?>" <?php if($settings['entry_edit_page'] == $page->ID) { echo 'selected="selected"'; } ?>><?php echo $page->post_title; ?></option>
			<?php  } ?>
						</select>
						<label class="description" for="wbsf_settings_options_entry_edit_page"><?php _e( 'Select Page to show edit entry form for gues user.'); ?></label>
						</div>				
					</td>
				</tr>
				<tr valign="top"><th scope="row"><?php _e( 'Admin Email'); ?></th>
					<td>
						<div class="relative">
						<input type="text" id="wbsf_settings_options_email" class="regular-text" name="wbsf_settings_options[email]" value="<?php echo get_option( 'admin_email' ); ?>" />
						<label class="description" for="wbsf_settings_options_email"><?php _e( 'Admin Email address for mail notifications.'); ?></label>
						</div>				
					</td>
				</tr>
		</table>

		<p class="submit">
			<input type="submit" class="button-primary" value="<?php _e( 'Save Settings'); ?>" />
		</p>
	</form>
</div>
<?php } 

/**
 * Sanitize and validate input. Accepts an array, return a sanitized array.
 */
function wbsf_settings_validate( $input ) {

	// Say our text option must be safe text with no HTML tags
	$input['entry_edit_page'] = wp_filter_nohtml_kses( $input['entry_edit_page'] );
	$input['email'] = wp_filter_nohtml_kses( $input['email'] );

	// Say our textarea option must be safe text with the allowed tags for posts
	//$input['textarea'] = wp_filter_post_kses( $input['textarea'] );

	return $input;
}
?>
