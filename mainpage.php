<?php
/*
Plugin Name: Scrummer
Plugin URI: http://scrummer.anaxe.net/
Description: Agile Scrum tool as Wordpress plugin;
Version: 0.1
Author: scrummer.anaxe.net
Author URI: http://scrummer.anaxe.net/
Update Server: http://scrummer.anaxe.net/
Min WP Version: 3.2
Max WP Version: 4.3.+
*/

if(!function_exists('__pn')){
function __pn($file=__FILE__){
	return current(explode('/',plugin_basename($file)));
}}


$GLOBALS['plgn_shortname'] = 'scrm'; // plugin short name
$GLOBALS["{$GLOBALS['plgn_shortname']}_version"] = '0.1'; // plugin version

add_filter( 'init', "__{$GLOBALS['plgn_shortname']}_init_vars", 20, 3);
register_activation_hook(__FILE__, "__{$GLOBALS['plgn_shortname']}_plugin_install");


__scrm_plugin_environment();


/////////////////////////////////////////////////////////////////////////////////////////////////////////
/////////////////////////////////////////////////////////////////////////////////////////////////////////
/////////////////////////////////////////////////////////////////////////////////////////////////////////
/////////////////////////////////////////////////////////////////////////////////////////////////////////
/////////////////////////////////////////////////////////////////////////////////////////////////////////
/////////////////////////////////////////////////////////////////////////////////////////////////////////
/////////////////////////////////////////////////////////////////////////////////////////////////////////
function __scrm_plugin_environment(){
	$funcdir = __DIR__."/funcs/";
	if(!is_file($funcdir.'sys.php'))return false;
	require_once "{$funcdir}sys.php";
	
	if (get_site_option("{$GLOBALS['plgn_shortname']}_version") < $GLOBALS["{$GLOBALS['plgn_shortname']}_version"])__scrm_plugin_install();
	
	
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

	add_action( 'init', 'loadScrummerPostTypes', 0 );
	//////// plugin public actions
	if(!is_admin()){
		__scrmActions();
		add_action("template_redirect", 'my_theme_redirect');
	}

	return;
}




function my_theme_redirect(){
	global $wp;


	$plugindir = dirname( __FILE__ ).'/';

	if(!empty($wp->request) && strpos($wp->request,'/')!==false){
		$request = substr($wp->request, 0 , strpos($wp->request,'/'));
	}else{
		$request = $wp->request;
	}


	$file = __chek_file("file={$request}&dir=view&plugin=scrummer");

	if($file){
		loadScrummerPostTypes();
		global $post, $wp_query;
		include($file);
		exit;
	}


	return;

}


function __scrmActions(){
	$dirname = plugins_url().'/'.basename(dirname(__FILE__));
	//print "{$dirname}/assets/main.js";

	wp_enqueue_style( 'bootstrap', "{$dirname}/assets/bootstrap/css/bootstrap.min.css", array(), '3.2' );
	wp_enqueue_style( 'bootstrap-theme', "{$dirname}/assets/bootstrap/css/bootstrap-theme.min.css", array('bootstrap'), '3.2' );
	wp_enqueue_script( 'bootstrap', "{$dirname}/assets/bootstrap/js/bootstrap.min.js", array( 'jquery' ), '20141010' );
	wp_enqueue_style( "stylefile", "{$dirname}/assets/main.css", array('bootstrap'), '3.2');

	wp_enqueue_script( "myfunc_{$GLOBALS['plgn_shortname']}", "{$dirname}/assets/main.js",array('jquery'), 1.1 );
	wp_enqueue_script( "jquery-ui-{$GLOBALS['plgn_shortname']}", "{$dirname}/assets/jquery-ui.min.js",array('jquery'), 1.1 );



	__scrm_localize();

}


function __scrm_plugin_admin_menu() {
//add_menu_page( $page_title, $menu_title, $capability, $menu_slug, $function, $icon_url, $position );




	//create admin menu
	$ident = basename(dirname(__FILE__)).'/admin/index.php';
	add_menu_page( 'Scrummer', 'Scrummer', 'manage_options', $ident);
	add_submenu_page( $ident, 'Settings', 'Settings', 'manage_options', 'settings', '__scrm_plugin_get_page' );

	return false;
}


function __scrm_plugin_get_page(){
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

function __scrm_init_vars(){

	$pluginname = __pn(__FILE__);

	
	return;	
}


function __scrm_localize(){
	wp_localize_script( "myfunc_{$GLOBALS['plgn_shortname']}", "dinob", array(
		'home_url' => home_url(),
	));
}



////////////////////////////////////////////////////////////////////////////////////////////////////////
/////////// install plugin DBs
function __scrm_plugin_install(){ //return false;
	$plugin = basename(dirname(__FILE__));
   global $wpdb;

   $installed_ver = get_option( "{$plugin}_version" );
	if( $installed_ver >= $GLOBALS["{$GLOBALS['plgn_shortname']}_version"] )return false;

 
   update_option( "{$plugin}_version", $GLOBALS["{$GLOBALS['plgn_shortname']}_version"]);
}



