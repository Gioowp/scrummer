<?

////////////////////////////////////////////////////////////////////////////////////////////////////////
////////////////////////////////////////////////////////////////////////////////////////////////////////
/////// plugin additional functions 
if (!function_exists('__admin_pages')) {
function __admin_pages(){
	global $p;

	if(!chek_val($p,1))return false;
	$filename = chek_val($p,1);

	$dirname = chek_val($p,2)?'part':$p[2];
	
	if(__chek_file($filename, $dirname )){
		print __file_part($filename, $dirname);
	}elseif(__chek_file($filename,'admin')){
		return __file_part($filename, 'admin');
	}elseif(__chek_file($filename,'form')){
		return __file_part($filename, 'form');
	}
	
	return;
	
}}

if (!function_exists('__link_to')) {
function __link_to($to='a='){
///// V1.1.1 created for wp
//// ////////////
///////

	global $optimizer;
	$opt = "";

			$get = $_GET;
			$link = "";
            $to1 = explode("&", $to);
            $i=0;
            $fu = false;
	foreach($to1 as $val){
		//echo($k);
		$to2 = explode("=", $val);
			/////if action encode to base64
			if(empty($to2[0])){continue;}
			if($to2[0]=='act'){$to2[1]= base64_encode($to2[1]); }
			if($to2[0]=='fl'){$to2[1]= base64_encode($to2[1]); }
			if($to2[0]=='p'){$to2[1]= base64_encode($to2[1]); }
			if($to2[0]=='permalink'){$fu = $to2[1]; continue; }
			
			if(!isset($to2[1])){continue;}
		$get[$to2[0]]=$to2[1];
	}
		
//print_r($get);
	foreach($get as $key=>$val){
		if(empty($val)){ continue; }
		$sep = ++$i == 1?"":"&";
		
		$link = $link.$sep.$key."=".$val;
	}
	
	$fu = explode('.', $fu);
	$fuu = '';
	foreach($fu as $k=>$v){
		$fuu .= safe_name($v)."/";
	}
	
    return "?{$link}";
}}

if (!function_exists('print_rr')){
function print_rr($arr=array()){
	print "<pre>";
	print_r($arr);
	print "</pre>";
}}

if (!function_exists('__file_part')) {
function __file_part($cf = ''){//v1
//////// get file
	$cf = __default_configer($cf,'file=&dir=part&data=ar&plugin=');
	if(empty($cf['file']))return false;
	global $wpdb, $p, $act, $fl;
	$incfile = false;

	if(!$incfile = __chek_file("file={$cf['file']}&dir={$cf['dir']}&plugin={$cf['plugin']}")){//print_rr($cf);
	//print __chek_file("file={$cf['file']}&dir={$cf['dir']}&plugin={$cf['plugin']}&return=dir")."{$cf['file']}.php";
		file_put_contents(__chek_file("file={$cf['file']}&dir={$cf['dir']}&plugin={$cf['plugin']}&return=dir")."{$cf['file']}.php", $cf['file']);
		return false;
	}

	ob_start();
	include $incfile;
	$ret = ob_get_contents();
	ob_end_clean();
	return $ret;
}}

if (!function_exists('__chek_file')){
function __chek_file( $cf = '' ){//v1
	$cf = __default_configer($cf,'file=&dir=part&return=fullpatch&plugin=');

	//$abspatch = substr(__FILE__,0,strpos(__FILE__,'plugins'));
	$patch = ABSPATH .'wp-content\plugins\\'.$cf['plugin'].'\\';

	if(is_dir($patch.$cf['dir'].'\\')){
		$patch=$patch.$cf['dir'].'\\';
	}else{ return false; }
	
	if( $cf['return']=='dir' )return $patch;

	if(empty($cf['file']))return false;
	if(is_file("{$patch}{$cf['file']}.php"))return "{$patch}{$cf['file']}.php";
	
	return false;
}}




