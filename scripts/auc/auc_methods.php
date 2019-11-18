<?php

$auc_cookie_key = 'ajuser';
$auc_cookie_key_isSigned = 'ajuser_isSigned2.0';

function auc_set_cookie($value) {
	global $auc_cookie_key, $auc_cookie_key_isSigned;
	session_start();
	$expire = empty($value) ? 1 : time() + 3600 * 24;
	setcookie($auc_cookie_key, $value, $expire, "/", ".carvector.com", false, true);
	setcookie(
			$auc_cookie_key_isSigned, !empty($value),
			$expire, "/", ".carvector.com", false, false
	);
}

function aj_login($username, $password, $user_id, &$confirm) {
	$value = base64_encode($username . ':' . md5($password) . ':' . $user_id . '::');

	auc_set_cookie($value);
	$confirm = @file_get_contents('http://auc.carvector.com/login?ajuser=' . $value);
	return $value;
}

function aj_logout() {
	global $auc_cookie_key, $auc_cookie_key_isSigned;
	if (isset($_COOKIE[$auc_cookie_key]) || isset($_COOKIE[$auc_cookie_key_isSigned])) {
		auc_set_cookie('');
		unset($_COOKIE[$auc_cookie_key]);
		unset($_COOKIE[$auc_cookie_key_isSigned]);
	}
}