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
	die('404');
}

header('Content-type: application/json; charset=UTF-8');

$aucLangCode = isset($_REQUEST['aucLang']) ? $_REQUEST['aucLang'] : 'en';
require_once '../../tools/utils.php';
$lang_id = langCodeToId($aucLangCode);

require "../../scripts_admin/db_config_quick.php";
$a = [484, '492-493'];
if (is_array($a) && (count($a) > 0)) {
	$s = "";
	for ($i = 0; $i < count($a); $i++) {
		$j = strpos($a[$i], "-");
		if (!$j) $s .= " OR v.content_id = '" . $a[$i] . "'"; else
			$s .= " OR (v.content_id >= '" . substr($a[$i], 0, $j) . "' AND v.content_id <= '" . substr($a[$i], $j + 1) . "')";
	}
	$s = "WHERE v.language_id = '$lang_id' and v.content_id = c.id AND (" . substr($s, 4) . ")";
	/** @noinspection SqlDialectInspection */
	$s = "SELECT c.type, v.* FROM cv_content_value v, cv_content c $s";
	$result = mysqli_query($pdo, $s);
	if ($result === false) error($s);
	$strings = [];
	while ($rows = mysqli_fetch_array($result)) {
		$strings[$rows['content_id']] = $rows["value"];
	}
}

echo json_encode([
		'title' => $strings[484],
		'body' => $strings[492],
		'tickText' => $strings[493]
]);
exit;