if (!function_exists('chek_val')) {
function chek_val($array = '', $key='', $chektype='empty',$toequal=''){//v.1
//	print $array;
	
	if(empty($key)&&!is_numeric($key)){ return false; }
	if(!is_array($array))$tmp = decode($array);
	if(isset($tmp) && is_array($tmp))$array = $tmp;
//if($key=='name'){ print_rr($array); }
	$val=false;
	if(is_array($array) && isset($array[$key])){ //// && $array[$key]!=''
		$val = $array[$key]; 
	}elseif(is_array($array) && !isset($array[$key])){
		return false;
	}else{ $val = $array; }
	$val2 = decode($val);
//	print_rr($array);
	if(($chektype=='numeric'||$chektype=='num') && !is_numeric($val)){ return false; }
	if($chektype=='str' && !is_string($val)){ return false; }
	
	if(($chektype=='arr'||$chektype=='ar'||$chektype=='array') && is_array($val2)){ $val = $val2; }
	if(($chektype=='arr'||$chektype=='ar'||$chektype=='array') && !is_array($val)){ return false; }
	if(($chektype=='email'||$chektype=='mail') && !is_array($val)){ return _chek_email($val); }
	
	
	if($chektype=='empty' && empty($val)){ return false; }
//	if(!empty($toequal) && $val!=$toequal){ return false; }
	if(!empty($val)||$val!='')return $val;
	return true;
}}

if (!function_exists('_prepare_decode')) {
function _prepare_decode($data=''){
	if(!is_array($data))return false;
	$badchars = array('"', "'", '\'');
	$badchars2 = array("\n");
	$badchars3 = array('\\', "\t", "\r");
	$striptags = '<p><a><br><br/><div>';
	
	$ret=array();
	foreach($data as $k=>$v){
		if(is_array($v)){ $ret[$k] = _prepare_decode($v); continue; }
			$v = stripslashes($v);
//			$v = strip_tags($v,$striptags);
			$v = str_replace($badchars,'`', $v);
			$v = str_replace($badchars2,'<br />', $v);
			$v = str_replace($badchars3,'', $v);
			$ret[$k] = addslashes($v);
			
		}
	return $ret;
}}

if (!function_exists('inarray')) {
function inarray($array = array(), $key='', $default=false){
	if(!is_array($array)){ $array = decode($array); }
	if(!is_array($array) || $key==''){ return $default; }
	
	if(isset($array[$key]) && $array[$key]==''){ return $default; }
	elseif (isset($array[$key])){return $array[$key]; }
	return $default;
}}

if (!function_exists('decode')) {
function decode($data='', $val_name='', $def='', $base64=false){
	if(is_array($data)){
		$data = _prepare_decode($data);
		if($base64){ 
			foreach($data as $k=>$v){
				$data[$k] = base64_encode($v);
			}
		}
		return serialize($data);
	}
	
	if(empty($data)){return $def;}
	@$data = unserialize(@$data);
	if(!is_array($data)){return $def;}
	if($base64){ 
		foreach($data as $k=>$v){
			$data[$k] = stripslashes(base64_decode($v));
		}
	}
	//print_r($data);
	if(empty($val_name)){return $data;}
	return inarray($data,$val_name,$def);
}}
///////////////////////////////////////////////////////
if (!function_exists('safe_name')) {
function safe_name($val = ''){
	if(empty($val)){ return false; }

		$val = strip_tags($val);
		$val = trim($val);
		$val = trim($val);
		$val = strtolower($val);
		
		$badchars = array('\\','|','/','"','  ','~','.',':',';',',','?','!','{','}','[',']','<','>','*','=','+','&','^','$','%','@','`','(',')');
		
		$val = str_replace($badchars,'',$val);
		$val = str_replace($badchars,'',$val);
		$val = str_replace(array(' ','-'),'_',$val);
	return $val;
}}

///////////////////////////////////////////


if (!function_exists('__select_url')) {
function __select_url($id='',$like='',$class='selected', $noselectedclass=''){//v.1
	if($id=='' || $like=='' || empty($class))return $noselectedclass;
	if(is_array($like) && array_search($id, $GLOBALS['mID_array'])){
		 return $class;
	}elseif($id==$like){
		return $class;
	}
	return $noselectedclass;
}}



/////////////////////////////////////// for links
if (!function_exists('__action_maker')) {
function __action_maker($var = 'act',$data=false){
	
	if($data){
		$action = base64_decode($data);
	}else{
		$action = isset($_GET[$var])? base64_decode($_GET[$var]):'';
	}
	$arr = explode('.',$action);
	
	$ret[1] = isset($arr[0])?$arr[0]:'';
	$ret[2] = isset($arr[1])?$arr[1]:'';
	$ret[3] = isset($arr[2])?$arr[2]:'';
	$ret[4] = isset($arr[3])?$arr[3]:'';
	$ret[5] = isset($arr[4])?$arr[4]:'';
//		print_r($ret);
		if(isset($_GET['act'])){ unset($_GET['act']); }
	return $ret;
}}



