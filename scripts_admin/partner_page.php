<?php



define("DBName","carvectornet_db");
define("HostName","localhost");
define("UserName","carvector_dba");
define("Password","Rbid8rdSfgQrp");

if(!$pdo = mysqli_connect(HostName,UserName,Password,DBName))
{ echo "___Не могу сконнектиться с базой ".DBName."!___<br>"; exit;}
#if(!mysqli_select_db(DBName))
#{ echo "___Не могу сделать активной базу ".DBName."!___<br>"; exit;}
mysqli_query($pdo,"set names UTF8");

if (isset($_GET["id"])) $id = strtolower($_GET["id"]); else $id = "";
if (isset($_GET["err"])) $err = $_GET["err"]; else $err = "";
if (substr($id,0,4)=="www.") $id = substr($id,4);
$ext = strtolower(substr($err,strrpos($err,".")));
if (substr($err,0,5)=="pics/" && ($ext==".jpg" || $ext==".jpeg" || $ext==".png" || $ext==".gif"))
        $pic = "./../pics/partners/".$id."/".substr($err,5); else $pic = "";
if ($err) if ($pic && file_exists($pic)) {
        if ($ext==".jpg" || $ext==".jpeg") header ("Content-type: image/jpeg");
        if ($ext==".png" || $ext==".gif") header ("Content-type: image/".substr($ext,1));
        readfile($pic);
        exit;
}
if (strtolower($err)!="index.php") {
        echo "<html><body onLoad=\"window.location='https://".$_SERVER['HTTP_HOST']."/index.php';\"></body></html>";
        exit;
}
$result = mysqli_query("SELECT * FROM cv_partners WHERE subd = '$id'") or error();
if ($rows = mysqli_fetch_array($result)) {
        header('Content-type: text/html; charset=UTF-8');
        $data = $rows["site"];
        $data = str_replace("&#62;", ">", $data);
        $data = str_replace("&#60;", "<", $data);
        $data = str_replace("&#39;", "'", $data);
        $data = str_replace('&#34;', '"', $data);
        $data = str_replace("&#92;", "\\", $data);
        $data = str_replace("&#38;", "&", $data);
        echo $data;
} else {
        $h = $_SERVER['HTTP_HOST'];
        $i = strrpos($h, ".");
        $i = strrpos(substr($h,0,$i), ".");
        $h = substr($h,$i+1);
        echo "<html><body onLoad=\"window.location='https://".$h."';\"></body></html>";
        exit;
}

?>
