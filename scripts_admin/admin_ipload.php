<?php

$smarty->assign("id", $id);
if (isset($_FILES["fn"]["tmp_name"]) && !empty($_FILES["fn"]["tmp_name"]) && file_exists($_FILES["fn"]["tmp_name"])) {
        $zip = zip_open($_FILES["fn"]["tmp_name"]);$i = 0;
        if ($zip) {
                while ($i<=1 && $zip_entry=zip_read($zip)) {
                        $i++;if ($i>1) break;
                        if (zip_entry_open($zip, $zip_entry, "r")) {
                            $buf = zip_entry_read($zip_entry, zip_entry_filesize($zip_entry));
                            zip_entry_close($zip_entry);
                        }
                }
                zip_close($zip);
        }
        unlink($_FILES["fn"]["tmp_name"]);
        if ($i!=1) $msg = "error"; else {
                set_time_limit(0);
                mysqli_query($pdo,"TRUNCATE TABLE cv_iptable") or die('ошибка выполнения запроса '.mysqli_error($pdo));
                $s = split(chr(10), $buf);
                for($i=0;$i<count($s);$i++) {
                        $ss = split(",", str_replace('"','',$s[$i]));
                        $sql = "INSERT into cv_iptable (ip_from, ip_to, short, country) VALUES ('".$ss[2]."','".$ss[3]."','".$ss[4]."','".str_replace("'","&#39;",$ss[5])."')";
                        mysqli_query($pdo,$sql) or die('ошибка выполнения запроса '.mysqli_error($pdo)." - ".$sql);
                }
                $msg = "Файл успешно загружен!";
        }
        $smarty->assign(array("alert"=>$msg,"url"=>"./admin.php?content&lang_id=$lang_id&id=$id"));
        $smarty->display("exec_command.tpl");
        exit;
}
if ($save) {
        $result = mysqli_query($pdo,"SELECT distinct short, country, language_id FROM cv_iptable ORDER BY country") or die('ошибка выполнения запроса '.mysqli_error($pdo));
        while ($rows = mysqli_fetch_array($result)) if ($rows["country"])
                mysqli_query($pdo,"UPDATE cv_iptable SET language_id = '".int_cip($_POST["lang".$rows["short"]])."' WHERE short = '{$rows['short']}'") or die('ошибка выполнения запроса '.mysqli_error($pdo));
        $smarty->assign(array("alert"=>"Успешно сохранено","url"=>"./admin.php?content&lang_id=$lang_id&id=$id"));
        $smarty->display("exec_command.tpl");
        exit;
}
$result = mysqli_query($pdo,"SELECT distinct short, country, language_id FROM cv_iptable ORDER BY country") or die('ошибка выполнения запроса '.mysqli_error($pdo));
while ($rows = mysqli_fetch_array($result)) if ($rows["country"]) $smarty->append("iptables", $rows);

?>
