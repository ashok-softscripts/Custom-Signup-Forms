<?php
function wbsf_edit_form() {
/* Load Attributes Here */
$wbsf_token = $_REQUEST['wbsf_token'];
$form_type = $_REQUEST['form_type'];
$entry = wbsf_get_entry_by_token($form_type,$wbsf_token);
$entry_id = $entry->edi;
$form_id = $entry->fid;
$form = wbsf_get_form($form_id);
$entry_mode = $_REQUEST['wbsf_entry_mode'];
if(!$entry_mode) {
	$entry_mode = 'submit';
}

if(isset($_POST['wbsf-update-submit']) && !empty($_POST['wbsf-update-submit'])) { 
	$entry_id = $_POST['eid'];
	if(!empty($entry_id) && !empty($wbsf_token) && !empty($form_type)) {
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
		$data['token'] = $wbsf_token;
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

if($wbsf_token) { ?>
<div class="row" id="wbsf_entry_form">
	<div class="col-md-8">
	<h3><?php echo $form->form_title; ?></h3>

	<?php require_once('edit_form_type_'.$form_type.'.php'); //Load Form

	if($entry_mode == 'success' && !empty($entry)) { ?>
	<div class="wbsf_form_fieldset wbsf_success">
			<h4 class="wbsf_form_fieldset_title"><?php echo $entry->parent_name; ?>,</h4>
			<div class="alert alert-info">Thank you! Your registration is confirmed for	<?php echo $form->form_title; ?></div>
			<p>Your Registration ID: <strong><?php echo $entry->token; ?></strong></p>
			<p>A confirmation email has been sent with additional details of your registration.</p>
	</div>
	<p>We have sent you an confirmation email to your email address. Please print it or the copy below, and bring it in to a Bookmans location to get started.</p>
	<p><a class="printLink" href="javascript:window.print()">Print your confirmation</a></p>
	
	<?php } ?>
	</div>
</div>
<?php 
} // END IF
} // END FUNCTION ?>
