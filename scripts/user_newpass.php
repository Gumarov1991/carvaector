<?php

if (isset($_POST['save'])) {
        mysqli_query($pdo,"UPDATE cv_customers SET cus_pass = '{$_POST['pass']}' WHERE id = '{$_SESSION['login_user_id']}'") or error();
        $smarty->assign("url", "./index.php?newpass");
        $smarty->display('exec_command.tpl');
        $_SESSION['alert'] = 'yes';
        exit;
}

set_content(array(267,285,305));
if ($_SESSION['alert']) {
        $result = mysqli_query($pdo," SELECT value
                                FROM cv_content_value
                                WHERE language_id = '$lang_id'
                                AND content_id in (306)") or error();
        $rows = mysqli_fetch_array($result);
        $smarty->assign("onload", 'alert("'.$rows[0].'");');
}
$_SESSION['alert'] = '';

?>
