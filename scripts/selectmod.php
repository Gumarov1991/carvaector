<?php

include "./../scripts_admin/db_config.php";

function get_site($host, $fn, $cookie, $post="") {
        $fp = fsockopen($host, 80, $errno, $errstr, 10);
        if ($fp) {
                if ($post) $out = "POST"; else $out = "GET";
                $out .= " $fn HTTP/1.1\r\n";
                $out .= "Host: $host\r\n";
                if ($cookie) $out .= "Cookie: $cookie\r\n";
                if ($post) $out .= "Content-type: application/x-www-form-urlencoded\r\nContent-length: ".strlen($post)."\r\n";
                $out .= "Connection: Close\r\n";
                $out .= "\r\n";
                if ($post) $out .= $post."\r\n\r\n";
                fwrite($fp, $out);
                $s = '';while (!feof($fp)) $s .= fgets($fp,128);
                fclose($fp);
                $i = strpos($s, "\r\n\r\n");if (!$i) $i = strlen($s);
                $head = split("\r\n", substr($s,0,$i));$html = substr($s,$i+4);
                return array($head, $html);
        }
}

$host = "www.provideauctions.com";
$result = mysqli_query($pdo,"SELECT value FROM cv_content_value WHERE content_id = 0 and language_id = 0 and to_days(ts) = to_days(NOW())") or error();
if ($rows = mysqli_fetch_array($result)) $cookie = $rows[0]; else $cookie = "";
if (!$cookie) $cookie = "config=lang=Russian";
$res = get_site($host, "/cars/selectmod.asp?".$_SERVER["QUERY_STRING"], $cookie);
header('Content-type: text/html; charset=UTF-8');
$s = str_replace('selectmod.asp', 'selectmod.php', str_replace('<LINK href="/', '<LINK href="https://'.$host.'/', $res[1]));
echo $s;

?>
