<?php
/***********************
  Plugin Main Core Files
***********************/
require_once ( 'forms.php' ); // Forms Generation
require_once ( 'entries.php' ); // Form submission entries
require_once ( 'settings.php' ); // Plugin Settings


// Add Scripts and css in backend.
add_action( 'admin_enqueue_scripts', 'wbsf_admin_enqueue_scripts' );
function wbsf_admin_enqueue_scripts( $hook_suffix ) {
  // first check that $hook_suffix is appropriate for your admin page
  wp_enqueue_script( 'wbsf-data-tables', WBSF_PLUGIN_URL . '/admin/js/jquery.dataTables.min.js', array( 'jquery' ), false, true );
  wp_enqueue_script( 'wbsf-admin-scripts', WBSF_PLUGIN_URL . '/admin/js/admin-scripts.js', array( 'jquery' ), false, true );
  wp_enqueue_style( 'wbsf-admin-styles', WBSF_PLUGIN_URL . '/admin/css/admin.css', array(), '', 'all' );
  wp_enqueue_media();
}

?>
