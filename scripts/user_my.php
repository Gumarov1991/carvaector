<?php


if (isset($_POST['save'])) {

	mysqli_query($pdo,"UPDATE cv_customers SET    cus_name = '".quote_cip($_POST['cus_name'])."',
		cus_country = '".quote_cip($_POST['cus_country'])."',
		cus_address = '".quote_cip($_POST['cus_address'])."',
		cus_phone = '".quote_cip($_POST['cus_phone'])."',
		cus_mphone = '".quote_cip($_POST['cus_mphone'])."',
		cus_skype = '".quote_cip($_POST['cus_skype'])."',
		cus_info = '".quote_cip($_POST['cus_info'])."',
		gender = '".int_cip($_POST['gender'])."'
		WHERE id = '{$_SESSION['login_user_id']}'") or error();

	if (isset($_POST['massmail'])) {
		mysqli_query($pdo,"UPDATE cv_customers SET    massmail = '".int_cip($_POST['massmail'])."'
			WHERE id = '{$_SESSION['login_user_id']}'") or error();
	}

	$result = mysqli_query($pdo," SELECT *
		FROM cv_content_value
		WHERE language_id = '$lang_id'
		AND content_id = 314") or error();
	$rows = mysqli_fetch_array($result);
	$smarty->assign(array("url"=>"./index.php?my"));
	$smarty->display('exec_command.tpl');
	exit;
}

set_content(array("263-285","441-443",449));

$result = mysqli_query($pdo,"SELECT * FROM cv_customers WHERE id = '{$_SESSION['login_user_id']}'") or error();
if ($rows = mysqli_fetch_array($result)) $smarty->assign("user", $rows);



?>
