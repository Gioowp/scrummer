jQuery(window).load(function(){
	jQuery('.vcenter').each(function(index){
		var parent = $(this).parent('*');
		if(!parent || $(parent).height()<=$(this).height())return;
		var margintop = ($(parent).height()-$(this).height())/2;
		$(this).css({'margin-top':margintop+'px'});
	});

})

jQuery(document).ready(function($){

	
	$("input:radio, input:checkbox").addClass('radio');
	$(".zebra tr:nth-child(odd)").css("background","#cccccc");
	
	
	$(".hovertable tr, .entry-content table tr").on("mouseenter",function(){
		$(this).addClass('hovertd');
	}).on("mouseleave",function(){
		$(this).removeClass('hovertd');
	});
	
	$(".hovertbody tbody tr, .hovertbody table tbody tr").on("mouseenter",function(){
		$(this).addClass('hovertd');
	}).on("mouseleave",function(){
		$(this).removeClass('hovertd');
	});  

	



$(".confirm, .delete").on("click",function(){
	if($(this).hasClass('noautoconfirm'))return;
	var text = ' \n Before you click OK be sure you do right action! \n\n\n Note: This may take a some troubles \n\n\n';
	if($(this).attr('confirm'))text=$(this).attr('confirm');
	return confirm(text);
});


  
$(".onhover").on("mouseenter",function(){
	$(".onhover").removeClass('hover');
	$(this).addClass('hover');
}).on("mouseleave",function(){
	$(".onhover").removeClass('hover');});


$('body').on('click','*[close]',function(){
	var closebox = $(this).attr('close');
	if(!closebox)return false;
	$('.'+closebox).fadeOut('fast'); return false;//	winclose(this);
})


$("body").on("click",".delwin, .windel, .submitdel", function(){
	$(this).closest('.window').html('').remove(); return false;//	winclose(this);
});


	
$("body").on("click",".dinload",function(){
	dinload($(this).attr('toid'), $(this).attr('tourl') ,$(this).attr('action'),$(this).attr('varr'));
	return false;
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
	



