<?php

ini_set("display_errors","0");
$no_connect_mysql = "yes";
require("./scripts_admin/db_config.php");

if (isset($_GET['t'])) $tt = $_GET['t']; else $tt = 0;
$w = $_GET['w'];
$h = $_GET['h'];
$p = $_GET['pic'];
$res = get_image($p,$tt,true);
$im = $res[0];$t = $res[1];
if (!$im) { $im = @imagecreatefromgif("./pics/no_foto.gif");$t = "gif"; }
$ww = imagesx($im);
$hh = imagesy($im);
$hhh = $w*$hh/$ww;$www = $w;
if ($hhh>$h) { $www = $h*$ww/$hh;$hhh = $h; }
$im_d = imagecreatetruecolor($w, $h);
$bgc = imagecolorallocate ($im_d, 255, 255, 255);
imagefilledrectangle($im_d, 0, 0, $w, $h, $bgc);
imagecopyresampled($im_d, $im, ($w-$www)/2, ($h-$hhh)/2, 0, 0, $www, $hhh, $ww, $hh);
imagedestroy($im);
header ("Content-type: image/".$t);
$func = "image".$t;$func($im_d);
imagedestroy($im_d);

?>
