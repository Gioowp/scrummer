<style>
a{ cursor:pointer; }
.hide{ display:none; }
.shdw{-webkit-box-shadow: 0px 0px 5px 0px rgba(50, 50, 50, 0.75); -moz-box-shadow: 0px 0px 5px 0px rgba(50, 50, 50, 0.75); box-shadow:0px 0px 5px 0px rgba(50, 50, 50, 0.75);}
.ic{ background:#CCC; width:20px; height:20px; display:block; text-align:center; line-height:17px; border-radius:50%; }
.close{cursor:pointer; float:right; margin:0px; position:absolute; right:40px; top:-16px; }

.word-listing{ float:left; width:90%; }
.word-listing thead td{ background:#CCC; padding:5px 15px; font-weight:bold; }
.word-listing td{ border-bottom:solid 1px #CCCCCC; }
.edit-form-place{ float:left; background:#0C0; }
.din-form{position:relative;}

.word-edit-form{ position:absolute; background:#eaeaea; padding:15px; border-top:#CCC solid 4px; opacity:0.95; top:25px; right:45px; }
.word-edit-form textarea{ float:left; width:900px; height:130px; }

.local-result .cell{ display:none; }
.local-result .cell.<?=get_bloginfo('language')?>{display:block;}

.paging{ float:left; width:90%; background:#eaeaea; margin:30px 0px; padding:10px; }
.paging a{ padding:4px 12px; font-size:16px; text-decoration:none; }
.paging a:hover{ background:#72c5e6; color:#FFF;  }
.paging a.current{ background:#0074A2; color:#FFF; }


</style>

<? 

$where = '';
if(chek_val($_POST,'searchword') && chek_val($_POST,'word')){
	$word = strip_tags( $_POST['word'] );
	$where = "where name like '%{$word}%' OR data like '%{$word}%' ";
}

$qr_part = " from ".__table('words')." {$where} order by domain, name  ";


/* pager */
$qr = "select count(*) {$qr_part} ";
$tmp = $GLOBALS['wpdb']->get_var($qr);
$pager = __pager($tmp,$perpage=40, $html_limit=20, __link_to(), $words=array());



$qr = "select * {$qr_part} {$pager['limit']}";
$tmp = $GLOBALS['wpdb']->get_results($qr, ARRAY_A);

?>

<form action="<?=__link_to('pp=')?>" method="post">
<table class='word-search'>
<tr>
	<td>String </td>
    <td><input type="text" name="word" class="word" value="<?=chek_val($_POST,'word')?>" /></td>
    <td><input type="submit" class="button" name="searchword" value="Search...." /></td>
    <td><a class="button" href="<?=__link_to()?>">Clear filter</a></td>
</tr> 
</table>
</form>


<table class='word-listing'>
<thead>
<tr>
	<td>Name</td>
	<td>Domain</td>
	<td>String</td>
    <td>Action</td>
</tr> 
</thead>

<tbody>
<?

foreach($tmp as $v){

?>


<tr class="<?=$v['id']?>" wordid='<?=$v['id']?>'>
	<td><?=$v['name']?></td>
	<td><?=$v['domain']?></td>
	<td class="strings">
    <div class="local-result" id="local-result-<?=$v['id']?>">
	<? __show_local_strings($v['data']); ?>
    </div>
	</td>
	<td><div class="din-form"></div>
        <a class="do-edit-word" toid='edit-form-place' word='<?=$v['id']?>'>Edit</a>
        
    </td>
</tr>

<? }?>

</tbody>
</table>
<?=$pager['html']?>

<div class="edit-form-place" id="edit-form-place" style="display:none;"><?=__file_part("file=word_edit&dir=form&plugin=".__pn(__FILE__))?></div>


<?


?>
<script>

jQuery(window).load(function(){
	jQuery('.do-edit-word').on('click', function(){
		var et = jQuery(this).attr('word');
		jQuery('.din-form').html( '' );
		jQuery( 'tr.'+et+' .din-form').html( jQuery('.edit-form-place').html() );
		jQuery( 'tr.'+et+' .strings .cell').each(function(){
			jQuery( 'tr.'+et+' .din-form textarea[name='+jQuery(this).attr('title')+']').val( jQuery(this).html() );
		});
		jQuery( 'tr.'+et+' .din-form input[name=wordid]').val( et );
	})

	jQuery('body').on('click','.word-edit-form .button',function(){
		var et = jQuery(this).closest('tr').attr('wordid');
		dinload('local-result-'+et,'?','__update_string', jQuery( this ).closest('form').serializeArray());
	})

})


</script>

