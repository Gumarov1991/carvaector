<?php
	$CONF = Array() ;
$CONF['DOCUMENT_ROOT'] = addslashes( '/var/www/vhosts/carvector.net/httpdocs/phplive' ) ;
$CONF['BASE_URL'] = '//carvector.com/phplive' ;
$CONF['SQLTYPE'] = 'SQL.php' ;
$CONF['SQLHOST'] = 'localhost' ;
$CONF['SQLLOGIN'] = 'cvector_com_pls' ;
$CONF['SQLPASS'] = 'XodV1lZBDwTPh3G8' ;
$CONF['DATABASE'] = 'carvector_com_pls' ;
$CONF['THEME'] = 'nature' ;
$CONF['TIMEZONE'] = 'Asia/Tokyo' ;
$CONF['icon_online'] = '' ;
$CONF['icon_offline'] = '' ;
$CONF['lang'] = 'english' ;
$CONF['logo'] = 'logo_0.PNG' ;
$CONF['geo'] = '1' ;
$CONF['SALT'] = 'zhpbxn3msa' ;
$CONF['API_KEY'] = 'jkd3csz3er' ;
$CONF['cookie'] = 'on' ;
$CONF['screen'] = 'separate' ;
$CONF['geo_v'] = '1.6' ;
$CONF['icon_check'] = 'on' ;
$CONF['auto_initiate'] = 'a:6:{s:8:&quot;duration&quot;;s:3:&quot;120&quot;;s:5:&quot;andor&quot;;s:1:&quot;1&quot;;s:10:&quot;footprints&quot;;s:1:&quot;5&quot;;s:5:&quot;reset&quot;;s:1:&quot;1&quot;;s:7:&quot;exclude&quot;;s:0:&quot;&quot;;s:3:&quot;pos&quot;;s:1:&quot;1&quot;;}' ;
$CONF['KEY'] = 'e71b11cc694ce569577be26304c01dcd' ;
$CONF['foot_log'] = 'on' ;
$CONF['CONF_ROOT'] = '/var/www/vhosts/carvector.net/httpdocs/phplive/web' ;
$CONF['UPLOAD_HTTP'] = 'http://www.carvector.net/phplive/web' ;
$CONF['UPLOAD_DIR'] = '/var/www/vhosts/carvector.net/httpdocs/phplive/web' ;
	if ( phpversion() >= '5.1.0' ){ date_default_timezone_set( $CONF['TIMEZONE'] ) ; }
	include_once( "$CONF[DOCUMENT_ROOT]/API/Util_Vars.php" ) ;
?>