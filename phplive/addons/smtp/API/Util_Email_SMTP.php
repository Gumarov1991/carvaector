<?php
	if ( defined( 'API_Util_Email_SMTP' ) ) { return ; }	
	define( 'API_Util_Email_SMTP', true ) ;

	function Util_Email_SMTP_SwiftMailer($to, $to_name, $from, $from_name, $subject, $body) {
		global $CONF ;
		global $smtp_array ;

		if ( isset( $smtp_array ) && isset( $smtp_array["api"] ) )
		{
			$CONF["SMTP_API"] = $smtp_array["api"] ;
			$CONF["SMTP_DOMAIN"] = $smtp_array["domain"] ;
		}

		if ( is_file( "$CONF[DOCUMENT_ROOT]/addons/smtp/API/swift/swift_required.php" ) )
		{
			if ( isset( $CONF["SMTP_API"] ) && $CONF["SMTP_API"] && !$CONF["SMTP_HOST"] && is_file( "$CONF[DOCUMENT_ROOT]/addons/smtp/API/api_$CONF[SMTP_API].php" ) )
			{
				include_once( "$CONF[DOCUMENT_ROOT]/addons/smtp/API/api_$CONF[SMTP_API].php" ) ;

				$error = SMTP_API_Send( $to, $to_name, $from, $from_name, $subject, $body ) ;
				return $error ;
			}
			else
			{
				include_once( "$CONF[DOCUMENT_ROOT]/addons/smtp/API/swift/swift_required.php" ) ;

				$transport = Swift_SmtpTransport::newInstance($CONF["SMTP_HOST"], $CONF["SMTP_PORT"]) ;
				$transport->setUsername($CONF["SMTP_LOGIN"]) ;
				$transport->setPassword($CONF["SMTP_PASS"]) ;
				if ( $CONF["SMTP_PORT"] == 465 )
					$transport->setEncryption('ssl') ;
				
				$mailer = Swift_Mailer::newInstance($transport) ;

				$message = Swift_Message::newInstance($subject)
				->setFrom(array($from => $from_name))
				->setTo(array($to => $to_name)) ;
				$message->addPart($body, 'text/plain') ;

				try{
					$mailer->send($message) ;
					return "NONE" ;
				} catch (Exception $e) {
					$error = "SMTP information is invalid.  Double check the values and try again. [e1]" ;
					if ( preg_match( "/ssl/i", $e ) )
						$error = "OpenSSL is not enabled on this server.  Enable the PHP OpenSSL extension and try again." ;
					else if ( preg_match( "/(php_network_getaddresses)/i", $e ) )
						$error = "SMTP host is invalid." ;
					else if ( preg_match( "/(expected response code 250)/i", $e ) )
						$error = "SMTP login or password is incorrect." ;
					else if ( preg_match( "/(refused)/i", $e ) )
					{
						$error = "SMTP host or port is invalid.  Double check the SMTP values and try again.  If the issue persists, check that the outbound port $CONF[SMTP_PORT] for your server is open." ;
						if ( function_exists( fsockopen ) )
						{
							$fp = fsockopen('localhost', $CONF["SMTP_PORT"], $errno, $errstr, 10);
							if ( !$fp ) { $error = "SMTP port is invalid or the outbound port $CONF[SMTP_PORT] for your server is closed.  Contact the server admin for more information." ; }
							else { fclose($fp); }
						}
					}
					else if ( preg_match( "/(address in mailbox given)/i", $e ) )
						$error = "Email Address is invalid [to->$to, from->$from]" ;

					return $error ;
				}
			}
		}
		else
			return "SMTP addon lib not found. Try reinstalling the SMTP addon. [e2]" ;
	}
?>