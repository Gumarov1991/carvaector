<?php

set_content(array("261-271", 409, 433, 434, 435, 438));

if (isset($_POST['save'])) {
	mysqli_query($pdo,"UPDATE cv_customers SET    cus_auclogin        = '".quote_cip($_POST['auclogin'])."',
											cus_aucpass         = '".quote_cip($_POST['aucpass'])."'
											WHERE id = '{$_SESSION['login_user_id']}'") or die('ошибка выполнения запроса '.mysql_error());
}

$result = mysqli_query($pdo,"SELECT * FROM cv_customers WHERE id = '{$_SESSION['login_user_id']}'") or error();
$rows = mysqli_fetch_array($result);
$smarty->assign("fio", $rows["name"]);
$smarty->assign("sess", md5($sess_id));
$smarty->assign("direct", $rows["direct"]);
$smarty->assign("cus_auclogin", $rows["cus_auclogin"]);
$smarty->assign("cus_aucpass", $rows["cus_aucpass"]);
$result = mysqli_query($pdo,"SELECT * FROM cv_hrefs WHERE language_id = '$lang_id' order by id") or error();
while ($rows = mysqli_fetch_array($result)) $smarty->append("hrefs", $rows);

if (isset($_SESSION['alert']) && $_SESSION['alert'] == 'yes') {
        $result = mysqli_query($pdo," SELECT value
                                FROM cv_content_value
                                WHERE language_id = '$lang_id'
                                AND content_id in (304)") or error();
        $rows = mysqli_fetch_array($result);
        $smarty->assign("onload", 'alert("'.$rows[0].'");');
}
$_SESSION['alert'] = '';
?>
