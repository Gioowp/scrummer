jQuery(document).ready(function($){




	jQuery( ".boardList" ).sortable({
		items: "> div.listItem",
		connectWith: ".boardList",
		placeholder: "sorting-placeholder"
	});
//    jQuery( ".boardList" ).disableSelection();


	jQuery( ".manageCol" ).accordion({
		collapsible: true,
		header: ".panel-heading"

	});


	jQuery( ".listItemForm" ).dialog({
		autoOpen: false,
		draggable: false,
		modal: true,
		minHeight: 600,
		minWidth: 700,
		show: {
			effect: "blind",
			duration: 100
		},
		hide: {
			effect: "explode",
			duration: 100
		}
	});

	jQuery( ".doAddNewListItem" ).click(function() {
		jQuery( ".listItemForm" ).dialog( "open" );
	});





})


function dinload( id, get, action, post){
	///id - loading container id
	if(id==''){return false;}
	
	if(action=='' || !action)action='dinload';
	if(get=='' || !get)get='?';
	if(id=='' || !id)return;

	//var data;

	jQuery.ajax({
		type: "POST",
		url: dinob.home_url+'/wp-admin/admin-ajax.php'+get,
		data: { val: post, action: action },
		dataType: "html",
		success: function (dataCheck) {
			if(jQuery('#'+id)){ jQuery('#'+id).html(dataCheck); return false; }
        },
        async:true
		});

	return false;
}
	



