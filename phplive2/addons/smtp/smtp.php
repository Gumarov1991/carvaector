<?php
	/* (c) OSI Codes Inc. */
	/* http://www.osicodesinc.com */
	/* Dev team: 615 */
	/****************************************/
	// STANDARD header for Setup
	if ( !is_file( "../../web/config.php" ) ){ HEADER("location: ../../setup/install.php") ; exit ; }
	include_once( "../../web/config.php" ) ;
	include_once( "$CONF[DOCUMENT_ROOT]/API/Util_Format.php" ) ;
	include_once( "$CONF[DOCUMENT_ROOT]/API/Util_Error.php" ) ;
	include_once( "$CONF[DOCUMENT_ROOT]/API/SQL.php" ) ;
	include_once( "$CONF[DOCUMENT_ROOT]/API/Util_Security.php" ) ;
	$ses = Util_Format_Sanatize( Util_Format_GetVar( "ses" ), "ln" ) ;
	if ( !$admininfo = Util_Security_AuthSetup( $dbh, $ses ) ){ ErrorHandler ( 608, "Invalid setup session or session has expired.", $PHPLIVE_FULLURL, 0, Array() ) ; }
	// STANDARD header end
	/****************************************/

	include_once( "$CONF[DOCUMENT_ROOT]/API/Util_Functions_itr.php" ) ;
	include_once( "$CONF[DOCUMENT_ROOT]/API/Depts/get.php" ) ;

	$SMTP_VERSION = "1.0" ;
	if ( is_file( "$CONF[DOCUMENT_ROOT]/addons/smtp/API/VERSION.php" ) )
		include_once( "$CONF[DOCUMENT_ROOT]/addons/smtp/API/VERSION.php" ) ;

	$action = Util_Format_Sanatize( Util_Format_GetVar( "action" ), "ln" ) ;
	$deptid = Util_Format_Sanatize( Util_Format_GetVar( "deptid" ), "ln" ) ;

	$departments = Depts_get_AllDepts( $dbh ) ;
	$deptinfo = Array() ;
	if ( $deptid )
	{
		$deptinfo = Depts_get_DeptInfo( $dbh, $deptid ) ;
		if ( !isset( $deptinfo["deptID"] ) ) { $action = "" ; }
	}
	else if ( count( $departments ) > 0 )
	{
		$deptinfo = $departments[0] ;
		$CONF["lang"] = $deptinfo["lang"] ;
	}

	if ( $action == "send_verification" )
	{
		$smtp_type = Util_Format_StripQuotes( Util_Format_Sanatize( Util_Format_GetVar( "smtp_type" ), "ln" ) ) ;
		$smtp_theapi = Util_Format_StripQuotes( Util_Format_Sanatize( Util_Format_GetVar( "smtp_theapi" ), "ln" ) ) ;
		$smtp_theapi_domain = Util_Format_StripQuotes( Util_Format_Sanatize( Util_Format_GetVar( "smtp_theapi_domain" ), "ln" ) ) ;
		$smtp_host = Util_Format_StripQuotes( Util_Format_Sanatize( Util_Format_GetVar( "smtp_host" ), "notags" ) ) ;
		$smtp_login = Util_Format_StripQuotes( Util_Format_Sanatize( Util_Format_GetVar( "smtp_login" ), "notags" ) ) ;
		$smtp_pass = Util_Format_StripQuotes( Util_Format_Sanatize( Util_Format_GetVar( "smtp_pass" ), "notags" ) ) ;
		$smtp_port = Util_Format_Sanatize( Util_Format_GetVar( "smtp_port" ), "n" ) ;

		if ( ( ( $smtp_type == "connect" ) && ( $smtp_host && $smtp_login && $smtp_pass && $smtp_port ) ) || ( ( $smtp_type == "api" ) && ( $smtp_theapi == "sendgrid" ) && ( $smtp_login && $smtp_pass ) ) || ( ( $smtp_type == "api" ) && ( $smtp_theapi == "mailgun" ) && ( $smtp_theapi_domain && $smtp_pass ) ) )
		{
			include_once( "$CONF[DOCUMENT_ROOT]/lang_packs/$CONF[lang].php" ) ;
			include_once( "$CONF[DOCUMENT_ROOT]/API/Util_Email.php" ) ;

			if ( $deptinfo["smtp"] )
			{
				$smtp_array = unserialize( Util_Functions_itr_Decrypt( $CONF["SALT"], $deptinfo["smtp"] ) ) ;
				if ( $smtp_pass == preg_replace( "/(.)/", "*", $smtp_array["pass"] ) )
					$smtp_pass = $smtp_array["pass"] ;
				unset( $smtp_array ) ;
			}

			$CONF["SMTP_HOST"] = ( $smtp_type == "connect" ) ? $smtp_host : "" ;
			$CONF["SMTP_LOGIN"] = ( $smtp_theapi != "mailgun" ) ? $smtp_login : "" ;
			$CONF["SMTP_PASS"] = $smtp_pass ;
			$CONF["SMTP_PORT"] = ( $smtp_type == "connect" ) ? $smtp_port : "" ;
			$CONF["SMTP_API"] = ( $smtp_type == "api" ) ? $smtp_theapi : "" ;
			$CONF["SMTP_DOMAIN"] = ( $smtp_theapi == "mailgun" ) ? $smtp_theapi_domain : "" ;

			if ( !isset( $CONF['SALT'] ) )
			{
				include_once( "$CONF[DOCUMENT_ROOT]/API/Util_Vals.php" ) ;

				$salt = Util_Format_RandomString( 10 ) ;
				Util_Vals_WriteToConfFile( "SALT", $salt ) ;
			}

			$md5 = md5( "$smtp_host $smtp_login $CONF[SALT]" ) ;
			$message = "\r\n\r\nVerification Code:\r\n\r\n$md5\r\n\r\n" ;
			$error = Util_Email_SendEmail( $deptinfo["name"], $deptinfo["email"], $deptinfo["name"], $deptinfo["email"], "SMTP Verification Code", $message,  "" ) ;

			if ( !$error )
				$json_data = "json_data = { \"status\": 1, \"email\": \"$deptinfo[email]\" };" ;
			else
				$json_data = "json_data = { \"status\": 0, \"error\": \"$error\" };" ;
		}
		else
			$json_data = "json_data = { \"status\": 0, \"error\": \"All values must be provided.\" };" ;

		print $json_data ;
		exit ;
	}
	else if ( $action == "verify" )
	{
		$code = Util_Format_StripQuotes( Util_Format_Sanatize( Util_Format_GetVar( "code" ), "ln" ) ) ;
		$smtp_type = Util_Format_StripQuotes( Util_Format_Sanatize( Util_Format_GetVar( "smtp_type" ), "ln" ) ) ;
		$smtp_theapi = Util_Format_StripQuotes( Util_Format_Sanatize( Util_Format_GetVar( "smtp_theapi" ), "ln" ) ) ;
		$smtp_theapi_domain = Util_Format_StripQuotes( Util_Format_Sanatize( Util_Format_GetVar( "smtp_theapi_domain" ), "ln" ) ) ;
		$smtp_host = Util_Format_StripQuotes( Util_Format_Sanatize( Util_Format_GetVar( "smtp_host" ), "notags" ) ) ;
		$smtp_login = Util_Format_StripQuotes( Util_Format_Sanatize( Util_Format_GetVar( "smtp_login" ), "notags" ) ) ;
		$smtp_pass = Util_Format_StripQuotes( Util_Format_Sanatize( Util_Format_GetVar( "smtp_pass" ), "notags" ) ) ;
		$smtp_port = Util_Format_Sanatize( Util_Format_GetVar( "smtp_port" ), "n" ) ;
		$copy_all = Util_Format_StripQuotes( Util_Format_Sanatize( Util_Format_GetVar( "copy_all" ), "ln" ) ) ;

		$md5 = md5( "$smtp_host $smtp_login $CONF[SALT]" ) ;
		if ( $code == $md5 )
		{
			include_once( "$CONF[DOCUMENT_ROOT]/API/Depts/update.php" ) ;

			if ( $deptinfo["smtp"] )
			{
				$smtp_array = unserialize( Util_Functions_itr_Decrypt( $CONF["SALT"], $deptinfo["smtp"] ) ) ;
				if ( $smtp_pass == preg_replace( "/(.)/", "*", $smtp_array["pass"] ) )
					$smtp_pass = $smtp_array["pass"] ;
				unset( $smtp_array ) ;
			}

			$smtp_array = Array() ;
			$smtp_array["host"] = ( $smtp_type == "connect" ) ? $smtp_host : "" ;
			$smtp_array["login"] = ( $smtp_theapi != "mailgun" ) ? $smtp_login : "" ;
			$smtp_array["pass"] = $smtp_pass ;
			$smtp_array["port"] = ( $smtp_type == "connect" ) ? $smtp_port : "" ;
			$smtp_array["api"] = ( $smtp_type == "api" ) ? $smtp_theapi : "" ;
			$smtp_array["domain"] = ( $smtp_theapi == "mailgun" ) ? $smtp_theapi_domain : "" ;

			$smtp_serialize = Util_Functions_itr_Encrypt( $CONF["SALT"], serialize( $smtp_array ) ) ;

			if ( $copy_all )
			{
				for( $c = 0; $c < count( $departments ); ++$c )
					Depts_update_UserDeptValue( $dbh, $departments[$c]["deptID"], "smtp", $smtp_serialize ) ;
			}
			else
				Depts_update_UserDeptValue( $dbh, $deptid, "smtp", $smtp_serialize ) ;

			$json_data = "json_data = { \"status\": 1 };" ;
		}
		else
			$json_data = "json_data = { \"status\": 0, \"error\": \"Invalid verification code.\" };" ;

		print $json_data ;
		exit ;
	}
	else if ( $action == "clear" )
	{
		include_once( "$CONF[DOCUMENT_ROOT]/API/Depts/update.php" ) ;

		Depts_update_UserDeptValue( $dbh, $deptid, "smtp", "" ) ;
		$deptinfo["smtp"] = Array() ;
	}

	if ( isset( $deptinfo["deptID"] ) && $deptinfo["smtp"] )
	{
		$smtp_array = unserialize( Util_Functions_itr_Decrypt( $CONF["SALT"], $deptinfo["smtp"] ) ) ;

		$CONF["SMTP_HOST"] = $smtp_array["host"] ;
		$CONF["SMTP_LOGIN"] = $smtp_array["login"] ;
		$CONF["SMTP_PASS"] = $smtp_array["pass"] ;
		$CONF["SMTP_PORT"] = $smtp_array["port"] ;
		$CONF["SMTP_API"] = isset( $smtp_array["api"] ) ? $smtp_array["api"] : "" ;
		$CONF["SMTP_DOMAIN"] = isset( $smtp_array["domain"] ) ? $smtp_array["domain"] : "" ;
	}
