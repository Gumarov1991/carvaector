<?php
	$CONF = Array() ;
$CONF['DOCUMENT_ROOT'] = addslashes( '/var/www/vhosts/carvector.net/httpdocs/phplive' ) ;
$CONF['BASE_URL'] = 'https://carvector.com/phplive' ;
$CONF['SQLTYPE'] = 'SQLi.php' ;
$CONF['SQLHOST'] = 'localhost' ;
$CONF['SQLLOGIN'] = 'cvector_com_pls' ;
$CONF['SQLPASS'] = 'XodV1lZBDwTPh3G8' ;
$CONF['DATABASE'] = 'carvector_com_pls' ;
$CONF['THEME'] = 'island' ;
$CONF['TIMEZONE'] = 'Asia/Tokyo' ;
$CONF['icon_online'] = '' ;
$CONF['icon_offline'] = '' ;
$CONF['lang'] = 'english' ;
$CONF['logo'] = 'logo_0.PNG' ;
$CONF['CONF_ROOT'] = '/var/www/vhosts/carvector.net/httpdocs/phplive/web' ;
$CONF['UPLOAD_HTTP'] = 'https://carvector.com/phplive/web' ;
$CONF['UPLOAD_DIR'] = '/var/www/vhosts/carvector.net/httpdocs/phplive/web' ;
$CONF['screen'] = 'separate' ;
$CONF['API_KEY'] = 'w8n8c4vnhy' ;
$CONF['SALT'] = 'ka2hc3rb8h' ;
$CONF['geo'] = '' ;
$CONF['MAPP_KEY'] = 'm7nv3e7e66' ;
$CONF['icon_initiate'] = 'icon_initiate_0.JPEG' ;
	if ( phpversion() >= '5.1.0' ){ date_default_timezone_set( $CONF['TIMEZONE'] ) ; }
	include_once( "$CONF[DOCUMENT_ROOT]/API/Util_Vars.php" ) ;
?>