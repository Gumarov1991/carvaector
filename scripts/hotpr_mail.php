<?php
$errMessage = '';
$errors = 0;

if (
	isset($_POST["requestHiddenId"])
	&& isset($_POST["requestHiddenName"])
	&& isset($_POST["requestHiddenModel"])
	&& !empty($_POST["requestUserName"])
	&& !empty($_POST["requestUserEmail"])
	) 
{

	$requestHiddenId = $_POST['requestHiddenId'];
	$requestHiddenName = $_POST['requestHiddenName'];
	$requestHiddenModel = $_POST['requestHiddenModel'];
	$requestUserName = $_POST['requestUserName'];
	$requestUserEmail = $_POST['requestUserEmail'];
	$requestUserMessage = $_POST['requestUserMessage'];

	if (!strlen($requestUserName)>=2) { $errors++; $errMessage .= 'Name field is short! <br>'; }
	if (!strpos($requestUserEmail, '@')) { $errors++; $errMessage .= 'Email field is not valid! <br>';  }
		

	if ($errors <= 0) {
		$email_to = 'bids@carvector.com';
		$subj = 'NEW request from hotoffers | Carvector';
		$msg = "New request!" . "\n";
		$msg .= "Hot off ID: " . $requestHiddenId . "\n";
		$msg .= "Title (make): " . $requestHiddenName . "\n";
		$msg .= "Model: " . $requestHiddenModel . "\n";
		$msg .= "User name: " . $requestUserName . "\n";
		$msg .= "User email: " . $requestUserEmail . "\n";
		$msg .= "User message: " . $requestUserMessage . "\n";
		$msg .= 
			'Hot off link: <a href="https://carvector.com/index.php?hotpr&prid='
			.  $requestHiddenId
			. '">https://carvector.net/index.php?hotpr&prid='
			. $requestHiddenId
			. "</a><br>";

		$msg .= "Please contact him!" . "\n";
		$adm_email = "support@carvector.com";
		$header = "From: ".$adm_email."\n";
		$header .= "Content-type: text/html; charset=\"UTF-8\"\n";

		$mailSend = @mail($email_to, $subj, $msg, $header) or error();
		if ($mailSend) echo json_encode(['status' => 'success', 'message' => 'Thank for your ticket!']); 
		else echo json_encode(['status' => 'fail', 'message' => 'Server inner error! Please try.']); 
	}
	else
	{
		echo json_encode(['status' => 'fail', 'message' => $errMessage]);
	}
}
else
{
	$errMessage .= "Fields is empty!";
	echo json_encode(['status' => 'fail', 'message' => $errMessage]);
}


?>