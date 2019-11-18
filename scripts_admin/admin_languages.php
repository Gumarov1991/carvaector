<?php

if (isset($_GET['del'])) $del = int_cip($_GET['del']); else $del = "";
if (isset($_POST['save'])) $save = $_POST['save']; else $save = "";
if ($save) {
        $result = mysqli_query($pdo,"SELECT * FROM cv_language") or die('ошибка выполнения запроса '.mysqli_error($pdo));
        while ($rows = mysqli_fetch_array($result)) {
                $a = $_POST['active'.$rows['id']];
                if ($a) $a = 1; else $a = 0;
                mysqli_query($pdo,"UPDATE cv_language SET name = '".quote_cip($_POST['name'.$rows['id']])."', active = '$a' WHERE id = '{$rows['id']}'") or die('ошибка выполнения запроса '.mysqli_error($pdo));
        }
        $smarty->assign(array("alert"=>"Успешно сохранено","url"=>"./admin.php?languages"));
        $smarty->display("exec_command.tpl");
        exit;
}
if (isset($_GET['add'])) {
        mysqli_query($pdo,"INSERT into cv_language (name) VALUES ('')") or die('ошибка выполнения запроса '.mysqli_error($pdo));
        $smarty->assign(array("url"=>"./admin.php?languages"));
        $smarty->display("exec_command.tpl");
        exit;
}
if ($del) mysqli_query($pdo,"DELETE FROM cv_language WHERE id = '$del'") or die('ошибка выполнения запроса '.mysqli_error($pdo));
$result = mysqli_query($pdo,"SELECT * FROM cv_language") or die('ошибка выполнения запроса '.mysqli_error($pdo));
while ($rows = mysqli_fetch_array($result)) $smarty->append("languages", $rows);

?>
