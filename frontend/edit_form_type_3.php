<?php if($entry_mode == 'confirm') { ?>
<form id="wbsf_form_entry" name="wbsf_entry_form" action="" method="post" class="form-horizontal" role="form">
	<h4 class="wbsf_form_fieldset_title">School Infomation</h4>
	<div class="form-group">
		<label for="school_name" class="col-lg-3 control-label">School Name<em>*</em></label>
		<div class="col-lg-9">
			<input type="text" placeholder="School Name" class="data-required form-control" required="required" name="school_name" id="school_name" value="<?php echo $entry->school_name; ?>" />
		</div>
	</div>
	<div class="form-group">
		<label for="school_type" class="col-lg-3 control-label">School Type<em>*</em></label> 
		<div class="col-lg-9">
			<select class="data-required form-control" id="school_type" required="required" name="school_type">
				<option value="">Select one</option>
				<option value="Preschool/Kindergarten" <?php if($entry->school_type == 'Preschool/Kindergarten') { echo 'selected="selected"'; } ?>>Preschool/Kindergarten</option>
				<option value="Elementary" <?php if($entry->school_type == 'Elementary') { echo 'selected="selected"'; } ?>>Elementary</option>
				<option value="Middle School/Junior High" <?php if($entry->school_type == 'Middle School/Junior High') { echo 'selected="selected"'; } ?>>Middle School/Junior High</option>
				<option value="High School" <?php if($entry->school_type == 'High School') { echo 'selected="selected"'; } ?>>High School</option>
				<option value="College/University" <?php if($entry->school_type == 'College/University') { echo 'selected="selected"'; } ?>>College/University</option>
				<option value="Technical/Trade School" <?php if($entry->school_type == 'Technical/Trade School') { echo 'selected="selected"'; } ?>>Technical/Trade School</option>
				<option value="Home School" <?php if($entry->school_type == 'Home School') { echo 'selected="selected"'; } ?>>Home School</option>
				<option value="Other" <?php if($entry->school_type == 'Other') { echo 'selected="selected"'; } ?>>Other</option>
			</select>
		</div>
	</div>
	<div class="form-group">
		<label for="school_zip" class="col-lg-3 control-label">School Zip<em>*</em></label>
		<div class="col-lg-9">
			<input type="text" placeholder="School Zip" class="data-required form-control" required="required" name="school_zip" id="school_zip" value="<?php echo $entry->school_zip; ?>" />
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
