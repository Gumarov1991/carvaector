<?php

$image = $_GET['i'];
$watermark = imagecreatefrompng('watermark.png');  
$watermark_width = imagesx($watermark);
$watermark_height = imagesy($watermark); 
$image_path = './pic_catalog/'.$image;
$im = getimagesize($image_path);
if ($im[2] && $im[1] > 120) {
	$a = 0;
	switch ($im[2]) {
		case 1: $a = ImageCreateFromGIF($image_path); break;
		case 2: $a = ImageCreateFromJPEG($image_path); break;
		case 3: $a = ImageCreateFromPNG($image_path); break;
	}
	if ($a === false) {
		imagedestroy($a);
		imagedestroy($watermark);
		exit;
	}
	$dest_x = ceil($im[0]/2) - ceil($watermark_width/2);
	$dest_y = ceil($im[1]/2) - ceil($watermark_height/2)+90;
	imagealphablending($a, true);
	imagealphablending($watermark, true);
	imagecopy($a, $watermark, $dest_x, $dest_y, 0, 0, $watermark_width, $watermark_height);
	header('content-type: image/jpeg');
	switch ($im[2]) { 
		case 1: imageGIF($a); break;
		case 2: imageJPEG($a); break;
		case 3: imagePNG($a); break;
	} 
	imagedestroy($a);
	imagedestroy($watermark);
	exit;
}
readfile($image_path);
exit;



?>