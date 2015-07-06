<?php
require_once ( 'form.php' ); // Load Frontend Form
require_once ( 'edit-form.php' ); // Load Frontend Edit Form
add_shortcode('wbsf', 'wbsf_form');
//add_shortcode('wbsfedit', 'wbsf_edit_form');

add_filter( 'the_content', 'wbsf_content_filter', 20 );
/**
 * Add a custom shortcode to the ending of selected page.
 *
 * @uses is_page()
 */
function wbsf_content_filter( $content ) {
	$edit_page_id = wbsf_options('entry_edit_page');
    if ( is_page($edit_page_id) )
		wbsf_edit_form();

    // Returns the content.
    return $content;
}


add_action('wp_enqueue_scripts', 'wbsf_enqueue_scripts' );
function wbsf_enqueue_scripts(){
  // first check that $hook_suffix is appropriate for your admin page
  wp_enqueue_script('jquery-ui-datepicker');
  wp_enqueue_style('jquery-style', 'http://ajax.googleapis.com/ajax/libs/jqueryui/1.8.2/themes/smoothness/jquery-ui.css');
  wp_enqueue_script( 'wbsf-bootstrap-datepicker-js', WBSF_PLUGIN_URL . '/frontend/bootstrap/js/bootstrap-datepicker.js', array( 'jquery' ), false, false );
  wp_enqueue_script( 'wbsf-bootstrap-js', WBSF_PLUGIN_URL . '/frontend/bootstrap/js/bootstrap.min.js', array( 'jquery' ), false, false );
  wp_enqueue_script( 'wbsf-scripts', WBSF_PLUGIN_URL . '/frontend/js/scripts.js', array( 'jquery' ), false, false );
  wp_enqueue_style( 'wbsf-styles', WBSF_PLUGIN_URL . '/frontend/css/styles.css', array(), '', 'all' );
  wp_enqueue_style( 'wbsf-bootstrap-css', WBSF_PLUGIN_URL . '/frontend/bootstrap/css/bootstrap.min.css', array(), '', 'all' );
  wp_enqueue_style( 'wbsf-bootstrap-datepicker-css', WBSF_PLUGIN_URL . '/frontend/bootstrap/css/datepicker.css', array(), '', 'all' );
}

?>
