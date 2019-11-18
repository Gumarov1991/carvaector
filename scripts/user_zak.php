<?php

set_content(array(264,"286-291"));

if (isset($_GET['files'])) $files = $_GET['files']; else $files = '';
if ($files) {
        $result = mysqli_query($pdo,"SELECT * FROM cv_orders WHERE id = '$files'") or error();
        if ($rows = mysqli_fetch_array($result)) {
                $cfiles = explode('|', $rows['afiles']);
                for ($i=0;$i<count($cfiles);$i++) {
                        if (!empty($cfiles[$i]) && $cfiles[$i]!='Array' && $cfiles[$i]!=NULL) {
				$ff = explode(':', $cfiles[$i]);
                                if (!isset($ext[strtolower(substr($ff[0],strlen($ff[0])-4))])) $ext_p = "./pics/ext_unknown.gif"; else
                                        $ext_p = $ext[strtolower(substr($ff[0],strlen($ff[0])-4))];
                                $smarty->append("pics", array(  "href" => $ff[0],
                                                                "url" => urlencode($ff[0]),
                                                                "name" => $ff[1],
                                                                "size" => filesize($ff[0]),
                                                                "xy" => get_image_xy($ff[0]),
                                                                "ext" => $ext_p,
                                                                ));
                        }
                }
                if (count($cfiles)>4 && fmod(count($cfiles),4)>0) for($i=4;$i>fmod(count($cfiles),4);$i--)
                        $smarty->append("pics", array("href"=>"","name"=>""));
                $smarty->assign("zak_name", $rows["name"]);
        }
        $smarty->assign("files", $files);
} else {
        $result = mysqli_query($pdo,"SELECT o.*, date_format(o.adate,'%d %b %Y') dt FROM cv_orders o WHERE o.uid = '{$_SESSION['login_user_id']}' ORDER BY o.adate") or error();
        while ($rows = mysqli_fetch_array($result)) {
                $rows["num"] = $rows["id"];
                while (strlen($rows["num"])<4) $rows["num"] = "0".$rows["num"];
                $smarty->append("zaks", $rows);
        }
}

?>
