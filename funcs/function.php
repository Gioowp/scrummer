<?
add_action( 'wp_ajax_nopriv___update_string', '__update_string' );
add_action( 'wp_ajax___update_string', '__update_string' );
function __update_string(){
	//print_rr($_POST);
	
	$ret = array();
	$id='';
	foreach($_POST['val'] as $v){
		if($v['name']=='wordid'){$id=$v['value'];continue;}
		$ret[$v['name']] = $v['value'];
	}
	//print_rr($_POST['val']);
	$ret = decode($ret);
	$qr = "update ".__table('words')." set data='{$ret}' where id='{$id}' ";
	$tmp = $GLOBALS['wpdb']->query( $qr );
	
	
	__show_local_strings($ret);
	__generate_string_file();
	//print_rr($ret);
	exit;
}

function __show_local_strings($data=''){
//	print_rr($data);
	$data = decode($data);
	//print_rr($data);
	
	$ret = '';
	foreach( $data as $kk=>$vv ){
		$ret .= "<div class='{$kk} cell' title='{$kk}'>{$vv}</div>";
	}
	print $ret;
	return;
}

function __generate_string_file(){//return false;
	$langs = get_option( __pn(__FILE__)."_languages" );
	if(!is_array($langs))return false;
	$upload_dir = wp_upload_dir();
	
	$qr = "select * from ".__table('words')." {$where} order by domain, name limit 200000 ";
	$tmp = $GLOBALS['wpdb']->get_results($qr, ARRAY_A);

	$ret=array();
	foreach($langs as $k=>$v){
		foreach($tmp as $kk=>$vv){
			$vv['data'] = decode($vv['data']);
			$ret[md5($vv['name'])] = chek_val($vv['data'], $k)?$vv['data'][$k]:$vv['name'];
		}
		file_put_contents("{$upload_dir['basedir']}/{$k}.ssm", serialize($ret));
	}
return;	
}


/*/////////////////////////////////////////////////////////////////*/
/*/////////////////////////////////////////////////////////////////*/
/*/////////////////////////////////////////////////////////////////*/
/*/////////////////////////////////////////////////////////////////*/


add_action('init','all_my_hooks');

function all_my_hooks(){
	add_filter( 'gettext', '__change_word', 20, 3);
}



function __change_word($translated,$name,$domain){
	
	if(!isset($GLOBALS['strings'])){
		$currentlan = get_bloginfo('language');
		$upload_dir = wp_upload_dir();
		
		if(is_file("{$upload_dir['basedir']}/{$currentlan}.ssm")){
			$str = file_get_contents("{$upload_dir['basedir']}/{$currentlan}.ssm");
			$GLOBALS['strings'] = unserialize($str);
		}else{
			$qr = "select * from ".__table('words')." order by domain, name ";
			$tmp = $GLOBALS['wpdb']->get_results($qr, ARRAY_A);
	
			$ret = array();
			foreach($tmp as $v){
				$v['data'] = unserialize($v['data']);
				if(!isset($v['data'][$currentlan]))continue;
				$ret[md5($v['name'])] = $v['data'][$currentlan];
			}
			$GLOBALS['strings'] = $ret;
		}
		//print_rr( $GLOBALS['strings'] );
	}
	
	if( isset($GLOBALS['strings'][md5($name)]) ){
		return $GLOBALS['strings'][md5($name)];
	}
	

	//if($name!='testword')return $translated;//// for testing
	
	__insert_new_word("name={$name}&domain={$domain}");

	return $translated;
}



function __insert_new_word($cf=''){
	$cf = __default_configer($cf, "name=&domain=default" );
	if(empty($cf['name']))return false;

	if(!isset($GLOBALS['limitWordInserts']))$GLOBALS['limitWordInserts']=1;
	if(++$GLOBALS['limitWordInserts']>100)return false;
	
	$qr = "select id from ".__table('words')." where name='{$cf['name']}' AND domain='{$cf['domain']}' ";
	$tmp = $GLOBALS['wpdb']->get_var($qr);
	if(is_numeric($tmp))return false;

	$upd[get_bloginfo('language')] = $cf['name'];
	$upd = decode($upd);
	$qr = "insert into ".__table('words')."(name,domain,data,config,status) values('{$cf['name']}', '{$cf['domain']}', '{$upd}','','' ) ";
	$tmp = $GLOBALS['wpdb']->query($qr);
	return false;
	
	
}