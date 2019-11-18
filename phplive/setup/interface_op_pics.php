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

	if ( is_file( "$CONF[DOCUMENT_ROOT]/API/Util_Extra_Pre.php" ) ) { include_once( "$CONF[DOCUMENT_ROOT]/API/Util_Upload_.php" ) ; }
	else { include_once( "$CONF[DOCUMENT_ROOT]/API/Util_Upload.php" ) ; }
	include_once( "$CONF[DOCUMENT_ROOT]/API/Util_Upload_File.php" ) ;
	include_once( "$CONF[DOCUMENT_ROOT]/API/Ops/get.php" ) ;

	$action = Util_Format_Sanatize( Util_Format_GetVar( "action" ), "ln" ) ;
	$opid = Util_Format_Sanatize( Util_Format_GetVar( "opid" ), "n" ) ;

	$error = "" ;

	if ( $action == "update" )
	{
		$profile_pic_onoff = Util_Format_Sanatize( Util_Format_GetVar( "profile_pic_onoff" ), "n" ) ;

		LIST( $error, $filename ) = Util_Upload_File( "profile", $opid ) ;
		if ( !$error )
		{
			include_once( "$CONF[DOCUMENT_ROOT]/API/Util_Vals.php" ) ;
			if ( $opid )
			{
				include_once( "$CONF[DOCUMENT_ROOT]/API/Ops/update.php" ) ;
				Ops_update_OpValue( $dbh, $opid, "pic", $profile_pic_onoff ) ;
			}
			else { Util_Vals_WriteToFile( "PROFILE", $profile_pic_onoff ) ; }
		}
	}
	else if ( ( $action == "clear" ) && $opid )
	{
		$dir_files = glob( $CONF["CONF_ROOT"]."/profile_$opid.*", GLOB_NOSORT ) ;
		$total_dir_files = count( $dir_files ) ;
		if ( $total_dir_files )
		{
			for ( $c = 0; $c < $total_dir_files; ++$c )
			{
				if ( $dir_files[$c] && is_file( $dir_files[$c] ) ) { unlink( $dir_files[$c] ) ; }
			}
		}
	}

	$operators = Ops_get_AllOps( $dbh ) ;
	$opinfo = Ops_get_OpInfoByID( $dbh, $opid ) ;

	$profile_pic_onoff_default = ( isset( $VALS['PROFILE'] ) && ( $VALS['PROFILE'] == 1 ) ) ? 1 : 0 ;
	if ( $opid )
		$profile_pic_onoff = ( isset( $opinfo["pic"] ) && ( $opinfo["pic"] == 1 ) ) ? 1 : 0 ;
	else
		$profile_pic_onoff = ( $profile_pic_onoff_default ) ? 1 : 0 ;
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
	var global_profile_pic_onoff = parseInt( <?php echo $profile_pic_onoff ?> ) ;

	$(document).ready(function()
	{
		$("body").css({'background': '#8DB26C'}) ;

		init_menu() ;
		toggle_menu_setup( "interface" ) ;

		<?php if ( $action && $error ): ?>
		do_alert_div( "..", 0, "<?php echo $error ?>" ) ;
		<?php elseif ( $action ): ?>
		do_alert(1, "Success!" ) ;
		<?php endif ; ?>

	});

	function switch_op()
	{
		var opid = $('#select_ops').val() ;
		location.href = "interface_op_pics.php?ses=<?php echo $ses ?>&opid="+opid ;
	}

	function confirm_clear()
	{
		if ( confirm( "Really clear this operator profile picture and use Global Default?" ) )
		{
			location.href = "interface_op_pics.php?ses=<?php echo $ses ?>&action=clear&opid=<?php echo $opid ?>" ;
		}
	}

	function update_profile_pic_onoff( thevalue )
	{
		if ( global_profile_pic_onoff != thevalue )
		{
			var json_data = new Object ;

			$.ajax({
				type: "POST",
				url: "../ajax/setup_actions_.php",
				data: "ses=<?php echo $ses ?>&action=update_profile_pic_onoff&opid=<?php echo $opid ?>&value="+thevalue+"&"+unixtime(),
				success: function(data){
					location.href = "interface_op_pics.php?ses=<?php echo $ses ?>&opid=<?php echo $opid ?>&action=success" ;
				}
			});
		}
	}
