<?php /*
  Plugin Name: WP Bookmans Signup Forms
  Plugin URI: https://github.com/toadkicker/wp_bookmans
  Description: Generate Signup forms and store entries.
  Version: 1.2
  Author: Bookmans
  Author URI: http://www.bookmans.com/
 */
global $wpdb;
$siteurl = get_bloginfo('url');
/* Define WPSF TABLES */
define('WBSF_PLUGIN_URL', WP_PLUGIN_URL.'/wp-bookmans-signup-forms');
define("WBSF_FORMS_TABLE", $wpdb->prefix . "bookmans_signup_forms");
define("WBSF_ENTRIES_TABLE", $wpdb->prefix . "bookmans_signup_entries");
define("WBSF_KIDS_ENTRIES_TABLE", $wpdb->prefix . "bookmans_signup_kid_entries");
define("WBSF_EDU_ENTRIES_TABLE", $wpdb->prefix . "bookmans_signup_edu_entries");

/* Load all functions */
require_once ( 'functions/functions.php' ); // Load Utility Functions
require_once ( 'admin/index.php' ); // Load Backend Pages
require_once ( 'frontend/index.php' ); // Load Frontend Form

add_action('admin_menu','wbsf_backend_menu');

function wbsf_backend_menu() {
	add_menu_page('Bookmans Forms','Bookmans Signup Forms','manage_options','wbsf_forms','wbsf_forms', '', 24);
	add_submenu_page('wbsf_forms','Forms','Forms','manage_options','wbsf_forms','wbsf_forms');
	add_submenu_page('wbsf_forms','Entries','Entries','manage_options','wbsf_entries','wbsf_entries');
	add_submenu_page('wbsf_forms','Settings','Settings','manage_options','wbsf_settings','wbsf_settings');
}

// this hook will cause our creation function to run when the plugin is activated
register_activation_hook( __FILE__, 'wbsf_plugin_install' );

function wbsf_plugin_install() {
	global $wpdb; // do NOT forget this global
 
	if($wpdb->get_var("show tables like '". WBSF_FORMS_TABLE) != WBSF_FORMS_TABLE)  {
			$wpdb->query("CREATE TABLE IF NOT EXISTS `". WBSF_FORMS_TABLE . "` (`fid` INT NOT NULL AUTO_INCREMENT PRIMARY KEY , `form_title` VARCHAR( 250 ) NOT NULL, `form_type` VARCHAR( 250 ) NOT NULL, `form_prefix` VARCHAR( 250 ) NOT NULL, `form_status` INT NOT NULL, `form_created` TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP)");
		}
		if($wpdb->get_var("show tables like '". WBSF_ENTRIES_TABLE) != WBSF_ENTRIES_TABLE)  {
			$wpdb->query("CREATE TABLE IF NOT EXISTS `". WBSF_ENTRIES_TABLE . "` (`eid` INT NOT NULL AUTO_INCREMENT PRIMARY KEY , `fid` INT NOT NULL, `token` VARCHAR( 250 ) NOT NULL, `children` TEXT NOT NULL, `parent_name` VARCHAR( 250 ) NOT NULL, `email` VARCHAR( 250 ) NOT NULL, `parent_dob` VARCHAR( 250 ) NOT NULL, `address` VARCHAR( 250 ) NOT NULL, `city` VARCHAR( 250 ) NOT NULL, `state` VARCHAR( 250 ) NOT NULL, `zip` VARCHAR( 200 ) NOT NULL, `entry_created` TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP, `confirm_status` VARCHAR( 200 ) NOT NULL)");
		}
		if($wpdb->get_var("show tables like '". WBSF_KIDS_ENTRIES_TABLE) != WBSF_KIDS_ENTRIES_TABLE)  {
			$wpdb->query("CREATE TABLE IF NOT EXISTS `". WBSF_KIDS_ENTRIES_TABLE . "` (`eid` INT NOT NULL AUTO_INCREMENT PRIMARY KEY , `fid` INT NOT NULL, `token` VARCHAR( 250 ) NOT NULL, `children` TEXT NOT NULL, `parent_name` VARCHAR( 250 ) NOT NULL, `email` VARCHAR( 250 ) NOT NULL, `parent_dob` VARCHAR( 250 ) NOT NULL, `address` VARCHAR( 250 ) NOT NULL, `city` VARCHAR( 250 ) NOT NULL, `state` VARCHAR( 250 ) NOT NULL, `zip` VARCHAR( 200 ) NOT NULL, `entry_created` TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP, `confirm_status` VARCHAR( 200 ) NOT NULL)");
		}
		if($wpdb->get_var("show tables like '". WBSF_EDU_ENTRIES_TABLE) != WBSF_EDU_ENTRIES_TABLE)  {
			$wpdb->query("CREATE TABLE IF NOT EXISTS `". WBSF_EDU_ENTRIES_TABLE . "` (`eid` INT NOT NULL AUTO_INCREMENT PRIMARY KEY , `fid` INT NOT NULL, `token` VARCHAR( 250 ) NOT NULL, `school_name` VARCHAR( 250 ) NOT NULL, `school_type` VARCHAR( 250 ) NOT NULL, `school_zip` VARCHAR( 250 ) NOT NULL, `parent_name` VARCHAR( 250 ) NOT NULL, `email` VARCHAR( 250 ) NOT NULL, `parent_dob` VARCHAR( 250 ) NOT NULL, `address` VARCHAR( 250 ) NOT NULL, `city` VARCHAR( 250 ) NOT NULL, `state` VARCHAR( 250 ) NOT NULL, `zip` VARCHAR( 200 ) NOT NULL, `entry_created` TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP, `confirm_status` VARCHAR( 200 ) NOT NULL)");
		}
		
	update_option('disable_wbsf_admin_message',1);

}

