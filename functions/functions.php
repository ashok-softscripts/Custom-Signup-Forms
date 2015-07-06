<?php 
/***************************
 Get Plugin Backend URL
 :- Args: Data String
****************************/
function wbsf_get_url($page) {
	if($page) {
		return get_admin_url(get_current_blog_id(),'admin.php?page=wbsf_'.$page);
	}
}

/***********************
 Status cases
 :- Args: Data Strings
************************/
function wbsf_status_info($step,$status) {
	$status_msg = "";
	switch($step) {
		case 'forms': 
			switch($status) {
				case 'info':
		    	$status_msg = '<strong>Welcome!</strong> Start generating signup forms with WBSF.';
				break;
				case 'success':
		    	$status_msg = '<strong>Success!</strong> You have created signup form successfully. Now you can use form shortcode anywhere.';
				break;
				case 'error':
		    	$status_msg = '<strong>Error!</strong> Something went wrong. Please try again.';
				break;
			}
		break;
		case 'entries':
			switch($status) {
				case 'info':
		    	$status_msg = 'Please select signup form to view entries.';
				break;
				case 'alert':
		    	$status_msg = '<strong>Alert!</strong> There are no entries for this form.';
				break;
				case 'success':
		    	$status_msg = '<strong>Success!</strong> Entries found for this form.';
				break;
				case 'error':
		    	$status_msg = '<strong>Error!</strong> Something went wrong. Please try again';
				break;
			} 
		case 'entry':
			switch($status) {
				case 'success':
		    	$status_msg = '<strong>Success!</strong> You have updated successfully.';
				break;
				case 'error':
		    	$status_msg = '<strong>Error!</strong> Something went wrong. Please try again';
				break;
			} 
		break;
	}
	
	if($status) {
		echo '<div class="alert alert-'.$status.'">
		  			<button type="button" class="close" data-dismiss="alert">x</button>
		      	'.$status_msg.'
		  		</div>';
	}
}


/********************************
 WBSF Debug String/Array
 :- Args: Label, Value
*********************************/
function wbsf_debug($label, $data) {
	echo "<div style=\"margin-left: 40px;background-color:#eeeeee;\"><u><h3>".$label."</h3></u><pre style=\"border-left:2px solid #000000;margin:10px;padding:4px;\">".print_r($data, true)."</pre></div>";
}


/********************************
 WBSF Redirect String
 :- Args: Value
*********************************/
function wbsf_redirect($url) {
	if($url) {
		echo "<script>location.href='".$url."';</script>";
	}
}

/********************************
 WBSF Settings
 :- Args: Key
*********************************/
function wbsf_options($key) {
$settings = get_option( 'wbsf_settings_options' );
	if($key) {
		return $settings[$key];
	}
	else {
		return $settings;
	}
}


/********************************
 WBSF Generate URL
 :- Args: Value

*********************************/
function wbsf_url($atts = '') {
	$pageURL = get_permalink();
	if($atts) {
		if ( get_option('permalink_structure') ) {
			$pageURL = $pageURL.'?'.$atts;
		}
		else {
			$pageURL = $pageURL.'&'.$atts;
		}
	}
	return $pageURL;
}



/********************************
 WBSF Generate Edit URL
 :- Args: Value
*********************************/
function wbsf_edit_url($atts = '') {
	$edit_page_id = wbsf_options('entry_edit_page');
	$pageURL = get_permalink($edit_page_id);
	if($atts) {
		if ( get_option('permalink_structure') ) {
			$pageURL = $pageURL.'?'.$atts;
		}
		else {
			$pageURL = $pageURL.'&'.$atts;
		}
	}
	return $pageURL;
}


/********************************
 WBSF Generate UUID
 :- Args: Prefix (Optional)
*********************************/
function wbsf_uuid($form_id) {
	$form =  wbsf_get_form($form_id);
	$prefix = strtolower(str_replace(" ","-",$form->form_prefix));
	$chars = $prefix.'-'.md5(uniqid(mt_rand(), true));
	return $chars;
}

/********************************
 WBSF FORM TYPES
 :- Args: FORM TYPE (value)
*********************************/
function wbsf_form_type($form_type) {
	$forms = array(1=>'1317 signup',2=>'Kids Club signup',3=>'Project Educate Signup');
	return $forms[$form_type];
}	