?>
<?php include_once( "../../inc_doctype.php" ) ?>
<head>
<title> PHP Live! Support <?php echo $VERSION ?> </title>

<meta name="description" content="PHP Live! Support <?php echo $VERSION ?>">
<meta name="keywords" content="powered by: PHP Live!  www.phplivesupport.com">
<meta name="robots" content="all,index,follow">
<meta http-equiv="content-type" content="text/html; CHARSET=utf-8"> 

<link rel="Stylesheet" href="../../css/setup.css?<?php echo $VERSION ?>">
<script type="text/javascript" src="../../js/global.js?<?php echo $VERSION ?>"></script>
<script type="text/javascript" src="../../js/setup.js?<?php echo $VERSION ?>"></script>
<script type="text/javascript" src="../../js/framework.js?<?php echo $VERSION ?>"></script>
<script type="text/javascript" src="../../js/framework_cnt.js?<?php echo $VERSION ?>"></script>

<script type="text/javascript">
<!--
	$(document).ready(function()
	{
		$("body").css({'background': '#8DB26C'}) ;
		$("body").show() ;

		init_menu() ;
		toggle_menu_setup( "extras" ) ;

		<?php if ( isset( $CONF["SMTP_HOST"] ) && isset( $CONF["SMTP_LOGIN"] ) && isset( $CONF["SMTP_PASS"] ) && isset( $CONF["SMTP_PORT"] ) ): ?>
			input_disable() ;
			$('#div_verified').show() ;
		<?php else: ?>
			$('#div_prep').show() ;
		<?php endif ; ?>

		<?php if ( isset( $CONF["SMTP_API"] ) && $CONF["SMTP_API"] ): ?>toggle_type( "api" ) ;
		<?php else: ?>toggle_type( "connect" ) ;<?php endif ; ?>
	});

	function switch_dept( thedeptid )
	{
		location.href = "smtp.php?ses=<?php echo $ses ?>&deptid="+thedeptid ;
	}

	function toggle_type( themenu )
	{
		$(":radio[value="+themenu+"]").attr("checked", true) ;
		if ( themenu == "connect" )
		{
			$('#div_smtp_login').show() ;
			$('#div_smtp_domain').hide() ;
			$('#smtp_input_type_theapi').hide() ;
			$('#div_smtp_host').show() ;
			$('#div_smtp_port').show() ;
		}
		else
		{
			var smtp_theapi = $('#smtp_input_theapis_select').val() ;

			if ( smtp_theapi == "mailgun" ) { $('#div_smtp_login').hide() ; $('#div_smtp_domain').show() ; }
			else { $('#div_smtp_login').show() ; $('#div_smtp_domain').hide() ; }

			$('#smtp_input_type_theapi').show() ;
			$('#div_smtp_host').hide() ;
			$('#div_smtp_port').hide() ;
		}
	}

	function do_submit()
	{
		var unique = unixtime() ;
		var json_data = new Object ;

		var deptid = $('#deptid').val() ;
		var smtp_type = $('input[name=smtp_input_type]:radio:checked').val() ;
		var smtp_theapi = $('#smtp_input_theapis_select').val() ;
		var smtp_host = $('#smtp_input_host').val() ;
		var smtp_login = $('#smtp_input_login').val() ;
		var smtp_pass = $('#smtp_input_pass').val() ;
		var smtp_port = $('#smtp_input_port').val() ;
		var smtp_theapi_domain = $('#smtp_input_domain').val() ;

		$('#div_alert').fadeOut("slow") ;

		if ( ( smtp_type == "connect" ) && ( !smtp_port || !smtp_login || !smtp_pass || !smtp_port ) )
			do_alert( 0, "All values must be provided." ) ;
		else if ( ( smtp_type == "api" ) && ( ( smtp_theapi == "mailgun" ) && ( !smtp_theapi_domain || !smtp_pass ) ) )
				do_alert( 0, "All values must be provided." ) ;
		else if ( ( smtp_type == "api" ) && ( ( smtp_theapi == "sendgrid" ) && ( !smtp_login || !smtp_pass ) ) )
				do_alert( 0, "All values must be provided." ) ;
		else
		{
			$('#div_verify').hide() ;
			$('#btn_submit').attr("disabled", true) ;
			$('#btn_submit').html('Processing...') ;

			input_disable() ;

			$.ajax({
			type: "POST",
			url: "smtp.php",
			data: "action=send_verification&smtp_type="+smtp_type+"&smtp_theapi="+smtp_theapi+"&smtp_theapi_domain="+smtp_theapi_domain+"&smtp_host="+smtp_host+"&smtp_login="+smtp_login+"&smtp_pass="+smtp_pass+"&smtp_port="+smtp_port+"&deptid="+deptid+"&ses=<?php echo $ses ?>&"+unique,
			success: function(data){
				eval( data ) ;

				if ( json_data.status )
				{
					$('#dept_email').html( json_data.email ) ;
					$('#text_cancel').hide() ;
					$('#btn_submit').hide() ;
					$('#div_verify').show() ;
				}
				else
				{
					input_enable() ;
					if ( typeof( json_data.error ) == "undefined" )
					{
						// on localhost boxes sometimes it produces blank error
						do_alert_div( 0, "SMTP information is invalid.  Double check the values and try again. [e2]" ) ;
					}
					else
						do_alert_div( 0, json_data.error ) ;
				}

				reset_btn() ;
			},
			statusCode: {
				500: function() {
					input_enable() ; reset_btn() ;
					do_alert( 0, "Internal 500 error.  Check the web server error logs for more details." ) ;
				}
			},
			error:function (xhr, ajaxOptions, thrownError){
				input_enable() ;
				do_alert( 0, "Connection to server was lost.  Refresh the page and try again." ) ;
			} });
		}
	}

	function do_verify()
	{
		var unique = unixtime() ;
		var json_data = new Object ;

		var deptid = $('#deptid').val() ;
		var smtp_type = $('input[name=smtp_input_type]:radio:checked').val() ;
		var smtp_theapi = $('#smtp_input_theapis_select').val() ;
		var smtp_host = $('#smtp_input_host').val() ;
		var smtp_login = $('#smtp_input_login').val() ;
		var smtp_pass = $('#smtp_input_pass').val() ;
		var smtp_port = $('#smtp_input_port').val() ;
		var smtp_theapi_domain = $('#smtp_input_domain').val() ;
		var copy_all = ( $('#smtp_input_copy_all').is(':checked') ) ? 1 : 0 ;
		var code = $('#code').val() ;

		$.ajax({
		type: "POST",
		url: "smtp.php",
		data: "action=verify&smtp_type="+smtp_type+"&smtp_theapi="+smtp_theapi+"&smtp_theapi_domain="+smtp_theapi_domain+"&smtp_host="+smtp_host+"&smtp_login="+smtp_login+"&smtp_pass="+smtp_pass+"&smtp_port="+smtp_port+"&deptid="+deptid+"&copy_all="+copy_all+"&ses=<?php echo $ses ?>&code="+code+"&"+unique,
		success: function(data){
			eval( data ) ;

			if ( json_data.status )
			{
				$('#div_prep').hide() ;
				$('#div_verify').hide() ;
				$('#div_verified').show() ;
			}
			else
			{
				do_alert( 0, json_data.error ) ;
			}
		},
		error:function (xhr, ajaxOptions, thrownError){
			do_alert( 0, "Connection to server was lost.  Refresh the page and try again." ) ;
		} });
	}

	function reset_btn()
	{
		$('#btn_submit').attr("disabled", false) ;
		$('#btn_submit').html('Send Verification Code and Continue') ;
	}

	function resend()
	{
		$('#div_prep').show() ;
		$('#text_cancel').show() ;
		edit_form() ;
	}

	function input_disable()
	{
		$( '*', '#theform' ).each( function () {
			var div_name = $(this).attr('id') ;
			if ( div_name.indexOf( "smtp_input" ) == 0 )
				$(this).attr("disabled", true) ;
		}) ;
	}

	function input_enable()
	{
		$( '*', '#theform' ).each( function () {
			var div_name = $(this).attr('id') ;
			if ( div_name.indexOf( "smtp_input" ) == 0 )
				$(this).attr("disabled", false) ;
		}) ;
	}

	function edit_form()
	{
		input_enable() ;
		$('#div_verify').hide() ;
		$('#div_verified').hide() ;
		$('#btn_submit').show() ;

		$('#smtp_input_host').focus() ;
	}

	function do_clear()
	{
		var deptid = $('#deptid').val() ;

		if ( confirm( "Clear the department SMTP values?" ) )
			location.href = "smtp.php?ses=<?php echo $ses ?>&action=clear&deptid="+deptid ;
	}

	function do_cancel()
	{
		var deptid = $('#deptid').val() ;

		location.href = "smtp.php?ses=<?php echo $ses ?>&deptid="+deptid ;
	}

