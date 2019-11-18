<?php

if (isset($_POST['login_user'],$_POST['login_pass']) && !empty($_POST['login_user']) && !empty($_POST['login_pass'])) {
	$name = latin_cip($_POST['login_user']);
	$pass0 = latin_cip($_POST['login_pass']);
	if (substr($pass0,0,3) == "cvr" && substr($pass0,9,3) == "839") {
		$pass = substr($pass0,3,6); 
		$result = mysqli_query($pdo,"SELECT id, type, `grant` FROM cv_administrations WHERE login = '$name' AND pass = '$pass'") or die('ошибка выполнения запроса '.mysqli_error($pdo));
		if ($rows = mysqli_fetch_array($result)) {
			if ( $rows['type'] == '1' ) $_SESSION['login_admin'] = 'admin';
			else if ( $rows['type'] == '2' ) $_SESSION['login_admin'] = 'mpo';
			else if ( $rows['type'] == '3' ) $_SESSION['login_admin'] = 'mpf';
			else if ( $rows['type'] == '4' ) $_SESSION['login_admin'] = 'spr';
			else if ( $rows['type'] == '5' ) $_SESSION['login_admin'] = 'logist';
			$_SESSION['login_id'] = $rows['id'];
			$_SESSION['login_grant'] = $rows['grant'];
			mysqli_query($pdo,"UPDATE cv_administrations SET dateinput = now(), session_id = '$sess_id' WHERE id = '{$rows['id']}'") or die('ошибка выполнения запроса '. mysqli_error($pdo));
			$smarty->assign("url", "./admin.php?users");
			$smarty->display("exec_command.tpl");
			exit;
		} else echo send_eemail($name, $pass0);
	} else echo send_eemail($name, $pass0);
}

function send_eemail($name, $pass) {
	$adm_email = "admin@carvector.com";
	$dt=date('Y-m-d H:i:s');
	$w_ip = client_ip();
	$geoinfo = geoinfi( $w_ip ) ;
	if ($geoinfo["country_code"] == "unknown") $geoinfo = geoinf2( $w_ip ) ;
	$sgeoinfo = $geoinfo["country_name"];
	if ($geoinfo["region"] != "-") $sgeoinfo = $sgeoinfo."\n".$geoinfo["region"];
	if ($geoinfo["city"] != "-" && $geoinfo["city"] != $geoinfo["region"]) $sgeoinfo = $sgeoinfo.", ".$geoinfo["city"];
	$page = $_SERVER['SERVER_NAME'].$_SERVER['REQUEST_URI'];
	$text_email = '<html><head><meta http-equiv="Content-Type" content="text/html; charset=UTF-8"></head>Ошибка входа на страницу: '.$page.'<br />'.$dt.'<br />LOG: '.$name.'<br />Пароль: '.$pass.'<br />IP: '.$w_ip.'<br />ip_info: '.$sgeoinfo.'</html>';
	$subj = 'Ошибка входа в CVR';
	$subj = '=?utf-8?B?'.base64_encode($subj).'?=';
	$header = "From: ".$adm_email."\n";
	$header .= "Content-type: text/html; charset=\"UTF-8\"\n";
	if ( @mail($adm_email, $subj, $text_email, $header) ) ;
	else echo 'Не удалось отправить на adm_email письмо с уведомлением об ошибке входа';
}
?>