/********************************
 WBSF GET ENTRY TABLE NAME
 :- Args: FORM TYPE (value)
*********************************/
function wbsf_entry_table($form_type) {
	$table_name = "";
	switch($form_type) {
		case 1:
		$table_name = WBSF_ENTRIES_TABLE;
		break;
		case 2:
		$table_name = WBSF_KIDS_ENTRIES_TABLE;
		break;
		case 3:
		$table_name = WBSF_EDU_ENTRIES_TABLE;
		break;
	}
	return $table_name;
}

/**********************************
 WBSF GET ENTRY TABLE NAME BY ID
 :- Args: FORM ID (value)
***********************************/
function wbsf_entry_table_by_id($form_id) {
	$form = wbsf_get_form($form_id);
	$table_name = wbsf_entry_table($form->form_type);
	return $table_name;
}


/********************************
 WBSF serialize Children
 :- Args: Array (2)
*********************************/
function wbsf_serialize($child_names, $child_dobs) {
	if(count($child_names) > 0) {
		foreach($child_names as $key=>$child_name) {
			$child_array[] = array('name'=>$child_name, 'dob'=>$child_dobs[$key]); 
		}
	}
	return $children = serialize($child_array);
}


/********************************
 WBSF User Mail Message
 :- Args: FORM TYPE,ENTRY OBJECT
*********************************/
function wbsf_mail_admin_msg($form_type,$entry) { 
	$message = "";
	switch($form_type) {
		case 1:
		$children_array = unserialize($entry->children);
		foreach($children_array as $child){
			$children = $children.$child['name'].' - '.$child['dob'].'<br />';
		}
		$message = '<table border="1" rules="all">
				<tr>
					<th align="left">Name (Parent/Guardian)</th>
					<td align="left">'.$entry->parent_name.'</td>
				</tr>
				<tr>
					<th align="left">Email</th>
					<td align="left">'.$entry->email.'</td>
				</tr>
				<tr>
					<th align="left">Birthdate</th>
					<td align="left">'.$entry->parent_dob.'</td>
				</tr>
				<tr>
					<th align="left">Teens</th>
					<td align="left">'.$children.'</td>
				</tr>
				<tr>
					<th align="left">Mailing Address</th>
					<td align="left">'.$entry->address.',<br />'.$entry->city.', '.$entry->state.',<br />'.$entry->zip.'<br /><a href="https://maps.google.co.in/maps?q='.$entry->address.', '.$entry->city.', '.$entry->state.', '.$entry->zip.'" target="_blank">Google Map</a></td>
				</tr>
				<tr>
					<th align="left">Registration ID</th>
					<td align="left">'.$entry->token.'</td>
				</tr>
			</table>';
		break;
		case 2:
		$children_array = unserialize($entry->children);
		foreach($children_array as $child){
			$children = $children.$child['name'].' - '.$child['dob'].'<br />';
		}
		$message = '<table border="1" rules="all">
				<tr>
					<th align="left">Name (Parent/Guardian)</th>
					<td align="left">'.$entry->parent_name.'</td>
				</tr>
				<tr>
					<th align="left">Email</th>
					<td align="left">'.$entry->email.'</td>
				</tr>
				<tr>
					<th align="left">Birthdate</th>
					<td align="left">'.$entry->parent_dob.'</td>
				</tr>
				<tr>
					<th align="left">Children</th>
					<td align="left">'.$children.'</td>
				</tr>
				<tr>
					<th align="left">Mailing Address</th>
					<td align="left">'.$entry->address.',<br />'.$entry->city.', '.$entry->state.',<br />'.$entry->zip.'<br /><a href="https://maps.google.co.in/maps?q='.$entry->address.', '.$entry->city.', '.$entry->state.', '.$entry->zip.'" target="_blank">Google Map</a></td>
				</tr>
				<tr>
					<th align="left">Registration ID</th>
					<td align="left">'.$entry->token.'</td>
				</tr>
			</table>';
		break;
		case 3:
		$message = '<table border="1" rules="all">
				<tr>
					<th align="left">Name (Parent/Guardian)</th>
					<td align="left">'.$entry->parent_name.'</td>
				</tr>
				<tr>
					<th align="left">Email</th>
					<td align="left">'.$entry->email.'</td>
				</tr>
				<tr>
					<th align="left">Birthdate</th>
					<td align="left">'.$entry->parent_dob.'</td>
				</tr>
				<tr>
					<th align="left">School Name</th>
					<td align="left">'.$entry->school_name.'</td>
				</tr>
				<tr>
					<th align="left">School Type</th>
					<td align="left">'.$entry->school_type.'</td>
				</tr>
				<tr>
					<th align="left">School Zip</th>
					<td align="left">'.$entry->school_zip.'</td>
				</tr>
				<tr>
					<th align="left">Mailing Address</th>
					<td align="left">'.$entry->address.',<br />'.$entry->city.', '.$entry->state.',<br />'.$entry->zip.'<br /><a href="https://maps.google.co.in/maps?q='.$entry->address.', '.$entry->city.', '.$entry->state.', '.$entry->zip.'" target="_blank">Google Map</a></td>
				</tr>
				<tr>
					<th align="left">Registration ID</th>
					<td align="left">'.$entry->token.'</td>
				</tr>
			</table>';
		break;
	}

	return $message;

}


