<?php
//if uninstall not called from WordPress exit
if ( !defined( 'WP_UNINSTALL_PLUGIN' ) ) 
    exit();

$pluginname = basename(dirname(__FILE__));



delete_option( "{$pluginname}_languages" );
delete_option( "{$pluginname}_version" );




?>