if (!function_exists('__update_fl')) {
function __update_fl($position=1,$newvar=''){
	/// chatenis cvlads dagenerirebul GET paramertshi. mag.: fl-shi chatenis meore cvlads
	global $fl;
	$ret = array();
	for($i=1; $i<=5; $i++){
		if($position==$i){
			$ret[$i] = $newvar;
			continue;
		}
		$ret[$i] = chek_val($fl,$i);
	}
	$GLOBALS['fl'] = $ret;
	$_GET['fl'] = base64_encode(implode('.',$ret));
	
	return false;
}}


if (!function_exists('_corect_ajformdata')) {
function _corect_ajformdata($data=''){
	/////// corects jquery serializeArray data. convert to asociated array
	if(!is_array($data))return array();
	
	foreach($_POST['val'] as $k=>$v){
	if(!chek_val($v,'name'))continue;
	//$v['name'] = str_replace('[',"['",$v['name']);
	$v['name'] = str_replace(']',"",$v['name']);
	
	$tmp = explode('[',$v['name']);
	//print $rr = "ret['".implode("']['",$tmp)."']";
			if(count($tmp)==1){
			$ret[$tmp[0]]=$v['value'];
		}elseif(count($tmp)==2){
			$ret[$tmp[0]][$tmp[1]]=$v['value'];
		}elseif(count($tmp)==3){
			$ret[$tmp[0]][$tmp[1]][$tmp[2]]=$v['value'];
		}elseif(count($tmp)==4){
			$ret[$tmp[0]][$tmp[1]][$tmp[2]][$tmp[3]]=$v['value'];
		}elseif(count($tmp)==5){
			$ret[$tmp[0]][$tmp[1]][$tmp[2]][$tmp[3]][$tmp[4]]=$v['value'];
		}elseif(count($tmp)==6){
			$ret[$tmp[0]][$tmp[1]][$tmp[2]][$tmp[3]][$tmp[4]][$tmp[5]]=$v['value'];
		}

	}
	return $ret;
}}



//////////// table functions
if (!function_exists('__table')) {
function __table($tablename=''){
	if(empty($tablename))return false;
	global $wpdb;
	
//	$mytables=array(1,'category','products','import','words');
	$mytables = get_option( "meplgn_tables", array());
	array_unshift($mytables,1);
	
	$prefix = $wpdb->prefix;//substr($wpdb->prefix, 0,strpos($wpdb->prefix,'_'));
	if(array_search($tablename,$mytables))return $prefix.'__'.$tablename;
	return $wpdb->prefix.$tablename;
	
}}


if (!function_exists('table_key_finder')) {
function table_key_finder($table='',$field=false,$dbname=''){
	global $wpdb;
	if(empty($table) || is_numeric($table))return false;
	$qr = "show tables like '{$table}'";
	$tmp = $wpdb->get_results($wpdb->prepare($qr,''), ARRAY_A);
	if(empty($tmp) || count($tmp)==0) return false;
	
	$ar = $wpdb->get_results($wpdb->prepare("describe {$table}",''), ARRAY_A);
	
	if(!is_array($ar)){return false;}
	foreach ($ar as $k=>$v){
		if(!$field && $v['Key']=='PRI'){ return $v['Field']; }
		if(!empty($field) && $field==$v['Field']){ return $v['Field']; }
	}

	return false;
}}

//----------------------------------------
if (!function_exists('update_table')) {
function update_table($table='item', $id_num='0', $itm_arr=array(), $dbname, $id_field, $described_table){
/// V2.0
/// added default values 
/////

	$set='';$metadata='';
	foreach($described_table as $k=>$v){
		
		if ($v['Field']=='meta' && isset($itm_arr['meta'])) { $metadata = $itm_arr['meta']; continue; }
		
		if ($id_field == $v['Field']) { continue; }
		
		if(!isset($itm_arr[$v['Field']])){ continue; }
		
		if(is_string($itm_arr[$v['Field']]) && is_array(json_decode( stripslashes( $itm_arr[$v['Field']] ) ) ))$itm_arr[$v['Field']] = json_decode( stripslashes( $itm_arr[$v['Field']] ) ) ;
		if(is_array($itm_arr[$v['Field']])){$itm_arr[$v['Field']]=decode($itm_arr[$v['Field']]);}
			
			if(empty($set)){$coma='';}else{$coma=', ';}
			
			//$set .= $coma.$v['Field']."='".remove_tags($itm_arr[$v['Field']],'tags')."'";
			$set .= $coma.$v['Field']."='".$itm_arr[$v['Field']]."'";
	} // ------- end foreach
	
	
	if(empty($set)){return $id_num;}
	
	$req = ("update {$table} set {$set} where {$id_field}=$id_num;");
//		print $req.'<br>sssss<br><br>'; print mysql_error();
	mysql_query($req);

	return $id_num;
}}// ------   end function

