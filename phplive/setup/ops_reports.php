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
	include_once( "$CONF[DOCUMENT_ROOT]/API/Util_Security.php" ) ;
	$ses = Util_Format_Sanatize( Util_Format_GetVar( "ses" ), "ln" ) ;
	if ( !$admininfo = Util_Security_AuthSetup( $dbh, $ses ) ){ ErrorHandler( 608, "Invalid setup session or session has expired.", $PHPLIVE_FULLURL, 0, Array() ) ; }
	// STANDARD header end
	/****************************************/

	$error = "" ;

	include_once( "$CONF[DOCUMENT_ROOT]/API/Ops/get.php" ) ;
	include_once( "$CONF[DOCUMENT_ROOT]/API/Ops/update_itr.php" ) ;
	include_once( "$CONF[DOCUMENT_ROOT]/API/Depts/get.php" ) ;
	include_once( "$CONF[DOCUMENT_ROOT]/API/Chat/get_ext.php" ) ;

	$action = Util_Format_Sanatize( Util_Format_GetVar( "action" ), "ln" ) ;
	$opid = Util_Format_Sanatize( Util_Format_GetVar( "opid" ), "ln" ) ;
	$m = Util_Format_Sanatize( Util_Format_GetVar( "m" ), "ln" ) ;
	$d = Util_Format_Sanatize( Util_Format_GetVar( "d" ), "ln" ) ;
	$y = Util_Format_Sanatize( Util_Format_GetVar( "y" ), "ln" ) ;

	if ( !$m )
		$m = date( "m", time() ) ;
	if ( !$d )
		$d = date( "j", time() ) ;
	if ( !$y )
		$y = date( "Y", time() ) ;

	$stat_end = mktime( 0, 0, 1, $m+1, 0, $y ) ;
	$stat_end_day = date( "j", $stat_end ) ;

	$op_name = $error = "" ;

	if ( $action == "search" )
		$error = "" ;
	else
		$error = "invalid action" ;

	Ops_update_itr_IdleOps( $dbh ) ;
	$operators = Ops_get_AllOps( $dbh ) ;
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

<script type="text/javascript">
<!--
	$(document).ready(function()
	{
		$("body").css({'background': '#8DB26C'}) ;

		init_menu() ;
		toggle_menu_setup( "ops" ) ;
		switch_op() ;

		<?php if ( ( $action == "submit" ) && !$error ): ?>do_alert( 1, "Success" ) ;<?php endif ; ?>
	});

	function switch_op()
	{
		$('#cal_opid').val( $('#select_ops').val() ) ;
	}
