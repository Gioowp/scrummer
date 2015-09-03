jQuery(document).ready(function($){




	jQuery( ".boardList" ).sortable({
		items: "> div.listItem",
		connectWith: ".boardList",
		placeholder: "sorting-placeholder"
	});
//    jQuery( ".boardList" ).disableSelection();


	jQuery( ".manageCol" ).accordion({
		collapsible: true,
		header: ".panel-heading",
		activate: function( event, ui ) {
			updateListsContent();
		},
		create: function( event, ui ) {
			updateListsContent();
		},

	});

	jQuery( ".listItemForm" ).dialog({
		autoOpen: false,
		draggable: false,
		modal: true,
		minHeight: 600,
		minWidth: 700,

	});
	jQuery( ".doAddNewListItem" ).click(function() {
		jQuery( ".listItemForm" ).dialog( "open" );
	});

	jQuery( ".listForm" ).dialog({
		autoOpen: false,
		draggable: false,
		modal: true,
		minHeight: 600,
		minWidth: 700,

	});
	jQuery( ".doAddNewList" ).click(function() {
		jQuery( ".listForm" ).dialog( "open" );
	});


	jQuery( ".boardForm" ).dialog({
		autoOpen: false,
		draggable: false,
		modal: true,
		minHeight: 300,
		minWidth: 700,

	});
	jQuery( ".doAddNewBoard" ).click(function() {
		jQuery( ".boardForm" ).dialog( "open" );
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
		jQuery(this).closest('.dropdown, .dropup').toggleClass("open");
		updateLabels(this);
	});



	jQuery('body').on('click', '.labelStatus', function (e) {

		jQuery(this).toggleClass("active");
		updateLabels(this);

	});
	jQuery('body').on('click', '.memberBox .memberRow', function (e) {

		jQuery(this).toggleClass("active");
		updateMembers(this);

	});


	//////////// save board
	jQuery('body').on('submit', '#boardForm', function (e) {
		e.preventDefault();

		jQuery('.alert', this).remove();

		var formData = new FormData(this);

		jQuery.ajax({
			url: dinob.home_url+'/wp-admin/admin-ajax.php',
			data: formData,
			processData: false,
			contentType: false,
			type: 'POST',
			success: function(data){
				//alert(data);
				if(data)jQuery('#boardForm').prepend( addAlerts(data) );

			}
		});

	});

	////// save list
	jQuery('body').on('submit', '#listForm', function (e) {
		e.preventDefault();
		jQuery('.alert', this).remove();

		var formData = new FormData(this);
		formData.append('members', collectMembersId( jQuery('.activeMembers', this) ));
		formData.append('board', jQuery('.bodyCol').attr('boardId') );



		jQuery.ajax({
			url: dinob.home_url+'/wp-admin/admin-ajax.php',
			data: formData,
			processData: false,
			contentType: false,
			type: 'POST',
			success: function(data){
				//alert(data);
				if(data)jQuery('#listForm').prepend( addAlerts(data) );
			}
		});

	});

	//////////// save item
	jQuery('body').on('submit', '#itemForm', function (e) {
		e.preventDefault();

		var formData = new FormData(this);

		jQuery.ajax({
			url: dinob.home_url+'/wp-admin/admin-ajax.php',
			data: formData,
			processData: false,
			contentType: false,
			type: 'POST',
			success: function(data){
				alert(data);
			}
		});

	});

	//////////// save comment
	jQuery('body').on('submit', '#commentForm', function (e) {
		e.preventDefault();

		var formData = new FormData(this);

		jQuery.ajax({
			url: dinob.home_url+'/wp-admin/admin-ajax.php',
			data: formData,
			processData: false,
			contentType: false,
			type: 'POST',
			success: function(data){
				alert(data);
			}
		});

	});



})


function updateListsContent(){
	var boardId = jQuery('.boardManagers .boardSettings.ui-accordion-content-active').attr('boardId');
	if(!boardId){
		jQuery('.bodyCol').attr('boardId', '').html('');
		return;
	}
	jQuery('.bodyCol').attr('boardId', boardId);

	jQuery.ajax({
		url: dinob.home_url+'/wp-admin/admin-ajax.php',
		data: {action:'ajaxactions', whattodo: 'getLists', boardid: boardId},
		//processData: false,
		//contentType: false,
		type: 'POST',
		success: function(data){
			jQuery('.bodyCol').html( data );
			//alert(data);
		}
	});
	return;
}

function addAlerts(data){
	var alert = '<div class="alert alert-warning" role="alert">'+data+'</div>';

	return alert;
	//jQuery(thiss).prepend(alert);
}


function collectMembersId(thiss){

	var members = '';
	jQuery('[memberid]', thiss).each(function(){
		console.log( jQuery(this).attr('memberid') );

		members = members+','+jQuery(this).attr('memberid');

	})
	return members;
}

function collectLabels(thiss){

	var members = '';
	jQuery('[memberid]', thiss).each(function(){
		members = members+','+jQuery(this).attr('memberid');
	})

}

function updateMembers(thiss){

	var listItem = jQuery(thiss).closest('.listItem');
	var memberBox = jQuery('.memberBox', listItem);

	jQuery('.activeMembers', listItem).html('');

	jQuery('.memberRow',memberBox).each(function(e){

		if( jQuery(this).hasClass('active') ){
//alert(11111);
			var ee = jQuery( ".memberAbreviation", this ).clone();
			jQuery('.activeMembers', listItem).append( ee );
			//alert(ee);

		}else{

			jQuery('.activeMembers .memberAbreviation[memberId='+jQuery(this).attr('memberId')+']', listItem).remove();

		}

	});

}

function updateLabels(thiss){

	var listItem = jQuery(thiss).closest('.listItem');
	var labelBox = jQuery('.labelBox', listItem);

	jQuery('.activeLabels', listItem).html('');

	jQuery('.labelRow',labelBox).each(function(e){

		//console.log( jQuery('.labelStatus', this).attr('class') );

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

function dinForm(thiss){


	jQuery.ajax({
		url: dinob.home_url+'/wp-admin/admin-ajax.php'+get,
		data: new FormData(thiss),
		processData: false,
		contentType: false,
		type: 'POST',
		success: function(data){
			alert(data);
		}
	});
}
	