//----------------------------------------
if (!function_exists('insert_table')) {
function insert_table($table='item', $itm_arr=array(), $dbname, $id_field = '', $described_table=''){
/// V2.0
/// added default values and modified newkey select
/////
global $wpdb; 

	if(empty($id_field)){ print "Error: in {$table} identity field not set"; return false;}
	$qr = "insert into {$table} ($id_field) values(0);";
	$wpdb->query($wpdb->prepare($qr,''));

	$newkey = mysql_insert_id();

//echo($table.$newkey);echo(mysql_error().("insert into $table(id_$table, putdate) values(0, now());"));
return update_table($table, $newkey, $itm_arr, $dbname, $id_field, $described_table);


}}

///////////////////////////////////////////////////////////////
if (!function_exists('to_table')) {
function to_table($table='', $itm_arr=array(), $id_num='0', $dbname=''){
/// V1.0
/// insert or update table
////
	mysql_query("SET sql_mode = ''");
	global $wpdb;
	if(empty($table)){ return false; }
	$table = __table($table);

		
		$tbl = $wpdb->get_results($wpdb->prepare("describe {$table}",''), ARRAY_A);

		$id_field = table_key_finder($table,false,$dbname);
	
		$ss='';
	
		
		if(isset($itm_arr[$id_field]) && is_numeric($itm_arr[$id_field])){
			$ss=$itm_arr[$id_field];
		}
		
		
		
	if(empty($id_num) && is_numeric($ss) && $ss>=1){$id_num=$ss;}

	if(empty($id_num) || !is_numeric($id_num)){ 
		return insert_table($table, $itm_arr, $dbname, $id_field, $tbl);
	}else{ 
		return update_table($table, $id_num, $itm_arr, $dbname, $id_field, $tbl);
	}
	
}}


if (!function_exists('_prepare_sql_data')) {
function _prepare_sql_data($data=''){//v.1
	if(empty($data)||!is_array($data))return false;
	$ret='';
	foreach($data as $k=>$v){
		$decode='';
		$decode=decode($v);
			if(is_array($decode)){ $ret[$k]=$decode; continue; }
			if(!is_array($v))$v = htmlspecialchars_decode($v);
		$ret[$k]=$v;
	}
	return $ret;
}}


if (!function_exists('_set_arr')) {
function _set_arr($data='',$range=false,$low=1){
   if(is_array($data) && count($data)>=1)return $data;
   if($range && is_numeric($range) && is_numeric($low))return range($low,$range);
   return array();
}}



if (!function_exists('__default_configer')) {
function __default_configer($inparr='',$defaults=false){
	if(!$defaults)return false;
	if(!is_array($defaults) && strpos($defaults,'=')!==false)parse_str($defaults, $defaults);

	if(!is_array($inparr) && strpos($inparr,'=')!==false)parse_str($inparr, $inparr);
	if(!is_array($inparr))return $defaults;
	
	foreach($defaults as $k=>$v){ 
		if($v!=0 && $v=='false'){ $defaults[$k]=false; }
		if($v!=0 && $v=='array'){
			if(isset($inparr[$k]) && !is_array($inparr[$k])){ 
				$defaults[$k] = array(); continue;
			}elseif(!isset($inparr[$k])){  
				$defaults[$k] = array(); continue;
			}	
		}


		if(!isset($inparr[$k]) || (empty($inparr[$k]) && !is_numeric($inparr[$k]) ))continue;
		if((is_numeric($defaults[$k]) || $defaults[$k]=='num') && !is_numeric($inparr[$k])){ 
			$defaults[$k] = false; continue;
		}
		
		$defaults[$k]=$inparr[$k];
	}
	return $defaults;
}}

if (!function_exists('from_to_extractor')) {
function from_to_extractor($src='', $from='------', $to='------', $option=array()){
	
	if(empty($src)) return false;	
	if(!empty($from) && strpos($src, $from )!==false){
		$src = substr($src, strpos($src, $from )+strlen($from));
		//$src = str_replace($from,'', $src);
	}
	
	if(!empty($to) && strpos($src, $to)!==false){
		$src = substr($src,0, strpos($src, $to ));
	}
		return trim($src);
}}