//-->
</script>
</head>
<?php include_once( "../../setup/inc_header.php" ) ?>

		<div class="op_submenu_wrapper">
			<div class="op_submenu" onClick="location.href='../../setup/extras.php?ses=<?php echo $ses ?>'" id="menu_external">External URLs</div>
			<div class="op_submenu" onClick="location.href='../../setup/extras_geo.php?ses=<?php echo $ses ?>'" id="menu_geoip">GeoIP</div>
			<div class="op_submenu" onClick="location.href='../../setup/extras_geo.php?ses=<?php echo $ses ?>&jump=geomap'" id="menu_geomap">Google Maps</div>
			<div class="op_submenu_focus" id="menu_smtp"><img src="../../pics/icons/email.png" width="12" height="12" border="0" alt=""> SMTP</div>
			<div class="op_submenu" onClick="location.href='../../setup/extras.php?ses=<?php echo $ses ?>&jump=apis'" id="menu_apis">Dev APIs</div>
			<div style="clear: both"></div>
		</div>

		<form id="theform">
		<input type="hidden" name="action" value="update">
		<input type="hidden" name="ses" value="<?php echo $ses ?>">

		<div style="margin-top: 25px;">

			<?php if ( version_compare( PHP_VERSION, "5.2" ) < 0 ): ?>
				<img src="../../pics/icons/alert.png" width="12" height="12" border="0" alt=""> SMTP integration requires web server <a href="http://www.php.net" target="new">PHP 5.2 or greater</a>.  The server's current PHP version is <?php echo PHP_VERSION ?>.  Consider upgrading the web server PHP to utilize the SMTP integration.
			<?php elseif ( !extension_loaded("mcrypt") ): ?>
				<img src="../../pics/icons/alert.png" width="12" height="12" border="0" alt=""> Could not locate the <b><code>mcrypt</code></b> PHP extension.  Enable the <code><a href="https://www.google.com/#q=php+mcrypt&oq=php+mcrypt&" target="new">mcrypt</a></code> extension to  utilize the SMTP integration. 
			<?php else: ?>
				<?php if ( count( $departments ) > 0 ): ?>
				<table cellspacing=0 cellpadding=0 border=0 width="100%">
				<tr>
					<td valign="top" width="30%">
						<div style="">
							<table cellspacing=0 cellpadding=0 border=0>
							<tr>
								<td><div class="tab_form_title">Department</div></td>
								<td style="padding-left: 10px;">
									<div style="">
										<select name="deptid" id="deptid" style="font-size: 16px; background: #D4FFD4; color: #009000;" OnChange="switch_dept( this.value )">
										<?php
											for ( $c = 0; $c < count( $departments ); ++$c )
											{
												$department = $departments[$c] ;
												if ( $department["name"] != "Archive" )
												{
													$selected = ( $deptid == $department["deptID"] ) ? "selected" : "" ;
													print "<option value=\"$department[deptID]\" $selected>$department[name]</option>" ;
												}
											}
										?>
										</select>
									</div>
								</td>
							</tr>
							</table>
						</div>

						<div style="margin-top: 15px;">
							<table cellspacing=0 cellpadding=0 border=0>
							<tr>
								<td><div class="tab_form_title" style="background: #FFFFFF; border: 0px;">&nbsp;</div></td>
								<td style="width: 100%; padding-left: 10px; text-shadow: none;">
									<div class="info_box" style="text-shadow: none;">
										<div style="padding-bottom: 5px;">The selected type will be used.</div>
										<div class="li_op round"><input type="radio" id="smtp_input_type_connect" name="smtp_input_type" value="connect" onClick="toggle_type('connect')"> Port Connect</div><div class="li_op round"><input type="radio" id="smtp_input_type_api" name="smtp_input_type" value="api" onClick="toggle_type('api')"> Available APIs</div>
										<div style="clear: both;"></div>
									</div>
									<div id="smtp_input_type_theapi" style="display: none; margin-top: 15px;">
										<select id="smtp_input_theapis_select" name="api_name" style="width: 100%;" onChange="toggle_type( 'api' )"><option value="sendgrid" <?php echo ( isset( $CONF["SMTP_API"] ) && ( $CONF["SMTP_API"] == "sendgrid" ) ) ? "selected" : "" ?>>SendGrid (sendgrid.com)</option><option value="mailgun" <?php echo ( isset( $CONF["SMTP_API"] ) && ( $CONF["SMTP_API"] == "mailgun" ) ) ? "selected" : "" ?>>Mailgun (mailgun.com)</option></select>
									</div>
								</td>
							</tr>
							</table>
						</div>
						<div style="margin-top: 15px;" id="div_smtp_host">
							<table cellspacing=0 cellpadding=0 border=0>
							<tr>
								<td><div class="tab_form_title">SMTP Host</div></td>
								<td style="padding-left: 10px;"><input type="text" name="smtp_input_host" id="smtp_input_host" size="30" maxlength="160" onKeyPress="return noquotestags(event)" onFocus="reset_btn()" value="<?php echo ( isset( $CONF["SMTP_HOST"] ) ) ? $CONF["SMTP_HOST"] : "" ?>"></td>
							</tr>
							</table>
						</div>
						<div style="margin-top: 15px;" id="div_smtp_login">
							<table cellspacing=0 cellpadding=0 border=0>
							<tr>
								<td><div class="tab_form_title">SMTP Login</div></td>
								<td style="padding-left: 10px;"><input type="text" name="smtp_input_login" id="smtp_input_login" size="30" maxlength="160" onKeyPress="return noquotestags(event)" onFocus="reset_btn()" value="<?php echo ( isset( $CONF["SMTP_LOGIN"] ) ) ? $CONF["SMTP_LOGIN"] : "" ?>"></td>
							</tr>
							</table>
						</div>
						<div style="display: none; margin-top: 15px;" id="div_smtp_domain">
							<table cellspacing=0 cellpadding=0 border=0>
							<tr>
								<td><div class="tab_form_title">Domain Name</div></td>
								<td style="padding-left: 10px;"><input type="text" name="smtp_input_domain" id="smtp_input_domain" size="30" maxlength="25" onKeyPress="return noquotestags(event)" onFocus="reset_btn()" value="<?php echo ( isset( $CONF["SMTP_DOMAIN"] ) ) ? $CONF["SMTP_DOMAIN"] : "" ?>"></td>
							</tr>
							</table>
						</div>
						<div style="margin-top: 15px;">
							<table cellspacing=0 cellpadding=0 border=0>
							<tr>
								<td><div class="tab_form_title">SMTP Password / Key</div></td>
								<td style="padding-left: 10px;"><input type="password" name="smtp_input_pass" id="smtp_input_pass" size="30" maxlength="160" onKeyPress="return noquotestags(event)" onFocus="reset_btn()" value="<?php echo ( isset( $CONF["SMTP_PASS"] ) ) ? preg_replace( "/(.)/", "*", $CONF["SMTP_PASS"] ) : "" ?>"></td>
							</tr>
							</table>
						</div>
						<div style="margin-top: 15px;" id="div_smtp_port">
							<table cellspacing=0 cellpadding=0 border=0>
							<tr>
								<td><div class="tab_form_title">SMTP Port</div></td>
								<td style="padding-left: 10px;"><input type="text" name="smtp_input_port" id="smtp_input_port" size="30" maxlength="5" onKeyPress="return numbersonly(event)" onFocus="reset_btn()" value="<?php echo ( isset( $CONF["SMTP_PORT"] ) ) ? $CONF["SMTP_PORT"] : "" ?>"></td>
							</tr>
							</table>
						</div>
						<div style="margin-top: 25px;">
							<table cellspacing=0 cellpadding=0 border=0>
							<tr>
								<td><div class="tab_form_title" style="background: #FFFFFF; border: 0px;">&nbsp;</div></td>
								<td style="padding-left: 10px;">
									<?php if ( count( $departments ) > 1 ): ?>
									<div style="padding-bottom: 15px;"><input type="checkbox" id="smtp_input_copy_all" name="copy_all" value=1> copy this update to all departments</div>
									<?php endif ; ?>
								</td>
							</tr>
							</table>
						</div>
					</td>
					<td valign="top" width="70%" style="padding-left: 50px;">
						<div id="div_prep" style="display: none; text-align: justify;">
							<div>As a default, the system will use the standard PHP mail() function with the web server mail settings to send out emails (transcripts, offline messages, etc).  However, if the department SMTP values are provided, emails will be sent using the external SMTP provider.</div>
							<div style="margin-top: 15px;"><img src="../../pics/icons/warning.png" width="12" height="12" border="0" alt=""> Before activating the SMTP feature, the SMTP settings will need to be verified.  Using the SMTP values, the system will attempt to send an email to the <a href="../../setup/depts.php?ses=<?php echo $ses ?>">department email address</a> containing the SMTP Verification Code, which will need to be provided on the next step.</div>

							<div id="div_alert" style="display: none; margin-top: 15px;"></div>
							<button style="margin-top: 15px;" type="button" onClick="do_submit()" class="btn" id="btn_submit">Send Verification Code and Continue</button> &nbsp; <span style="display: none;" id="text_cancel"><a href="JavaScript:void(0)" onClick="do_cancel()">cancel</a></span>
						</div>

						<div id="div_verify" style="display: none; margin-top: 5px;" class="info_info">
							<span class="edit_title">Verification Code Sent!</span> &nbsp; <span class="info_error">Settings have not been saved yet.</span>
							<div style="margin-top: 15px;">An email has been sent to <span id="dept_email" style="font-weight: bold; color: #8DB173; background: #FFFFFF; padding: 1px;"></span> containing the SMTP Verification Code.  If you do not receive the email within 5 minutes, perhaps double check the SMTP values and resend. [ <a href="JavaScript:void(0)" onClick="edit_form()">edit values</a> ]</div>

							<div style="margin-top: 25px;">
								<table cellspacing=0 cellpadding=0 border=0>
								<tr>
									<td><div class="tab_form_title">Verification Code</div></td>
									<td style="padding-left: 10px;"><input type="text" name="code" id="code" size="25" maxlength="50" onKeyPress="return logins(event)" value=""></td>
									<td style="padding-left: 10px;"><button type="button" onClick="do_verify()" class="btn" id="btn_verify">Verify</button></td>
								</tr>
								</table>
							</div>
						</div>

						<div id="div_verified" style="display: none;" class="info_info">
							<span class="edit_title">SMTP settings verified!</span> &nbsp; <span class="info_good">Settings saved and active.</span>
							<div style="margin-top: 15px;">
								<div>All outgoing emails are sent using the department SMTP settings.  No further action is required.</div>
								<div style="margin-top: 15px;">[ <a href="JavaScript:void(0)" onClick="resend()">update values</a> ] &nbsp; [ <a href="JavaScript:void(0)" onClick="do_clear()">clear values</a> ]</div>
							</div>
						</div>
					</td>
				</tr>
				<tr>
					<td colspan=2 align="right"><div style="">SMTP Addon v.<?php echo $SMTP_VERSION ?>  <img src="../../pics/icons/disc.png" width="16" height="16" border="0" alt=""> <a href="http://www.phplivesupport.com/r.php?r=vcheck_smtp&v=<?php echo base64_encode( $SMTP_VERSION ) ?>&v_=<?php echo base64_encode( $VERSION ) ?>" target="new">Check for updates.</a></div></td>
				</tr>
				</table>
				<?php else: ?>
				<span class="info_error"><img src="../../pics/icons/warning.png" width="12" height="12" border="0" alt=""> Create a <a href="../../setup/depts.php?ses=<?php echo $ses ?>" style="color: #FFFFFF;">Department</a> to continue.</span>
				<?php endif ; ?>
			<?php endif ; ?>

		</div>
		</form>

<?php include_once( "../../setup/inc_footer.php" ) ?>
