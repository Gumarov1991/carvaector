<?php
	/* (c) OSI Codes Inc. */
	/* http://www.osicodesinc.com */
	/****************************************/
	// STANDARD header for Setup
	if ( !is_file( "../web/config.php" ) ){ HEADER("location: install.php") ; exit ; }
	include_once( "../web/config.php" ) ;
	include_once( "$CONF[DOCUMENT_ROOT]/API/Util_Format.php" ) ;
	include_once( "$CONF[DOCUMENT_ROOT]/API/Util_Error.php" ) ;
	include_once( "$CONF[DOCUMENT_ROOT]/API/".Util_Format_Sanatize($CONF["SQLTYPE"], "ln") ) ;
	include_once( "$CONF[DOCUMENT_ROOT]/API/Util_IP.php" ) ;
	include_once( "$CONF[DOCUMENT_ROOT]/API/Util_Security.php" ) ;
	$ses = Util_Format_Sanatize( Util_Format_GetVar( "ses" ), "ln" ) ;
	if ( !$admininfo = Util_Security_AuthSetup( $dbh, $ses ) ){ ErrorHandler( 608, "Invalid setup session or session has expired.", $PHPLIVE_FULLURL, 0, Array() ) ; }
	// STANDARD header end
	/****************************************/

	include_once( "$CONF[DOCUMENT_ROOT]/API/Util_Vals.php" ) ;
	include_once( "$CONF[DOCUMENT_ROOT]/API/Util_Hash.php" ) ;
	if ( is_file( "$CONF[DOCUMENT_ROOT]/API/Util_Extra_Pre.php" ) ) { include_once( "$CONF[DOCUMENT_ROOT]/API/Util_Upload_.php" ) ; }
	else { include_once( "$CONF[DOCUMENT_ROOT]/API/Util_Upload.php" ) ; }
	include_once( "$CONF[DOCUMENT_ROOT]/API/Util_Upload_File.php" ) ;
	include_once( "$CONF[DOCUMENT_ROOT]/API/Depts/get.php" ) ;

	$https = "" ;
	if ( isset( $_SERVER["HTTP_CF_VISITOR"] ) && preg_match( "/(https)/i", $_SERVER["HTTP_CF_VISITOR"] ) ) { $https = "s" ; }
	else if ( isset( $_SERVER["HTTP_X_FORWARDED_PROTO"] ) && preg_match( "/(https)/i", $_SERVER["HTTP_X_FORWARDED_PROTO"] ) ) { $https = "s" ; }
	else if ( isset( $_SERVER["HTTPS"] ) && preg_match( "/(on)/i", $_SERVER["HTTPS"] ) ) { $https = "s" ; }

	$action = Util_Format_Sanatize( Util_Format_GetVar( "action" ), "ln" ) ;
	$jump = ( Util_Format_Sanatize( Util_Format_GetVar( "jump" ), "ln" ) ) ? Util_Format_Sanatize( Util_Format_GetVar( "jump" ), "ln" ) : "logo" ;
	$deptid = Util_Format_Sanatize( Util_Format_GetVar( "deptid" ), "ln" ) ;
	$lang = Util_Format_Sanatize( Util_Format_GetVar( "lang" ), "ln" ) ;

	if ( !isset( $CONF["screen"] ) ) { $CONF["screen"] = "same" ; }
	if ( !isset( $CONF["THEME"] ) ) { $CONF["THEME"] = "default" ; }
	if ( !isset( $VALS["POPOUT"] ) ) { $VALS["POPOUT"] = "on" ; }
	if ( !isset( $VALS["DEPT_NAME_VIS"] ) ) { $VALS["DEPT_NAME_VIS"] = "off" ; }
	if ( !isset( $CONF["lang"] ) ) { $CONF["lang"] = "english" ; } if ( !$lang ) { $lang = $CONF["lang"] ; }

	$error = "" ;

	$deptinfo = Depts_get_DeptInfo( $dbh, $deptid ) ;
	LIST( $your_ip, $null ) = Util_IP_GetIP( "" ) ;

	if ( $action == "update" )
	{
		if ( $jump == "logo" )
			LIST( $error, $filename ) = Util_Upload_File( "logo", $deptid ) ;
		else if ( $jump == "time" )
		{
			include_once( "$CONF[DOCUMENT_ROOT]/API/Chat/remove.php" ) ;

			$timezone = Util_Format_Sanatize( Util_Format_GetVar( "timezone" ), "timezone" ) ;

			if ( $timezone != $CONF["TIMEZONE"] )
				Chat_remove_ResetReports( $dbh ) ;

			$error = ( Util_Vals_WriteToConfFile( "TIMEZONE", $timezone ) ) ? "" : "Could not write to config file." ;
			if ( phpversion() >= "5.1.0" ){ date_default_timezone_set( $timezone ) ; }
		}
	}
	else if ( $action == "screen" )
	{
		$screen = Util_Format_Sanatize( Util_Format_GetVar( "screen" ), "ln" ) ;
		$error = ( Util_Vals_WriteToConfFile( "screen", $screen ) ) ? "" : "Could not write to config file." ;
		$CONF["screen"] = $screen ;

		$jump = "screen" ;
	}
	else if ( ( $action == "clear" ) && $deptid )
	{
		$dir_files = glob( $CONF["CONF_ROOT"]."/logo_$deptid.*", GLOB_NOSORT ) ;
		$total_dir_files = count( $dir_files ) ;
		if ( $total_dir_files )
		{
			for ( $c = 0; $c < $total_dir_files; ++$c )
			{
				if ( $dir_files[$c] && is_file( $dir_files[$c] ) ) { unlink( $dir_files[$c] ) ; }
			}
		}
	}

	$screen_same = ( $CONF["screen"] == "same" ) ? "checked" : "" ;
	$screen_separate = ( $screen_same == "checked" ) ? "" : "checked" ;

	$departments = Depts_get_AllDepts( $dbh ) ;
	$timezones = Util_Hash_Timezones() ;
	$vars = Util_Format_Get_Vars( $dbh ) ;
	$charset = ( isset( $vars["char_set"] ) && $vars["char_set"] ) ? unserialize( $vars["char_set"] ) : Array(0=>"UTF-8") ;

	$login_url = $CONF['BASE_URL'] ;
	if ( !preg_match( "/\/\//", $login_url ) ) { $login_url = "//$PHPLIVE_HOST$login_url" ; }