//////////////////////////////// FORM COMPONENTS
//////////////////////////////// FORM COMPONENTS
//////////////////////////////// FORM COMPONENTS
//////////////////////////////// FORM COMPONENTS
if (!function_exists('select_opt')) {
function select_opt($array="", $cf = ''){
	$cf = __default_configer($cf,'key_var=id&label=name&selected=false&key=false&first_var=false&first_var_key=-');
	
	
		if(!is_array($array)){$array = explode(",",$array);}
		///print_r($array);
	$option = "";
	
	if($cf['first_var'])$option = "<option name='option{$cf['first_var_key']}' value='{$cf['first_var_key']}'>".trim($cf['first_var'])."</option>";
	
	foreach($array as $k=>$v){
		if(!isset($v[$cf['label']]))continue;
		$label = $v[$cf['label']];
		$kk = isset($v[$cf['key_var']])?$v[$cf['key_var']]:$label;
		
		if($cf['selected'] && (trim($label)==$cf['selected'] || ($cf['key'] && $kk==$cf['selected'] )) ) { 
			$select = 'selected="selected"'; 
		}elseif(is_array($cf['selected']) && (array_search(trim($label),$cf['selected'])!==false || ($cf['key'] && array_search($kk,$cf['selected'])!==false))){
			$select = 'selected="selected"';
		}else{ $select = ''; }
		
		if(empty($label)){$label='empty';}
		if($cf['key']){$value = " value='".trim($kk)."' ";}else{$value = " value='".trim($label)."' ";}
		
		$option .= "<option name='option{$kk}' {$value} {$select}>".trim($label)."</option>";
		
	}
	
	
	return $option;
}}

if (!function_exists('select_checkbox')) {
function select_checkbox($array="", $cf = '' ){
	//print_rr($cf);
	$cf = __default_configer($cf,"fieldname=f&inputalign=left&selected=false&key=false");
	
		if(!is_array($array)){$array = explode(",",$array);}
		///print_r($array);
	$option = "<input name='{$cf['fieldname']}[0]' value='' type='hidden' />";

	foreach($array as $k=>$v){$k++;
		if($cf['selected'] && (trim($v)==$cf['selected'] || ($cf['key'] && $k==$cf['selected'])) ) { 
			$select = ' checked="checked" '; 
		
		}elseif(is_array($cf['selected']) && (array_search(trim($v),$cf['selected'])!==false || ($cf['key'] && array_search($k,$cf['selected'])!==false))){
			$select = ' checked="checked" ';
		}else{ $select = ''; }
		
		if(empty($v)){$v='empty';}
		if($cf['key']){$value = " value='".trim($k)."' ";}else{$value = " value='".trim($v)."' ";}
		
		
		$inp = "<input name='{$cf['fieldname']}[{$k}]' {$value} {$select} type='checkbox' style='width:auto;' />";
		$hiddeninp = strpos($fieldname,'config')!==false?" <input name='{$cf['fieldname']}[{$k}]' value='' type='hidden' /> ":'';
		
		$inpttl = "<div class='title'>{$v}</div>";
		
		if($inputalign=='r'||$inputalign=='right'){
			$option .= "<li>{$hiddeninp}<label>{$inpttl}{$inp}</label></li>";
		}else{
			$option .= "<li>{$hiddeninp}<label>{$inp}{$inpttl}</label></li>";
		}
		
	}

	return "<ul class='cbx'>{$option}</ul>";
}}


if (!function_exists('select_multi')) {
function select_multi($array="", $selected=false, $key=false, $name='f'){
	if(!is_array($array)){$array = explode(",",$array);}
	$option = $headel = "";
	$arr2 = $array;
	if($key)$arr2 = array_keys($array);
	foreach($arr2 as $k=>$v){
		$vv = chek_val($array,$v)?trim($array[$v]):'empty';
		$select = '';
		
		if($selected && $v==$selected) {
			$select = "checked='checked'";
			$headel .= $vv.", ";
		}elseif(is_array($selected) && array_search($v,$selected)!==false){
			$select = "checked='checked'";
			$headel .= $vv.", ";
		}
		
		$value = $key?" value='{$v}' ":" value='{$vv}' ";
		
		$option .= "<label title='{$vv}'><input type='checkbox' name='{$name}[{$v}]' {$value} {$select} /><span>{$vv}</span></label> \n";
		
	}
	if(empty($headel)){$headel='select';}
	return "<div class='multis'>
	<div class='headel'>{$headel}</div>
	<div class='hiddenel' style='display:none;'>
	<div class='panelel'>OK</div>
	{$option}</div>
	</div>";
}}


