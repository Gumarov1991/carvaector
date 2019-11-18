<?php

if (isset($_GET['id'])) $id = $_GET['id']; else $id = "";$smarty->assign("id", $id);
if ($id) {
        $result = mysqli_query($pdo,"SELECT * FROM cv_faq WHERE id = '$id'") or error();
        if ($rows = mysqli_fetch_array($result))
                $smarty->assign(array("quest" => $rows['quest'], "answer" => $rows['answer']));
} else {
        $result = mysqli_query($pdo,"SELECT * FROM cv_faq WHERE language_id = '$lang_id' ORDER BY position") or error();
        while ($rows = mysqli_fetch_array($result)) $smarty->append("faqs", $rows);
}

set_content(array(40,41,42,43,323));

if (isset($_POST['send'])) {

        $result = mysqli_query($pdo,"SELECT email FROM cv_administrations WHERE type = 1") or error();
        if ($rows = mysqli_fetch_array($result)) {
                $email = $rows[0];
                $text_email = 'Вопрос от '.$_POST['contact'].'<br><br>'.$_POST['quest'];
                $subj = 'Новый вопрос в FAQ';
                $subj = '=?utf-8?B?'.base64_encode($subj).'?=';
                $header = "From: ".$email."\n";
                $header .= "Content-type: text/html; charset=\"UTF-8\"\n";
                if (@mail($email, $subj, $text_email, $header))
                $n = 44; else $n = 45;
        } else $n = 45;
        $result = mysqli_query($pdo,"SELECT * FROM cv_content_value WHERE language_id = '$lang_id' AND content_id = $n") or error();
        if ($rows = mysqli_fetch_array($result)) $smarty->assign("onload", 'alert("'.$rows['value'].'");');
}

?>
