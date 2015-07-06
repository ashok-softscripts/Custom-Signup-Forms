<?php function wbsf_entries() {

global $wpdb;
$url = wbsf_get_url('entries'); //Current page url

/******************
 Common Requests
******************/
$action = $_REQUEST['action'];
$form_id = $_REQUEST['fid'];
$entry_id = $_REQUEST['eid'];
$form_type = $_REQUEST['form_type'];
$step = 'entries'; //Reset to Step
$status = $_REQUEST['status'];


if($action == 'view' && !empty($entry_id) && !empty($form_type)) {
	$entry = wbsf_get_entry($form_type,$entry_id);
}

/******************
 Delete Entry Step
******************/
if($action == 'delete' && !empty($entry_id) && !empty($form_type)) {
	$status = wbsf_delete_entry($form_type,$entry_id);
	if($status == 1) {
		wbsf_redirect($url);	
	}
}

?>
<div class="wrap wbsf_wrap">
	﻿<div class="add_new"><div id="icon-edit-pages" class="icon32"><br></div><h2><?php _e('Bookmans Signup Forms'); ?></h2></div>
	<div class="wbsf_container">
		<?php wbsf_status_info($step,$status); ?>
		<?php if($action == 'view') { //Form Add/Edit Area ?>
			<div class="wbsf_add_new"><a class="button button-primary" href="<?php echo $url; ?>"><?php _e('Go Back'); ?></a></div>
			<div class="wbsf_form_add">
				<?php require_once('entry_view_'.$form_type.'.php'); ?>
			</div>
		<?php }
		else if(!$action) { // List of forms ?>
			<div class="wbsf_add_new">
				<form name="wbsf_filter_entries" method="post" action="">
					<select id="form_list" name="fid" class="wbsf_select regular-text large data-required">
					<?php $forms_list = wbsf_get_forms($form_status=1);
						if(count($forms_list)) { 
						foreach($forms_list as $form_list) { ?>
						<option value="<?php echo $form_list->fid; ?>" <?php if($form_list->fid == $form_id) { echo 'selected="selected"'; } ?>><?php echo $form_list->form_title; ?></option>
					<?php }	} ?>
					</select>
					<input type="submit" class="button-primary" name="wbsf_filter_entries" value="<?php _e( 'Filter'); ?>" />
				</form>
			</div>
			<table class="table table-striped table-bordered" id="wbsf_dyntable">
		        <colgroup>
		            <col class="con0" />
		            <col class="con1" />
		            <col class="con0" />
		            <col class="con1" />
		            <col class="con0" />
		            <col class="con1" />
		            <col class="con0" />
		            <col class="con1" />
		        </colgroup>
		        <thead>
		            <tr>
		                <th class="head0"><?php _e('Name'); ?></th>
						<th class="head0"><?php _e('Email'); ?></th>
		                <th class="head0"><?php _e('Registered ID'); ?></th>
		                <th class="head1"><?php _e('Assoc. Form'); ?></th>
		                <th class="head1"><?php _e('Form Type'); ?></th>
		                <th class="head1"><?php _e('Status'); ?></th>
		                <th class="head1"><?php _e('View'); ?></th>
		                <th class="head1"><?php _e('Delete'); ?></th>
		            </tr>
		        </thead>
		        <tbody>
					<?php $entries = wbsf_get_entries(1,$form_id);
					if(count($entries)) { 
					foreach($entries as $entry) {
					$form = wbsf_get_form($entry->fid); ?>
		            <tr class="grade<?php if($entry->confirm_status == 0) { echo 'U'; } else { echo 'X'; } ?>">
		                <td><?php echo $entry->parent_name; ?></td>
 					    <td><?php echo $entry->email; ?></td>
		                <td><?php echo $entry->token; ?></td>
		                <td><a href="<?php echo $url; ?>&fid=<?php echo $entry->fid; ?>" class="button"><?php echo $form->form_title; ?></a></td>
		                <td><?php echo wbsf_form_type($form->form_type); ?></td>
		                <td><?php if($entry->confirm_status == 1) { echo 'Verified'; } else { echo 'Not Verified'; } ?></td>
		                <td><a href="<?php echo $url; ?>&action=view&eid=<?php echo $entry->eid; ?>&form_type=<?php echo $form->form_type; ?>" class="button"><?php _e('View'); ?></a></td>
		                <td><a href="<?php echo $url; ?>&action=delete&eid=<?php echo $entry->eid; ?>&form_type=<?php echo $form->form_type; ?>" class="button wbsf_delete"><?php _e('Delete'); ?></a></td>
		            </tr>
							<?php } } ?>
					<?php $entries = wbsf_get_entries(2,$form_id);
					if(count($entries)) { 
					foreach($entries as $entry) {
					$form = wbsf_get_form($entry->fid); ?>
		            <tr class="grade<?php if($entry->confirm_status == 0) { echo 'U'; } else { echo 'X'; } ?>">
		                <td><?php echo $entry->parent_name; ?></td>
 					    <td><?php echo $entry->email; ?></td>
		                <td><?php echo $entry->token; ?></td>
		                <td><a href="<?php echo $url; ?>&fid=<?php echo $entry->fid; ?>" class="button"><?php echo $form->form_title; ?></a></td>
						<td><?php echo wbsf_form_type($form->form_type); ?></td>
		                <td><?php if($entry->confirm_status == 1) { echo 'Verified'; } else { echo 'Not Verified'; } ?></td>
		                <td><a href="<?php echo $url; ?>&action=view&eid=<?php echo $entry->eid; ?>&form_type=<?php echo $form->form_type; ?>" class="button"><?php _e('View'); ?></a></td>
		                <td><a href="<?php echo $url; ?>&action=delete&eid=<?php echo $entry->eid; ?>&form_type=<?php echo $form->form_type; ?>" class="button wbsf_delete"><?php _e('Delete'); ?></a></td>

		            </tr>
							<?php } } ?>
					<?php $entries = wbsf_get_entries(3,$form_id);
					if(count($entries)) { 
					foreach($entries as $entry) {
					$form = wbsf_get_form($entry->fid); ?>
		            <tr class="grade<?php if($entry->confirm_status == 0) { echo 'U'; } else { echo 'X'; } ?>">
		                <td><?php echo $entry->parent_name; ?></td>
 					    <td><?php echo $entry->email; ?></td>
		                <td><?php echo $entry->token; ?></td>
		                <td><a href="<?php echo $url; ?>&fid=<?php echo $entry->fid; ?>" class="button"><?php echo $form->form_title; ?></a></td>
						<td><?php echo wbsf_form_type($form->form_type); ?></td>
		                <td><?php if($entry->confirm_status == 1) { echo 'Verified'; } else { echo 'Not Verified'; } ?></td>
		                <td><a href="<?php echo $url; ?>&action=view&eid=<?php echo $entry->eid; ?>&form_type=<?php echo $form->form_type; ?>" class="button"><?php _e('View'); ?></a></td>
		                <td><a href="<?php echo $url; ?>&action=delete&eid=<?php echo $entry->eid; ?>&form_type=<?php echo $form->form_type; ?>" class="button wbsf_delete"><?php _e('Delete'); ?></a></td>

		            </tr>
							<?php } } ?>
		        </tbody>
      		</table>
		<?php } ?>			
		
	</div> <!-- end container -->
</div> <!-- end wrapper -->
<?php } ?>
