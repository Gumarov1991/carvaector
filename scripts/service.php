<?php

if (isset($_GET['id'])) $id = $_GET['id']; else $id = "";
if ($id) {
        $result = mysqli_query($pdo,"SELECT v.value FROM cv_content c, cv_content_value v WHERE c.id = '$id' AND v.language_id = '$lang_id' AND v.content_id = c.id") or error();
        if ($rows = mysqli_fetch_array($result)) $name = $rows['value'];
        $result = mysqli_query($pdo,"SELECT v.value FROM cv_content c, cv_content_value v WHERE c.content_id = '$id' AND v.language_id = '$lang_id' AND v.content_id = c.id") or error();
        if ($rows = mysqli_fetch_array($result)) $value = $rows['value'];
        $smarty->assign(array(  "service_name"  => $name,
                                "value"         => $value,
                                "id"            => $id,
                                ));
} else {
        $result = mysqli_query($pdo,"SELECT * FROM cv_content WHERE content_id = 8 ORDER BY position") or error();
        while ($rows = mysqli_fetch_array($result)) {
                $result2 = mysqli_query($pdo," SELECT * FROM cv_content_value WHERE language_id = '$lang_id' AND content_id = '{$rows[0]}'") or error();
                if ($rows2 = mysqli_fetch_array($result2)) $rows['value'] = $rows2['value'];
                $smarty->append("services", $rows);
        }
}

?>
