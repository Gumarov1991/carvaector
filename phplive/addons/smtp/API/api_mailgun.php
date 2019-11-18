<?php
	function SMTP_API_Send( $to, $to_name, $from, $from_name, $subject, $body )
	{
		global $CONF ;

		$error = "" ;
		if ( !isset( $CONF["SMTP_DOMAIN"] ) )
			$error = "SMTP domain has not been set." ;
		else if ( !function_exists( "curl_init" ) )
			$error = "Server PHP does not support <a href='http://php.net/manual/en/book.curl.php' target='new' style='color: #FFFFFF;'>cURL</a>.  Contact your server admin to enable the PHP cURL support to utilize the API." ;
		else
		{
			$request = curl_init() ;

			curl_setopt( $request, CURLOPT_HTTPAUTH, CURLAUTH_BASIC ) ;
			curl_setopt( $request, CURLOPT_USERPWD, "api:$CONF[SMTP_PASS]" ) ;
			curl_setopt( $request, CURLOPT_RETURNTRANSFER, 1 ) ;

			curl_setopt( $request, CURLOPT_CUSTOMREQUEST, "POST") ;
			curl_setopt( $request, CURLOPT_URL, "https://api.mailgun.net/v2/$CONF[SMTP_DOMAIN].mailgun.org/messages" ) ;
			curl_setopt( $request, CURLOPT_POSTFIELDS, array( "from" => "$from",
			"to" => $to,
			"subject" => $subject,
			"text" => $body ) ) ;

			$response = curl_exec( $request ) ;
			curl_close( $request ) ;

			if ( preg_match( "/(thank you)/i", $response ) )
				$error = "NONE" ;
			else if ( preg_match( "/(Domain not found)/i", $response ) )
				$error = "Mailgun account domain is invalid." ;
			else
				$error = "Mailgun API key is invalid.";
		}

		return $error ;
	}
?>