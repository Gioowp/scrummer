<?



$langs = get_option( __pn(__FILE__)."_languages" );
//print_rr($langs);

?>

<div class="word-edit-form window shdw">
<div class="delwin close ic shdw">X</div>

<form>
<?
foreach($langs as $k=>$v){
?>
<div class="lan_title"><?=$v?></div>
<textarea name="<?=$v?>" title="<?=$v?>"></textarea>

<? }?>
<input type="hidden" name="wordid" value="" />
<div class="button save">Save</div>
<div class="button save_close">Save & Close</div>
</form>
</div>