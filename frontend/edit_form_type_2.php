<?php if($entry_mode == 'confirm') { ?>
<form id="wbsf_form_entry" name="wbsf_entry_form" action="" method="post" class="form-horizontal" role="form">
	<?php $children_array = unserialize($entry->children);
			$i=0;
 			foreach($children_array as $child) { $i++; ?>
	<div class="children_field clearfix" id="children_detils_<?php echo $i; ?>">
		<h4 class="wbsf_form_fieldset_title">Child's Information</h4>
		<div class="form-group">
			<label for="child_name_<?php echo $i; ?>" class="col-lg-3 control-label">Child's Name<em>*</em></label>
			<div class="col-lg-9">
				<input type="text" placeholder="Name" class="data-required form-control" required="required" name="child_name[]" id="child_name_<?php echo $i; ?>" value="<?php echo $child['name']; ?>" />
			</div>
		</div>
		<div class="form-group">
			<label for="child_dob_<?php echo $i; ?>" class="col-lg-3 control-label">Child's Birthdate<em>*</em></label> 
			<div class="col-lg-9">
				<input class="data-required form-control wbsf-datepicker" placeholder="Date of birth" type="text" id="child_dob_<?php echo $i; ?>" required="required" name="child_dob[]" value="<?php echo $child['dob']; ?>" />
			</div>
		</div>
		<?php if($i != 1) { ?><a href="#" class="btn btn-danger btn-xs wbsf-remove">X</a><?php } ?>
	</div>
	<?php } ?>
	<div class="form-group right-align">
			<div class="col-lg-offset-3 col-lg-9">
				<a href="#" class="btn btn-default btn-sm" id="wbsf-addnew">Add Another</a>
			</div>
		</div>
		<h4 class="wbsf_form_fieldset_title">Parent/Gardian</h4>
		<div class="form-group">
			<label for="parent_name" class="col-lg-3 control-label">First Name<em>*</em></label>
			<div class="col-lg-9">
				<input type="text" class="data-required form-control" placeholder="Name" name="parent_name" required="required" id="parent_name" value="<?php echo $entry->parent_name; ?>" />
			</div>
		</div>
		<div class="form-group">
			<label for="wbsf_email" class="col-lg-3 control-label">Email<em>*</em></label> 
			<div class="col-lg-9">
				<input class="data-required form-control" placeholder="Email" type="email" required="required" id="wbsf_email" name="email" value="<?php echo $entry->email; ?>" />
			</div>
		</div>
		<div class="form-group">
			<label for="parent_dob" class="col-lg-3 control-label">Birthdate<em>*</em></label> 
			<div class="col-lg-9">
				<input class="data-required form-control wbsf-datepicker" placeholder="Date of birth" type="text" id="parent_dob" name="parent_dob" value="<?php echo $entry->parent_dob; ?>" />
			</div>
		</div>
		<h4 class="wbsf_form_fieldset_title">Mailing Address</h4>
		<div class="form-group">
				<label for="wbsf_address" class="col-lg-3 control-label">Address<em>*</em></label>
			<div class="col-lg-9">
				<input type="text" class="data-required form-control" placeholder="Address" name="address" id="wbsf_address" value="<?php echo $entry->address; ?>" />
			</div>
		</div>
		<div class="form-group">
				<label for="wbsf_city" class="col-lg-3 control-label">City<em>*</em></label> 
			<div class="col-lg-9">
				<input class="data-required form-control" placeholder="City" type="text" id="wbsf_city" name="city" value="<?php echo $entry->city; ?>" />
			</div>
		</div>
		<div class="form-group">
				<label for="wbsf_state" class="col-lg-3 control-label">State<em>*</em></label> 
			<div class="col-lg-9">
				<input class="data-required form-control" placeholder="State" type="text" id="wbsf_state" name="state" value="<?php echo $entry->state; ?>" />
			</div>
		</div>
		<div class="form-group">
				<label for="wbsf_zip" class="col-lg-3 control-label">Zip<em>*</em></label> 
			<div class="col-lg-9">
				<input class="data-required form-control" placeholder="Zipcode" type="text" id="wbsf_zip" name="zip" value="<?php echo $entry->zip; ?>" />
			</div>
		</div>
		<div class="form-group">
			<div class="col-lg-offset-3 col-lg-9">
				<input type="hidden" name="fid" id="wbsf_form_id" value="<?php echo $entry->fid; ?>" />
				<input type="hidden" name="eid" id="wbsf_form_id" value="<?php echo $entry->eid; ?>" />
				<input type="submit" name="wbsf-update-submit" id="wbsf-submit" class="btn btn-primary" value="Submit" />
			</div>
		</div>
	</form>
	
<?php }  ?>