////////////////////////////////////// ////////////////////////////////////// ////////////////////////////////////// ////////////////////////////////////// 
////////////////////////////////////// ////////////////////////////////////// ////////////////////////////////////// ////////////////////////////////////// 
////////////////////////////////////// ////////////////////////////////////// ////////////////////////////////////// 
////////////////////////////////////// ////////////////////////////////////// 
////////////////////////////////////// 
////////////////////////////////////// ////////////////////////////////////// ////////////////////////////////////// 
////////////////////////////////////// ////////////////////////////////////// ////////////////////////////////////// 
if (!function_exists('gen_auto_config')) {
function gen_auto_config($confname='',$class='bxx1',$post_var='f[config]',$config=''){//v1
	if(empty($confname))return false; $confname = trim(strip_tags($confname));
	$config = __default_configer($config,array('name'=>false,'first'=>'','last'=>''));
	
	$tmp = $GLOBALS['DB']->selectCell("select id from parameters where name='{$confname}' ");
	if(!is_numeric($tmp)){ $GLOBALS['DB']->query("insert into parameters(name) values('{$confname}') "); }
	$tmp = $GLOBALS['DB']->selectRow("select id, config from parameters where name='{$confname}' ");
	$values = chek_val($tmp,'config','empty');
	
	$ret = "<input type='hidden' name='{$post_var}[acc]' value='0' />";
	$values = explode(',',$values);
	
	if(chek_val($config,'first'))array_unshift($values,$config['first']);
	if(chek_val($config,'last')){
		$rrr = explode(',',$config['last']);
		foreach($rrr as $k=>$v){
			$values[]=$v;
		}
	}
	
	if(!is_array($tmp))return false;
	foreach($values as $k=>$v){
		$v = trim($v); if(empty($v))continue;
		$title = $config['name']?get_word('conf_'.$v,4):$v;
		$hiddeninp = strpos($post_var,'config')!==false?"<input name='{$post_var}[ac{$k}]' value='' type='hidden' />":'';

		$ret .= "<label class='{$class}'>
					{$hiddeninp} {$title} 
					<input type='checkbox' class='radio confchek' name='{$post_var}[ac{$k}]' value='{$v}' />
				</label>";
	}
	
	if(permision('full')&&chek_val($tmp,'id','numeric')){
		$ret="<div class='editblock'><div tourl='".link_to("act=_site._form_configs.{$tmp['id']}")."' class='dinload settings'></div>{$ret}&nbsp;</div>";
	}
	
	return $ret;
}}


if (!function_exists('gen_auto_parameters')) {
function gen_auto_parameters($confname='',$output_type=''){//v1
	if(empty($confname))return false; $confname = trim(strip_tags($confname));
	$tmp = $GLOBALS['DB']->selectCell("select id from parameters where name='{$confname}' ");
	if(!is_numeric($tmp)){ $GLOBALS['DB']->query("insert into parameters(name) values('{$confname}') "); }
	$tmp = $GLOBALS['DB']->selectCell("select config from parameters where name='{$confname}' ");
	
	if($output_type=='array'){
		$tmp = explode(',',$tmp);
		$ret='';
		foreach($tmp as $k=>$v){
			$v = trim($v); if(empty($v))continue; $ret[] = $v;
		}  if(!is_array($ret) || count($ret)==0){return false;} return $ret;
	}
	
	return trim(strip_tags($tmp));
}}


if (!function_exists('chek_param')) {
function chek_param($confname='', $value=''){//v1
	if(empty($confname))return false;
	$tmp = gen_auto_parameters($confname,'array');
	if(!$tmp)return false;
	foreach($tmp as $k=>$v){ if($v==$value) return $v; }
	return false;
}}


if (!function_exists('_show_configs')) {
function _show_configs($data=''){//v1
	if(!is_array($data))$data=decode($data);
	if(!is_array($data))return false;
	
	$ret = '';
	foreach($data as $k=>$v){
		if(empty($v))continue;
		$ret .= '<span class="confcell">'.get_word('conf_'.$v).'</span>';
	}
	return $ret;
}}



