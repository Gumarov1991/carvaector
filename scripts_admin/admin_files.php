<?php

if (!isset($no_pages) || empty($no_pages)) $no_pages = 0;
if (!isset($page_e) || empty($page_e)) $page_e = 8;
if (!isset($page_str_n) || empty($page_str_n)) $page_str_n = 4;
if (!isset($dir) || empty($dir)) $dir = "./files/add/";

if (isset($_GET['page'])) $page = $_GET['page']; else $page = 0;
if (isset($_GET['del'])) $del = $_GET['del']; else $del = "";

if (!isset($no_navigation))
$smarty->assign("id", $id);
$f = array();
if ($del) if (file_exists($del)) unlink($del);
if (isset($_FILES["fn"]["tmp_name"]) && !empty($_FILES["fn"]["tmp_name"])) {
        if (file_exists($dir.$_FILES["fn"]["name"])) {
                $msg = "Файл с таким именем уже есть, загрузите файл с другим именем!";
                if (file_exists($_FILES["fn"]["tmp_name"])) unlink($_FILES["fn"]["tmp_name"]);
        } else {
                $msg = "Файл успешно загружен!";
                if (file_exists($_FILES["fn"]["tmp_name"])) {
                        move_uploaded_file($_FILES["fn"]["tmp_name"], $dir.$_FILES["fn"]["name"]);
                }
        }
        if ($part=="admin_partners") $url = "./admin.php?partners&edit=$edit"; else
                $url = "./admin.php?content&lang_id=$lang_id&id=$id".($edit?"&edit=$edit":"");
        $smarty->assign(array("alert"=>$msg,"url"=>$url));
        $smarty->display("exec_command.tpl");
        exit;
}
if ($dh=opendir($dir)) {
        while (($file=readdir($dh))!==false) if (!is_dir($dir.$file)) array_push($f, $file);
        closedir($dh);
}
sort($f);
$fc = count($f);
if ($fc!=0) {
	if (fmod($fc,$page_e)>$page_str_n) if (fmod($fc,$page_str_n)>0) for($i=0;$i<$page_str_n-fmod($fc,$page_str_n);$i++) array_push($f, "");
	$item_c = count($f);
	$page_c = ceil($item_c/$page_e);
	if (!$page || $page>$page_c) $page = $page_c;
	for($i=($page-1)*$page_e;$i<$page*$page_e && $i<count($f);$i++) {
			$ext_v = strtolower(substr($f[$i],strrpos($f[$i],".")));
			if (!isset($ext[$ext_v])) $ext_p = "./pics/ext_unknown.gif"; else $ext_p = $ext[$ext_v];
			$smarty->append("pics", array(  "href" => (($part=="admin_partners")?$dir2:$dir).$f[$i],
											"url" => urlencode($dir.$f[$i]),
											"name" => $f[$i],
											"size" => filesize($dir.$f[$i]),
											"xy" => get_image_xy($dir.$f[$i]),
											"ext" => $ext_p,
											));
	}
	$page_beg = $page-5;if ($page_beg<1) $page_beg = 1;
	for($i=$page_beg;$i<$page_beg+10 && $i<=$page_c;$i++) {
			$ii = $i;if (strlen($ii)==1) $ii = "0".$ii;
			$smarty->append("pages", array("page" => $i, "name" => $ii));
	}

	$smarty->assign(array(  "page_c"        => $page_c,
							"page"          => $page,
							"page_beg"      => $page_beg,
							"item_c"        => $item_c,
							"fcount"        => $fc,
							"no_pages"        => $no_pages,
							"page_str_n"    => $page_str_n,
							));
}
?>
