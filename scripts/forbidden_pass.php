<?php

if (isset($_POST['email'])) {
        $email = latin_cip($_POST['email']);
        $result = mysqli_query($pdo,"SELECT cus_pass FROM cv_customers WHERE email = '$email'") or error();
        $rows = mysqli_fetch_array($result);
        if ($rows[0]) {
                $subj = 'Восстановление пароля';
                $adm_email = "support@carvector.com";
                $result = mysqli_query($pdo,"SELECT value FROM cv_content_value WHERE language_id = '$lang_id' AND content_id = 313") or error();
                $rows2 = mysqli_fetch_array($result);
                $msg = str_replace('{$pass}', $rows[0], $rows2[0]);
                if (substr($msg,0,6)=="From: ") {
                  $i = strpos($msg, "\n");
                  $adm_email = substr($msg, 6, $i-6);
                  $msg = substr($msg, $i+1);
                }
                if (substr($msg,0,6)=="Subj: ") {
                  $i = strpos($msg, "\n");
                  $subj = substr($msg, 6, $i-6);
                  $msg = substr($msg, $i+1);
                }
                $subj = '=?utf-8?B?'.base64_encode($subj).'?=';
                $header = "From: ".$adm_email."\n";
                $header .= "Content-type: text/html; charset=\"UTF-8\"\n";
                @mail($email,$subj,$msg,$header) or error();
                $smarty->assign(array("url"=>"./index.php?login","alert"=>""));
                $smarty->display("exec_command.tpl");
                exit;
        }
}

set_content(array(12,257,312,258));

?>
