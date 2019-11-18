<?php
header('Content-type: text/html; charset=UTF-8');

$SITE_ROOT = ".";

require_once "tools/dev.php";
if (__IS_DEV__()) {
	error_reporting(E_ALL + E_NOTICE);
	ini_set('display_errors', 1);
	echo "<p style='position: absolute; color: red;'>DON'T PANIC. VISIBLE ONLY INSIDE OUR OFFICE. HAVE A GOOD DAY.</p>";
//	$smarty->debugging = true;
}

require 'smarty/libs/Smarty.class.php';
$smarty = new Smarty;
$smarty->compile_check = true;
$smarty->error_reporting = E_ALL & ~E_NOTICE;
$pdo = '';

require "scripts_admin/db_config.php";

$c_ip = client_ip();
$ip = explode(".", $c_ip);
if ($ip) $ip = $ip[0] * 256 * 256 * 256 + $ip[1] * 256 * 256 + $ip[2] * 256 + $ip[3]; else $ip = 0;
$date = date("Y-m-d");
/** @noinspection PhpParamsInspection */
$res = mysqli_query($pdo, "SELECT id FROM cv_suser_visitors WHERE date ='$date'") or error();
if (mysqli_num_rows($res) == 0) {
	mysqli_query($pdo, "TRUNCATE TABLE cv_suser_ips");
	mysqli_query($pdo, "INSERT INTO cv_suser_ips SET ip='$ip'");
	mysqli_query($pdo, "INSERT INTO cv_suser_visitors SET date='$date', visitors=1");
} else {
	$current_ip = mysqli_query($pdo, "SELECT id FROM cv_suser_ips WHERE ip='$ip'");
	if (mysqli_num_rows($current_ip) == 0) {
		mysqli_query($pdo, "INSERT INTO cv_suser_ips SET ip='$ip'");
		mysqli_query($pdo, "UPDATE cv_suser_visitors SET visitors=visitors+1 WHERE `date`='$date'");
	}
}

$lang_id = 2;
if (isset($_GET['language'])) {
	$lang_id = int_cip($_GET['language']);
	$result = mysqli_query($pdo, "SELECT * FROM cv_language WHERE id = $lang_id and active = 1") or error();
	if (!mysqli_fetch_array($result)) $lang_id = 2;
	$_SESSION['language_id'] = $lang_id;
} else if (isset($_SESSION['language_id'])) {
	$lang_id = $_SESSION['language_id'];
	$result = mysqli_query($pdo, "SELECT * FROM cv_language WHERE id = $lang_id and active = 1") or error();
	if (!mysqli_fetch_array($result)) $lang_id = 2;
	$_SESSION['language_id'] = $lang_id;
} else {
	$result = mysqli_query($pdo, "SELECT * FROM cv_iptable WHERE ip_from <= $ip and ip_to >= $ip") or error();
	if ($rows = mysqli_fetch_array($result)) $lang_id = $rows["language_id"]; else $lang_id = 2;
	$result = mysqli_query($pdo, "SELECT * FROM cv_language WHERE id = $lang_id and active = 1") or error();
	if (!mysqli_fetch_array($result)) $lang_id = 2;
	$_SESSION['language_id'] = $lang_id;
}

// TODO use utils methods
$array_id_to_code = [
		1 => 'ru', 2 => 'en', 3 => 'jp', 4 => 'de',
];
if ($aucLang) {
	$lang_id = array_search($aucLang, $array_id_to_code);
	if ($lang_id === false) {
		$lang_id = 2;
	}
}
$lang_code = $array_id_to_code[$lang_id];
$smarty->assign("lang_id", $lang_id);
$smarty->assign("lang_code", $lang_code);

if (isset($_GET['quit'])) {
	mysqli_query($pdo, "UPDATE cv_customers SET session_id = '' WHERE id = '{$_SESSION['login_user_id']}'") or error();
	$_SESSION['login_user'] = "";
	$_SESSION['login_user_id'] = "";
	$_SESSION['counter'] = "0";
	include __DIR__ . '/scripts/logout.php';
}

// phpinfo();
// set_content(array("2-10",12,15,16,261,320,321,322,"364-372",380,381,387,"390-392","399-401",408,456));
set_content(array("1-9990"));

