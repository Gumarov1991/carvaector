<?php
	function SMTP_API_Send( $to, $to_name, $from, $from_name, $subject, $body )
	{
		global $CONF ;

		$error = "" ;
		if ( !function_exists( "curl_init" ) )
			$error = "Server PHP does not support <a href='http://php.net/manual/en/book.curl.php' target='new' style='color: #FFFFFF;'>cURL</a>.  Contact your server admin to enable the PHP cURL support to utilize the API." ;
		else
		{
			$params = array(
			'api_user'  => $CONF["SMTP_LOGIN"],
			'api_key'   => $CONF["SMTP_PASS"],
			'to'        => $to,
			'subject'   => $subject,
			'html'      => "",
			'text'      => $body,
			'from'      => $from,
			);

			$request = curl_init( "http://sendgrid.com/api/mail.send.json" ) ;
			curl_setopt ( $request, CURLOPT_POST, true ) ;
			// Tell curl that this is the body of the POST
			curl_setopt ( $request, CURLOPT_POSTFIELDS, $params ) ;
			// Tell curl not to return headers, but do return the response
			curl_setopt( $request, CURLOPT_HEADER, false ) ;
			curl_setopt( $request, CURLOPT_RETURNTRANSFER, true ) ;

			// obtain response
			$response = curl_exec( $request ) ;
			curl_close( $request ) ;

			if ( preg_match( "/(success)/i", $response ) ) { $error = "NONE" ; }
			else { $error = "SendGrid login or password is incorrect." ; }
		}

		return $error ;
	}
?>