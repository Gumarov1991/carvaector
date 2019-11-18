<?php

$smarty->assign(array(  "id"            => $id,
                        ));
if (isset($_GET["del_dostavka_row"]))
        mysqli_query($pdo,"DELETE FROM cv_dostavka WHERE id = '".int_cip($_GET["del_dostavka_row"])."'") or die('ошибка выполнения запроса '.mysqli_error($pdo));
if (isset($_GET["add_dostavka_row"]))
        mysqli_query($pdo,"INSERT into cv_dostavka (language_id) VALUES ('$lang_id')") or die('ошибка выполнения запроса '.mysqli_error($pdo));
if ($save) {
        $result = mysqli_query($pdo,"SELECT * FROM cv_dostavka WHERE language_id = '$lang_id'") or die('ошибка выполнения запроса '.mysqli_error($pdo));
        while ($rows = mysqli_fetch_array($result)) {
                $sql = "exp = '".quote_cip($_POST["exp".$rows["id"]])."'";
                $sql .= ", imp = '".quote_cip($_POST["imp".$rows["id"]])."'";
                $sql .= ", dest = '".quote_cip($_POST["dest".$rows["id"]])."'";
                for($i=1;$i<=5;$i++) {
                        $sql .= ", summa".$i." = '".quote_cip($_POST["summa".$i."_".$rows["id"]])."'";
                        $sql .= ", descr".$i." = '".quote_cip($_POST["descr".$i."_".$rows["id"]])."'";
                }
                mysqli_query($pdo,"UPDATE cv_dostavka SET $sql WHERE id = '{$rows['id']}'") or die('ошибка выполнения запроса '.mysqli_error($pdo));
        }
        $result = mysqli_query($pdo,"SELECT exp,imp,dest FROM cv_dostavka WHERE language_id = '$lang_id' GROUP BY exp,imp,dest HAVING count(*)>1") or die('ошибка выполнения запроса '.mysqli_error($pdo));
        if ($rows = mysqli_fetch_array($result)) {
                $i = 1;$s = "";
                $result2 = mysqli_query($pdo,"SELECT * FROM cv_dostavka WHERE language_id = '$lang_id' ORDER BY id") or die('ошибка выполнения запроса '.mysqli_error($pdo));
                while ($rows2 = mysqli_fetch_array($result2)) {
                        if ($rows["exp"]==$rows2["exp"] && $rows["imp"]==$rows2["imp"] && $rows["dest"]==$rows2["dest"]) $s .= ", ".$i;
                        $i++;
                }
                $smarty->assign("onload", 'alert("Дублирующие значения для строк '.substr($s,2).'");');
        } else {
                $smarty->assign(array("alert"=>"Сохранено успешно","url"=>"./admin.php?content&lang_id=$lang_id&id=$id"));
                $smarty->display("exec_command.tpl");
                exit;
        }
}
$result = mysqli_query($pdo,"SELECT * FROM cv_dostavka WHERE language_id = '$lang_id' ORDER BY id") or die('ошибка выполнения запроса '.mysqli_error($pdo));
while ($rows = mysqli_fetch_array($result)) $smarty->append("dostavkas", $rows);

?>