/********************************
 WBSF Send Mail to User
 :- Args: Data
*********************************/
function wbsf_mail_user($form_type,$entry_id) {
	$entry = wbsf_get_entry($form_type,$entry_id);
	$wbsf_token = $entry->token;
	$to = $entry->email;
	$admin = wbsf_options('email');
	if(!$admin) { $admin = get_option( 'admin_email' ); }
	$form = wbsf_get_form($entry->fid);
	$subject = "Registered on ".$form->form_title;
	$edit_url = wbsf_edit_url('wbsf_token='.$wbsf_token.'&wbsf_entry_mode=confirm&form_type='.$form_type);
	$message = '
			<p>***This is an automated response - Do Not Reply***</p>
			<p>Hi '.$entry->parent_name.',</p>
			<p>Thank you for registering for '.$form->form_title.'.</p>
			<p>Your Registration ID: <strong>'.$entry->token.'</strong></p>
			<p>We hope that you will find this event both informative and enjoyable. Should you have any questions, please contact '.$admin.'.</p>
			<p><a href="'.$edit_url.'" target="_blank">Edit Registration Details</a></p>
			<p>&nbsp;</p>
			<p>Thank You.</p>';
	add_filter( 'wp_mail_content_type', 'wbsf_set_html_content_type' );
	wp_mail( $to, $subject, $message );
	remove_filter( 'wp_mail_content_type', 'wbsf_set_html_content_type' );
}


/********************************
 WBSF Send Mail to Admin
 :- Args: Data
*********************************/
function wbsf_mail_admin($form_type,$entry_id) {
	$entry = wbsf_get_entry($form_type,$entry_id);
	$to = wbsf_options('email');
	if(!$to) { $to = get_option( 'admin_email' ); }
	$form = wbsf_get_form($entry->fid);
	$subject = "New Submission for ".$form->form_title;
	$message = '
			<p>***This is an automated response - Do Not Reply***</p>
			<p>Hi,</p>
			<p>'.$entry->parent_name.' registered for '.$form->form_title.'.</p>
			<p><strong>Details:</strong></p>
			'.wbsf_mail_admin_msg($form_type,$entry).'
			<p><a href="'.wbsf_get_url('entries').'&action=view&eid='.$entry->eid.'&form_type='.$form_type.'">View Registration Details</a></p>
			<p>&nbsp;</p>
			<p>Thank You.</p>';
	add_filter( 'wp_mail_content_type', 'wbsf_set_html_content_type' );
	wp_mail( $to, $subject, $message );
	remove_filter( 'wp_mail_content_type', 'wbsf_set_html_content_type' );
}

/********************************
 WBSF Send Mail Formate
 :- Args: None
*********************************/
function wbsf_set_html_content_type() {

	return 'text/html';
}


/****************************************
 Check and Insert Form and return Form ID
 :- Args : Data Array
******************************************/
function wbsf_create_form($data) {
	global $wpdb;
	$table = WBSF_FORMS_TABLE;
	if(!empty($data['form_title'])) { // Checking
		$wpdb->insert( $table, $data );
		$form_id = $wpdb->insert_id;
	}
	return $form_id;
}


/****************************************
 Check and Update Form and return Form ID
 :- Args : Data Array
******************************************/
function wbsf_update_form($form_id,$data) {
	global $wpdb;
	$table = WBSF_FORMS_TABLE;
	$where = array('fid'=>$form_id);
	if(!empty($data['form_title'])) { // Checking
		$wpdb->update($table, $data, $where);
	}
	return $form_id;
}

