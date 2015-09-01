<?php
//if uninstall not called from WordPress exit
if ( !defined( 'WP_UNINSTALL_PLUGIN' ) ) 
    exit();

$pluginname = basename(dirname(__FILE__));
$langs = get_option( $pluginname."_languages" );
$upload_dir = wp_upload_dir();
foreach($langs as $k=>$v){
		if(is_file("{$upload_dir['basedir']}/{$k}.ssm"))unlink("{$upload_dir['basedir']}/{$k}.ssm");
	}

delete_option( "{$pluginname}_languages" );
delete_option( "{$pluginname}_version" );

// delete custom tables
$GLOBALS['wpdb']->query("DROP TABLE {$GLOBALS['wpdb']->prefix}__words");




?>