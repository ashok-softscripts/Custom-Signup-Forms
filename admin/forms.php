<?php function wbsf_forms() {
global $wpdb;
$url = wbsf_get_url('forms'); //Current page url

/******************
 Common Requests
******************/
$action = $_REQUEST['action'];
$step = 'forms'; //Reset to Step

$status = $_REQUEST['status'];
if(!$status && !$action) {
 $status = 'info'; //Reset to Status for Step 
}

$form_id = $_REQUEST['fid'];

if($action == 'delete' && !empty($form_id)) {
	$status = wbsf_delete_form($form_id);
	if($status == 1) {
		wbsf_redirect($url);	
	}
}


if($action == 'edit' && !empty($form_id)) {
	$form = wbsf_get_form($form_id);
}



/**************
 Create Form Step
***************/
if(isset($_REQUEST['form_add'])) {
	if(!empty($_REQUEST['form_add'])) {
		$data = array();
		$data['form_title'] = $_POST['form_title'];
		$data['form_type'] = $_POST['form_type'];
		$data['form_prefix'] = $_POST['form_prefix'];
		$data['form_status'] = 1;
		$form_id = wbsf_create_form($data);
		if($form_id) {
			wbsf_redirect($url);
		}
	}
}

/**************
 Update Form Step
***************/
if(isset($_REQUEST['form_update'])) {
	if(!empty($_REQUEST['form_update'])) {
		$data = array();
		$data['form_title'] = $_POST['form_title'];
		$data['form_type'] = $_POST['form_type'];
		$data['form_prefix'] = $_POST['form_prefix'];
		$data['form_status'] = 1;
		$form_id = wbsf_update_form($form_id, $data);
		if($form_id) {
			wbsf_redirect($url);
		}
	}
}


?>
<div class="wrap wbsf_wrap">
	﻿<div class="add_new"><div id="icon-edit-pages" class="icon32"><br></div><h2><?php _e('Bookmans Signup Forms'); ?></h2></div>
	<div class="wbsf_container">
		<?php wbsf_status_info($step,$status); ?>
		<?php if($action == 'edit' || $action == 'add') { //Form Add/Edit Area ?>
			<div class="wbsf_form_add">
				<form method="post" name="form_action" action="" id="form_action">
					<table id="general-tab" class="form-table wbsf_setting_table">
						<tr valign="top">
							<th scope="row"><?php _e('Form Title'); ?></th>
							<td><input type="text" id="form_title" name="form_title" id="wbsf-submit" class="wbsf_input regular-text data-required" value="<?php echo $form->form_title; ?>"  /></td>
						</tr>
				<tr valign="top"><th scope="row"><?php _e( 'Form Type'); ?></th>
					<td><select id="form_type" class="regular-text large data-required" name="form_type">
							<option value=""><?php echo esc_attr( __( 'Select' ) ); ?></option>
							<?php for($i=1;$i<=3;$i++) {  ?>
							<option value="<?php echo $i; ?>" <?php if($i == $form->form_type) { echo 'selected="selected"'; } ?>><?php echo wbsf_form_type($i); ?></option>
							<?php  } ?>
						</select>
					</td>
				</tr>
				<tr valign="top">
					<th scope="row"><?php _e('Registered ID Prefix'); ?></th>
					<td><input type="text" id="form_prefix" name="form_prefix" id="wbsf-submit" class="wbsf_input regular-text data-required" value="<?php echo $form->form_prefix; ?>"  /></td>
				</tr>
			</table>

		<p class="submit">
					<?php if($action == 'add') { ?><input type="submit" id="wbsf-submit" class="button-primary" name="form_add" value="<?php _e( 'Create'); ?>" /><?php }
					else { ?><input type="submit" class="button-primary" id="wbsf-submit" name="form_update" value="<?php _e( 'Update'); ?>" /><?php } ?>
					<a class="button" href="<?php echo $url; ?>"><?php _e('Cancel'); ?></a>
		</p>
				</form>
			</div>
		<?php }
		else if(!$action) { // List of forms ?>
			<div class="wbsf_add_new"><a class="button button-primary" href="<?php echo $url; ?>&action=add"><?php _e('Add new'); ?></a></div>
			<table class="table table-striped table-bordered" id="wbsf_dyntable">
		        <colgroup>
		            <col class="con0" />
		            <col class="con1" />
		            <col class="con0" />
		            <col class="con1" />
		        </colgroup>
		        <thead>
		            <tr>
		                <th class="head0"><?php _e('Form Title'); ?></th>
						<th class="head0"><?php _e('Short Code'); ?></th>
		                <th class="head1"><?php _e('Entries'); ?></th>
						<th class="head1"><?php _e('Form Type'); ?></th>
		                <th class="head0"><?php _e('Edit'); ?></th>
		                <th class="head1"><?php _e('Delete'); ?></th>
		            </tr>
		        </thead>
		        <tbody>
						<?php $forms = wbsf_get_forms($form_status=1);
									if(count($forms)) { 
										foreach($forms as $form) { ?>
		            <tr class="gradeX">
		                <td><?php echo $form->form_title; ?></td>
 					    <td><input type="text" value="[wbsf form=<?php echo $form->fid; ?>]" class="shortcode"  /></td>
		                <td><a href="<?php echo wbsf_get_url('entries'); ?>&fid=<?php echo $form->fid; ?>" class="button"><?php _e('View Entries'); ?> (<?php echo wbsf_get_entries_count($form->fid); ?>)</a></td>
		                <td><?php echo wbsf_form_type($form->form_type); ?></td>
		                <td><a href="<?php echo $url; ?>&action=edit&fid=<?php echo $form->fid; ?>" class="button"><?php _e('Edit'); ?></a></td>
		                <td><a href="<?php echo $url; ?>&action=delete&fid=<?php echo $form->fid; ?>" class="button wbsf_delete"><?php _e('Delete'); ?></a></td>
		            </tr>
							<?php } } ?>
		        </tbody>
      		</table>
		<?php } ?>			
		
	</div> <!-- end container -->
</div> <!-- end wrapper -->
<?php } ?>
