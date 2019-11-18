<?php

header('Access-Control-Allow-Origin: http://auc.carvector.com');
header('Access-Control-Allow-Methods: GET, POST');
header('Access-Control-Allow-Headers: X-Requested-With');
header('Content-type: text/html; charset=UTF-8');

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
	// TODO throw 404
	die('404');
}

$part_auc = true;
$aucSignedLogin = $_REQUEST['aucSignedLogin'];
$dbgRequest = json_encode($_REQUEST);
$aucLang = isset($_REQUEST['aucLang']) ? $_REQUEST['aucLang'] : 'en';

chdir(realpath(__DIR__ . '/../../'));
require __DIR__ . '/../../index.php';
exit;