//-->
</script>
</head>
<?php include_once( "./inc_header.php" ) ?>

		<div class="op_submenu_wrapper">
			<div class="op_submenu" onClick="location.href='interface.php?ses=<?php echo $ses ?>&jump=logo'">Logo</div>
			<div class="op_submenu_focus">Operator Pics</div>
			<div class="op_submenu" onClick="location.href='interface.php?ses=<?php echo $ses ?>&jump=themes'">Themes</div>
			<div class="op_submenu" onClick="location.href='interface.php?ses=<?php echo $ses ?>&jump=charset'">Character Set</div>
			<?php if ( phpversion() >= "5.1.0" ): ?><div class="op_submenu" onClick="location.href='interface.php?ses=<?php echo $ses ?>&jump=time'">Time Zone</div><?php endif; ?>
			<div class="op_submenu" onClick="location.href='interface_lang.php?ses=<?php echo $ses ?>'" id="menu_lang">Language Text</div>
			<div class="op_submenu" onClick="location.href='interface.php?ses=<?php echo $ses ?>&jump=misc_settings'">Settings</div>
			<div class="op_submenu" onClick="location.href='interface.php?ses=<?php echo $ses ?>&jump=screen'">Login Screen</div>
			<div style="clear: both"></div>
		</div>

		<form method="POST" action="interface_op_pics.php?submit" enctype="multipart/form-data">
		<input type="hidden" name="action" value="update">
		<input type="hidden" name="opid" value="<?php echo $opid ?>">
		<input type="hidden" name="ses" value="<?php echo $ses ?>">
		<input type="hidden" name="MAX_FILE_SIZE" value="20000">

		<div style="margin-top: 25px;" id="div_op_pics">
			The "Global Default" profile picture will be utilized until a new picture has been uploaded for the operator.  Browse available <a href="http://www.phplivesupport.com/r.php?r=avatars" target="_blank">profile picture avatars</a>.

			<?php if ( count( $operators ) > 0 ): ?>
			<div style="margin-top: 25px;">
				<select id="select_ops" style="font-size: 16px; background: #D4FFD4; color: #009000;" OnChange="switch_op()"><option value="0">Global Default (<?php echo ( $profile_pic_onoff_default ) ? "on" : "off" ; ?>)</option>
				<?php
					for ( $c = 0; $c < count( $operators ); ++$c )
					{
						$operator = $operators[$c] ;
						$selected = "" ;
						if ( $opid == $operator["opID"] )
						{
							$selected = "selected" ;
							$op_name = $operator["name"] ;
						}
						$p_onoff = ( $operator["pic"] == 1 ) ? "on" : "off" ;
						print "<option value=\"$operator[opID]\" $selected>$operator[name] ($p_onoff)</option>" ;
					}
				?>
				</select>

				<div style="margin-top: 15px;">
					<div style="font-size: 14px;" class="info_box">
						<table cellspacing=0 cellpadding=0 border=0>
						<tr>
							<td style="padding-right: 15px;">
								<div style="text-shadow: none;">
									<div class="info_good" style="float: left; width: 60px; padding: 3px;"><input type="radio" name="profile_pic_onoff" id="profile_pic_on" value="1" onClick="update_profile_pic_onoff(1)" <?php echo ( $profile_pic_onoff ) ? "checked" : "" ?> > On</div>
									<div class="info_error" style="float: left; margin-left: 10px; width: 60px; padding: 3px;"><input type="radio" name="profile_pic_onoff" id="profile_picoff" value="0" onClick="update_profile_pic_onoff(0)" <?php echo ( !$profile_pic_onoff ) ? "checked" : "" ?> > Off</div>
									<div style="clear: both;"></div>
								</div>
							</td>
							<td><div id="div_info_title">Profile picture for <span id="span_dept_name" style="font-size: 18px; font-weight: bold;"><?php echo ( isset( $opinfo["name"] ) ) ? "<a href=\"ops.php?ses=$ses\">".$opinfo["name"]."</a>" : "Global Default" ; ?></span></div></td>
						</tr>
						</table>
						<?php if ( $opid && $opinfo["pic"] && !$profile_pic_onoff_default ): ?>
						<div style="font-size: 12px; margin-top: 10px; text-shadow: none;" class="info_error"><img src="../pics/icons/warning.png" width="12" height="12" border="0" alt=""> Operator's profile picture <b>will not be displayed</b> on the <b>visitor chat window</b> because the "<a href="interface_op_pics.php?ses=<?php echo $ses ?>" style="color: #FFFFFF;">Global Default</a>" setting is Off.</div>
						<?php elseif ( !$opid ): ?>
						<div style="font-size: 12px; margin-top: 10px;"><img src="../pics/icons/info.png" width="12" height="12" border="0" alt=""> Global Default <b>"On"</b> will enable displaying of the operator profile picture on the visitor chat window (on/off setting for each operator).</div>
						<div style="font-size: 12px; margin-top: 5px;"><img src="../pics/icons/info.png" width="12" height="12" border="0" alt=""> Global Default <b>"Off"</b> will switch off the displaying of the operator profile picture on the visitor chat window (overrides operator setting).</div>
						<?php endif ; ?>
						<div style="font-size: 12px; margin-top: 5px;"><img src="../pics/icons/info.png" width="12" height="12" border="0" alt=""> Operator profile pictures are <b>always</b> visible to other operators.</div>
					</div>

					<div id="div_alert" style="display: none; margin-top: 15px; margin-bottom: 25px;"></div>
					<div style="margin-top: 15px;">
						<input type="file" name="profile" size="30"><p>
						<input type="submit" value="Upload Image" style="margin-top: 10px;" class="btn">
					</div>

					<div style="margin-top: 15px;"><img src="../pics/icons/info.png" width="12" height="12" border="0" alt=""> Profile image size should be <b>55 pixels width</b> and <b>55 pixels height</b>.  The image will be automatcially scaled to fit the dimensions.</div>
					<div id="div_profile" style="margin-top: 25px;"><img src="<?php print Util_Upload_GetLogo( "profile", $opid ) ?>" width="55" height="55" border=0 style="border: 1px solid #DFDFDF;" class="round"></div>

					<?php if ( $opid && ( Util_Upload_GetLogo( "profile", 0 ) != Util_Upload_GetLogo( "profile", $opid ) ) ): ?>
					<div style="margin-top: 15px;"><img src="../pics/icons/reset.png" width="16" height="16" border="0" alt=""> <a href="JavaScript:void(0)" onClick="confirm_clear()">clear operator profile picture and use Global Default image</a></div>
					<?php elseif ( $opid ): ?>
					<div style="margin-top: 15px;"><img src="../pics/icons/themes.png" width="16" height="16" border="0" alt=""> currently using <a href="interface_op_pics.php?ses=<?php echo $ses ?>">Global Default</a> image</div>
					<?php endif ; ?>
				</div>
			</div>
			<?php else: ?>
			<div style="margin-top: 25px;"><span class="info_error"><img src="../pics/icons/warning.png" width="12" height="12" border="0" alt=""> Create an <a href="ops.php?ses=<?php echo $ses ?>" style="color: #FFFFFF;">Operator</a> to continue.</span></div>
			<?php endif ; ?>
		</div>
		</form>

<?php include_once( "./inc_footer.php" ) ?>

