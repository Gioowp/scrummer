<?php
/*
Plugin Name: Simple String Manager
Plugin URI: http://ssm.anaxe.net/
Description: Manage strings/words from admin panel; Use as string translator at multilanguage sites;
Version: 0.6
Author: ssm.anaxe.net
Author URI: http://ssm.anaxe.net/
Update Server: http://ssm.anaxe.net/
Min WP Version: 3.2
Max WP Version: 3.8.+
*/

if(!function_exists('__pn')){
function __pn($file=__FILE__){
	return current(explode('/',plugin_basename($file)));
}}


$GLOBALS['plgn_shortname'] = 'ssm'; // plugin short name
$GLOBALS["{$GLOBALS['plgn_shortname']}_version"] = '0.6'; // plugin version

add_filter( 'init', "__{$GLOBALS['plgn_shortname']}_init_vars", 20, 3);
register_activation_hook(__FILE__, "__{$GLOBALS['plgn_shortname']}_plugin_install");


__ssm_plugin_environment();


/////////////////////////////////////////////////////////////////////////////////////////////////////////
/////////////////////////////////////////////////////////////////////////////////////////////////////////
/////////////////////////////////////////////////////////////////////////////////////////////////////////
/////////////////////////////////////////////////////////////////////////////////////////////////////////
/////////////////////////////////////////////////////////////////////////////////////////////////////////
/////////////////////////////////////////////////////////////////////////////////////////////////////////
/////////////////////////////////////////////////////////////////////////////////////////////////////////
function __ssm_plugin_environment(){
	$funcdir = __DIR__."/funcs/";
	if(!is_file($funcdir.'sys.php'))return false;
	require_once "{$funcdir}sys.php";
	
	if (get_site_option("{$GLOBALS['plgn_shortname']}_version") < $GLOBALS["{$GLOBALS['plgn_shortname']}_version"])__ssm_plugin_install();
	
	
//	print "{$funcdir}sys.php";
	$tmp = scandir($funcdir);
	foreach($tmp as $v){ if(!strpos($v,'.php'))continue; require_once( "{$funcdir}{$v}" ); }

	$GLOBALS['act'] = $act = __action_maker();
	$GLOBALS['p'] = $p = __action_maker('p');
	$GLOBALS['fl'] = $fl = __action_maker('fl');
	
		//print_rr(__chek_w3i_form());
	if(chek_val($p,'1')){
		setcookie($p[1], decode($_GET), time()+86400*15,'/');
	}
	
	
	
// Registrieren der WordPress-Hooks
	add_action('admin_menu', "__{$GLOBALS['plgn_shortname']}_plugin_admin_menu");
	

	return;
}



function __ssm_plugin_admin_menu() {
//add_menu_page( $page_title, $menu_title, $capability, $menu_slug, $function, $icon_url, $position );


	//create top-level menu
	$ident = basename(dirname(__FILE__)).'/admin/main.php';
	add_menu_page( 'Simple String Manager', 'String Manager', 'manage_options', $ident);
	//add_submenu_page( $ident, 'Field Values', 'Field Values', 'manage_options', 'dddd', '__ssm_plugin_get_page' );


	$dirname = plugins_url().'/'.basename(dirname(__FILE__));
	//print "{$dirname}/static/myfunc.js";

	wp_enqueue_script( "myfunc_{$GLOBALS['plgn_shortname']}", "{$dirname}/static/myfunc.js",array('jquery'), 1.1 );
	wp_register_style( "{$GLOBALS['plgn_shortname']}-plugin-main-style", "{$dirname}/static/style.css" );
	
	__ssm_localize();

	return false;
}


function __ssm_plugin_get_page(){
	if(!isset($_GET['page']))return false;
	$plgn = basename(dirname(__FILE__)); // plugin name 
	$var = strip_tags($_GET['page']);
	if(empty($var))return false;
	
	print "<div class='plugincontainer {$plgn}'>";
	if (function_exists($var)){
		print call_user_func_array($var);
	}else{
    //__this_plugin_styles();
		print __file_part( array('file'=>$var, 'dir'=>'admin','plugin'=>$plgn) );
	}
	print "</div>";
	return false;
}

function __ssm_init_vars(){
	$current =  get_bloginfo('language');
	$pluginname = __pn(__FILE__);
	$tmp = get_option( "{$pluginname}_languages", array());
	
	if(!isset($tmp[$current])){ 
		$tmp[$current] = $current; 
		$tmp = update_option( "{$pluginname}_languages", $tmp); 
	}
	
	
	return;	
}


function __ssm_localize(){
	wp_localize_script( "myfunc_{$GLOBALS['plgn_shortname']}", "dinob", array(
		'home_url' => home_url(),
	));
}



////////////////////////////////////////////////////////////////////////////////////////////////////////
/////////// install plugin DBs
function __ssm_plugin_install(){ //return false;
	$plugin = basename(dirname(__FILE__));
   global $wpdb;

   $installed_ver = get_option( "{$plugin}_version" );
	if( $installed_ver >= $GLOBALS["{$GLOBALS['plgn_shortname']}_version"] )return false;

	$tmp = get_option( "meplgn_tables", array());
	if(array_search('words',$tmp)===false){ $tmp[]='words'; update_option( "meplgn_tables", $tmp); }
	
	$table_name = "{$GLOBALS['wpdb']->prefix}__words";

	$sql = "CREATE TABLE {$table_name} (
	id INT NOT NULL AUTO_INCREMENT,
	  domain text NOT NULL,
	  name text CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL,
	  data text CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL,
	  config text CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL,
	  status text NOT NULL,
	UNIQUE KEY id (id)
	);
	";
	
   require_once(ABSPATH . 'wp-admin/includes/upgrade.php');
   
   dbDelta($sql);

 
   update_option( "{$plugin}_version", $GLOBALS["{$GLOBALS['plgn_shortname']}_version"]);
}



