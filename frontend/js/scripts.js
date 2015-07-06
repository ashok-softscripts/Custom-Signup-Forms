jQuery(document).ready(function($){

	jQuery('#wbsf-submit').click(function(){
		var stat = 1;
		jQuery('.data-required').each(function() {
			var val = jQuery(this).val();
			if(val == '') {
				jQuery(this).addClass('wbsf-not-valid');
				stat = 0;
			}
			else {
				jQuery(this).removeClass('wbsf-not-valid');
				if(jQuery(this).hasClass('wbsf-datepicker')) {
					var check_dob = validated_dob(val);
					if (check_dob[0] == "NO"){
						stat = 0;
            alert(check_dob[1]);
            jQuery(this).addClass('wbsf-not-valid');
						return false;
					 }
				}
			}
		});
		
	
		if(stat == 1) {
			//jQuery('#wb_overlay').fadeIn();
			return true;
		}
		else {
			return false;
		}

	});

	jQuery('.data-required').keyup(function(){
		var val = jQuery(this).val();
			if(val == '') {
			jQuery(this).addClass('wbsf-not-valid');
		}
		else {
			jQuery(this).removeClass('wbsf-not-valid');
		}
	});

	jQuery('[data-dismiss="alert"]').click(function(){
		jQuery(this).parent().remove();
	});
	
	jQuery('a.wbsf-remove').click(function(){
		jQuery(this).parent().slideUp('800',function() {
			jQuery(this).remove();
		});;
		return false;				
	});
	
	jQuery('.wbsf-datepicker').datepicker({
			format: 'mm-dd-yyyy'
	});
	
	var newRowNum = jQuery('.children_field').length;
		
			// bind a click event to the "Add" link
			jQuery('#wbsf-addnew').click(function(){
				// increment the counter
				newRowNum += 1;
						
				var addRow = jQuery(this).parent().parent().prev();
				
				// copy the entire row from the DOM
				// with "clone"
				var newRow = addRow.clone();
				
				// set the values of the inputs
				// in the "Add" row to empty strings
				jQuery('input', newRow).val('');
				jQuery('input', newRow).removeClass('hasDatepicker');
				
				newRow.attr('id','children_detils_'+(newRowNum+1));

				jQuery('input', newRow).each(function(i){
					inID="";
					if(i==0){ var inID="child_name"; }
					if(i==1){ var inID="child_dob"; }
					var newID = inID+'_'+newRowNum;
					jQuery(this).attr('id',newID);
				});
				jQuery('label', newRow).each(function(s){
					lbID="";
					if(s==0){ var lbID="child_name"; }
					if(s==1){ var lbID="child_dob"; }
					var newlbID = lbID+'_'+newRowNum;
					jQuery(this).attr('for',newlbID);
				});

				// insert a remove link in the last cell
				
				if(jQuery(newRow).children('a.wbsf-remove').length == 0) {
					jQuery(newRow).append('<a href="#" class="btn btn-danger btn-xs wbsf-remove">X<\/a>');
				}
		
				// insert the new row into the table
				// "after" the Add row
				addRow.after(newRow);
				
				jQuery('.wbsf-datepicker').datepicker({
						format: 'mm-dd-yyyy'
				});

				// add the remove function to the new row
				jQuery('a.wbsf-remove', newRow).click(function(){
					jQuery(this).parent().slideUp('800',function() {
						jQuery(this).remove();
					});;
					return false;				
				});

				// prevent the default click
				return false;
			});




});
