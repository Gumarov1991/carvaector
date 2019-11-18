<?php

define("DBName", "carvectornet_db");
define("HostName", "localhost");
define("UserName", "carvector_dba");
define("Password", "Rbid8rdSfgQrp");


if (!isset($no_connect_mysql)) {
	if (!$pdo = mysqli_connect(HostName, UserName, Password, DBName)) {
		echo "___Не могу сконнектиться с базой " . DBName . "!___<br>";
		exit;
	}
#        if(!mysqli_select_db(DBName))
#        { echo "___Не могу сделать активной базу ".DBName."!___<br>"; exit;}
	mysqli_query($pdo, "set names UTF8");
	mysqli_query($pdo, "SET SQL_BIG_SELECTS=1");
}

$ext = array(".jpg" => "pic",
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

$sn = $_SERVER["SCRIPT_NAME"];
$sn = substr($sn, strrpos($sn, "/") + 1);
if ($sn == "admin.php") {
	session_start();
	$sess_id = session_id();
	$result = mysqli_query($pdo, "SELECT * FROM cv_administrations WHERE session_id = '$sess_id'") or error();
	if ($rows = mysqli_fetch_array($result)) {
		$_SESSION['login_id'] = $rows["id"];
		$_SESSION['login_idocs'] = $rows["idocs"];
		$_SESSION['login'] = $rows["login"];
		$_SESSION['login_grant'] = $rows['grant'];
		if ($rows['type'] == '1') $_SESSION['login_admin'] = 'admin';
		else if ($rows['type'] == '2') $_SESSION['login_admin'] = 'mpo';
		else if ($rows['type'] == '3') $_SESSION['login_admin'] = 'mpf';
		else if ($rows['type'] == '4') $_SESSION['login_admin'] = 'spr';
		else if ($rows['type'] == '5') $_SESSION['login_admin'] = 'logist';
		$clip = client_ip();
		$_SESSION['ip'] = $clip;
		$geoinfo = geoinfi($clip);
		if ($geoinfo["country_code"] == "unknown") $geoinfo = geoinf2($clip);
		$sgeoinfo = $geoinfo["country_name"];
		if ($geoinfo["region"] != "-") $sgeoinfo = $sgeoinfo . "\n" . $geoinfo["region"];
		if ($geoinfo["city"] != "-" && $geoinfo["city"] != $geoinfo["region"]) $sgeoinfo = $sgeoinfo . ", " . $geoinfo["city"];
		mysqli_query($pdo, "UPDATE cv_administrations SET dateinput = now(), ip = '$clip', country_by_ip = '$sgeoinfo' WHERE id = '{$_SESSION['login_id']}'") or error();
	} else {
		$_SESSION['login_admin'] = "";
		$_SESSION['login_id'] = "";
	}
}
if ($sn == "index.php") {
	session_start();
	$sess_id = session_id();
	$result = mysqli_query($pdo, "SELECT id, direct, email, cus_pass FROM cv_customers WHERE session_id = '$sess_id'") or error();

	if ($rows = mysqli_fetch_array($result)) {

		// синхронизация с состоянем токена auc.cvr
		if ($_COOKIE['ajuser']) {
			//
			$_SESSION['login_user_id'] = $rows["id"];
			$_SESSION['login_user'] = 'user';
			if ($rows["direct"] == 1) $_SESSION['direct_user'] = 'direct';
#				$_SESSION['country'] = apache_note("GEOIP_COUNTRY_NAME");

			if (!$_COOKIE['ajuser']) {
				$auc_mode = 'login';
				$email = $rows['email'];
				$pass = $rows['cus_pass'];
				include __DIR__ . '/../scripts/auc/register_in_auc.php';
			}

			$_SESSION['country'] = $_SERVER['GEOIP_COUNTRY_NAME'];
			mysqli_query($pdo, "UPDATE cv_customers SET ts_lastinput = now() WHERE id = '{$_SESSION['login_user_id']}'") or error();
		} else {
			mysqli_query($pdo, "UPDATE cv_customers SET session_id = '' WHERE id = '{$_SESSION['login_user_id']}'") or error();
			$_SESSION['login_user'] = "";
			$_SESSION['login_user_id'] = "";
			$_SESSION['counter'] = "0";
			include __DIR__ . '/../scripts/logout.php';
		}

	} else {
		$_SESSION['login_user'] = "";
		$_SESSION['login_user_id'] = "";
		$_SESSION['direct_user'] = "";
		include __DIR__ . '/../scripts/logout.php';
	}
}

function generate_key() {
	return md5(uniqid(rand(), true));
}

function latin_cip($data) {
	return trim(preg_replace('/[^?!#$%\d@a-zA-Z0-9-_.s() ]/i', '', $data));
}

function cip($data) {
	return trim(preg_replace('/[^\?\d@a-zA-Zа-яА-Я-_\.\s\(\) ]/iu', '', $data));
}

function int_cip($data) {
	return trim(preg_replace('/[^0-9]/i', '', $data));
}

function phone_cip($data) {
	return trim(preg_replace('/[^0-9-+\(\)\s ]/i', '', $data));
}

function quote_cip($data) {
	$data = str_replace("&", "&#38;", $data);
	$data = str_replace('\\"', '&#34;', $data);
	$data = str_replace("\\'", "&#39;", $data);
	$data = str_replace("\\\\", "&#92;", $data);
	$data = str_replace('"', '&#34;', $data);
	$data = str_replace("'", "&#39;", $data);
	$data = str_replace("<", "&#60;", $data);
	$data = str_replace(">", "&#62;", $data);
	return $data;
}

function send_to_mail_two($user_id) {
	global $pdo;
	$result = mysqli_query($pdo, "SELECT email FROM cv_administrations WHERE id = '1'") or error();
	if ($rowss = mysqli_fetch_array($result)) {
		$result = mysqli_query($pdo, "SELECT name,email FROM cv_administrations WHERE id = '$user_id'") or error();
		$row = mysqli_fetch_array($result);
		$name = $row[0];
		$email = $row[1];
		$text_email = 'Внимание административный пользователь ' . $name . ' с id ' . $user_id . ' и email ' . $email . ' зашел одновременно два раза';
		$subj = 'Уведомление об одновременном входе неск. человек';
		$subj = '=?utf-8?B?' . base64_encode($subj) . '?=';
		$header = "From: " . $rowss[0] . "\n";
		$header .= "Content-type: text/html; charset=\"UTF-8\"\n";
		if (@mail($rowss[0], $subj, $text_email, $header)) return 'На email отправлено письмо с уведомлением об одновременном входе';
		else return 'На email не удалось отправить письмо с уведомлением об одновременном входе';
	} else return 'Такого пользователя нет в базеы нет в базе';
}

function send_to_mail($user_id) {
	global $pdo;
	$result = mysqli_query($pdo, "SELECT email FROM cv_administrations WHERE id = '1'") or error();
	$rowss = mysqli_fetch_array($result);
	$result = mysqli_query($pdo, "SELECT name,email FROM cv_customers WHERE id = '$user_id'") or error();
	if ($rows = mysqli_fetch_array($result)) {
		$name = $rows[1];
		$email = $rows[1];
		$text_email = 'Внимание пользователь ' . $name . ' с id ' . $user_id . ' и email ' . $email . ' зашел одновременно два раза';
		$subj = 'Уведомление об одновременном входе неск. человек';
		$subj = '=?utf-8?B?' . base64_encode($subj) . '?=';
		$header = "From: " . $rowss[0] . "\n";
		$header .= "Content-type: text/html; charset=\"UTF-8\"\n";
		if (@mail($rowss[0], $subj, $text_email, $header)) return 'На email отправлено письмо с уведомлением об одновременном входе';
		else return 'На email не удалось отправить письмо с уведомлением об одновременном входе';
	} else return 'Такого пользователя нет в базеы нет в базе';
}

function get_image_xy($pic) {
	$im = @imagecreatefromjpeg($pic);
	if (!$im) $im = @imagecreatefrompng($pic);
	if (!$im) $im = @imagecreatefromgif($pic);
	if (!$im) return array(0, 0);
	$w = imagesx($im);
	$h = imagesy($im);
	imagedestroy($im);
	return array($w, $h);
}

function set_content($a) {
	global $lang_id, $smarty;
	global $pdo;
	if (!is_array($a)) error();
	if (count($a) == 0) error();
	$s = "";
	for ($i = 0; $i < count($a); $i++) {
		$j = strpos($a[$i], "-");
		if (!$j) $s .= " OR v.content_id = '" . $a[$i] . "'"; else
			$s .= " OR (v.content_id >= '" . substr($a[$i], 0, $j) . "' AND v.content_id <= '" . substr($a[$i], $j + 1) . "')";
	}
	$s = "WHERE v.language_id = '$lang_id' and v.content_id = c.id AND (" . substr($s, 4) . ")";
	$s = "SELECT c.type, v.* FROM cv_content_value v, cv_content c $s";
	$result = mysqli_query($pdo, $s);
	if ($result === false) error($s);
	while ($rows = mysqli_fetch_array($result)) {
		$smarty->assign("content_" . $rows["content_id"], $rows["value"]);
		// if ($rows["type"]==2)
		// {
		//         $smarty->assign("content_xy_".$rows["content_id"], get_image_xy("./pics/content/".$rows["value"]));
		// }
		// print_r($rows);
		// echo "<br>";
	}
	return false;
}

function error($sql = "") {
	global $smarty, $lang_id;
	if (!$lang_id) $lang_id = 2;
	$smarty->display('error_' . $lang_id . '.tpl');
	die();
}

function getP($mm) {
	return round(150 * $mm / 25.4);
}

function textout_s($im, $xb, $yb, $xw, $hf, $col, $v, $align = "l") {
	for ($i = 0; $i < 10; $i++) $v = str_replace("  ", " ", $v);
	$s = split(" ", $v);
	$hd = 2 * $hf / 3;
	$y = $yb + $hf + $hd / 2;
	$nb = $hf;
	$i = 0;
	while ($i < count($s)) {
		$x = 0;
		$c = 0;
		while ($i + $c < count($s) && $x + ($c ? ($c - 1) * $nb : 0) < $xw) {
			$r = imagettfbbox($hf, 0, "./tahoma.ttf", $s[$i + $c]);
			$rw = $r[2] - $r[0];
			$x += $rw;
			$c++;
		}
		if ($c && $x + ($c - 1) * $nb == $xw) {
			$xx = 0;
			$nb_r = $nb;
			$c++;
		} else
			if ($c > 2 && $x + ($c - 1) * $nb > $xw) {
				$xx = $xw - ($x - $rw + ($c - 2) * $nb);
				if ($align != "j") $nb_r = $nb; else
					$nb_r = ($xw - ($x - $rw)) / ($c - 2);
			} else if ($c == 2 && $x + ($c - 1) * $nb > $xw) {
				$xx = $xw - ($x - $rw);
				$nb_r = $nb;
			} else if ($c == 1 && $x > $xw) {
				$s[count($s)] = "";
				for ($j = count($s); $j > $i; $j--) $s[$j] = $s[$j - 1];
				$j = strlen($s[$i]);
				while ($rw > $xw) {
					$j--;
					$r = imagettfbbox($hf, 0, "./tahoma.ttf", substr($s[$i], 0, $j));
					$rw = $r[2] - $r[0];
				}
				$s[$i] = substr($s[$i], 0, $j);
				$s[$i + 1] = substr($s[$i + 1], $j);
				$xx = $xw - $rw;
				$nb_r = $nb;
				$c++;
			} else {
				$nb_r = $nb;
				$xx = $xw - ($x + ($c - 1) * $nb);
				$c++;
			}
		if ($align == "c") $xx = $xx / 2; else if ($align != "r") $xx = 0;
		$x = $xb + $xx;
		for ($j = 0; $j < $c - 1; $j++) {
			imagettftext($im, $hf, 0, $x, $y, $col, "./tahoma.ttf", $s[$i + $j]);
			$r = imagettfbbox($hf, 0, "./tahoma.ttf", $s[$i + $j]);
			$rw = $r[2] - $r[0];
			$x += $rw + $nb_r;
		}
		$i += $c - 1;
		$y += $hf + $hd;
	}
	return $y - $hf - $hd / 2;
}

function textout($im, $xb, $yb, $xw, $hf, $col, $txt, $align = "l") {
	if (!$txt) return $yb;
	$v = str_replace("\r", "", $txt);
	$s = split("\n", $v);
	$y = $yb;
	for ($i = 0; $i < count($s); $i++) $y = textout_s($im, $xb, $y, $xw, $hf, $col, $s[$i], $align);
	return $y;
}

function get_file_of_url($url) {
	$i = strpos($url, "/", 7);
	$host = substr($url, 7, $i - 7);
	$socket = fsockopen($host, 80);
	fputs($socket, "GET $url HTTP/1.1\r\n");
	fputs($socket, "Host: $host\r\n");
	fputs($socket, "User-Agent: Mozilla/5.0 (Windows NT 6.1; rv:2.0.1) Gecko/20100101 Firefox/4.0.1\r\n");
	fputs($socket, "Accept: text/html,application/xhtml+xml,application/xml;q=0.9,* / *;q=0.8\r\n");
	fputs($socket, "Accept-Language: ru-ru,ru;q=0.8,en-us;q=0.5,en;q=0.3\r\n");
	fputs($socket, "Accept-Encoding: gzip, deflate\r\n");
	fputs($socket, "Accept-Charset: windows-1251,utf-8;q=0.7,*;q=0.7\r\n");
	fputs($socket, "Keep-Alive: 115\r\n");
	fputs($socket, "Connection: keep-alive\r\n");
	fputs($socket, "Cookie: vc=1; GUEST_LANGUAGE_ID=en_US; COOKIE_SUPPORT=true\r\n");
	fputs($socket, "Pragma: no-cache\r\n");
	fputs($socket, "Cache-Control: no-cache\r\n");
	fputs($socket, "\r\n");
	$i = 0;
	$s = "1";
	while (trim($s) && $i < 20) {
		$s = fgets($socket, 200000);
		$i++;
	}

	$s = "1";
	$ss = "";
	while ($i) {
		$i = trim(fgets($socket, 200000));
		$i = 0 + ("0x" . $i);//echo $i."/<br>";
		if ($i) {
			$s = "";
			while (strlen($s) < $i) $s .= fgets($socket, 1000000);
			$s = substr($s, 0, $i);
			//echo strlen($s)."/<br>";
			$ss .= $s;
		}
	}

	fclose($socket);
	return $ss;
}

function get_image($pic, $t = 0, $im_b = false) {
	if (strtolower(substr($pic, 0, 22)) == "https://car-vector.com") $pic = "." . substr($pic, 22);
	if (strtolower(substr($pic, 0, 21)) == "https://carvector.com") $pic = "." . substr($pic, 21);
	if (strtolower(substr($pic, 0, 26)) == "https://www.car-vector.com") $pic = "." . substr($pic, 26);
	if (strtolower(substr($pic, 0, 25)) == "https://www.carvector.com") $pic = "." . substr($pic, 25);
	if (strtolower(substr($pic, 0, 8)) != "https://") {
		$pp = strtolower(substr($pic, strrpos($pic, ".") + 1));
		if ($pp == "jpg") $pp = "jpeg";
		if (($pp != "jpeg" && $pp != "png" && $pp != "gif") || !file_exists($pic)) $pp = "";
		if ($pp) {
			if (!$im_b) return $pic; else {
				$func = "imagecreatefrom" . $pp;
				$im = @$func($pic);
				if ($t == 1) {
					$bgc = imagecolorallocate($im, 0x99, 0xff, 0x66);
					$col = imagecolorallocate($im, 0, 0, 0);
					$x = imagesx($im);
					$y = imagesy($im);
					imagefilledrectangle($im, $x - 270, $y - 80, $x, $y, $bgc);
					$s = "www.carvector.com";
					$r = imagettfbbox(20, 0, "./tahoma.ttf", $s);
					$rw = $r[2] - $r[0];
					imagettftext($im, 20, 0, $x - 270 + (270 - $rw) / 2, $y - 30, $col, "./tahoma.ttf", $s);
				}
				if ($t == 2) {
					$bgc = imagecolorallocate($im, 0x99, 0xff, 0x66);
					$col = imagecolorallocate($im, 0, 0, 0);
					imagefilledrectangle($im, 0, 0, 270, 30, $bgc);
					$s = "www.carvector.com";
					$r = imagettfbbox(20, 0, "./tahoma.ttf", $s);
					$rw = $r[2] - $r[0];
					imagettftext($im, 20, 0, (270 - $rw) / 2, 23, $col, "./tahoma.ttf", $s);
				}
				return array($im, $pp);
			}
		} else if (!$im_b) return ""; else return array("", "");
	}
	$p = "./pics/cash_pics/" . md5($pic);
	$pp = "";
	if (file_exists($p . ".jpeg")) $pp = "jpeg"; else
		if (file_exists($p . ".png")) $pp = "png"; else
			if (file_exists($p . ".gif")) $pp = "gif";
	if ($pp) {
		if (!$im_b) return $p . "." . $pp; else {
			$func = "imagecreatefrom" . $pp;
			$im = @$func($p . "." . $pp);
			return array($im, $pp);
		}
	}
	$im = "";
	if ($t == 0) {
		$pp = "jpeg";
		$im = @imagecreatefromstring(get_file_of_url($pic));
	}
	if (!$im) {
		$im = @imagecreatefromjpeg($pic);
		$pp = "jpeg";
	}
	if (!$im) {
		$im = @imagecreatefrompng($pic);
		$pp = "png";
	}
	if (!$im) {
		$im = @imagecreatefromgif($pic);
		$pp = "gif";
	}
	if (!$im) if (!$im_b) return ""; else array("", "");
	if ($t == 1) {
		$bgc = imagecolorallocate($im, 0x99, 0xff, 0x66);
		$col = imagecolorallocate($im, 0, 0, 0);
		$x = imagesx($im);
		$y = imagesy($im);
		imagefilledrectangle($im, $x - 270, $y - 80, $x, $y, $bgc);
		$s = "www.carvector.com";
		$r = imagettfbbox(20, 0, "./tahoma.ttf", $s);
		$rw = $r[2] - $r[0];
		imagettftext($im, 20, 0, $x - 270 + (270 - $rw) / 2, $y - 30, $col, "./tahoma.ttf", $s);
	}
	if ($t == 2) {
		$bgc = imagecolorallocate($im, 0x99, 0xff, 0x66);
		$col = imagecolorallocate($im, 0, 0, 0);
		imagefilledrectangle($im, 0, 0, 270, 30, $bgc);
		$s = "www.carvector.com";
		$r = imagettfbbox(20, 0, "./tahoma.ttf", $s);
		$rw = $r[2] - $r[0];
		imagettftext($im, 20, 0, (270 - $rw) / 2, 23, $col, "./tahoma.ttf", $s);
	}
	$func = "image" . $pp;
	$func($im, $p . "." . $pp);
	if ($im_b) return array($im, $pp); else {
		imagedestroy($im);
		return $p . "." . $pp;
	}
}

function ext_to_pic($fn) {
	if (file_exists($fn . "jpg")) $fn .= "jpg"; else
		if (file_exists($fn . "jpeg")) $fn .= "jpeg"; else
			if (file_exists($fn . "png")) $fn .= "png"; else
				if (file_exists($fn . "gif")) $fn .= "gif"; else $fn = "";
	return $fn;
}

function client_ip() {
	if (isset($_SERVER['HTTP_X_REAL_IP']) && $_SERVER['HTTP_X_REAL_IP']) {
		$ip = $_SERVER['HTTP_X_REAL_IP'];
	} else {
		if (isset($_SERVER['HTTP_CLIENT_IP']) && $_SERVER['HTTP_CLIENT_IP']) {
			$ip = $_SERVER['HTTP_CLIENT_IP'];
		} elseif (isset($_SERVER['HTTP_X_FORWARDED_FOR']) && $_SERVER['HTTP_X_FORWARDED_FOR']) {
			$ip = $_SERVER['HTTP_X_FORWARDED_FOR'];
			if (preg_match("/,/", $ip))
				LIST($ip, $ip_) = explode(",", preg_replace("/ +/", "", $ip));
		} elseif (isset($_SERVER['REMOTE_ADDR']) && $_SERVER['REMOTE_ADDR']) {
			$ip = $_SERVER['REMOTE_ADDR'];
		} else $ip = "0.0.0.0";
	}
	if (ip2long($ip) === false || ip2long($ip) == '-1') $ip = "0.0.0.0";
	return $ip;
}

function geoinf2() {
#	$country_code = apache_note("GEOIP_COUNTRY_CODE");
#	$country_name = apache_note("GEOIP_COUNTRY_NAME");
#	$region = apache_note("GEOIP_REGION");
#	$city = apache_note("GEOIP_CITY");
	$country_code = $_SERVER['GEOIP_COUNTRY_CODE'];
	$country_name = $_SERVER['GEOIP_COUNTRY_NAME'];
	$region = $_SERVER['GEOIP_REGION'];
	$city = $_SERVER['GEOIP_CITY'];
	$ginf["country_code"] = (isset($country_code) && $country_code) ? $country_code : "unknown";
	$ginf["country_name"] = (isset($country_name) && $country_name) ? $country_name : "Location Unknown";
	$ginf["region"] = (isset($region) && $region) ? $region : "-";
	$ginf["city"] = (isset($city) && $city) ? $city : "-";
	return $ginf;
}

function geoinfi($ip) {
	if ($ip != "0.0.0.0") {
		$link = @mysqli_connect('localhost', 'cvector_com_pls', 'XodV1lZBDwTPh3G8', 'carvector_com_pls');
		if ($link) {
			$ips = explode(".", $ip);
			$network = isset($ips[0]) ? $ips[0] : 0;
			$ip_num = ($ips[3] + $ips[2] * 256 + $ips[1] * 256 * 256 + $ips[0] * 256 * 256 * 256);
			$query = "SELECT l.country, l.region, l.city FROM p_geo_loc l JOIN p_geo_bloc b ON ( l.locId = b.locId ) WHERE b.network = $network AND $ip_num BETWEEN startIpNum AND endIpNum limit 1";
			if ($result = mysqli_query($link, $query)) {
				$row = mysqli_fetch_assoc($result);
				mysqli_free_result($result);
			}
			mysqli_close($link);
		}
	}
	$countries = Array("A1" => "Anonymous Proxy", "A2" => "Satellite Provider", "O1" => "Other Country", "AD" => "Andorra", "AE" => "United Arab Emirates", "AF" => "Afghanistan", "AG" => "Antigua and Barbuda", "AI" => "Anguilla", "AL" => "Albania", "AM" => "Armenia", "AN" => "Netherlands Antilles", "AO" => "Angola", "AP" => "Asia/Pacific Region", "AQ" => "Antarctica", "AR" => "Argentina", "AS" => "American Samoa", "AT" => "Austria", "AU" => "Australia", "AW" => "Aruba", "AX" => "Aland Islands", "AZ" => "Azerbaijan", "BA" => "Bosnia and Herzegovina", "BB" => "Barbados", "BD" => "Bangladesh", "BE" => "Belgium", "BF" => "Burkina Faso", "BG" => "Bulgaria", "BH" => "Bahrain", "BI" => "Burundi", "BJ" => "Benin", "BL" => "Saint Bartelemey", "BM" => "Bermuda", "BN" => "Brunei Darussalam", "BO" => "Bolivia", "BR" => "Brazil", "BS" => "Bahamas", "BT" => "Bhutan", "BV" => "Bouvet Island", "BW" => "Botswana", "BY" => "Belarus", "BZ" => "Belize", "CA" => "Canada", "CC" => "Cocos (Keeling) Islands", "CD" => "Congo", "CF" => "Central African Republic", "CG" => "Congo", "CH" => "Switzerland", "CI" => "Cote d'Ivoire", "CK" => "Cook Islands", "CL" => "Chile", "CM" => "Cameroon", "CN" => "China", "CO" => "Colombia", "CR" => "Costa Rica", "CU" => "Cuba", "CV" => "Cape Verde", "CX" => "Christmas Island", "CY" => "Cyprus", "CZ" => "Czech Republic", "DE" => "Germany", "DJ" => "Djibouti", "DK" => "Denmark", "DM" => "Dominica", "DO" => "Dominican Republic", "DZ" => "Algeria", "EC" => "Ecuador", "EE" => "Estonia", "EG" => "Egypt", "EH" => "Western Sahara", "ER" => "Eritrea", "ES" => "Spain", "ET" => "Ethiopia", "EU" => "Europe", "FI" => "Finland", "FJ" => "Fiji", "FK" => "Falkland Islands (Malvinas)", "FM" => "Micronesia", "FO" => "Faroe Islands", "FR" => "France", "FX" => "France", "GA" => "Gabon", "GB" => "United Kingdom", "GD" => "Grenada", "GE" => "Georgia", "GF" => "French Guiana", "GG" => "Guernsey", "GH" => "Ghana", "GI" => "Gibraltar", "GL" => "Greenland", "GM" => "Gambia", "GN" => "Guinea", "GP" => "Guadeloupe", "GQ" => "Equatorial Guinea", "GR" => "Greece", "GS" => "South Georgia and the South Sandwich Islands", "GT" => "Guatemala", "GU" => "Guam", "GW" => "Guinea-Bissau", "GY" => "Guyana", "HK" => "Hong Kong", "HM" => "Heard Island and McDonald Islands", "HN" => "Honduras", "HR" => "Croatia", "HT" => "Haiti", "HU" => "Hungary", "ID" => "Indonesia", "IE" => "Ireland", "IL" => "Israel", "IM" => "Isle of Man", "IN" => "India", "IO" => "British Indian Ocean Territory", "IQ" => "Iraq", "IR" => "Iran", "IS" => "Iceland", "IT" => "Italy", "JE" => "Jersey", "JM" => "Jamaica", "JO" => "Jordan", "JP" => "Japan", "KE" => "Kenya", "KG" => "Kyrgyzstan", "KH" => "Cambodia", "KI" => "Kiribati", "KM" => "Comoros", "KN" => "Saint Kitts and Nevis", "KP" => "Korea", "KR" => "Korea", "KW" => "Kuwait", "KY" => "Cayman Islands", "KZ" => "Kazakhstan", "LA" => "Lao People's Democratic Republic", "LB" => "Lebanon", "LC" => "Saint Lucia", "LI" => "Liechtenstein", "LK" => "Sri Lanka", "LR" => "Liberia", "LS" => "Lesotho", "LT" => "Lithuania", "LU" => "Luxembourg", "LV" => "Latvia", "LY" => "Libyan Arab Jamahiriya", "MA" => "Morocco", "MC" => "Monaco", "MD" => "Moldova", "ME" => "Montenegro", "MF" => "Saint Martin", "MG" => "Madagascar", "MH" => "Marshall Islands", "MK" => "Macedonia", "ML" => "Mali", "MM" => "Myanmar", "MN" => "Mongolia", "MO" => "Macao", "MP" => "Northern Mariana Islands", "MQ" => "Martinique", "MR" => "Mauritania", "MS" => "Montserrat", "MT" => "Malta", "MU" => "Mauritius", "MV" => "Maldives", "MW" => "Malawi", "MX" => "Mexico", "MY" => "Malaysia", "MZ" => "Mozambique", "NA" => "Namibia", "NC" => "New Caledonia", "NE" => "Niger", "NF" => "Norfolk Island", "NG" => "Nigeria", "NI" => "Nicaragua", "NL" => "Netherlands", "NO" => "Norway", "NP" => "Nepal", "NR" => "Nauru", "NU" => "Niue", "NZ" => "New Zealand", "OM" => "Oman", "PA" => "Panama", "PE" => "Peru", "PF" => "French Polynesia", "PG" => "Papua New Guinea", "PH" => "Philippines", "PK" => "Pakistan", "PL" => "Poland", "PM" => "Saint Pierre and Miquelon", "PN" => "Pitcairn", "PR" => "Puerto Rico", "PS" => "Palestinian Territory", "PT" => "Portugal", "PW" => "Palau", "PY" => "Paraguay", "QA" => "Qatar", "RE" => "Reunion", "RO" => "Romania", "RS" => "Serbia", "RU" => "Russian Federation", "RW" => "Rwanda", "SA" => "Saudi Arabia", "SB" => "Solomon Islands", "SC" => "Seychelles", "SD" => "Sudan", "SE" => "Sweden", "SG" => "Singapore", "SH" => "Saint Helena", "SI" => "Slovenia", "SJ" => "Svalbard and Jan Mayen", "SK" => "Slovakia", "SL" => "Sierra Leone", "SM" => "San Marino", "SN" => "Senegal", "SO" => "Somalia", "SR" => "Suriname", "ST" => "Sao Tome and Principe", "SV" => "El Salvador", "SY" => "Syrian Arab Republic", "SZ" => "Swaziland", "TC" => "Turks and Caicos Islands", "TD" => "Chad", "TF" => "French Southern Territories", "TG" => "Togo", "TH" => "Thailand", "TJ" => "Tajikistan", "TK" => "Tokelau", "TL" => "Timor-Leste", "TM" => "Turkmenistan", "TN" => "Tunisia", "TO" => "Tonga", "TR" => "Turkey", "TT" => "Trinidad and Tobago", "TV" => "Tuvalu", "TW" => "Taiwan", "TZ" => "Tanzania", "UA" => "Ukraine", "UG" => "Uganda", "UM" => "United States Minor Outlying Islands", "US" => "United States", "UY" => "Uruguay", "UZ" => "Uzbekistan", "VA" => "Holy See (Vatican City State)", "VC" => "Saint Vincent and the Grenadines", "VE" => "Venezuela", "VG" => "Virgin Islands", "VI" => "Virgin Islands", "VN" => "Vietnam", "VU" => "Vanuatu", "WF" => "Wallis and Futuna", "WS" => "Samoa", "YE" => "Yemen", "YT" => "Mayotte", "ZA" => "South Africa", "ZM" => "Zambia", "ZW" => "Zimbabwe");
	$ginf["country_code"] = (isset($row["country"]) && $row["country"]) ? $row["country"] : "unknown";
	$ginf["country_name"] = (isset($row["country"]) && $row["country"]) ? $countries[$row["country"]] : "Location Unknown";
	$ginf["region"] = (isset($row["region"]) && $row["region"]) ? $row["region"] : "-";
	$ginf["city"] = (isset($row["city"]) && $row["city"]) ? $row["city"] : "-";
	return $ginf;
}


?>