//-->
</script>
</head>
<?php include_once( "./inc_header.php" ) ?>

		<div class="op_submenu_wrapper">
			<div class="op_submenu" onClick="location.href='ops.php?ses=<?php echo $ses ?>&jump=main'" id="menu_ops_main">Operators</div>
			<div class="op_submenu" onClick="location.href='ops.php?ses=<?php echo $ses ?>&jump=assign'" id="menu_ops_assign">Assign Operator to Department</div>
			<div class="op_submenu_focus" id="menu_ops_report">Online Activity</div>
			<div class="op_submenu" onClick="location.href='ops.php?ses=<?php echo $ses ?>&jump=monitor'" id="menu_ops_monitor">Operator Status Widget</div>
			<div class="op_submenu" onClick="location.href='ops.php?ses=<?php echo $ses ?>&jump=online'" id="menu_ops_online"><img src="../pics/icons/bulb.png" width="12" height="12" border="0" alt=""> Go ONLINE!</div>
			<div style="clear: both"></div>
		</div>

		<div style="margin-top: 25px;" id="ops_monitor">
			Online/Offline activity report. The display output are for days with online activities only.
			<div style="margin-top: 15px;"><b>Note:</b> If there is an <img src="../pics/icons/online_green.png" width="12" height="12" border="0" alt=""> Online status right after another Online status, it may be because the operator has updated a setting (example: theme, sound).  When certain settings are updated, the operator console will need to refresh in order to process the request. The refresh of the operator console will trigger an Online status.</div>

			<?php if ( count( $operators ) > 0 ): ?>
			<div style="margin-top: 25px;">
				<table cellspacing=0 cellpadding=0 border=0>
				<tr>
					<td valign="top" nowrap>
						<select id="select_ops" style="font-size: 16px; background: #D4FFD4; color: #009000;" OnChange="switch_op()">
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
								print "<option value=\"$operator[opID]\" $selected>$operator[name]</option>" ;
							}
						?>
						</select>
					</td>
					<td style="padding-left: 15px;"><div><?php include_once( "./inc_select_cal.php" ) ; ?></div></td>
				</tr>
				</table>
			</div>

			<div style="margin-top: 25px;">
				<div id="reports">
					<?php
						$overall_duration = null ;
						for ( $c = 1; $c <= $stat_end_day; ++$c )
						{
							$stat_day = mktime( 0, 0, 0, $m, $c, $y ) ;
							$stat_day_expand = date( "D M j", mktime( 0, 0, 0, $m, $c, $y ) ) ;

							$stat_start = mktime( 0, 0, 0, $m, $c, $y ) ;
							$stat_end = mktime( 23, 60, 60, $m, $c, $y ) ;

							$reports = Chat_ext_get_OpStatusLog( $dbh, $opid, $stat_start, $stat_end ) ;

							$output = "" ;
							if ( count( $reports ) > 0 )
							{
								$prev_created = $total_duration = 0 ;
								for( $c2 = 0; $c2 < count( $reports ) ; ++$c2 )
								{
									$report = $reports[$c2] ;

									$diff = 0 ;
									$created = $report["created"] ;
									$created_expand = date( "M j (g:i a)", $created ) ;
									$status_text = ( $report["status"] ) ? "Online" : "Offline" ;
									$mapp_online_icon = ( $report["status"] && $report["mapp"] ) ? " &nbsp; <img src=\"../pics/icons/mobile.png\" width=\"16\" height=\"16\" border=\"0\" alt=\"logged in on mobile\" title=\"logged in on mobile\" style=\"cursor: help;\">" : "" ;

									if ( $report["status"] && !$prev_created )
										$prev_created = $created ;
									else if ( !$report["status"] && !$prev_created && !$c2 && $overall_duration )
									{
										// is online from previous day
										$created_ = mktime( 0, 0, 0, date( "m", $created ), date( "j", $created ), date( "Y", $created ) ) ;
										$created_expand_ = date( "M j (g:i a)", $created_ ) ;
										$total_duration += $created - $created_ ;

										$output .= "<div class=\"td_dept_td\"><img src=\"../pics/icons/online_green.png\" width=\"12\" height=\"12\" border=\"0\" alt=\"\"> <span style=\"padding-left: 25px;\">$created_expand_</span></div>" ;
									}
									else if ( !$report["status"] && $prev_created )
									{
										$diff = $report["created"] - $prev_created ;
										$total_duration += $diff ;
										$prev_created = 0 ;
									}

									$class = "td_dept_td" ;
									$status = ( $report["status"] ) ? "<img src=\"../pics/icons/online_green.png\" width=\"12\" height=\"12\" border=\"0\" alt=\"\">" : "<img src=\"../pics/icons/online_grey.png\" width=\"12\" height=\"12\" border=\"0\" alt=\"\">" ;

									$output .= "<div class=\"$class\">$status <span style=\"padding-left: 25px;\">$created_expand <small>- $status_text</small>$mapp_online_icon</span></div>" ;
								}

								if ( $prev_created )
								{
									$now = time() ;
									$diff = $now - $prev_created ;

									if ( date( "j", ( $diff + $now ) ) != date( "j", $now ) )
									{
										// when the online time goes past the end of the day
										$total_duration += mktime( 0, 0, 0, $m,date( "j", $prev_created )+1, $y ) - $prev_created ;
									}
									else
										$total_duration += $diff ;
								}

								if ( $total_duration && ( $total_duration < 60 ) )
									$total_duration = 60 ;

								$overall_duration += $total_duration ;
								$duration = Util_Format_Duration( $total_duration ) ;

								print "<div style=\"margin-bottom: 5px; float: left; width: 33%;\"><div class=\"td_dept_header\"><table cellspacing=0 cellpadding=0 border=0 width=\"100%\"><tr><td nowrap>$stat_day_expand</td><td style=\"font-weight: normal; padding-left: 10px;\" width=\"100%\"><span class=\"info_neutral\" style=\"text-shadow: none;\">duration online: $duration</span></td></tr></table></div><div id=\"stat_$c\" style=\"height: 100px; overflow: auto;\">$output</div></div>" ;
							}
						}
						if ( !is_null( $overall_duration ) )
							print "<div style=\"clear: both;\"></div>" ;
						else if ( $op_name )
							print "<div style=\"\">Blank results.</div>" ;

						$duration = Util_Format_Duration( $overall_duration ) ;
						$month = date( "F", $stat_start ) ;
						$year = date( "Y", $stat_start ) ;
						
						if ( $op_name ) { print "<div style=\"margin-top: 15px;\"><table cellspacing=0 cellpadding=0 border=0><tr><td nowrap><div style=\"\">Total duration online </div></td><td style=\"font-weight: normal; padding-left: 15px;\"><span class=\"info_good\">$duration</span></td></tr></table></div>" ; }
					?>

				</div>
			</div>
			<?php else: ?>
			<div style="margin-top: 25px;"><span class="info_error"><img src="../pics/icons/warning.png" width="12" height="12" border="0" alt=""> Create an <a href="ops.php?ses=<?php echo $ses ?>" style="color: #FFFFFF;">Operator</a> to continue.</span></div>
			<?php endif ; ?>
		</div>

<?php include_once( "./inc_footer.php" ) ?>

