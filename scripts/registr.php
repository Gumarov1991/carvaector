<?php

if (isset($_SESSION['language_id'])) $lang_id = $_SESSION['language_id']; else $lang_id = 2;

set_content(array("242-254", 284, "309-311", 388, "441-448"));

if (isset($_POST['reg'])) {
	$cath = "";
	if (isset($_POST['fio']) && !empty($_POST['fio'])) $cath = "yes";
	if (isset($_POST['pass']) && !empty($_POST['pass'])) $cath = "yes";
	if (isset($_POST['name']) && !empty($_POST['name'])) $cath = "yes";
	if (isset($_POST['email']) && !empty($_POST['email'])) $cath = "yes";
	if (isset($_POST['password']) && !empty($_POST['password'])) $cath = "yes";
	if (isset($_POST['e_mail']) && !empty($_POST['e_mail'])) $cath = "yes";
	if (isset($_POST['phone']) && !empty($_POST['phone'])) $cath = "yes";
	if ($cath) {
		$smarty->assign("url", "./index.php");
		$smarty->display("exec_command.tpl");
		exit;
	}

	if (isset($_POST['r01'])) $gender = int_cip(mb_substr($_POST['r01'], 0, 1)); else $gender = "";
	if (isset($_POST['r02'])) {
		$fio1 = quote_cip(trim(preg_replace('/\s+/', ' ', mb_substr($_POST['r02'], 0, 255))));
		preg_match_all("/./u", mb_strtolower($fio1, 'UTF-8'), $matches);
		$array = $matches[0];
		$array[0] = mb_strtoupper($array[0], 'UTF-8');
		foreach ($array as $key => $value) {
			if (($value == "(" || $value == "." || $value == "," || $value == " " || $value == "-") && isset($array[$key + 1])) $array[$key + 1] = mb_strtoupper($array[$key + 1], 'UTF-8');
		}
		$fio = "";
		foreach ($array as $value) $fio .= $value;
		$fio = preg_replace('/\s\.+/', '.', $fio);
		$fio = preg_replace('/\s,+/', ',', $fio);
		$fio = preg_replace('/(\.,+)|(,\.+)/', '.', $fio);
		$fio = preg_replace('/\.+/', '.', $fio);
		$fio = preg_replace('/,+/', ',', $fio);
	} else $fio = "";
	if (isset($_POST['r03'])) {
		$email = latin_cip(str_replace(" ", "", mb_substr($_POST['r03'], 0, 255)));
		$email = mb_strtolower($email, 'UTF-8');
	} else $email = "";
	if (isset($_POST['r04'])) $pass = latin_cip(str_replace(" ", "", mb_substr($_POST['r04'], 0, 20))); else $pass = "";
	if (isset($_POST['r05'])) {
		$phone = phone_cip(str_replace(" ", "", mb_substr($_POST['r05'], 0, 50)));
		if ($phone && substr($phone, 0, 1) != '+') $phone = "+" . $phone;
	} else $phone = "";
	if (isset($_POST['r06'])) {
		$mphone = phone_cip(str_replace(" ", "", mb_substr($_POST['r06'], 0, 50)));
		if ($mphone && substr($mphone, 0, 1) != '+') $mphone = "+" . $mphone;
	} else $mphone = "";
	if (isset($_POST['r07'])) $skype = latin_cip(mb_substr($_POST['r07'], 0, 50)); else $skype = "";
	if (isset($_POST['r08'])) $info = cip(mb_substr($_POST['r08'], 0, 255)); else $info = "";

	$smarty->assign(array("r01" => $gender
	, "r02" => $fio1
	, "r03" => $email
	, "r04" => $pass
	, "r05" => $phone
	, "r06" => $mphone
	, "r07" => $skype
	, "r08" => $info
	));

	$cnt = "";
	$result = mysqli_query($pdo, "SELECT count(*) FROM cv_customers WHERE email = '$email'") or error();
	$rows = mysqli_fetch_array($result);
	$cnt = $rows[0];

	if (!($gender && $fio1 && $email && $pass)) {
		$smarty->assign("message", "no_filled");
		$smarty->assign("onload", 'alert("' . $smarty->tpl_vars["content_250"] . '");');
	} else if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
		$smarty->assign("message", "email_error");
		$smarty->assign("onload", 'alert("' . $smarty->tpl_vars["content_448"] . '");');
	} else if ($cnt) {
		$smarty->assign("message", "email_exist");
		$smarty->assign("onload", 'alert("' . $smarty->tpl_vars["content_310"] . '");');
	} else if ($pass != $_POST['r04'] || strlen($pass) < 6) {
		$smarty->assign("message", "pass_error");
		$smarty->assign("onload", 'alert("' . $smarty->tpl_vars["content_251"] . '");');
	} else {
		$confirm_code = generate_key();
		$clip = client_ip();
		$ip_country_code = 00;
		$ip_country = "";
		$ip_region = "";
		$ip_city = "";
		$addr = "";
		$cus_address = "";
		$cus_country = "";
		$geoinfo = geoinfi($clip);
		if ($geoinfo["country_code"] == "unknown") $geoinfo = geoinf2($clip);
		if ($geoinfo["country_code"] != "unknown") $ip_country_code = $geoinfo["country_code"];
		if ($geoinfo["country_name"]) $ip_country = $geoinfo["country_name"];
		if ($geoinfo["region"] != "-") $ip_region = $geoinfo["region"];
		if ($geoinfo["city"] != "-") $ip_city = $geoinfo["city"];

		if (!$ip_region && $ip_city) {
			$addr = $ip_city;
		} else if ($ip_region && $ip_city) {
			if ($ip_region != $ip_city) {
				$addr = $ip_region . ", " . $ip_city;
			} else $addr = $ip_region;
		}

		if ($ip_country_code == "KZ" || $ip_country_code == "A1" || $ip_country_code == "A2" || $ip_country_code == "O1") {
			$cus_address = "";
			$cus_country = "";
			$address = "";
			$country = "";
		} else {
			$cus_address = $addr;
			$cus_country = $ip_country;
			$address = $addr;
			$country = $ip_country;
		}

		mysqli_query($pdo, "INSERT INTO cv_customers SET 
						date_reg		=now()
						,ts_lastinput	=now()
						,lang_id		='$lang_id'
						,gender			='$gender'
						,email			='" . mysqli_real_escape_string($pdo, $email) . "'
						,name			='" . mysqli_real_escape_string($pdo, $fio) . "'
						,address		='" . mysqli_real_escape_string($pdo, $address) . "'
						,country		='" . mysqli_real_escape_string($pdo, $country) . "'
						,phone			='" . mysqli_real_escape_string($pdo, $phone) . "'
						,mphone			='" . mysqli_real_escape_string($pdo, $mphone) . "'
						,skype			='" . mysqli_real_escape_string($pdo, $skype) . "'
						,info			='" . mysqli_real_escape_string($pdo, $info) . "'
						,cus_pass		='" . mysqli_real_escape_string($pdo, $pass) . "'
						,cus_name		='" . mysqli_real_escape_string($pdo, $fio1) . "'
						,cus_address	='" . mysqli_real_escape_string($pdo, $cus_address) . "'
						,cus_country	='" . mysqli_real_escape_string($pdo, $cus_country) . "'
						,cus_phone		='" . mysqli_real_escape_string($pdo, $phone) . "'
						,cus_mphone		='" . mysqli_real_escape_string($pdo, $mphone) . "'
						,cus_skype		='" . mysqli_real_escape_string($pdo, $skype) . "'
						,cus_info		='" . mysqli_real_escape_string($pdo, $info) . "'
						,cus_auclogin	='guest'
						,cus_aucpass	='guest'
						,name_in_reg	='" . mysqli_real_escape_string($pdo, $fio) . "'
						,email_in_reg	='" . mysqli_real_escape_string($pdo, $email) . "'
						,pass_in_reg	='" . mysqli_real_escape_string($pdo, $pass) . "'
						,confirm_code	='" . mysqli_real_escape_string($pdo, $confirm_code) . "'
						,ip_adress		='$clip'
						,ip_country_code='" . mysqli_real_escape_string($pdo, $ip_country_code) . "'
						,ip_country_name='" . mysqli_real_escape_string($pdo, $ip_country) . "'
						,ip_region		='" . mysqli_real_escape_string($pdo, $ip_region) . "'
						,ip_city		='" . mysqli_real_escape_string($pdo, $ip_city) . "'
						") or die ("Error DB connection<br>" . mysqli_error($pdo));

		$subj = 'CARVECTOR.COM | Confirm your registration';
		$adm_email = "support@carvector.com";
		$url = "https://" . $_SERVER['HTTP_HOST'] . "/index.php?registr&confirm_code=" . urlencode($confirm_code);
		$msg = str_replace('{$email}', $email, $smarty->tpl_vars["content_309"]);
		$msg = str_replace('{$pass}', $pass, $msg);
		$msg = str_replace('{$url}', $url, $msg);
		if (substr($msg, 0, 6) == "From: ") {
			$i = strpos($msg, "\n");
			$adm_email = trim(substr($msg, 6, $i - 6));
			$msg = trim(substr($msg, $i + 1));
		}
		if (substr($msg, 0, 6) == "Subj: ") {
			$i = strpos($msg, "\n");
			$subj = trim(substr($msg, 6, $i - 7));
			$msg = trim(substr($msg, $i + 1));
		}
		$subj = '=?utf-8?B?' . base64_encode($subj) . '?=';
		$header = "From: " . $adm_email . "\n";
		$header .= "Content-type: text/html; charset=\"UTF-8\"\n";

		if (HAS_FEATURE_AUC_REGISTER()) {
			// car preferences
			$car_preferences = '_';
			$car_preferredMileage = '_';
			$car_preferredYear = '_';
			$car_preferredPrice = '_';

			$auc_mode = 'register';
			include 'auc/register_in_auc.php';
		}

		@mail($email, $subj, $msg, $header) or error();

		$smarty->assign("url", "./index.php?registr&success");
		$smarty->display("exec_command.tpl");
		exit;
	}
} else if (isset($_GET['success'])) {
	$smarty->assign("reg_success", "yes");
} else if (isset($_GET['confirm_code'])) {
	$result = mysqli_query($pdo, "SELECT id FROM cv_customers WHERE confirm_code = '" . latin_cip($_GET['confirm_code']) . "'") or error();
	$rows = mysqli_fetch_array($result);
	if ($rows['id']) {
		mysqli_query($pdo, "UPDATE cv_customers SET confirmed = '1' WHERE id = '{$rows['id']}'") or error();
		$err = 0;
	} else $err = 1;
	$smarty->assign(array("reg_confirm_code" => "yes", "err" => $err));
} else /* исходная страница без действий */ {
	if (__IS_DEV__()) {
		$smarty->assign(array("r01" => 1
		, "r02" => "Тестовый Тест"
		, "r03" => "kayr.morpheu@gmail.com"
		, "r04" => "123456"
		));
	}
}

function ValidEmail($address) {
	if (function_exists('filter_list')) {
		$valid_email = filter_var($address, FILTER_VALIDATE_EMAIL);
		if ($valid_email !== false)
			return true;
		else
			return false;
	} else {
		if (ereg("^[^@  ]+@([a-zA-Z0-9\-]+\.)+([a-zA-Z0-9\-]{2}|net|com|gov|mil|org|edu|int)\$", $address))
			return true;
		else
			return false;
	}
}
