<?php

$smarty->assign(array(  "id"            => $id,
        "edit"          => $edit,
));
if ($save) {
        for($i=0;$i<8;$i++) {
                if (isset($_POST['n'.$i])) $j = $_POST['n'.$i];
                $queryUPD = "
                UPDATE cv_hotpr
                SET     name = '" . $_POST['name'.$i] . "',
                        note = '" . $_POST['note'.$i] . "',
                        mark = '" . $_POST['mark'.$i] . "',
                        model = '" . $_POST['model'.$i] . "',
                        year = '" . $_POST['year'.$i] . "',
                        engine = '" . $_POST['engine'.$i] . "',
                        chassis = '" . $_POST['chassis'.$i] . "',
                        mileage = '" . $_POST['mileage'.$i] . "',
                        transmission = '" . $_POST['transmission'.$i] . "',
                        fuel = '" . $_POST['fuel'.$i] . "',
                        color = '" . $_POST['color'.$i] . "',
                        delivery = '" . $_POST['delivery'.$i] . "',
                        amount = '" . $_POST['amount'.$i] . "'
                        WHERE id = '$j'";

                if ($j) mysqli_query($pdo, $queryUPD) or die('ошибка выполнения запроса '.mysqli_error($pdo));
                else mysqli_query($pdo,"INSERT into cv_hotpr (language_id, name, amount, note) VALUES
                        ('$lang_id', '".$_POST['name'.$i]."', '".$_POST['amount'.$i]."', '".$_POST['note'.$i]."')") or die('ошибка выполнения запроса '.mysqli_error($pdo));

                if (isset($_FILES['fn'.$i]['tmp_name']) && !empty($_FILES['fn'.$i]['tmp_name'])) {
                        if ($j && file_exists("./files/hotpr/".$j.".jpg")) unlink("./files/hotpr/".$j.".jpg");
                        if ($j && file_exists("./files/hotpr/".$j.".jpeg")) unlink("./files/hotpr/".$j.".jpeg");
                        if ($j && file_exists("./files/hotpr/".$j.".png")) unlink("./files/hotpr/".$j.".png");
                        if ($j && file_exists("./files/hotpr/".$j.".gif")) unlink("./files/hotpr/".$j.".gif");
                        if (!$j) {
                                $result = mysqli_query($pdo,"SELECT max(id) FROM cv_hotpr WHERE language_id = '$lang_id'") or die('ошибка выполнения запроса '.mysqli_error($pdo));
                                $rows = mysqli_fetch_array($result);$j = $rows[0];
                        }
                        $fn = $_FILES['fn'.$i]['name'];
                        $fn = strtolower(substr($fn,strrpos($fn,".")));
                        move_uploaded_file($_FILES['fn'.$i]['tmp_name'], "./files/hotpr/".$j.$fn);
                }
        }
        $smarty->assign("onload",'alert("Успешно сохранено");');
}
$i = 0;
$result = mysqli_query($pdo,"SELECT * FROM cv_hotpr WHERE language_id = '$lang_id' ORDER BY id") or die('ошибка выполнения запроса '.mysqli_error($pdo));
while ($rows = mysqli_fetch_array($result)) {
        $rows["name"] = quote_cip($rows["name"]);
        $rows["note"] = quote_cip($rows["note"]);
        $rows["mark"] = quote_cip($rows["mark"]);
        $rows["model"] = quote_cip($rows["model"]);
        $rows["year"] = quote_cip($rows["year"]);
        $rows["engine"] = quote_cip($rows["engine"]);
        $rows["chassis"] = quote_cip($rows["chassis"]);
        $rows["mileage"] = quote_cip($rows["mileage"]);
        $rows["transmission"] = quote_cip($rows["transmission"]);
        $rows["fuel"] = quote_cip($rows["fuel"]);
        $rows["color"] = quote_cip($rows["color"]);
        $rows["delivery"] = quote_cip($rows["delivery"]);
        $rows["amount"] = quote_cip($rows["amount"]);
        $fn = ext_to_pic("./files/hotpr/".$rows['id'].".");
        if ($fn) $rows['photo'] = urlencode($fn); else $rows['photo'] = "";
        $rows['dt'] = date("YmdHis");
        $smarty->append("hot_list", $rows);$i++;
}
for($j=$i;$j<5;$j++) $smarty->append("hot_list", array());

        ?>
