var oTable;
jQuery(document).ready(function($){

var _custom_media = true,
      _orig_send_attachment = wp.media.editor.send.attachment;

  jQuery('.meta_upload').click(function(e) {
    var send_attachment_bkp = wp.media.editor.send.attachment;
    var button = $(this);
    var id = button.attr('id').replace('button_', '');
    _custom_media = true;
    wp.media.editor.send.attachment = function(props, attachment){
      if ( _custom_media ) {
        $("#"+id).val(attachment.url).select();
      } else {
        return _orig_send_attachment.apply( this, [props, attachment] );
      };
    }

    wp.media.editor.open(button);
    return false;
  });


	


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
			}
		});
	
		if(stat == 1) {
			jQuery('#wb_overlay').fadeIn();
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
	
if($('#wbsf_dyntable').length > 0) {

	
		$('#commit_form_step').submit( function() {
		var fields =  oTable.$('input').serializeArray();

    $( "#commit_fields" ).val('');
    jQuery.each( fields, function( i, field ) {
			var cons = ",";
			if(i==0) { cons = ""; }
      $( "#commit_fields" ).val(function( index, val ) {
		    return val + cons + field.value;
			});
    });
     return true;
    } );
     
    oTable = $('#wbsf_dyntable').dataTable({
			"sPaginationType": "full_numbers",
			"aaSortingFixed": [[0,'asc']]
		});

}

	jQuery('.wbsf_delete').click(function() {
		var con = confirm('Confirm delete?');
		if(con){
			return true;
		}
		else {
			return false;
		}
		
	});

});
