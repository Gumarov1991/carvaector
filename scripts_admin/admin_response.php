<?php

$no_navigation = "yes";
$no_pages = 1;
$page_e = 80;
$page_str_n = 4;
$dir = "./files/add_response/".$edit."/";
if (!file_exists(substr($dir,0,strlen($dir)-1))) {
        mkdir(substr($dir,0,strlen($dir)-1), 0777);
        chmod(substr($dir,0,strlen($dir)-1), 0777);
}
include "admin_files.php";
$smarty->assign(array(  "id"            => $id,
                        "edit"          => $edit,
                        ));
if (isset($_GET["response_del"]))
        mysqli_query($pdo,"DELETE FROM cv_responses WHERE id = '".int_cip($_GET["response_del"])."'") or die('ошибка выполнения запроса '.mysqli_error($pdo));
if (isset($_GET["add"]))
        mysqli_query($pdo,"INSERT into cv_responses (user_id, date, language_id) VALUES ('0', now(), '$lang_id')") or die('ошибка выполнения запроса '.mysqli_error($pdo));
if ($save) {
        mysqli_query($pdo,"UPDATE cv_responses SET    language_id = '{$_POST['language_id']}',
                                                confirm = '".int_cip($_POST['en'])."',
                                                message = '".quote_cip($_POST['msg'])."',
                                                name = '".quote_cip($_POST['name'])."'
                                                WHERE id = '$edit'") or die('ошибка выполнения запроса '.mysqli_error($pdo));
        $smarty->assign("onload",'alert("Успешно сохранено");');
}
if (isset($_GET["response_up"])) {
        $result = mysqli_query($pdo,"SELECT date FROM cv_responses where id = '$edit'") or die('ошибка выполнения запроса '.mysqli_error($pdo));
        $rows = mysqli_fetch_array($result);$dt1 = $rows[0];
        $result = mysqli_query($pdo,"SELECT date, id FROM cv_responses where date > '$dt1' and language_id = '$lang_id' order by date limit 0,1") or die('ошибка выполнения запроса '.mysqli_error($pdo));
        if ($rows = mysqli_fetch_array($result)) { $dt2 = $rows[0];$edit2 = $rows[1]; } else { $dt2 = "";$edit2 = ""; }
        if ($edit2) {
                mysqli_query($pdo,"UPDATE cv_responses SET date = '$dt2' WHERE id = '$edit'") or die('ошибка выполнения запроса '.mysqli_error($pdo));
                mysqli_query($pdo,"UPDATE cv_responses SET date = '$dt1' WHERE id = '$edit2'") or die('ошибка выполнения запроса '.mysqli_error($pdo));
        }
}
if (isset($_GET["response_down"])) {
        $result = mysqli_query($pdo,"SELECT date FROM cv_responses where id = '$edit'") or die('ошибка выполнения запроса '.mysqli_error($pdo));
        $rows = mysqli_fetch_array($result);$dt1 = $rows[0];
        $result = mysqli_query($pdo,"SELECT date, id FROM cv_responses where date < '$dt1' and language_id = '$lang_id' order by date desc limit 0,1") or die('ошибка выполнения запроса '.mysqli_error($pdo));
        if ($rows = mysqli_fetch_array($result)) { $dt2 = $rows[0];$edit2 = $rows[1]; } else { $dt2 = "";$edit2 = ""; }
        if ($edit2) {
                mysqli_query($pdo,"UPDATE cv_responses SET date = '$dt2' WHERE id = '$edit'") or die('ошибка выполнения запроса '.mysqli_error($pdo));
                mysqli_query($pdo,"UPDATE cv_responses SET date = '$dt1' WHERE id = '$edit2'") or die('ошибка выполнения запроса '.mysqli_error($pdo));
        }
}
$num = 1;
$result = mysqli_query($pdo,"SELECT id,confirm,name FROM cv_responses WHERE language_id = '$lang_id' ORDER BY date desc") or die('ошибка выполнения запроса '.mysqli_error($pdo));
while ($rows = mysqli_fetch_array($result)) {
        if ($rows["confirm"]) { 
			$rows["num"] = $num;
			$num++; 
		} else $rows["num"] = "";
        if (!$rows["name"]) $rows["name"] = 'Отзыв №'.$rows['id'];
        if ($edit==$rows["id"]) { 
            $result2 = mysqli_query($pdo,"SELECT * FROM cv_responses WHERE id = '{$rows['id']}'") or die('ошибка выполнения запроса '.mysqli_error($pdo));
            if ($rows2 = mysqli_fetch_array($result2)) { $smarty->assign("r", $rows2); $usr = $rows2; }
        }
        $smarty->append("response_list", $rows);
}

if (isset($usr)) {
        $result = mysqli_query($pdo,"SELECT * FROM cv_customers WHERE id = '{$usr['user_id']}'") or die('ошибка выполнения запроса '.mysqli_error($pdo));
        if ($rows3 = mysqli_fetch_array($result)) $smarty->assign("usr", $rows3);
}

?>
