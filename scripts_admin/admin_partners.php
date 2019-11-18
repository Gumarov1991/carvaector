<?php

function site_cip($data) {
        $data = strtolower(trim(preg_replace('/[^a-zA-Z0-9-_]/i', '', $data)));
        if (substr($data,0,4)=="www.") $data = substr($data,4);
        return $data;
}
if (isset($_GET['del'])) $del = site_cip($_GET['del']); else $del = "";
if (isset($_GET['edit'])) $edit = site_cip($_GET['edit']); else $edit = "";
$dir = "./pics/partners/";

function del_dir($dir) {
        if ($dh=opendir($dir)) {
                while (($file=readdir($dh))!==false)
                        if (is_dir($dir.$file)) {
                                if ($file!="." && $file!="..") del_dir($dir.$file."/");
                        } else unlink($dir.$file);
                closedir($dh);
                rmdir($dir);
        }
}

if ($edit) {
        if (isset($_POST["save"])) {
                $subd = site_cip($_POST["subd"]);
                $name = quote_cip($_POST["name"]);
                $note = quote_cip($_POST["note"]);
                $note = str_replace('\\"', '"', $note);
                $note = str_replace("\\'", "'", $note);
                if ($subd!=$edit && file_exists($dir.$subd."/")) {
                        $smarty->assign(array("alert"=>"Поддомен $subd уже существует!","url"=>"./admin.php?partners&edit=$edit"));
                        $smarty->display("exec_command.tpl");
                        exit;
                } else {
                        if ($subd!=$edit) rename($dir.$edit, $dir.$subd);
                        mysqli_query($pdo,"UPDATE cv_partners SET subd = '$subd', name = '$name', site = '$note' WHERE subd = '$edit'") or die('ошибка выполнения запроса '.mysqli_error($pdo));
                        $smarty->assign(array("alert"=>"Сохранено успешно","url"=>"./admin.php?partners"));
                        $smarty->display("exec_command.tpl");
                        exit;
                }
        }
        $result = mysqli_query($pdo,"SELECT * FROM cv_partners WHERE subd = '$edit'") or die('ошибка выполнения запроса '.mysqli_error($pdo));
        if ($rows = mysqli_fetch_array($result)) { $name = $rows["name"];$note = $rows["site"]; }
        $smarty->assign(array(  "name" => $name,
                                "note" => $note,
                                "edit" => $edit,
                                "part" => $part,
                                ));
        $dir .= $edit."/";
        $host = $_SERVER['HTTP_HOST'];if (substr($host,0,4)=="www.") $host = substr($host, 4);
        $dir2 = "http://".$edit.".".$host."/pics/";
        $dir2 = $dir;
        $no_navigation = "yes";
        $page_e = 4;
        $page_str_n = 2;
        include "./scripts_admin/admin_files.php";
} else {
        if ($del) {
                try { del_dir($dir.$del."/"); } catch (Exception $e) { }
                mysqli_query($pdo,"DELETE FROM cv_partners WHERE subd = '$del'") or die('ошибка выполнения запроса '.mysqli_error($pdo));
                $smarty->assign(array("alert"=>"","url"=>"./admin.php?partners"));
                $smarty->display("exec_command.tpl");
                exit;
        }
        if (isset($_POST["add"])) {
                $subd = site_cip($_POST["subd"]);
                if ($subd) {
                        $name = quote_cip($_POST["name"]);
                        $result = mysqli_query($pdo,"SELECT * FROM cv_partners WHERE subd = '$subd'") or die('ошибка выполнения запроса '.mysqli_error($pdo));
                        if ($rows = mysqli_fetch_array($result)) $msg = "Такой поддомен уже существует!"; else {
                                mkdir($dir.$subd, 0777);
                                chmod($dir.$subd, 0777);
                                mysqli_query($pdo,"INSERT into cv_partners (subd,name) VALUES ('$subd','$name')") or die('ошибка выполнения запроса '.mysqli_error($pdo));
                                $msg = "Поддомен успешно добавлен!";
                        }
                } else $msg = "Не верное значение в поле поддомен!";
                $smarty->assign(array("alert"=>$msg,"url"=>"./admin.php?partners"));
                $smarty->display("exec_command.tpl");
                exit;
        }
        $result = mysqli_query($pdo,"SELECT subd, name FROM cv_partners ORDER BY subd") or die('ошибка выполнения запроса '.mysqli_error($pdo));
        while ($rows = mysqli_fetch_array($result)) {
                $host = $_SERVER['HTTP_HOST'];if (substr($host,0,4)=="www.") $host = substr($host, 4);
                $rows["site"] = $rows["subd"].".".$host;
                $smarty->append("partners", $rows);
        }
}

?>