?>
<?php include_once( "../inc_doctype.php" ) ?>
<head>
<title> PHP Live! Support <?php echo $VERSION ?> </title>

<meta name="description" content="PHP Live! Support <?php echo $VERSION ?>">
<meta name="keywords" content="powered by: PHP Live!  www.phplivesupport.com">
<meta name="robots" content="all,index,follow">
<meta http-equiv="content-type" content="text/html; CHARSET=utf-8">
<?php include_once( "../inc_meta_dev.php" ) ; ?>

<link rel="Stylesheet" href="../css/setup.css?<?php echo $VERSION ?>">
<script type="text/javascript" src="../js/global.js?<?php echo $VERSION ?>"></script>
<script type="text/javascript" src="../js/setup.js?<?php echo $VERSION ?>"></script>
<script type="text/javascript" src="../js/framework.js?<?php echo $VERSION ?>"></script>
<script type="text/javascript" src="../js/framework_cnt.js?<?php echo $VERSION ?>"></script>
<script type="text/javascript" src="../js/jquery_md5.js?<?php echo $VERSION ?>"></script>

<script type="text/javascript">
<!--
	var theme = "<?php echo $CONF["THEME"] ?>" ;
	var global_div ;
	var global_charset = "<?php echo $charset[0] ?>" ;
	var global_popout = "<?php echo ( isset( $VALS["POPOUT"] ) && $VALS["POPOUT"] ) ? $VALS["POPOUT"] : "on" ; ?>" ;
	var global_dept_name_vis = "<?php echo $VALS["DEPT_NAME_VIS"] ?>" ;

	$(document).ready(function()
	{
		$("body").css({'background': '#8DB26C'}) ;

		init_menu() ;
		toggle_menu_setup( "interface" ) ;

		show_div( "<?php echo $jump ?>" ) ;

		<?php if ( $action && !$error ): ?>do_alert( 1, "Success" ) ;<?php endif ; ?>
		<?php if ( $action && $error ): ?>do_alert_div( "..", 0, "<?php echo $error ?>" ) ;<?php endif ; ?>

		$('#urls_<?php echo $CONF["screen"] ?>').show() ;

		check_image_dim() ;
	});

	function show_div( thediv )
	{
		$('#div_alert').hide() ;
	
		var divs = Array( "logo", "themes", "charset", "time", "screen", "misc_settings", "lang" ) ;
		for ( var c = 0; c < divs.length; ++c )
		{
			$('#settings_'+divs[c]).hide() ;
			$('#menu_'+divs[c]).removeClass('op_submenu_focus').addClass('op_submenu') ;
		}

		$('input#jump').val( thediv ) ;
		$('#settings_'+thediv).show() ;
		$('#menu_'+thediv).removeClass('op_submenu').addClass('op_submenu_focus') ;
	}

	function switch_dept( theobject )
	{
		location.href = "interface.php?ses=<?php echo $ses ?>&deptid="+theobject.value ;
	}

	function update_timezone()
	{
		var timezone = $('#timezone').val() ;

		if ( confirm( "This action will reset the chat reports data.  Are you sure?" ) )
			location.href = "interface.php?ses=<?php echo $ses ?>&action=update&jump=time&timezone="+timezone ;
	}

	function confirm_charset( thecharset )
	{
		if ( global_charset != thecharset )
		{
			var json_data = new Object ;

			$.ajax({
				type: "POST",
				url: "../ajax/setup_actions.php",
				data: "ses=<?php echo $ses ?>&action=update_vars&varname=char_set&value="+thecharset+"&"+unixtime(),
				success: function(data){
					global_charset = thecharset ;
					do_alert( 1, "Success!" ) ;
				}
			});
		}
	}

	function check_image_dim()
	{
		var img = new Image() ;
		img.onload = get_img_dim ;
		img.src = '<?php print Util_Upload_GetLogo( "logo", $deptid ) ?>' ;
	}

	function get_img_dim()
	{
		var img_width = this.width ;
		var img_height = this.height ;

		$('#div_logo').css({'width': img_width, 'height': img_height}) ;
	}

	function confirm_popout( thepopout )
	{
		if ( global_popout != thepopout )
		{
			var json_data = new Object ;

			$.ajax({
				type: "POST",
				url: "../ajax/setup_actions.php",
				data: "ses=<?php echo $ses ?>&action=update_popout&value="+thepopout+"&"+unixtime(),
				success: function(data){
					global_popout = thepopout ;
					do_alert( 1, "Success!" ) ;
				}
			});
		}
	}

	function confirm_dept_name_vis( the_dept_name_vis )
	{
		if ( global_dept_name_vis != the_dept_name_vis )
		{
			var json_data = new Object ;

			$.ajax({
				type: "POST",
				url: "../ajax/setup_actions.php",
				data: "ses=<?php echo $ses ?>&action=update_dept_name_vis&value="+the_dept_name_vis+"&"+unixtime(),
				success: function(data){
					global_dept_name_vis = the_dept_name_vis ;
					do_alert( 1, "Success!" ) ;
				}
			});
		}
	}

	function confirm_clear()
	{
		if ( confirm( "Really clear this department logo and use Global Default?" ) )
		{
			location.href = "interface.php?ses=<?php echo $ses ?>&action=clear&deptid=<?php echo $deptid ?>" ;
		}
	}
