<?php

if (isset($_POST['login'])) {
	$name = latin_cip($_POST['login']);
	$pass = latin_cip($_POST['pass']);
	/** @noinspection PhpParamsInspection FIXME */
	$result = mysqli_query($pdo, "SELECT id, confirmed, blocked FROM cv_customers WHERE email = '$name' AND cus_pass = '$pass'") or error();
	$rows = mysqli_fetch_array($result);
	if ($rows['confirmed'] == 1 && $rows['blocked'] == 0) {
		$_SESSION['login_user'] = 'user';
		$_SESSION['login_user_id'] = $rows['id'];
		mysqli_query($pdo, "UPDATE cv_customers SET ts_lastinput = now(), session_id = '$sess_id' WHERE id = '{$rows['id']}'") or error();

		// auc.carvector.com
		$email = $name;
		$auc_mode = 'login';
		include 'auc/register_in_auc.php';

		// Google Analytics
		setcookie(
				'_cvr_uid', $rows['id'], time() + 3600 * 24 * 365, "/", ".carvector.com"
		);

		$smarty->assign("url", "./index.php?account");
		$smarty->display('exec_command.tpl');

		exit;
	} else {
		$result = mysqli_query($pdo, " SELECT *
                                        FROM cv_content_value
                                        WHERE language_id = '$lang_id'
                                        AND content_id = 260") or error();
		$rows = mysqli_fetch_array($result);

		$smarty->assign("onload", 'alert("' . $rows['value'] . '");');

		if (HAS_FEATURE_LOGIN_ISSUES()) {
			$login_try_count = isset($_POST['login-try-count']) ? (((int) $_POST['login-try-count']) + 1) : 1;
			$smarty->assign("login_try_count", $login_try_count);
		}
	}
}

set_content(array("256-260", 389));