/****************************************
 Delete Form
 :- Args : Form ID
******************************************/
function wbsf_delete_form($form_id) {
	global $wpdb;
	$status = 0;
	$table = WBSF_FORMS_TABLE;
	$where = array('fid'=>$form_id);
	if(!empty($form_id)) { // Checking
		$wpdb->delete($table, $where);
		$status = 1;
	}
	return $status;
}

/*************************
 Get Forms 
 :- Args : Data Number
*************************/
function wbsf_get_forms($form_status=1) {
	global $wpdb;
	$table = WBSF_FORMS_TABLE;
	$dataQuery = "form_status=".$form_status;	
	$output = $wpdb->get_results( "SELECT * FROM $table WHERE $dataQuery" );
	return $output;
}

/******************************
 Get Single Form 
 :- Args : Data Number-Form ID
*******************************/
function wbsf_get_form($form_id) {
	global $wpdb;
	$table = WBSF_FORMS_TABLE;
	$output = $wpdb->get_row( "SELECT * FROM $table WHERE fid=$form_id" );
	return $output;
}


/****************************************
 Check and Insert Entry and return Entry ID
 :- Args : Data Array

******************************************/
function wbsf_create_entry($form_type,$data) {
	global $wpdb;
	$table = wbsf_entry_table($form_type);
	if(count($data) > 0) { // Checking
		$wpdb->insert( $table, $data );
		$entry_id = $wpdb->insert_id;
	}
	return $entry_id;
}


/****************************************
 Check and Update Entry and return Entry ID
 :- Args : Data Array
******************************************/
function wbsf_update_entry($form_type,$entry_id,$data) {
	global $wpdb;
	$table = wbsf_entry_table($form_type);
	$where = array('eid'=>$entry_id);
	if(count($data) > 0) { // Checking
		$wpdb->update($table, $data, $where);
		return $entry_id;
	}
}

/****************************************
 Delete Entry
 :- Args : Entry ID

******************************************/
function wbsf_delete_entry($form_type,$entry_id) {
	global $wpdb;
	$status = 0;
	$table = wbsf_entry_table($form_type);
	$where = array('eid'=>$entry_id);
	if(!empty($entry_id)) { // Checking
		$wpdb->delete($table, $where);
		$status = 1;

	}
	return $status;
}


/*******************************
 Get Entry By ID
 :- Args : Data Number-Entry ID
********************************/
function wbsf_get_entry($form_type,$entry_id) {
	global $wpdb;
	$table = wbsf_entry_table($form_type);
	$output = $wpdb->get_row( "SELECT * FROM $table WHERE eid=$entry_id" );	
	return $output;
}

/*******************************
 Get Entry By Token
 :- Args : Data Number-Entry ID
********************************/
function wbsf_get_entry_by_token($form_type,$entry_token) {
	global $wpdb;
	$table = wbsf_entry_table($form_type);
	$output = $wpdb->get_row( "SELECT * FROM $table WHERE token='$entry_token'" );	
	return $output;
}


/*******************************
 Get Entries of Form 
 :- Args : Data Number-Form ID
********************************/
function wbsf_get_entries($form_type,$form_id) {
	global $wpdb;
	$table = wbsf_entry_table($form_type);
	if($form_id) {
		$query = 'SELECT * FROM '.$table.' WHERE fid='.$form_id;
	}
	else {
		$query = 'SELECT * FROM '.$table;
	}
	$output = $wpdb->get_results( $query );	
	return $output;
}


/********************************
 Get Num of Entries of Form
 :- Args : Data Number-FOrm ID
********************************/
function wbsf_get_entries_count($form_id) {
	$form = wbsf_get_form($form_id);
	$entries = wbsf_get_entries($form->form_type,$form_id);
	$count = count($entries);
	return $count;
}


/**********************************
 Check Entries there for Form?
 :- Args : Data Number-Form ID
***********************************/
function wbsf_has_entries($form_id) {
	$form = wbsf_get_form($form_id);
	$entries = wbsf_get_entries($form->form_type,$form_id);
	$count = count($entries);
	if($count > 0) {
		return true;
	}
	else {
		return false;
	}
}

/*********************************************
	Get Lat and Lng of address from Google map.
 :- Args : Data String-Address
**********************************************/
function wbsf_get_lat_lng($address) {
	if($address) {
		$output = array();
		$google_map = simplexml_load_file('http://maps.googleapis.com/maps/api/geocode/xml?address='.$address.'&sensor=true');
		$output['latitude'] = $google_map->result->geometry->location->lat;
		$output['longitude'] = $google_map->result->geometry->location->lng;
		return $output;
	}
}

?>