//-->
</script>
</head>
<?php include_once( "./inc_header.php" ) ?>

		<div class="op_submenu_wrapper">
			<div class="op_submenu" onClick="show_div('logo')" id="menu_logo">Logo</div>
			<div class="op_submenu" onClick="location.href='interface_op_pics.php?ses=<?php echo $ses ?>'">Operator Pics</div>
			<div class="op_submenu" onClick="show_div('themes')" id="menu_themes">Themes</div>
			<div class="op_submenu" onClick="show_div('charset')" id="menu_charset">Character Set</div>
			<?php if ( phpversion() >= "5.1.0" ): ?><div class="op_submenu" onClick="show_div('time')" id="menu_time">Time Zone</div><?php endif; ?>
			<div class="op_submenu" onClick="location.href='interface_lang.php?ses=<?php echo $ses ?>'" id="menu_lang">Language Text</div>
			<div class="op_submenu" onClick="show_div('misc_settings')" id="menu_misc_settings">Settings</div>
			<div class="op_submenu" onClick="show_div('screen')" id="menu_screen">Login Screen</div>
			<div style="clear: both"></div>
		</div>

		<form method="POST" action="interface.php?submit" enctype="multipart/form-data">
		<input type="hidden" name="action" value="update">
		<input type="hidden" name="jump" id="jump" value="">
		<input type="hidden" name="ses" value="<?php echo $ses ?>">
		<input type="hidden" name="MAX_FILE_SIZE" value="200000">

		<div style="display: none; margin-top: 25px;" id="settings_logo">
			<div style="">If more then one <a href="depts.php?ses=<?php echo $ses ?>">department</a> have been created, the "Global Default" logo will be displayed until a new logo has been uploaded for that department.  Keep in mind, the department logo will go into affect for the <a href="code.php?ses=<?php echo $ses ?>">department specific HTML Code</a> option only.</div>
			<div style="margin-top: 25px;">
				<select name="deptid" id="deptid" style="font-size: 16px; background: #D4FFD4; color: #009000;" OnChange="switch_dept( this )">
					<option value="0">Global Default</option>
					<?php
						if ( count( $departments ) > 1 )
						{
							for ( $c = 0; $c < count( $departments ); ++$c )
							{
								$department = $departments[$c] ;
								if ( $department["name"] != "Archive" )
								{
									$selected = ( $deptid == $department["deptID"] ) ? "selected" : "" ;
									print "<option value=\"$department[deptID]\" $selected>$department[name]</option>" ;
								}
							}
						}
					?>
				</select>
				
				<div style="margin-top: 15px;">
					<div style="font-size: 14px;" class="info_box">
						<div style="">
							Logo for <span id="span_dept_name" style="font-size: 18px; font-weight: bold;"><?php echo ( isset( $deptinfo["name"] ) ) ? "<a href=\"depts.php?ses=$ses\">".$deptinfo["name"]."</a>" : "Global Default" ; ?></span>
						</div>
						<div style="font-size: 12px; margin-top: 10px;"><img src="../pics/icons/info.png" width="12" height="12" border="0" alt=""> To maximize the visible chat space, the logo will not be displayed for the <a href="icons.php?ses=<?php echo $ses ?>&jump=settings">embed chat setting</a>.</div>
					</div>

					<table cellspacing=0 cellpadding=0 border=0 width="100%" class="edit_wrapper" style="margin-top: 15px;">
					<tr>
						<td valign="top">
							<div id="div_alert" style="display: none; margin-bottom: 25px;"></div>

							<?php if ( ( count( $departments ) == 1 ) && isset( $deptinfo["deptID"] ) ): ?>
							<div class="info_error"><img src="../pics/icons/warning.png" width="12" height="12" border="0" alt=""> Because only one department is available, choose the "Global Default" to upload your logo.</div>

							<?php else: ?>
							<div style="">
								<input type="file" name="logo" size="30"><p>
								<input type="submit" value="Upload Image" style="margin-top: 10px;" class="btn">
							</div>

							<div style="margin-top: 15px;"><img src="../pics/icons/info.png" width="12" height="12" border="0" alt=""> For proper display of the logo, recommended <b>maximum</b> logo size should be <b>520 pixels width</b> and <b>55 pixels height</b>.</div>
							<div id="div_logo" style="border: 1px solid #DFDFDF; margin-top: 25px; background: url( <?php print Util_Upload_GetLogo( "logo", $deptid ) ?> ) no-repeat;">&nbsp;</div>

							<?php if ( $deptid && ( Util_Upload_GetLogo( "logo", 0 ) != Util_Upload_GetLogo( "logo", $deptid ) ) ): ?>
							<div style="margin-top: 15px;"><img src="../pics/icons/reset.png" width="16" height="16" border="0" alt=""> <a href="JavaScript:void(0)" onClick="confirm_clear()">clear department logo and use Global Default image</a></div>
							<?php elseif ( $deptid ): ?>
							<div style="margin-top: 15px;"><img src="../pics/icons/themes.png" width="16" height="16" border="0" alt=""> currently using <a href="interface.php?ses=<?php echo $ses ?>">Global Default</a> image</div>
							<?php endif ; ?>

							<div style="margin-top: 15px;"><img src="../pics/icons/arrow_grey.png" width="16" height="16" border="0" alt=""> <a href="JavaScript:void(0)" onClick="preview_theme('<?php echo $CONF["THEME"] ?>', <?php echo $VARS_CHAT_WIDTH ?>, <?php echo $VARS_CHAT_HEIGHT ?>, <?php echo $deptid ?> )">view how it looks</a></div>
							<?php endif ; ?>
						</td>
					</tr>
					</table>
				</div>
			</div>
		</div>

		<div style="display: none; margin-top: 25px; text-align: justify;" id="settings_themes">
			<div>Set the visitor chat window theme.  Operators will be able to set their own theme by logging into the <a href="ops.php?ses=<?php echo $ses ?>&jump=online">Operator area</a>.</div>
			<div style="margin-top: 25px;"><img src="../pics/icons/arrow_right.png" width="16" height="15" border="0" alt=""> Visitor chat window theme can be set for each department at the <a href="depts.php?ses=<?php echo $ses ?>">Departments area.</a></div>
		</div>

		<div style="display: none; margin-top: 25px;" id="settings_charset">
			If multi-language characters are not rendering properly on the operator chat window or while viewing transcripts, try updating the character set value.  UTF-8 is suggested.

			<div style="margin-top: 25px;">
				<div class="li_op round"><input type="radio" name="charset" id="charset_UTF-8" value="UTF-8" onClick="confirm_charset(this.value)" <?php echo ( $charset[0] == "UTF-8" ) ? "checked" : "" ?>> UTF-8</div>
				<div class="li_op round"><input type="radio" name="charset" id="charset_ISO-8859-1" value="ISO-8859-1" onClick="confirm_charset(this.value)" <?php echo ( $charset[0] == "ISO-8859-1" ) ? "checked" : "" ?>> ISO-8859-1</div>
				<div style="clear: both;"></div>
			</div>
		</div>

		<?php if ( phpversion() >= "5.1.0" ): ?>
		<div style="display: none; margin-top: 25px;" id="settings_time">
			<div>Current system time based on timezone: <b><?php echo $CONF['TIMEZONE'] ?></b></div>
			<div style="margin-top: 15px; font-size: 32px; font-weight: bold; color: #79C2EB; font-family: sans-serif;"><?php echo date( "M j, Y (g:i a)", time() ) ; ?></div>

			<div style="margin-top: 15px;"><img src="../pics/icons/warning.png" width="12" height="12" border="0" alt=""> Updating the timezone will clear the <a href="reports_chat.php?ses=<?php echo $ses ?>">chat reports data</a>.  The chat report reset is necessary because the past data timezone will conflict with the new timezone.  Be sure to print out the report before continuing.  The chat <a href="transcripts.php?ses=<?php echo $ses ?>">transcripts</a> will not be affected but the creation timestamp may be different from the original due to the timezone change.</div>

			<div style="margin-top: 15px;">
				<select id="timezone">
				<?php
					for ( $c = 0; $c < count( $timezones ); ++$c )
					{
						$selected = "" ;
						if ( $timezones[$c] == date_default_timezone_get() )
							$selected = "selected" ;

						print "<option value=\"$timezones[$c]\" $selected>$timezones[$c]</option>" ;
					}
				?>
				</select>
			</div>
			
			<div style="margin-top: 25px;"><button type="button" onClick="update_timezone()" class="btn">Update</button></div>
		</div>
		<?php endif; ?>

		<div style="display: none; margin-top: 25px;" id="settings_screen">
			Choose whether to display the operator login and the setup login screens on the same URL or separate URLs.
		
			<div style="margin-top: 25px;">
				<div class="li_op round"><input type="radio" name="screen" id="screen_one" value="same" onClick="location.href='interface.php?ses=<?php echo $ses ?>&action=screen&screen=same'" <?php echo $screen_same ?>> Same URL</div>
				<div class="li_op round"><input type="radio" name="screen" id="screen_two" value="separate" onClick="location.href='interface.php?ses=<?php echo $ses ?>&action=screen&screen=separate'" <?php echo $screen_separate ?>> Separate URLs</div>
				<div style="clear: both;"></div>
			</div>

			<div style="margin-top: 25px;">
				<div id="urls_same" style="display: none;" class="info_info">
					<div style=""><img src="../pics/icons/key.png" width="16" height="16" border="0" alt=""> <img src="../pics/icons/bulb.png" width="16" height="16" border="0" alt="">Operator and Setup Login URL</div>
					<div style="margin-top: 5px; font-size: 32px; font-weight: bold; text-shadow: 1px 1px #FFFFFF;"><a href="<?php echo ( !preg_match( "/^(http)/", $CONF["BASE_URL"] ) ) ? "http$https:$login_url" : $login_url ; ?>" target="new" style="color: #8DB173;" class="nounder"><?php echo ( !preg_match( "/^(http)/", $login_url ) ) ? "http$https:$login_url" : $login_url ; ?></a></div>
				</div>
				<div id="urls_separate" style="display: none;">
					<div class="info_info">
						<div style="font-size: 14px; font-weight: bold; text-shadow: 1px 1px #FFFFFF;"><img src="../pics/icons/bulb.png" width="16" height="16" border="0" alt=""> Operator Login URL</div>
						<div style="margin-top: 5px; font-size: 32px; font-weight: bold; text-shadow: 1px 1px #FFFFFF;"><a href="<?php echo ( !preg_match( "/^(http)/", $login_url ) ) ? "http$https:$login_url" : $login_url ; ?>" target="new" style="color: #8DB173;" class="nounder"><?php echo ( !preg_match( "/^(http)/", $login_url ) ) ? "http$https:$login_url" : $login_url ; ?></a></div>
					</div>

					<div class="info_info" style="margin-top: 25px;">
						<div style="font-size: 14px; font-weight: bold; text-shadow: 1px 1px #FFFFFF;"><img src="../pics/icons/key.png" width="16" height="16" border="0" alt=""> Setup Login URL</div>
						<div style="margin-top: 5px; font-size: 32px; font-weight: bold; text-shadow: 1px 1px #FFFFFF;"><a href="<?php echo ( !preg_match( "/^(http)/", $login_url ) ) ? "http$https:$login_url" : $login_url ; ?>/setup" target="new" style="color: #8DB173;" class="nounder"><?php echo ( !preg_match( "/^(http)/", $login_url ) ) ? "http$https:$login_url" : $login_url ; ?>/setup</a></div>
					</div>
				</div>
			</div>
		</div>

		<div style="display: none; margin-top: 25px; text-align: justify;" id="settings_misc_settings">
			<div style="float: left; min-height: 210px; width: 45%" class="info_info">
				<div style="font-size: 14px; font-weight: bold;">Embed Chat Popout</div>

				<div style="margin-top: 15px;">(default is On) If <a href="icons.php?ses=<?php echo $ses ?>&jump=settings">embed chat</a> is enabled, switch on/off the embed chat "popout" feature.  The "popout" feature enables the visitor to open the embed chat in a new window when clicking the "popout" icon <img src="../pics/icons/win_pop.png" width="16" height="16" border="0" alt="">.  By switching off the embed chat "popout", the chat "popout" icon <img src="../themes/default/win_pop.png" width="16" height="16" border="0" alt=""> will not be visible.  Switching off the "popout" feature will also remove the print icon <img src="../themes/default/printer.png" width="16" height="16" border="0" alt=""> during a chat session (visitor chat).</div>
				<div style="margin-top: 15px;">
					<div class="info_good" style="float: left; width: 60px; padding: 3px;"><input type="radio" name="popout" id="popout_on" value="on" onClick="confirm_popout(this.value)" <?php echo ( $VALS["POPOUT"] != "off" ) ? "checked" : "" ?>> On</div>
					<div class="info_error" style="float: left; margin-left: 10px; width: 60px; padding: 3px;"><input type="radio" name="popout" id="popout_off" value="off" onClick="confirm_popout(this.value)" <?php echo ( $VALS["POPOUT"] == "off" ) ? "checked" : "" ?>> Off</div>
					<div style="clear: both;"></div>
				</div>
			</div>
			<div style="float: left; margin-left: 2px; min-height: 210px; width: 45%;" class="info_info">
				<div style="font-size: 14px; font-weight: bold;">Department Name Visible for One Department</div>

				<div style="margin-top: 15px;">(default is Off) Set the system to display or not to display the department name for the <a href="./code.php?ses=<?php echo $ses ?>">Department Specific HTML Code</a> or if only one department has been created.</div>
				<div style="margin-top: 15px;">
					<div class="info_good" style="float: left; width: 60px; padding: 3px;"><input type="radio" name="dept_name_vis" id="dept_name_vis_on" value="on" onClick="confirm_dept_name_vis(this.value)" <?php echo ( $VALS["DEPT_NAME_VIS"] != "off" ) ? "checked" : "" ?>> On</div>
					<div class="info_error" style="float: left; margin-left: 10px; width: 60px; padding: 3px;"><input type="radio" name="dept_name_vis" id="dept_name_vis_off" value="off" onClick="confirm_dept_name_vis(this.value)" <?php echo ( $VALS["DEPT_NAME_VIS"] == "off" ) ? "checked" : "" ?>> Off</div>
					<div style="clear: both;"></div>
				</div>
			</div>
			<div style="clear: both;"></div>
		</div>
		</form>

<?php include_once( "./inc_footer.php" ) ?>

