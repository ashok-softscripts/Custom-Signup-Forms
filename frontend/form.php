<?php
function wbsf_form($atts) {
//wbsf_debug("Attributes",$atts);

/* Load Attributes Here */
$form_id = $atts['form'];
$form = wbsf_get_form($form_id);
$title_status = $atts['title'];
if(!$title_status) { $title_status = 'show'; }
$entry_mode = $_REQUEST['wbsf_entry_mode'];
if(!$entry_mode) {
	$entry_mode = 'submit';
}
$wbsf_token = $_REQUEST['wbsf_token'];
$form_type = $_REQUEST['form_type'];
if(!$form_type) {
	$form_type = $form->form_type;
}

if(isset($_POST['wbsf-confirm-submit']) && !empty($_POST['wbsf-confirm-submit'])) { 
	$form_id = $_POST['fid'];
	$entry_id = $_POST['eid'];
	if(!empty($form_id) && !empty($entry_id) && !empty($wbsf_token) && !empty($form_type)) {
		$data['confirm_status'] = 1;
		$entry_id = wbsf_update_entry($form_type,$entry_id,$data);
		if($entry_id) {
			wbsf_mail_user($form_type,$entry_id);
			wbsf_mail_admin($form_type,$entry_id);
			$url = wbsf_url('wbsf_token='.$wbsf_token.'&wbsf_entry_mode=success&form_type='.$form_type);
			wbsf_redirect($url);
		}
	}
}


if(isset($_POST['wbsf-submit']) && !empty($_POST['wbsf-submit'])) {

	$data = array();
	if($form_type == 1) {
		$child_names = $_POST['child_name'];
		$child_dobs = $_POST['child_dob'];
		$data['parent_name'] = $_POST['parent_name'];
		$data['email'] = $_POST['email'];
		$data['parent_dob'] = $_POST['parent_dob'];
		$data['address'] = $_POST['address'];
		$data['city'] = $_POST['city'];
		$data['state'] = $_POST['state'];
		$data['zip'] = $_POST['zip'];
		$data['children'] = wbsf_serialize($child_names, $child_dobs);
	}
	else if($form_type == 2) {
		$child_names = $_POST['child_name'];
		$child_dobs = $_POST['child_dob'];
		$data['parent_name'] = $_POST['parent_name'];
		$data['email'] = $_POST['email'];
		$data['parent_dob'] = $_POST['parent_dob'];
		$data['address'] = $_POST['address'];
		$data['city'] = $_POST['city'];
		$data['state'] = $_POST['state'];
		$data['zip'] = $_POST['zip'];
		$data['children'] = wbsf_serialize($child_names, $child_dobs);
	}
	else if($form_type == 3) {
		$data['school_name'] = $_POST['school_name'];
		$data['school_type'] = $_POST['school_type'];
		$data['school_zip'] = $_POST['school_zip'];
		$data['parent_name'] = $_POST['parent_name'];
		$data['email'] = $_POST['email'];
		$data['parent_dob'] = $_POST['parent_dob'];
		$data['address'] = $_POST['address'];
		$data['city'] = $_POST['city'];
		$data['state'] = $_POST['state'];
		$data['zip'] = $_POST['zip'];
	}
	$data['fid'] = $_POST['fid'];
	$data['token'] = wbsf_uuid($form_id);
	$data['confirm_status'] = 0;

	$entry_id = wbsf_create_entry($form_type,$data);
	if($entry_id) {
		$url = wbsf_url('wbsf_token='.$data['token'].'&wbsf_entry_mode=confirm&form_type='.$form_type);
		wbsf_redirect($url);
	}
}


if(($entry_mode == 'confirm' || $entry_mode == 'success') && !empty($wbsf_token) && !empty($form_type)) {
	$entry = wbsf_get_entry_by_token($form_type,$wbsf_token);
	if($entry_mode == 'confirm' && $entry->confirm_status == 1) {
		$url = wbsf_url('wbsf_token='.$wbsf_token.'&wbsf_entry_mode=success&form_type='.$form_type);
		wbsf_redirect($url);
	}
	if($entry_mode == 'success' && $entry->confirm_status == 0) {
		$url = wbsf_url('wbsf_token='.$wbsf_token.'&wbsf_entry_mode=confirm&form_type='.$form_type);
		wbsf_redirect($url);
	} 

}


if($form_id) { ?>
<div class="row" id="wbsf_entry_form">
    <div class="col-md-8">
	<?php if($title_status != 'hide') { ?><h3><?php echo $form->form_title; ?></h3><?php } 

	 require_once('form_type_'.$form_type.'.php'); //Load Form

	if($entry_mode == 'success' && !empty($entry)) { ?>
	<div class="wbsf_form_fieldset wbsf_success">
			<h4 class="wbsf_form_fieldset_title"><?php echo $entry->parent_name; ?>,</h4>
			<div class="alert alert-success">Thank you! Your registration is confirmed for	<?php echo $form->form_title; ?></div>
			<p>Your Registration ID: <strong><?php echo $entry->token; ?></strong></p>
			<p>A confirmation email has been sent with additional details of your registration.</p>
	</div>
	<p>We have sent you an confirmation email to your email address. Please print it or the copy below, and bring it in to a Bookmans location to get started.</p>
	<p><a class="printLink" href="javascript:window.print()">Print your confirmation</a></p>
	
	<?php } ?>
	</div>
</div>
<?php 	} // END IF
} // END FUNCTION ?>
