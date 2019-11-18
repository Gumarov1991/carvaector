<?php

header('Access-Control-Allow-Origin: http://auc.carvector.com');
header('Access-Control-Allow-Methods: GET, POST');
header('Access-Control-Allow-Headers: X-Requested-With');

require_once '../../tools/dev.php';
if (__IS_DEV__()) {
	error_reporting(E_ALL + E_NOTICE);
	ini_set('display_errors', 1);
}

if (
		(
				empty($_SERVER['HTTP_X_REQUESTED_WITH']) ||
				(strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) !== 'xmlhttprequest')
		)
		&& (!__IS_DEV__())
) {
	die('');
}

header('Content-type: application/json; charset=UTF-8');

echo json_encode([
		'has_feature_auth_v2_0' => true,
]);
exit;