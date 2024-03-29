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

	include_once( "$CONF[DOCUMENT_ROOT]/API/Footprints/get_ext.php" ) ;

	$action = Util_Format_Sanatize( Util_Format_GetVar( "action" ), "ln" ) ;
	$statu = Util_Format_Sanatize( Util_Format_GetVar( "statu" ), "n" ) ;
	$jump = ( Util_Format_Sanatize( Util_Format_GetVar( "jump" ), "ln" ) ) ? Util_Format_Sanatize( Util_Format_GetVar( "jump" ), "ln" ) : "main" ;

	if ( !isset( $CONF["foot_log"] ) ) { $CONF["foot_log"] = "on" ; }
	if ( !isset( $CONF["icon_check"] ) ) { $CONF["icon_check"] = "on" ; }

	$footprint_off = ( $CONF["foot_log"] == "off" ) ? "checked" : "" ;
	$footprint_on = ( $footprint_off == "checked" ) ? "" : "checked" ;
	$icon_check_off = ( $CONF["icon_check"] == "off" ) ? "checked" : "" ;
	$icon_check_on = ( $icon_check_off == "checked" ) ? "" : "checked" ;

	if ( !$statu ) { $statu = time() ; }
	$m = date( "m", $statu ) ;
	$d = date( "j", $statu ) ;
	$y = date( "Y", $statu ) ;

	$today = mktime( 0, 0, 1, $m, $d, $y ) ;
	$stat_start = mktime( 0, 0, 1, $m, 1, $y ) ;
	$stat_end = mktime( 0, 0, 1, $m+1, 0, $y ) ;
	$stat_end_day = date( "j", $stat_end ) ;

	$footprints_timespan = Array() ;
	if ( $CONF["foot_log"] == "on" )
		$footprints_timespan = Footprints_get_ext_FootprintsRangeHash( $dbh, $stat_start, $stat_end ) ;

	$month_max = $month_total_footprints = 0 ;
	$month_max_expand = "" ;
	foreach ( $footprints_timespan as $key => $value )
	{
		if ( $value["total"] > $month_max )
		{
			$month_max = $value["total"] ;
			$month_max_expand = date( "D, M j, Y", $key ) ;
		}
		$month_total_footprints += $value["total"] ;
	}
	$month_ave = floor( $month_total_footprints/$stat_end_day ) ;
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
	var global_foot_log = "<?php echo $CONF["foot_log"] ?>" ;
	var global_icon_check = "<?php echo $CONF["icon_check"] ?>" ;

	$(document).ready(function()
	{
		$("body").css({'background': '#8DB26C'}) ;

		init_menu() ;
		toggle_menu_setup( "rtraffic" ) ;
		show_div( "<?php echo $jump ?>" ) ;

		$('#stat_day_expand').html( "Select a day from above to expand" ) ;
	});

	function show_div( thediv )
	{
		$('#div_alert').hide() ;
	
		var divs = Array( "main", "settings" ) ;
		for ( var c = 0; c < divs.length; ++c )
		{
			$('#foot_'+divs[c]).hide() ;
			$('#menu_foot_'+divs[c]).removeClass('op_submenu_focus').addClass('op_submenu') ;
		}

		$('#foot_'+thediv).show() ;
		$('#menu_foot_'+thediv).removeClass('op_submenu').addClass('op_submenu_focus') ;
	}

	function select_date( theunix, thedayexpand, thetotal )
	{
		<?php if ( $CONF["foot_log"] == "on" ): ?>
		$('#stat_day_expand').html( thedayexpand+" <span class=\"info_box\" style=\"font-size: 14px; font-weight: normal;\">Total Footprints: "+thetotal+"</span>" ) ;

		$.ajax({
			type: "POST",
			url: "../ajax/setup_actions_reports.php",
			data: "ses=<?php echo $ses ?>&action=footprints&sdate="+theunix+"&"+unixtime(),
			success: function(data){
				eval( data ) ;

				if ( json_data.status )
				{
					var footprints_string = "<table cellspacing=0 cellpadding=0 border=0 width=\"100%\">" ;
					for ( var c = 0; c < json_data.footprints.length; ++c )
					{
						total = json_data.footprints[c].total ;
						url_snap = json_data.footprints[c].url_snap ;
						url_raw = json_data.footprints[c].url_raw ;

						var td1 = "td_dept_td" ;

						if ( url_raw == "livechatimagelink" )
						{
							url_raw = "JavaScript:void(0)" ;
							url_snap = "Live Chat Image Link" ;
						}
						footprints_string += "<tr><td class=\""+td1+"\" width=\"16\">"+total+"</td><td class=\""+td1+"\" width=\"100%\"><a href=\""+url_raw+"\" target=\"_blank\" style=\"text-decoration: none;\">"+url_snap+"</a></td></tr>" ;
					}
					if ( !c )
						footprints_string += "<tr><td class=\"td_dept_td\" colspan=2>Blank results.</td></tr>" ;

					footprints_string += "</table>" ;
				}
				$('#dynamic_footprints').html( footprints_string ) ;
			}
		});
		<?php endif ; ?>
	}

	function update_foot_log( theflag )
	{
		if ( global_foot_log != theflag )
		{
			$.ajax({
				type: "POST",
				url: "../ajax/setup_actions.php",
				data: "ses=<?php echo $ses ?>&action=update_foot_settings&option=foot_settings&value="+theflag+"&"+unixtime(),
				success: function(data){
					global_foot_log = theflag ;
					do_alert( 1, "Success!" ) ;
				}
			});
		}
	}

	function update_icon_check( theflag )
	{
		if ( global_icon_check != theflag )
		{
			$.ajax({
				type: "POST",
				url: "../ajax/setup_actions.php",
				data: "ses=<?php echo $ses ?>&action=update_foot_settings&option=foot_icon&value="+theflag+"&"+unixtime(),
				success: function(data){
					global_icon_check = theflag ;
					do_alert( 1, "Success!" ) ;
				}
			});
		}
	}