////////////// select full patch from child to parent. selects one field treee
if (!function_exists('__child_patch')) {
function __child_patch($cf=''){

	$cf = __default_configer($cf,"table=category&id_field=id&pid_field=pid&id=&field=id&return=full&lan=".__get_lan());
	
	if(!is_numeric($cf['id'])){ return array();}
	if(empty($cf['pid_field'])){return array();}
	//if(!empty($dbname) && substr($dbname,-1)!='.'){$dbname = $dbname.'.';}
	$cf['table'] = __table('category');
	
	$req = $req2 = $concat = "";
	$id_field = table_key_finder($table);
	
	for($i=2; $i<=5; $i++){
		$req .= ", t{$i}.{$cf['id_field']} as id{$i} ";
		$prev = $i-1; 
		$req2 .= "left join {$cf['table']} as t{$i} on t{$i}.{$cf['id_field']}=t{$prev}.{$cf['pid_field']} ";

		if(!empty($concat))$concat .= ",";
		$concat .= "t{$i}.{$cf['id_field']},'>'";
	}
	
	$qr = "SELECT t1.{$cf['id_field']} as id1 {$req}, CONCAT({$concat}) as patch from {$cf['table']} as t1 {$req2} where t1.{$cf['id_field']}={$cf['id']} limit 1";
	$tmp = $GLOBALS['wpdb']->get_row($qr, ARRAY_A);
//	print_rr($tmp);
	
	$ret=array(); 
	for($i=5; $i>=0; $i--){
		if(!chek_val($tmp, $cf['id_field'].$i))continue;
		$id = $tmp[$cf['id_field'].$i];
		
		$tmpp = __cat_list(array('where'=>" (t2.id='{$id}' OR t2.tid='{$id}' ) ",'limit'=>'limit 1'));
//		print_rr($tmpp);
		$val = $tmpp[$cf['field']];
		$ret[$id] = $val;

	}

//	arsort($ret);
//	$ret = array_reverse($ret);
//print_rr($ret);
	if($cf['return']=='level')return count($ret);
	return $ret;
}}


if (!function_exists('__pager')) {
function __pager($count=0,$perpage=10, $html_limit=9,$tourl='', $words=array()){//v1
	$words['first'] = chek_val($words,'first')?chek_val($words,'first'):"&#10094;&#10094;";
	$words['prev'] = chek_val($words,'prev')?chek_val($words,'prev'):"&#10094;";
	$words['next'] = chek_val($words,'next')?chek_val($words,'next'):"&#10095;";
	$words['last'] = chek_val($words,'last')?chek_val($words,'last'):"&#10095;&#10095;";
	$words['seite'] = chek_val($words,'seite')?chek_val($words,'seite'):'';
	$words['somepages'] = chek_val($words,'somepages')?chek_val($words,'somepages'):__('....');

	if(strpos($tourl,'?')===false)$tourl .= '?';


	$ret = array('html'=>'', 'limit'=>'');

		if(chek_val($_GET,'pp','numeric')){  $current = chek_val($_GET,'pp','numeric'); }
	elseif(chek_val($_GET,'pp')){ $current = base64_decode($_GET['pp']);  }
	else						{ $current = 1; }
	
	if(!is_numeric($current)){ $current = 1; }
	if($perpage>=$count){ return $ret; }
	
	$pagescount = ceil($count/$perpage);

	$ret['limit'] = " limit ".(($current*$perpage)-$perpage).", {$perpage} ";
	$ret['from'] = (($current*$perpage)-$perpage);
	$ret['to'] = $perpage;
	$ret['current'] = $current;
	
	
	$starting = $current-(floor($html_limit/2));
	$starting = $starting<1?1:$starting;
		
	if(($starting + $html_limit)>$pagescount){ 
		$end = $pagescount; 
		$starting=$pagescount-$html_limit; 
	}else{ 
		$end = $starting + $html_limit; 
	}
	$starting = $starting<1?1:$starting;



    $prevpage = $current>1?$current-1:1;
	
	
	if($current>1) $ret['html'] .= "<a href='{$tourl}&pp={$prevpage}' class='prev {$active_class}'  title='".__('pevious')."'>{$words['prev']}</a>";


		$active_class = $current==1?'inactive':'';
	//$ret['html'] .= "<a href='{$tourl}&pp=1' class='first {$active_class}' title='".__('first')."'> 1 </a>";
	
	
	
		$active_class = $starting==1?'inactive inactive_somepages':'';
	$ret['html'] .= "<a class='some_pages {$active_class}'> {$words['somepages']} </a>";
	for($i=$starting; $i<=$end; $i++){
		if($i==$current){
			$ret['html'] .= "<a href='{$tourl}&pp={$i}' class='current'>{$i}</a>"; 
		}else{
			$ret['html'] .= "<a href='{$tourl}&pp={$i}' class=''>{$i}</a>";
		}
	}

		$active_class = $pagescount==$end?'inactive inactive_somepages':'';
	$ret['html'] .= "<a class='some_pages {$active_class}'> {$words['somepages']}{$pagescount}</a>";
	
	$nextpage = $current<$pagescount?$current+1:$pagescount;
		$active_class = $current==$pagescount?'inactive':'';
	
	//$ret['html'] .= "<a href='{$tourl}&pp={$pagescount}'  class='last {$active_class}' title='".__('last')."'> {$pagescount} </a>";
    if($current<$pagescount)  $ret['html'] .= "<a href='{$tourl}&pp={$nextpage}'  class='next {$active_class}'  title='".__('next')."'>{$words['next']}</a>";

	$ret['html'] = "<div class='paging'> <span class='title'> {$words['seite']} </span> ".$ret['html']."</div>";
	return $ret;
}}



