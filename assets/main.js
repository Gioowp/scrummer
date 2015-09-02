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


	jQuery( ".dateBuffer" ).datepicker({
		changeMonth: true,
		changeYear: true,
		onSelect:function(e, ob){
			//alert(e);
			console.log();
			jQuery('.dueDate', jQuery(ob.input).closest('.doSetDate')).html(e);
		}
	});


	jQuery('body').on('click','.doSetDate',function(e){
		jQuery( ".dateBuffer", this ).datepicker('show');
	})



	jQuery('body').on('click','.doDropDown, .doCloseDropdown', function (event) {
		jQuery(this).closest('.dropdown').toggleClass("open");
		updateLabels(this);
	});



	jQuery('body').on('click', '.labelStatus', function (e) {

		jQuery(this).toggleClass("active");
		updateLabels(this);

	});


})



function updateLabels(thiss){

	var listItem = jQuery(thiss).closest('.listItem');
	var labelBox = jQuery('.labelBox', listItem);

	jQuery('.activeLabels', listItem).html('');

	jQuery('.labelRow',labelBox).each(function(e){

		console.log( jQuery('.labelStatus', this).attr('class') );

		if( jQuery('.labelStatus', this).hasClass('active') ){


			jQuery('.activeLabels', listItem).append("<div style='background-color:#"+jQuery(this).attr('hexcode')+";' class='activeLabel "+jQuery(this).attr('hexcode')+"' title='"+jQuery('input', this).val()+"'>"+jQuery('input', this).val()+"</div>");

		}else{

			jQuery('.activeLabels', listItem).remove("."+jQuery(this).attr('hexcode'));

		}

	});
}

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
	



