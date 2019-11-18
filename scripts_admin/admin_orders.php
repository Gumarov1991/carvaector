<?php
if (isset($_GET['id'])) $id = int_cip($_GET['id']); else $id = 0;
if (isset($_GET['page'])) $page = int_cip($_GET['page']); else $page = "";
if (isset($_GET['del'])) $del = quote_cip($_GET['del']); else $del = "";
if (isset($_GET['order_del'])) $order_del = int_cip($_GET['order_del']); else $order_del = "";
if (isset($_GET["findtrno"]) && !empty($_GET["findtrno"])) $findtrno = quote_cip($_GET["findtrno"]); else $findtrno = "";
if (isset($_GET["finduid"]) && !empty($_GET["finduid"])) $finduid = quote_cip($_GET["finduid"]); else $finduid = "";
$ext = array(   ".jpg" => "pic",
                ".jpeg" => "pic",
                ".gif" => "pic",
                ".png" => "pic",
                ".doc" => "./pics/ext_doc.gif",
                ".xls" => "./pics/ext_xls.gif",
                ".csv" => "./pics/ext_csv.gif",
                ".rar" => "./pics/ext_rar.gif",
                ".zip" => "./pics/ext_rar.gif",
                ".txt" => "./pics/ext_txt.gif",
                ".pdf" => "./pics/ext_pdf.gif",
                );