function wbsf_admin_messages() {
	//If we're editing the events page show hello to new user
	$dismiss_link_joiner = ( count($_GET) > 0 ) ? '&amp;':'?';
	
	if( current_user_can('activate_plugins') ){
		//New User Intro
		if (isset ( $_GET ['disable_wbsf_admin_message'] ) && $_GET ['disable_wbsf_admin_message'] == 'true'){
			// Disable Hello to new user if requested
			update_option('disable_wbsf_admin_message',0);
		}elseif ( get_option ( 'disable_wbsf_admin_message' ) ) {
			
			$advice = sprintf( __("<p>WP Bookmans Signup Forms plugin is ready to go! Check out the <a href='%s'>Forms Generation Page</a>. <a href='%s' title='Don't show this advice again'>Dismiss</a></p>", 'wbsf'), wbsf_get_url('forms'),  $_SERVER['REQUEST_URI'].$dismiss_link_joiner.'disable_wbsf_admin_message=true');
			?>
			<div id="message" class="updated">
				<?php echo $advice; ?>
			</div>
			<?php
		}
	}
}

add_action ( 'admin_notices', 'wbsf_admin_messages', 100 );

// Add settings link on plugin page
function wbsf_settings_link($links) { 
  $forms_link = '<a href="'.wbsf_get_url('forms').'">Forms</a>'; 
  $settings_link = '<a href="'.wbsf_get_url('settings').'">Settings</a>'; 
  array_unshift($links, $forms_link); 
  array_unshift($links, $settings_link); 
  return $links; 
}
 
$plugin = plugin_basename(__FILE__); 
add_filter("plugin_action_links_$plugin", 'wbsf_settings_link' );


// this hook will cause our creation function to run when the plugin is deactivated
register_deactivation_hook( __FILE__,'wbsf_plugin_uninstall');

function wbsf_plugin_uninstall() {
	global $wpdb; // do NOT forget this global
 	delete_option('disable_wbsf_admin_message');
	delete_option('wbsf_settings_options');
   $wpdb->query("DROP TABLE IF EXISTS ".WBSF_FORMS_TABLE);
   $wpdb->query("DROP TABLE IF EXISTS ".WBSF_ENTRIES_TABLE);
   $wpdb->query("DROP TABLE IF EXISTS ".WBSF_KIDS_ENTRIES_TABLE);
   $wpdb->query("DROP TABLE IF EXISTS ".WBSF_EDU_ENTRIES_TABLE);
}
?>
