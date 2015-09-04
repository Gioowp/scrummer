<?php

////////////////////////////////////////////////////////////////////////////////////////////////////////
////////////////////////////////////////////////////////////////////////////////////////////////////////
/////// plugin additional functions
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

if (!function_exists('pp')){
function pp($arr=array()){
	print "<pre>";
	print_r($arr);
	print "</pre>";
}}

if (!function_exists('__file_part')) {
function __file_part($cf = ''){//v1
//////// get file
	$cf = __params($cf,'file=&dir=part&data=ar&plugin=');
	if(empty($cf['file']))return false;
	global $wpdb, $p, $act, $fl;

	$incfile = __chek_file("file={$cf['file']}&dir={$cf['dir']}&plugin={$cf['plugin']}");

	if(!$incfile){//pp($cf);
	//print __chek_file("file={$cf['file']}&dir={$cf['dir']}&plugin={$cf['plugin']}&return=dir")."{$cf['file']}.php";
		file_put_contents(__chek_file("file={$cf['file']}&dir={$cf['dir']}&plugin={$cf['plugin']}&return=dir")."{$cf['file']}.php", $cf['file']);
		return false;
	}

	$data = $cf['data'];
	ob_start();
	include $incfile;
	$ret = ob_get_contents();
	ob_end_clean();
	return $ret;
}}

if (!function_exists('__chek_file')){
function __chek_file( $cf = '' ){//v1
	$cf = __params($cf,'file=&dir=part&return=fullpatch&plugin=');

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


if (!function_exists('chek_val')) {
function chek_val($array = '', $key='', $chektype='empty',$toequal=''){//v.1
//	print $array;
	
	if(empty($key)&&!is_numeric($key)){ return false; }
	if(!is_array($array))$tmp = json_decode($array,true);
	if(isset($tmp) && is_array($tmp))$array = $tmp;
//if($key=='name'){ print_rr($array); }
	$val=false;
	if(is_array($array) && isset($array[$key])){ //// && $array[$key]!=''
		$val = $array[$key]; 
	}elseif(is_array($array) && !isset($array[$key])){
		return false;
	}else{ $val = $array; }
	$val2 = json_decode($val, true);
//	print_rr($array);
	if(($chektype=='numeric'||$chektype=='num') && !is_numeric($val)){ return false; }
	if($chektype=='str' && !is_string($val)){ return false; }
	
	if(($chektype=='arr'||$chektype=='ar'||$chektype=='array') && is_array($val2)){ $val = $val2; }
	if(($chektype=='arr'||$chektype=='ar'||$chektype=='array') && !is_array($val)){ return false; }

	
	if($chektype=='empty' && empty($val)){ return false; }
//	if(!empty($toequal) && $val!=$toequal){ return false; }
	if(!empty($val)||$val!='')return $val;
	return true;
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






if (!function_exists('__params')) {
function __params($inparr='',$defaults=false){
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