$result = mysqli_query($pdo, "SELECT * FROM cv_language WHERE active = 1 OR id = '$lang_id'") or error();
while ($rows = mysqli_fetch_array($result)) $smarty->append("languages", $rows);

if (isset($_GET['hotpr'])) $part = "hotpr";
else if (isset($_GET['response'])) $part = "response";
else if (isset($_GET['about'])) $part = "about";
else if (isset($_GET['service'])) $part = "service";
else if (isset($_GET['faq'])) $part = "faq";
else if (isset($_GET['contact'])) $part = "contact";
else if (isset($_GET['catalog'])) $part = "catalog";
else if (isset($_GET['search_3'])) {
	//redirect
	header('Location: http://carvector.com');
	die();
} else if (isset($_GET['calc'])) $part = "calc";
else if (isset($_GET['registr'])) {
	$part = "registr";
} else if (isset($_GET['forbidden_pass'])) $part = "forbidden_pass";
else if (isset($_GET['login'])) $part = "login";
else if (isset($_GET['account'])) $part = "account";
else if (isset($_GET['my'])) $part = "user_my";
else if (isset($_GET['zak'])) $part = "user_zak";
else if (isset($_GET['bal'])) $part = "user_bal";
else if (isset($_GET['resp'])) $part = "user_resp";
else if (isset($_GET['subscr'])) $part = "subscribe";
else if (isset($_GET['newpass'])) $part = "user_newpass";
else if (isset($_GET['direct'])) $part = "direct";
else if (isset($_GET['instr_2'])) $part = "instr_2";
else if (isset($_GET['instr_1'])) $part = "instr_1";
else if (isset($_GET['auchouses'])) $part = "auchouses";
else if (isset($_GET['myear'])) $part = "myear";
else if (isset($_GET['gradsys'])) $part = "gradsys";
else if (isset($_GET['term'])) $part = "term";
else if (isset($_GET['auc_elements']) || isset($part_auc)) {
	$part = "auc_elements";
} else $part = "main";

$isLoggedIn = !(!isset($_SESSION['login_user']) || empty($_SESSION['login_user']));
if (strpos(" ;account;user_my;user_zak;user_bal;user_resp;user_newpass;direct;instr_2;instr_1;auchouses;myear;gradsys;", ";" . $part . ";")) {
	if (!$isLoggedIn) {
		$smarty->assign("url", "./index.php?login");
		$smarty->display('exec_command.tpl');
		exit;
	}
}

$part_content = $part;

require __DIR__ . "/scripts/" . $part . ".php";

$hasPopupNewAuth = (!isset($_COOKIE['hasReadPopupNewAuth']));

if ($part === 'auc_elements') {
	$SITE_ROOT = "https://carvector.com";
}

$smarty->assign(
		array(
				"part" => $part,
				"part_content" => $part_content,
				"login_user" => isset($_SESSION['login_user']) ? $_SESSION['login_user'] : "",
				"login_user_id" => isset($_SESSION['login_user_id']) ? $_SESSION['login_user_id'] : "",
				"isLoggedIn" => $isLoggedIn,
				"has_popup_new_auth" => $hasPopupNewAuth,
				"siteRoot" => $SITE_ROOT,
				"isDev" => __IS_DEV__(),
				"langId" => $lang_id,
				"auc_lang_arg_start" => ($part == "auc_elements") ? "?language=" . $lang_id : "",
				"auc_lang_arg_next" => ($part == "auc_elements") ? "&language=" . $lang_id : "",
				"hasFeatureLiveChat" => HAS_FEATURE_LIVE_CHAT(),
				"hasFeatureChbTermAgree" => HAS_FEATURE_CHB_TERM_AGREE(),
				"fromSuffix" => "",
		)
);

if ($part === 'auc_elements') {
	$smarty->assign(
			array(
					"login_user" => isset($aucSignedLogin) ? $aucSignedLogin : "",
					"dbgRequest" => $dbgRequest,  // TODO удалить
					"hasFeatureLiveChat" => HAS_FEATURE_LIVE_CHAT(),
					"langId" => $lang_id,
					"fromSuffix" => "&from=auc",
			)
	);
	$smarty->display('auc_elements.tpl');
	exit;
}

$smarty->display('index.tpl');
