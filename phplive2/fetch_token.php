<?php
	include_once( "./web/config.php" ) ;
	$query = ( isset( $_SERVER["QUERY_STRING"] ) && $_SERVER["QUERY_STRING"] ) ? $_SERVER["QUERY_STRING"] : time() ;
?>
<!doctype html>
<html><head>
<title> Fetch Token </title>
<meta name="description" content="phplive_c615">
<meta http-equiv="content-type" content="text/html; CHARSET=utf-8"> 
<?php include_once( "./inc_meta_dev.php" ) ; ?>
<script type="text/javascript" src="./js/jquery_md5.js?<?php echo $VERSION ?>"></script>
<script language="JavaScript">
<!--
	var phplive_browser = navigator.appVersion ; var phplive_mime_types = "" ;
	var phplive_display_width = screen.availWidth ; var phplive_display_height = screen.availHeight ; var phplive_display_color = screen.colorDepth ; var phplive_timezone = new Date().getTimezoneOffset() ;
	if ( navigator.mimeTypes.length > 0 ) { for (var x=0; x < navigator.mimeTypes.length; x++) { phplive_mime_types += navigator.mimeTypes[x].description ; } }
	var phplive_browser_token = phplive_md5( phplive_display_width+phplive_display_height+phplive_display_color+phplive_timezone+phplive_browser+phplive_mime_types ) ;
	location.href = "./phplive.php?token="+phplive_browser_token+"&<?php echo $query ?>" ;
//-->
</script>
</head>
<body style="background: transparent;"></body>
</html>