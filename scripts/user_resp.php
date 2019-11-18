<?php

if (isset($_POST['save'])) {
        mysqli_query($pdo,"INSERT INTO cv_responses (user_id, date, message)
                        VALUES ('{$_SESSION['login_user_id']}', now(), '{$_POST['response']}')") or error();
        $_SESSION['alert'] = 'yes';
        $smarty->assign("url", "./index.php?account");
        $smarty->display('exec_command.tpl');
        exit;
}

set_content(array(266,285));

$_SESSION['alert'] = '';

?>
