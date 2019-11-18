<?php

if (isset($_GET['del'])) $del = $_GET['del']; else $del = "";
if (isset($_GET['up'])) $up = $_GET['up']; else $up = "";
if (isset($_GET['down'])) $down = $_GET['down']; else $down = "";
if ($up) {
        $result = mysqli_query($pdo,"SELECT * FROM cv_faq WHERE language_id = '$lang_id' and id = '$up'") or die('ошибка выполнения запроса '.mysqli_error($pdo));
        if ($rows = mysqli_fetch_array($result)) { $m1 = $rows['position'];$i1 = $rows['id']; }
        $result = mysqli_query($pdo,"SELECT * FROM cv_faq WHERE language_id = '$lang_id' and position < $m1 order by position desc limit 0,1") or die('ошибка выполнения запроса '.mysqli_error($pdo));
        if ($rows = mysqli_fetch_array($result)) {
                $m2 = $rows['position'];$i2 = $rows['id'];
                mysqli_query($pdo,"UPDATE cv_faq SET position = '$m2' WHERE id = '$i1'") or die('ошибка выполнения запроса '.mysqli_error($pdo));
                mysqli_query($pdo,"UPDATE cv_faq SET position = '$m1' WHERE id = '$i2'") or die('ошибка выполнения запроса '.mysqli_error($pdo));
        }
}
if ($down) {
        $result = mysqli_query($pdo,"SELECT * FROM cv_faq WHERE language_id = '$lang_id' and id = '$down'") or die('ошибка выполнения запроса '.mysqli_error($pdo));
        if ($rows = mysqli_fetch_array($result)) { $m1 = $rows['position'];$i1 = $rows['id']; }
        $result = mysqli_query($pdo,"SELECT * FROM cv_faq WHERE language_id = '$lang_id' and position > $m1 order by position limit 0,1") or die('ошибка выполнения запроса '.mysqli_error($pdo));
        if ($rows = mysqli_fetch_array($result)) {
                $m2 = $rows['position'];$i2 = $rows['id'];
                mysqli_query($pdo,"UPDATE cv_faq SET position = '$m2' WHERE id = '$i1'") or die('ошибка выполнения запроса '.mysqli_error($pdo));
                mysqli_query($pdo,"UPDATE cv_faq SET position = '$m1' WHERE id = '$i2'") or die('ошибка выполнения запроса '.mysqli_error($pdo));
        }
}
if ($save) {
        mysqli_query($pdo,"UPDATE cv_faq SET  quest = '".mysqli_real_escape_string($pdo,$_POST['quest'])."',
                                        answer = '".mysqli_real_escape_string($pdo,$_POST['answer'])."'
                                        WHERE id = '$edit'") or die('ошибка выполнения запроса '.mysqli_error($pdo));
        $smarty->assign(array("alert"=>"Успешно сохранено","url"=>"./admin.php?content&lang_id=$lang_id&id=faq"));
        $smarty->display("exec_command.tpl");
        exit;
}
if ($del) mysqli_query($pdo,"DELETE FROM cv_faq WHERE id = '$del'") or die('ошибка выполнения запроса '.mysqli_error($pdo));
if (!$edit) {
        $result = mysqli_query($pdo,"SELECT * FROM cv_faq WHERE language_id = '$lang_id' ORDER BY position") or die('ошибка выполнения запроса '.mysqli_error($pdo));
        while ($rows = mysqli_fetch_array($result)) $smarty->append("faq_list", $rows);
} else if ($edit!="add") {
        $result = mysqli_query($pdo,"SELECT * FROM cv_faq WHERE language_id = '$lang_id' AND id = '$edit'") or die('ошибка выполнения запроса '.mysqli_error($pdo));
        if ($rows = mysqli_fetch_array($result)) $smarty->assign("r", $rows);
} else {
        $result = mysqli_query($pdo,"SELECT max(position), max(id) FROM cv_faq WHERE language_id = '$lang_id'") or die('ошибка выполнения запроса '.mysqli_error($pdo));
        if ($rows = mysqli_fetch_array($result)) { $m = $rows[0]+1;$edit = $rows[1]+1; }
        mysqli_query($pdo,"INSERT into cv_faq (language_id,position,id_rubrika,quest,answer) VALUES ('$lang_id','$m','0','quest','answer')") or die('ошибка выполнения запроса '.mysqli_error($pdo));
}
$smarty->assign(array(  "id"            => $id,
                        "edit"          => $edit,
                        ));

?>