if ($id) {
        if ($del && $grant[2]) {
                $result = mysqli_query($pdo,"SELECT * FROM cv_orders WHERE id = '$id'") or die('ошибка выполнения запроса '.mysqli_error($pdo));
                $rows = mysqli_fetch_array($result);
                $f = $rows["afiles"];while (substr($f,0,1)=="|") $f = substr($f,1);
                if (strpos(" |".$f, "|".$del.":")) {
                        if (file_exists($del)) unlink($del);
                        $f = @split("\|", $f);$af = "";
                        for($i=0;$i<count($f);$i++) {
                                $ff = @split(":", $f[$i]);
                                if (substr($ff[0],0,3)=="../") $ff[0] = substr($ff[0],3);
                                if (file_exists($ff[0])) $af .= $ff[0].":".$ff[1]."|";
                        }
                        $af = substr($af, 0, strlen($af)-1);
                        mysqli_query($pdo,"UPDATE cv_orders SET afiles = '$af' WHERE id = '$id'") or die('ошибка выполнения запроса '.mysqli_error($pdo));
                }
                $smarty->assign(array("url"=>"./admin.php?orders&page=$page&id=$id&findtrno=$findtrno&finduid=$finduid"));
                $smarty->display("exec_command.tpl");
                exit;
        }
        if (isset($_POST['add']) && isset($_FILES["fn"]["tmp_name"]) && !empty($_FILES["fn"]["tmp_name"]) && $grant[2]) {
                $dir = "./files/zakaz/";
                if (file_exists($dir.$_FILES["fn"]["name"])) {
                        $msg = "Файл с таким именем уже есть, загрузите файл с другим именем!";
                        if (file_exists($_FILES["fn"]["tmp_name"])) unlink($_FILES["fn"]["tmp_name"]);
                } else {
                        $msg = "Файл успешно загружен!";
                        if (@file_exists($_FILES["fn"]["tmp_name"])) {
                                move_uploaded_file($_FILES["fn"]["tmp_name"], $dir.$_FILES["fn"]["name"]);
                                $result = mysqli_query($pdo,"SELECT * FROM cv_orders WHERE id = '$id'") or die('ошибка выполнения запроса '.mysqli_error($pdo));
                                $rows = mysqli_fetch_array($result);
                                $f = $rows["afiles"];while (substr($f,0,1)=="|") $f = substr($f,1);
                                $f = @split("\|", $f);$af = "";
                                for($i=0;$i<count($f);$i++) {
                                        $ff = @split(":", $f[$i]);
                                        if (substr($ff[0],0,3)=="../") $ff[0] = substr($ff[0],3);
                                        if (file_exists($ff[0])) $af .= $ff[0].":".$ff[1]."|";
                                }
                                $af .= $dir.$_FILES["fn"]["name"].":".str_replace(":", "", str_replace("\|", "", quote_cip($_POST["note"])));
                                mysqli_query($pdo,"UPDATE cv_orders SET afiles = '$af' WHERE id = '$id'") or die('ошибка выполнения запроса '.mysqli_error($pdo));
                        }
                }
                $smarty->assign(array("alert"=>$msg,"url"=>"./admin.php?orders&page=$page&id=$id&findtrno=$findtrno&finduid=$finduid"));
                $smarty->display("exec_command.tpl");
                exit;
        }
        if (isset($_GET["add"]) && $grant[2]) {
                mysqli_query($pdo,"INSERT INTO cv_orders (uid, aid, adate) VALUES ('$id', '{$_SESSION['login_id']}', now())") or die('ошибка выполнения запроса '.mysqli_error($pdo));
                $result = mysqli_query($pdo,"SELECT max(id) FROM cv_orders WHERE uid = '$id' and aid = '{$_SESSION['login_id']}'") or die('ошибка выполнения запроса '.mysqli_error($pdo));
                $rows = mysqli_fetch_array($result);$id = $rows[0];
                $smarty->assign(array("url"=>"./admin.php?orders&id=$id&findtrno=$findtrno&finduid=$finduid"));
                $smarty->display("exec_command.tpl");
                exit;
        }
        if (isset($_POST['save']) && $grant[2]) {
                mysqli_query($pdo,"UPDATE cv_orders SET       name = '".quote_cip($_POST["name"])."',
                                                        adate = '".quote_cip($_POST["adate"])."',
                                                        trno = '".quote_cip($_POST["trno"])."',
                                                        logist = '".quote_cip($_POST["logist"])."',
                                                        note = '".quote_cip($_POST["note"])."',
                                                        alocation = '".quote_cip($_POST["alocation"])."'
                                                        WHERE id = '$id'") or die('ошибка выполнения запроса '.mysqli_error($pdo));
                $smarty->assign(array("url"=>"./admin.php?orders&page=$page&findtrno=$findtrno&finduid=$finduid"));
                $smarty->display("exec_command.tpl");
                exit;
        }
        $result = mysqli_query($pdo,"SELECT * FROM cv_orders WHERE id = '$id'") or die('ошибка выполнения запроса '.mysqli_error($pdo));
        $rows = mysqli_fetch_array($result);
        $result2 = mysqli_query($pdo,"SELECT name FROM cv_customers WHERE id = '{$rows['uid']}'") or die('ошибка выполнения запроса '.mysqli_error($pdo));
        $rows2 = mysqli_fetch_array($result2);
        $smarty->assign(array(  "order" => $rows,
                                "id" => $id,
                                "page" => $page,
                                "findtrno" => $findtrno,
                                "finduid" => $finduid,
                                "uname" => $rows2["name"],
                                "dt" => date("Y-m-d"),
                                ));
        $f = $rows["afiles"];while (substr($f,0,1)=="|") $f = substr($f,1);
        $f = @split("\|", $f);$fc = 0;
        for($i=0;$i<count($f);$i++) {
                $ff = @split(":", $f[$i]);
                if (substr($ff[0],0,3)=="../") $ff[0] = substr($ff[0],3);
                if (file_exists($ff[0])) {
                        $ext_v = strtolower(substr($ff[0],strrpos($ff[0],".")));
                        if (!isset($ext[$ext_v])) $ext_p = "./pics/ext_unknown.gif"; else $ext_p = $ext[$ext_v];
                        $smarty->append("pics", array(  "href" => $ff[0],
                                                        "url" => urlencode($ff[0]),
                                                        "name" => $ff[1],
                                                        "size" => filesize($ff[0]),
                                                        "xy" => get_image_xy($ff[0]),
                                                        "ext" => $ext_p,
                                                        ));
                        $fc++;
                }
        }
        if ($fc>6) if (fmod($fc,6)>0) for($i=0;$i<6-fmod($fc,6);$i++) $smarty->append("pics",array("href"=>""));
} else {
        $ep = 10;
        if ($order_del && $grant[2]) {
                $result = mysqli_query($pdo,"SELECT * FROM cv_orders WHERE id = '$order_del'") or die('ошибка выполнения запроса '.mysqli_error($pdo));
                $rows = mysqli_fetch_array($result);
                $f = $rows["afiles"];while (substr($f,0,1)=="|") $f = substr($f,1);
                $f = @split("\|", $f);$af = "";
                for($i=0;$i<count($f);$i++) {
                        $ff = @split(":", $f[$i]);
                        if (substr($ff[0],0,3)=="../") $ff[0] = substr($ff[0],3);
                        if (file_exists($ff[0])) unlink($ff[0]);
                }
                mysqli_query($pdo,"DELETE FROM cv_orders WHERE id = '$order_del'") or die('ошибка выполнения запроса '.mysqli_error($pdo));
        }
        $result = mysqli_query($pdo,"SELECT count(*) FROM cv_orders o, cv_customers u WHERE ".($findtrno?"o.trno = '$findtrno' and ":"").($finduid?"u.id = '$finduid' and ":"")."o.uid = u.id") or die('ошибка выполнения запроса '.mysqli_error($pdo));
        if ($rows = mysqli_fetch_array($result)) $pc = ceil($rows[0]/$ep);
		if ($page != "" && $page < 1) $page = 1;
		if ($page=="" || $page > $pc) $page = $pc;
        if ($pc) {
			$result = mysqli_query($pdo," SELECT o.*, u.name user_name
									FROM cv_orders o, cv_customers u
									WHERE ".($findtrno?"o.trno = '$findtrno' and ":"").($finduid?"u.id = '$finduid' and ":"")."o.uid = u.id
									ORDER BY o.trno
									LIMIT ".(($page-1)*$ep).",$ep") or die('ошибка выполнения запроса '.mysqli_error($pdo));
			while ($rows = mysqli_fetch_array($result)) $smarty->append("orders", $rows);
			$pb = $page - 5;
			if ($pb<1) $pb = 1;
			for($i=$pb; $i<$pb+10 && $i<=$pc; $i++) {
				$smarty->append("pages", array("n"=>$i,"p"=>((strlen($i)==1)?"0".$i:$i)));
			}
        }
		if(!isset($pb)) $pb = 1;
		
        $result2 = mysqli_query($pdo,"SELECT name FROM cv_customers WHERE id = '{$finduid}'") or die('ошибка выполнения запроса '.mysqli_error($pdo));
        $rows2 = mysqli_fetch_array($result2);
        $smarty->assign(array(  "page_beg"  => $pb,
                                "page"      => $page,
                                "page_c"    => $pc,
                                "findtrno" 	=> $findtrno,
                                "finduid"  	=> $finduid,
                                "cname" 	=> $rows2["name"],
                                ));
}

?>
