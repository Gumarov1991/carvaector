<?php
	if ( defined( 'API_Chat_remove' ) ) { return ; }
	define( 'API_Chat_remove', true ) ;

	FUNCTION Chat_remove_Request( &$dbh,
						$requestid )
	{
		if ( $requestid == "" )
			return false ;

		LIST( $requestid ) = database_mysql_quote( $dbh, $requestid ) ;

		$query = "DELETE FROM p_requests WHERE requestID = $requestid" ;
		database_mysql_query( $dbh, $query ) ;

		return true ;
	}

	FUNCTION Chat_remove_OpDept( &$dbh,
						$opid,
						$deptid )
	{
		if ( ( $opid == "" ) || ( $deptid == "" ) )
			return false ;

		LIST( $opid, $deptid ) = database_mysql_quote( $dbh, $opid, $deptid ) ;

		$query = "SELECT * FROM p_dept_ops WHERE deptID = $deptid AND opID = $opid" ;
		database_mysql_query( $dbh, $query ) ;
		$data = database_mysql_fetchrow( $dbh ) ;

		$query = "DELETE FROM p_dept_ops WHERE deptID = $deptid AND opID = $opid" ;
		database_mysql_query( $dbh, $query ) ;

		$query = "UPDATE p_dept_ops SET display = display-1 WHERE deptID = $deptid AND display >= $data[display]" ;
		database_mysql_query( $dbh, $query ) ;

		return true ;
	}

	FUNCTION Chat_remove_Transcript( &$dbh,
						$ces,
						$created )
	{
		if ( ( $ces == "" ) || ( $created == "" ) )
			return false ;

		LIST( $ces, $created ) = database_mysql_quote( $dbh, $ces, $created ) ;

		$query = "DELETE FROM p_transcripts WHERE ces = '$ces' AND created = $created" ;
		database_mysql_query( $dbh, $query ) ;
		
		if ( $dbh[ 'ok' ] )
		{
			$query = "DELETE FROM p_req_log WHERE ces = '$ces'" ;
			database_mysql_query( $dbh, $query ) ;
			return true ;
		}
		else
			return false ;
	}

	FUNCTION Chat_remove_CleanStats( &$dbh )
	{
		$query = "SELECT p_rstats_depts.deptID FROM p_rstats_depts INNER JOIN p_departments ON p_rstats_depts.deptID != p_departments.deptID" ;
		database_mysql_query( $dbh, $query ) ;

		if ( $dbh[ 'ok' ] )
		{
			$deptids = Array() ;
			while ( $data = database_mysql_fetchrow( $dbh ) )
				$deptids[] = $data["deptID"] ;
			
			for ( $c = 0; $c < count( $deptids ); ++$c )
			{
				$deptid = $deptids[$c] ;
				$query = "DELETE FROM p_rstats_depts WHERE deptID = $deptid" ;
				database_mysql_query( $dbh, $query ) ;
			}
		}
	}

	FUNCTION Chat_remove_ResetReports( &$dbh )
	{
		$query = "TRUNCATE TABLE p_rstats_depts" ;
		database_mysql_query( $dbh, $query ) ;
		$query = "TRUNCATE TABLE p_rstats_ops" ;
		database_mysql_query( $dbh, $query ) ;
		$query = "UPDATE p_req_log SET archive = 1" ;
		database_mysql_query( $dbh, $query ) ;

		return true ;
	}
?>
