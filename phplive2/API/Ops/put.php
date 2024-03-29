<?php
	if ( defined( 'API_Ops_put' ) ) { return ; }
	define( 'API_Ops_put', true ) ;

	FUNCTION Ops_put_Op( &$dbh,
					$opid,
					$status,
					$rate,
					$sms,
					$op2op,
					$traffic,
					$viewip,
					$maxc,
					$login,
					$password,
					$name,
					$email )
	{
		if ( ( $login == "" ) || ( $name == "" ) || ( $email == "" ) )
			return "Blank input is invalid." ;

		if ( !$opid ) { $opid = "NULL" ; }
		LIST( $login ) = database_mysql_quote( $dbh, $login ) ;

		$query = "SELECT * FROM p_operators WHERE opID = $opid" ;
		database_mysql_query( $dbh, $query ) ;
		$operator = database_mysql_fetchrow( $dbh ) ;

		$operator_ = Ops_get_ext_OpInfoByLogin( $dbh, $login ) ;
		if ( $login == $operator_["login"] )
		{
			if ( $operator["opID"] != $operator_["opID"] )
				return "Operator login ($login) is in use." ;
		}

		if ( isset( $operator["opID"] ) )
		{
			if ( $password == "1655648fa5d34211f0232944dfe7a2d3" )
				$password = $operator["password"] ;

			if ( $sms && !$operator["sms"] )
				$sms = time()-60 ;
			else if ( $sms )
				$sms = $operator["sms"] ;
		}
		else
			$sms = ( $sms ) ? time()-60 : 0 ;

		LIST( $opid, $status, $rate, $sms, $op2op, $traffic, $viewip, $maxc, $password, $name, $email ) = database_mysql_quote( $dbh, $opid, $status, $rate, $sms, $op2op, $traffic, $viewip, $maxc, $password, $name, $email ) ;

		if ( isset( $operator["opID"] ) )
			$query = "UPDATE p_operators SET rate = $rate, op2op = $op2op, traffic = $traffic, viewip = $viewip, maxc = $maxc, sms = $sms, login = '$login', password = '$password', name = '$name', email = '$email' WHERE opID = $opid" ;
		else
			$query = "REPLACE INTO p_operators VALUES ( $opid, 0, 0, 0, 0, $rate, $op2op, $traffic, $viewip, 1, $maxc, 0, '', '', 0, $sms, '', '$login', '$password', '$name', '$email', 0, 'default', 'default', 'default' )" ;

		database_mysql_query( $dbh, $query ) ;

		if ( $dbh[ 'ok' ] )
		{
			$id = ( $opid != "NULL" ) ? $opid : database_mysql_insertid ( $dbh ) ;
			return $id ;
		}
		else
			return "DB Error: $dbh[error]" ;
	}

	FUNCTION Ops_put_OpDept( &$dbh,
					$opid,
					$deptid,
					$visible,
					$status )
	{
		if ( ( $opid == "" ) || ( $deptid == "" ) )
			return false ;

		LIST( $opid, $deptid, $visible, $status ) = database_mysql_quote( $dbh, $opid, $deptid, $visible, $status ) ;

		$query = "SELECT count(*) AS total FROM p_dept_ops WHERE deptID = $deptid" ;
		database_mysql_query( $dbh, $query ) ;
		$data = database_mysql_fetchrow( $dbh ) ;
		$display = $data["total"] + 1 ; // add 1 because it starts at ZERO

		$query = "INSERT INTO p_dept_ops VALUES ( $deptid, $opid, $display, $visible, $status )" ;
		database_mysql_query( $dbh, $query ) ;

		return true ;
	}

	FUNCTION Ops_put_OpVars( &$dbh,
					$opid )
	{
		if ( $opid == "" )
			return false ;

		LIST( $opid ) = database_mysql_quote( $dbh, $opid ) ;

		$query = "INSERT INTO p_op_vars VALUES( $opid, 0, 1, 0, 0, 0, 1, 1, 0 )" ;
		database_mysql_query( $dbh, $query ) ;

		return true ;
	}
?>