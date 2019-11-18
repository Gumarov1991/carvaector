<?php
	$NO_CACHE = 1 ; include_once( "../inc_cache.php" ) ;
	/* status DB request: -1 ended by action taken, 0 waiting pick-up, 1 picked up, 2 transfer */
	$microtime = ( function_exists( "gettimeofday" ) ) ? 1 : 0 ;
	$process_start = ( $microtime ) ? microtime(true) : time() ;
	include_once( "../web/config.php" ) ;
	include_once( "$CONF[DOCUMENT_ROOT]/API/Util_Format.php" ) ;

	$action = Util_Format_Sanatize( Util_Format_GetVar( "a" ), "ln" ) ;
	if ( !isset( $CONF['foot_log'] ) ) { $CONF['foot_log'] = "on" ; }
	if ( !isset( $CONF['icon_check'] ) ) { $CONF['icon_check'] = "on" ; }
	if ( $action == "rq" )
	{
		if ( !isset( $_COOKIE["phplive_opID"] ) || !$_COOKIE["phplive_opID"] )
			$json_data = "json_data = { \"status\": -1 };" ;
		else
		{
			include_once( "$CONF[DOCUMENT_ROOT]/API/".Util_Format_Sanatize($CONF["SQLTYPE"], "ln") ) ;
			include_once( "$CONF[DOCUMENT_ROOT]/API/Chat/Util.php" ) ;
			include_once( "$CONF[DOCUMENT_ROOT]/API/Footprints/get_itr.php" ) ;

			$now = time() ;
			$opid = Util_Format_Sanatize( $_COOKIE["phplive_opID"], "n" ) ;
			$prev_status = Util_Format_Sanatize( Util_Format_GetVar( "ps" ), "ln" ) ;
			$c_requesting = Util_Format_Sanatize( Util_Format_GetVar( "cr" ), "ln" ) ;
			$traffic = Util_Format_Sanatize( Util_Format_GetVar( "t" ), "ln" ) ;
			$q_ces = Util_Format_Sanatize( Util_Format_GetVar( "qc" ), "a" ) ;
			$q_ces_hash = Array() ;

			for ( $c = 0; $c < count( $q_ces ); ++$c ) { $ces = $q_ces[$c] ; $q_ces_hash[$ces] = 1 ; }
			if ( !( $c_requesting % $VARS_CYCLE_CLEAN ) )
			{
				$vars = Util_Format_Get_Vars( $dbh ) ;
				if ( $vars["ts_clean"] <= ( $now - ( $VARS_CYCLE_CLEAN * 2 ) ) )
				{
					include_once( "$CONF[DOCUMENT_ROOT]/API/Chat/remove_itr.php" ) ;
					include_once( "$CONF[DOCUMENT_ROOT]/API/Footprints/remove_itr.php" ) ;
					include_once( "$CONF[DOCUMENT_ROOT]/API/Ops/update_itr.php" ) ;

					Util_Format_Update_TimeStamp( $dbh, "clean", $now ) ;
					Footprints_remove_itr_Expired_U( $dbh ) ;
					Chat_remove_itr_ExpiredOp2OpRequests( $dbh ) ;
					Chat_remove_itr_OldRequests( $dbh ) ;
					Ops_update_itr_IdleOps( $dbh ) ;
				}
			}
			else if ( !( $c_requesting % ($VARS_CYCLE_CLEAN+1) ) )
			{
				$query = "UPDATE p_operators SET lastactive = $now WHERE opID = $opid" ;
				database_mysql_query( $dbh, $query ) ;
				$query = "UPDATE p_requests SET updated = $now WHERE ( opID = $opid OR op2op = $opid OR opID = 1111111111 ) AND ( status >= 0 AND status <= 2 )" ;
				database_mysql_query( $dbh, $query ) ;
			}

			$total_traffics = ( $traffic && ( $CONF['icon_check'] == "on" ) ) ? Footprints_get_itr_TotalFootprints_U( $dbh ) : 0 ;
			$query = "SELECT * FROM p_requests WHERE ( opID = $opid OR op2op = $opid OR opID = 1111111111 ) AND ( status >= 0 AND status <= 2 ) ORDER BY created ASC" ;
			database_mysql_query( $dbh, $query ) ;

			$requests_temp = Array() ;
			if ( $dbh[ 'ok' ] )
			{
				while ( $data = database_mysql_fetchrow( $dbh ) ) { $requests_temp[] = $data ; }
			} $requests = Array() ;
			for ( $c = 0; $c < count( $requests_temp ); ++$c )
			{
				$data = $requests_temp[$c] ;
				if ( ( $data["status"] == 2 ) && ( $data["op2op"] == $opid ) )
				{
					if ( $data["tupdated"] < ( time() - $VARS_TRANSFER_BACK ) )
						include_once( "$CONF[DOCUMENT_ROOT]/ops/inc_chat_transfer.php" ) ;
				}
				else
				{
					// sim ops filter for declined
					if ( !preg_match( "/(^|-)($opid-)/", $data["sim_ops_"] ) ) { $requests[] = $data ; }
				}
			}
			$json_data = "json_data = { \"status\": 1, \"traffics\": $total_traffics, \"requests\": [  " ;
			for ( $c = 0; $c < count( $requests ); ++$c )
			{
				$req = $requests[$c] ;
				$os = $VARS_OS[$req["os"]] ;
				$browser = $VARS_BROWSER[$req["browser"]] ;
				$title = preg_replace( "/\"/", "&quot;", $req["title"] ) ;
				$question = preg_replace( "/(\r\n)|(\n)|(\r)/", "<br>", preg_replace( "/\"/", "&quot;", $req["question"] ) ) ;
				$onpage = preg_replace( "/hphp/i", "http", $req["onpage"] ) ;
				$refer_raw = preg_replace( "/hphp/i", "http", $req["refer"] ) ;
				$refer_snap = ( strlen( $refer_raw ) > 50 ) ? substr( $refer_raw, 0, 45 ) . "..." : $refer_raw ;
				$custom = $req["custom"] ;

				// if status is 2 then it's a transfer call... keep original visitor name
				if ( ( $req["status"] != 2 ) && $req["op2op"] )
				{
					include_once( "$CONF[DOCUMENT_ROOT]/API/Ops/get.php" ) ;

					if ( $opid == $req["op2op"] ) { $opinfo = Ops_get_OpInfoByID( $dbh, $req["opID"] ) ; }
					else { $opinfo = Ops_get_OpInfoByID( $dbh, $req["op2op"] ) ; }
					$vname = $opinfo["name"] ; $vemail = $opinfo["email"] ;
				}
				else { $vname = $req["vname"] ; $vemail = $req["vemail"] ; }

				if ( ( $req["status"] == 1 ) && ( $req["opID"] == 1111111111 ) )
				{
					$req["status"] = 0 ;
					$query = "UPDATE p_requests SET status = 0 WHERE requestID = $req[requestID]" ;
					database_mysql_query( $dbh, $query ) ;
				}

				if ( isset( $q_ces_hash[$req["ces"]] ) )
					$json_data .= "{ \"rid\": $req[requestID], \"ces\": \"$req[ces]\", \"did\": $req[deptID], \"tv\": $req[t_vses], \"status\": $req[status] }," ;
				else
					$json_data .= "{ \"rid\": $req[requestID], \"ces\": \"$req[ces]\", \"created\": \"$req[created]\", \"did\": $req[deptID], \"opid\": $req[opID], \"op2op\": $req[op2op], \"tv\": $req[t_vses], \"vname\": \"$vname\", \"status\": $req[status], \"auto_pop\": $req[auto_pop], \"initiated\": $req[initiated], \"os\": \"$os\", \"browser\": \"$browser\", \"requests\": \"$req[requests]\", \"resolution\": \"$req[resolution]\", \"vemail\": \"$vemail\", \"ip\": \"$req[ip]\", \"vis_token\": \"$req[md5_vis_]\", \"onpage\": \"$onpage\", \"title\": \"$title\", \"question\": \"$question\", \"marketid\": \"$req[marketID]\", \"refer_raw\": \"$refer_raw\", \"refer_snap\": \"$refer_snap\", \"custom\": \"$custom\", \"vupdated\": \"$req[vupdated]\" }," ;
			} $json_data = substr_replace( $json_data, "", -1 ) ;
			$process_end = ( $microtime ) ? microtime(true) : time() ;
			$pd = $process_end - $process_start ; if ( !$pd ) { $pd = 0.001 ; }
			$pd = str_replace( ",", ".", $pd ) ;
			$json_data .= "	], pd: $pd };" ;
		}
	}
	if ( isset( $dbh ) && isset( $dbh['con'] ) )
		database_mysql_close( $dbh ) ;
	$json_data = preg_replace( "/\r\n/", "", $json_data ) ; $json_data = preg_replace( "/\t/", "", $json_data ) ; print "$json_data" ;
	exit ;
?>
