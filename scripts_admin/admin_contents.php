<?php

function get_content($id, $name, $level, $id_sel) {
	global $pdo;
        $res = array();$i = 0;$bol = false;
        $result = mysqli_query($pdo,"SELECT * FROM cv_content WHERE content_id = '$id' ORDER BY position") or die('ошибка выполнения запроса '.mysqli_error($pdo));
        while ($rows = mysqli_fetch_array($result)) {
                $r = get_content($rows["id"], $rows["name"], $level+1, $id_sel);
                if ($rows["id"]==$id_sel || $r[2]) $bol = true;
                if ($r[2]) $rows['dis'] = 'yes';
                $rows["res"] = $r[0];
                $rows['last'] = '';
                array_push($res, $rows);
                $i++;
        }
        if (count($res)>0) $res[count($res)-1]['last'] = 'yes';
        return array($res,$i,$bol);
}


if (isset($_GET['id'])) $id = int_cip($_GET['id']); else $id = "";
if (isset($_GET['del'])) $del = int_cip($_GET['del']); else $del = 0;
if (isset($_POST['save'])) $save = $_POST['save']; else $save = "";
$res = get_content(0, '', 0, $id);
$smarty->assign("contents", $res[0]);

$id2 = $id;$nav = "";
while ($id2) {
        $result = mysqli_query($pdo,"SELECT * FROM cv_content WHERE id = '$id2'") or die('ошибка выполнения запроса '.mysqli_error($pdo));
        if ($rows = mysqli_fetch_array($result)) {
                $id_last = $id2;$id2 = $rows['content_id'];
                $nav = " &#187; ".$rows['name'].$nav;
        }
}
if ($id) {
        if (isset($_GET['add']))
                mysqli_query($pdo,"INSERT into cv_content (content_id, position, name, type) VALUES ('$id', '10000', ' ', 3)") or die('ошибка выполнения запроса '.mysqli_error($pdo));
        if ($del)
                mysqli_query($pdo,"DELETE FROM cv_content WHERE id = '$del'") or die('ошибка выполнения запроса '.mysqli_error($pdo));
        $result = mysqli_query($pdo,"SELECT * FROM cv_content WHERE content_id = '$id' ORDER BY position") or die('ошибка выполнения запроса '.mysqli_error($pdo));
        while ($rows = mysqli_fetch_array($result)) {
                if ($save) {
                        $p = int_cip($_POST["p".$rows["id"]]);$rows["position"] = $p;
                        $n = quote_cip($_POST["n".$rows["id"]]);$rows["name"] = $n;
                        $t = int_cip($_POST["t".$rows["id"]]);$rows["type"] = $t;
                        mysqli_query($pdo,"UPDATE cv_content set position = '$p', name = '$n', type = '$t' WHERE id = '{$rows['id']}'") or die('ошибка выполнения запроса '.mysqli_error($pdo));
                        $smarty->assign("onload",'alert("Успешно сохранено");');
                }
                $smarty->append("content_list", $rows);
        }
        $smarty->assign(array(  "id"            => $id,
                                ));
}

?>