//-->
</script>
</head>
<?php include_once( "./inc_header.php" ) ?>

		<div class="op_submenu_wrapper">
			<div class="op_submenu_focus" id="menu_foot_main" onClick="show_div('main')">Website Footprints</div>
			<div class="op_submenu" onClick="location.href='reports_refer.php?ses=<?php echo $ses ?>'">Refer URLs</div>
			<div class="op_submenu" id="menu_foot_settings" onClick="show_div('settings')">Settings</div>
			<div style="clear: both"></div>
		</div>

		<div id="foot_main">
			
			<div class="info_neutral" style="text-shadow: none; margin-top: 25px;">
				<table cellspacing=0 cellpadding=0 border=0>
				<tr>
					<td><img src="../pics/icons/info.png" width="12" height="12" border="0" alt=""></td>
					<td style="padding-left: 10px; text-align: justify;">
						On pages that have the <a href="code.php?ses=<?php echo $ses ?>">Standard HTML Code</a>, the system will track the visitor's footprint data as they navigate from page to page.  To conserve server resources and to optimize system response, the footprint stats data is stored for maximum of <b><?php echo $VARS_FOOTPRINT_STATS_EXPIRE ?> days</b>.  Reports greater then <b><?php echo $VARS_FOOTPRINT_STATS_EXPIRE ?> days</b> will be automatically cleared.  It is recommended to utilize a traffic statistics tool such as <a href="http://www.google.com/analytics/" target="_blank">Google Analytics</a> for a detailed website traffic information.
						<div style="margin-top: 10px;">To further conserve server resources, the <a href="JavaScript:void(0)" onClick="show_div('settings')">footprint tracking can be switched off altogether</a>.</div>
					</td>
				</tr>
				</table>
			</div>

			<table cellspacing=0 cellpadding=0 border=0 width="100%" style="margin-top: 25px;">
			<tr>
				<td><div class="td_dept_header">Timeline</div></td>
				<td width="80"><div class="td_dept_header">Total</div></td>
			</tr>
			<tr>
				<td class="td_dept_td">
					<select onChange="location.href='reports_traffic.php?ses=<?php echo $ses ?>&statu='+this.value">
					<?php
						$now = time() ;
						$now_expire = $now - (60*60*24*$VARS_FOOTPRINT_STATS_EXPIRE) ;
						$start_month = date( "m", $now ) ; $end_month = date( "m", $now_expire ) ;
						$start_year = date( "Y", $now ) ; $end_year = date( "Y", $now_expire ) ;
						if ( $start_year == $end_year ) { $diff_month = $start_month - $end_month ; }
						else { $diff_month = ( $start_month + 12 ) - $end_month ; }
						for ( $c = 0; $c <= $diff_month; ++$c )
						{
							$stat_unixtime = mktime( 0, 0, 1, date( "m", $now_expire )+$c, date( "j", $now_expire ), date( "Y", $now_expire ) ) ;
							$this_month = date( "m", $stat_unixtime ) ;
							$stat_expand = date( "F Y", $stat_unixtime ) ;

							$selected = ( $this_month == $m ) ? "selected" : "" ;
							print "<option value=\"$stat_unixtime\" $selected>$stat_expand</option>" ;
						}
					?>
					</select>
				</td>
				<td class="td_dept_td"><?php echo $month_total_footprints ?></td>
			</tr>
			</table>

			<div style="margin-top: 25px; width: 100%;">
				<table cellspacing=0 cellpadding=0 border=0 style="height: 100px; width: 100%;">
				<tr>
					<?php
						$tooltips = Array() ;
						for ( $c = 1; $c <= $stat_end_day; ++$c )
						{
							$stat_day = mktime( 0, 0, 1, $m, $c, $y ) ;
							$stat_day_expand = date( "l, M j, Y", $stat_day ) ;

							$total = 0 ;
							$h1 = "0px" ; $meter = "meter_v_blue.gif" ;
							$tooltip = "$stat_day_expand" ;
							$tooltips[$stat_day] = $tooltip ;
							$tooltip_display = "" ;
							if ( isset( $footprints_timespan[$stat_day] ) )
							{
								$total = $footprints_timespan[$stat_day]["total"] ;
								$tooltip_display = "$stat_day_expand (Total: $total)" ;
								if ( $month_max )
									$h1 = round( ( $footprints_timespan[$stat_day]["total"]/$month_max ) * 100 ) . "px" ;
							}
							else if ( ( $c == $stat_end_day ) && ( !$month_max ) )
							{
								$h1 = "100px" ;
								$meter = "meter_v_clear.gif" ;
							}

							print "
								<td valign=\"bottom\" width=\"2%\"><div id=\"bar_v_requests_$c\" title=\"$tooltip_display\" alt=\"$tooltip_display\" style=\"height: $h1; background: url( ../pics/meters/$meter ) repeat-y; border-top-left-radius: 5px 5px; -moz-border-radius-topleft: 5px 5px; border-top-right-radius: 5px 5px; -moz-border-radius-topright: 5px 5px; cursor: pointer;\" OnMouseOver=\"\" OnClick=\"select_date( $stat_day, '$stat_day_expand', $total );\"></div></td>
								<td><img src=\"../pics/space.gif\" width=\"5\" height=1></td>
							" ;
						}
					?>
				</tr>
				<tr>
					<?php
						for ( $c = 1; $c <= $stat_end_day; ++$c )
						{
							$stat_day = mktime( 0, 0, 1, $m, $c, $y ) ;
							$stat_day_expand = date( "l, M j, Y", $stat_day ) ;
							$total = 0 ;
							if ( isset( $footprints_timespan[$stat_day] ) ) { $total = $footprints_timespan[$stat_day]["total"] ; }
							print "
								<td align=\"center\"><div id=\"requests_bg_day\" OnMouseOver=\"\" OnClick=\"select_date( $stat_day, '$stat_day_expand', $total );\" class=\"page_report\" style=\"margin: 0px; font-size: 10px; font-weight: bold;\" title=\"$tooltips[$stat_day]\" id=\"$tooltips[$stat_day]\">$c</div></td>
								<td><img src=\"../pics/space.gif\" width=\"5\" height=1></td>
							" ;
						}
					?>
				</tr>
				</table>
			</div>

			<div id="overview_day_chart" style="margin-top: 50px;">
				<div id="overview_date_title"><div id="stat_day_expand"></div></div>
				<div id="overview_data_container">
					<table cellspacing=0 cellpadding=0 border=0 width="100%">
					<tr>
						<td><div class="td_dept_header">Top 100 Footprints</div></td>
					</tr>
					<tr>
						<td><div style="min-height: 300px; max-height: 350px; overflow: auto;">
						<div id="dynamic_footprints">
							<?php if ( $CONF["foot_log"] != "on" ): ?>
							<div class="td_dept_td">Footprints are <a href="JavaScript:void(0)" onClick="show_div('foot_settings')">Off</a>.</div>
							<?php endif ; ?>
						</div>
						</div></td>
					</tr>
					</table>
				</div>
			</div>
		</div>

		<div id="foot_settings">
			
			<div style="margin-top: 25px;" class="info_info">
				<div style="font-size: 14px; font-weight: bold;"><a name="footprints">Visitor Footprint Tracking</a></div>
				
				<div style="margin-top: 15px;">
					(default is On) On pages that have the <a href="code.php?ses=<?php echo $ses ?>">Standard HTML Code</a>, the system will track the visitor's footprint data as they navigate from page to page.  At times, you may want to pause footprints logging altogether.  If you utilize <a href="http://www.google.com/analytics/" target="_blank">Google Analytics</a> or other third-party website traffic stat services, switching off the footprint logging will ensure no additional server resources are being consumed for redundant data.
					
					<div class="info_neutral" style="margin-top: 10px;">
						<ul>
							<li> <b>Off</b> will pause all tracking and logging of visitor footprint data to the database.
							<li> <b>Off</b> will hide all footprint instances throughout the operator console.  (example: visitor "footprint" tab will not be visible on the operator console)
							<li> <b>Off</b> will not effect the operator console real-time traffic monitor.
						</ul>
					</div>
				</div>

				<div style="margin-top: 25px;">
					<div class="info_good" style="float: left; width: 60px; padding: 3px;"><input type="radio" name="r_foot_settings" id="r_foot_settings_on" value="on" onClick="update_foot_log('on')" <?php echo $footprint_on ?>> On</div>
					<div class="info_error" style="float: left; margin-left: 10px; width: 60px; padding: 3px;"><input type="radio" name="r_foot_settings" id="r_foot_settings_off" value="off" onClick="update_foot_log('off')" <?php echo $footprint_off ?>> Off</div>
					<div style="clear: both;"></div>
				</div>
			</div>

			<div style="margin-top: 15px;" class="info_info">
				<div style="font-size: 14px; font-weight: bold;">Chat Icon Status Check</div>

				<div style="margin-top: 15px;">
					(default is On) During the duration the visitor is viewing a webpage, the system will regularly ping the server to update and gather various information to process few features (onlin/offline chat status, automatic chat invitation, operator initiated chat).  The resource usage of the requests are minimal and takes milliseconds to process.  But the communication is in regular intervals.  To optimize server resources for high traffic websites, an option to pause the periodic requests can be set.  
					
					<div class="info_neutral" style="margin-top: 10px;">
						<ul>
							<li> <b>Off</b> will pause the real-time chat icon online/offline status.  Chat icon will not automatically refresh to online/offline while the visitor is on the same page.
							<li> <b>Off</b> will switch off the <a href="code.php?ses=<?php echo $ses ?>&jump=auto">automatic chat invite</a> feature due to pausing of the periodic communication to the server.
							<li> <b>Off</b> will switch off the operator initiate chat feature from the operator console due to pausing of the periodic communication to the server.
						</ul>
					</div>
				</div>

				<div style="margin-top: 25px;">
					<div class="info_good" style="float: left; width: 60px; padding: 3px;"><input type="radio" name="r_foot_icon" id="r_foot_icon_on" value="on" onClick="update_icon_check('on')" <?php echo $icon_check_on ?>> On</div>
					<div class="info_error" style="float: left; margin-left: 10px; width: 60px; padding: 3px;"><input type="radio" name="r_foot_icon" id="r_foot_icon_off" value="off" onClick="update_icon_check('off')" <?php echo $icon_check_off ?>> Off</div>
					<div style="clear: both;"></div>
				</div>
			</div>

		</div>

<?php include_once( "./inc_footer.php" ) ?>

