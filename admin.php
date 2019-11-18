<?php

header('Content-type: text/html; charset=UTF-8');

require_once "tools/dev.php";
if (__IS_DEV__()) {
	error_reporting(E_ALL + E_NOTICE);
	ini_set('display_errors', 1);
	echo "<p style='position: absolute; color: black; font-size: 10px; background-color: red'>D<br/>&nbsp;E<br/>&nbsp;&nbsp;V</p>";
//	$smarty->debugging = true;
}

require 'smarty/libs/Smarty.class.php';
$smarty = new Smarty;
$smarty->compile_check = true;
$smarty->debugging = false;
$smarty->error_reporting = E_ALL & ~E_NOTICE;
$pdo = '';

require("./scripts_admin/db_config.php");

if (isset($_SESSION['login_grant'])) $g = $_SESSION['login_grant']; else $g = 0;
$grant = array();
for ($i = 0; $i < 16; $i++) {
	array_push($grant, fmod($g, 2));
	$g = floor($g / 2);
}
$smarty->assign("grant", $grant);
$smarty->assign("login_admin", $_SESSION['login_admin']);

if (isset($_GET['quit'])) {
	mysqli_query($pdo, "UPDATE cv_administrations SET session_id = '' WHERE id = '{$_SESSION['login_id']}'") or die('ошибка выполнения запроса _11' . mysqli_error());
	$_SESSION['login_admin'] = "";
	$_SESSION['login_id'] = "";
}
if (!isset($_SESSION['login_admin']) || empty($_SESSION['login_admin'])) {
	include "scripts_admin/admin_login.php";
	if (!isset($_SESSION['login_admin']) || empty($_SESSION['login_admin'])) {
		$smarty->display('admin_login.tpl');
		exit;
	} else $part = "";
}

$a_ip = client_ip();
$smarty->assign("a_ip", $a_ip);

$geoinfo = geoinfi($a_ip);
if ($geoinfo["country_code"] == "unknown") $geoinfo = geoinf2($a_ip);
$sgeoinfo = $geoinfo["country_name"];
if ($geoinfo["region"] != "-") $sgeoinfo = $sgeoinfo . "\n" . $geoinfo["region"];
if ($geoinfo["city"] != "-" && $geoinfo["city"] != $geoinfo["region"]) $sgeoinfo = $sgeoinfo . ", " . $geoinfo["city"];
$smarty->assign("sgeoinfo", $sgeoinfo);

$page = $_SERVER['SERVER_NAME'] . $_SERVER['REQUEST_URI'];
mysqli_query($pdo, "INSERT INTO cv_sadm_logips SET date=now(), login='{$_SESSION['login']}', login_id='{$_SESSION['login_id']}', ip='$a_ip', ip_info='" . mysqli_real_escape_string($pdo, $sgeoinfo) . "', page='$page'") or error();
mysqli_query($pdo, "DELETE FROM cv_sadm_logips WHERE date < DATE_SUB(CURDATE(), INTERVAL 100 DAY)");

$result = mysqli_query($pdo, "SELECT id, name FROM cv_administrations WHERE id = '{$_SESSION['login_id']}'") or die('ошибка выполнения запроса _21');
$row = mysqli_fetch_array($result);
$smarty->assign("men_id", $row["id"]);
$smarty->assign("men_name", $row["name"]);
$_SESSION['login_name'] = $row["name"];

if (isset($_GET['content']) && ($_SESSION['login_admin'] == "admin" || $grant[7] || $grant[6] || $grant[5] || $grant[4])) $part = "admin_content";
else if (isset($_GET['content_catalog'])) $part = "admin_content_catalog";
else if (isset($_GET['contents']) && $grant[15]) $part = "admin_contents";
else if (isset($_GET['admins']) && $_SESSION['login_admin'] == "admin") $part = "admin_administrations";
else if (isset($_GET['users'])) $part = "admin_users";
else if (isset($_GET['languages']) && $_SESSION['login_admin'] == "admin") $part = "admin_languages";
else if (isset($_GET['orders'])) $part = "admin_orders";
else if (isset($_GET['help'])) $part = "admin_help";
else if (isset($_GET['helpchat'])) $part = "admin_help_chat";
else if (isset($_GET['helpchat2'])) $part = "admin_help_chat2";
else if (isset($_GET['partners'])) $part = "admin_partners";
else if (isset($_GET['finans'])) $part = "admin_finans";
else if (isset($_GET['subscr'])) $part = "admin_subscr";
else if (isset($_GET['refresh'])) exit;
else $part = "admin_users";

if ($part) require "scripts_admin/" . $part . ".php";

$smarty->assign([
		"part" => $part,
		"login_id" => $_SESSION['login_id'],
		"login_admin" => $_SESSION['login_admin'],
]);
if ($_SESSION['login_id'] == 1) {
	$result = mysqli_query($pdo, "SELECT count(*) FROM cv_responses WHERE name = ''") or die('ошибка выполнения запроса ' . mysqli_error());
	$crows = mysqli_fetch_array($result);
	if ($crows[0]) $smarty->assign("cresp", $crows[0]);
}
$smarty->display('admin.tpl');