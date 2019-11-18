<?php

include_once 'auc/auc_methods.php';
aj_logout();

// Google Analytics
$key = '_cvr_uid';
setcookie(
		$key, '', 1, "/", ".carvector.com",
		false, true
);
unset($_COOKIE[$key]);