if(!function_exists('_utf_en')) {
function _utf_en($str=''){
	if(empty($str))return false;
	$ge =array('ა', 'ბ', 'გ', 'დ', 'ე', 'ვ', 'ზ', 'თ', 'ი', 'კ', 'ლ', 'მ', 'ნ', 'ო', 'პ', 'ჟ', 'რ', 'ს', 'ტ', 'უ', 'ფ', 'ქ', 'ღ', 'ყ', 'შ', 'ჩ', 'ძ', 'წ','ც','ჭ', 'ხ', 'ჯ', 'ჰ');
	$en =array('a', 'b', 'g', 'd', 'e', 'v', 'z', 't', 'i', 'k', 'l', 'm', 'n', 'o', 'p', 'j', 'r', 's', 't', 'u', 'f', 'q', 'gh', 'kh', 'sh', 'ch', 'dz', 'ts','c','tsh', 'kh', 'j', 'h');
	return str_replace($ge, $en, $str);
}}

if(!function_exists('_en_utf')){
function _en_utf($str=''){
	if(empty($str))return false;
	$ge =array('ა', 'ბ', 'გ', 'დ', 'ე', 'ვ', 'ზ', 'თ', 'ი', 'კ', 'ლ', 'მ', 'ნ', 'ო', 'პ', 'ჟ', 'რ', 'ს', 'ტ', 'უ', 'ფ', 'ქ', 'ღ', 'ყ', 'შ', 'ჩ', 'ძ', 'წ','ც','ჭ', 'ხ', 'ჯ', 'ჰ');
	$en =array('a', 'b', 'g', 'd', 'e', 'v', 'z', 't', 'i', 'k', 'l', 'm', 'n', 'o', 'p', 'j', 'r', 's', 't', 'u', 'f', 'q', 'gh', 'kh', 'sh', 'ch', 'dz', 'ts','c','tsh', 'kh', 'dj', 'h');
	return str_replace($en,$ge,$str);
}}


// remove tags
if(!function_exists('remove_tags')){
function remove_tags($var='', $option=''){
/////V 3.2
/// allow selected tags
/// coded by gioo@mail.ru
//////
/////

        if(!is_numeric($var) && empty($var)){ return false; }
        if(is_array($var)){ return $var; }
		$badchars = array('вЂ™','”','“','‘','’','``','///',"\\",'„',"\r","\t");
		
		$badchars2 = array('&nbsp;', "\r","\t","",'&quot;','&quot;','&rdquo;','&ldquo;','&lsquo;','&rsquo;','вЂ™','"','"','``','///',"\\",'&bdquo;','"');
		

		$tags = empty($option)?"<a> <p> <div> <span> <sup> <sub> <ol> <li> <ul> <hr> <hr /> <br> <br /> <strong> <em> <u> <strike> <b> <table> <tr> <td> <img /> <img> <h1> <h2> <h3>":$option;

			$i = strip_tags($var, $tags);
			$i = str_replace($badchars, "", $i);
			$i = str_replace('"', "'", $i);
		if(!empty($option)){
			$i = str_replace($badchars2, "",$i);
			$i = trim(htmlspecialchars($i, ENT_QUOTES));
		}
			$i = addslashes($i);
		
        return $i;
}}
