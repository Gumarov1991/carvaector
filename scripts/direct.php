<?php
set_time_limit(0);
$host = "www.provideauctions.com";

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
                $s = ''; while (!feof($fp)) $s .= fgets($fp,128);
                fclose($fp);
                $i = strpos($s, "\r\n\r\n");if (!$i) $i = strlen($s);
                $head = split("\r\n", substr($s,0,$i));$html = substr($s,$i+4);
                return array($head, $html);
        }
}

function set_cook($cook, $old) {
        global $lang_id;
        $cook = "  ".$cook;
        $i = strpos($cook, " ASPSESSIONID");
        if (!$i) {
                $i = strpos(" ".$old, "config=lang=");
                if ($i) $old = substr($old,0,$i+11).(($lang_id==1)?"Russian":"English").substr($old,$i+18);
                mysqli_query($pdo,"UPDATE cv_content_value SET value = '$old', ts = NOW() WHERE content_id = 0 and language_id = 0") or error();
                return $old;
        }
        $cook = substr($cook, $i+1);
        $i = strpos($cook, ";");if (!$i) $i = strlen($cook);
        $cook = substr($cook, 0, $i).(($lang_id==1)?"; config=lang=Russian":"; config=lang=English");
        mysqli_query($pdo,"UPDATE cv_content_value SET value = '$cook', ts = NOW() WHERE content_id = 0 and language_id = 0") or error();
        return $cook;
}

function get_param($head, $param) {
        $res = "";
        for($i=0;$i<count($head);$i++)
                if (strtolower(substr($head[$i],0,strlen($param)))==$param)
                        $res = substr($head[$i],strlen($param));
        return $res;
}

function get_form() {
        global $lang_id, $host;
        $result = mysqli_query($pdo,"SELECT value FROM cv_content_value WHERE content_id = 0 and language_id = 0 and to_days(ts) = to_days(NOW())") or error();
        if ($rows = mysqli_fetch_array($result)) $cookie = $rows[0]; else $cookie = "";
        if (!$cookie) $cookie = (($lang_id==1)?"config=lang=Russian":"config=lang=English");
        $res = get_site($host, "/cars/", $cookie);
        $cookie = set_cook(get_param($res[0],"set-cookie: "),$cookie);
        $l = get_param($res[0],"location: ");
        if ($l) {
                $res = get_site($host, $l, $cookie);
                $cookie = set_cook(get_param($res[0],"set-cookie: "),$cookie);
                $l = get_param($res[0],"location: ");
                if ($l) return 0;
        }
        if (strpos($res[1], '<form action="/cars/login.asp"')) {
                $post = "login=".urlencode("cvectorguest2")."&pass=".urlencode("cvrguest2");
                $res = get_site($host, "/cars/login.asp", $cookie, $post);
                $cookie = set_cook(get_param($res[0],"set-cookie: "),$cookie);
                $l = get_param($res[0],"location: ");
                if ($l) {
                        $res = get_site($host, $l, $cookie);
                        $cookie = set_cook(get_param($res[0],"set-cookie: "),$cookie);
                        $l = get_param($res[0],"location: ");
                        if ($l) {
                                $res = get_site($host, $l, $cookie);
                                $cookie = set_cook(get_param($res[0],"set-cookie: "),$cookie);
                                $l = get_param($res[0],"location: ");
                                if ($l) return 1;
                        }
                }
        }
        $res = get_site($host, "/cars/search.asp", $cookie);
        $cookie = set_cook(get_param($res[0],"set-cookie: "),$cookie);
        $s = $res[1];$i = strpos(strtolower($s), "<form ");if (!$i) return 2;$s = substr($s, $i);
        $i = strpos($s, ">");$s = substr($s, $i+1);
        $i = strpos(strtolower($s), "</form>");if (!$i) return 3;$s = substr($s, 0, $i+7);
        $i1 = strpos(strtolower($s), "<table");$i2 = strpos(strtolower($s), "</table>");
        if ($i1 && $i2) $s = substr($s, 0, $i1).substr($s, $i2+8);
        $i1 = 0;
        while (true) {
                $i1 = strpos(strtolower($s), "<script", $i1+1);if (!$i1) break;$i2 = strpos($s, "</script>", $i1);
                $i3 = strpos(strtolower($s), "function turnonday(", $i1);
                if (!$i3 || $i3>$i2) {
                        $s = substr($s, 0, $i1).substr($s, $i2+9);
                        $i2 = strpos(strtolower($s), "</a>", $i1);
                        if ($i2) $s = substr($s, 0, $i2).substr($s, $i2+4);
                }
        }
        $i1 = strrpos(strtolower($s), "<table");$i2 = strrpos(strtolower($s), "</form>");
        if ($i1 && $i2) $s = substr($s, 0, $i1).substr($s, $i2);
        $i1 = strrpos(strtolower($s), "<table");$i2 = strrpos(strtolower($s), "</form>");
        if ($i1 && $i2) $s = substr($s, 0, $i1).substr($s, $i2);
        $i1 = strrpos(strtolower($s), "<table");$i2 = strrpos(strtolower($s), "</form>");
        if ($i1 && $i2) $s = substr($s, 0, $i1).substr($s, $i2);
        $i1 = 0;
        while (true) {
                $i1 = strpos(strtolower($s), "<a ", $i1+1);if (!$i1) break;$i2 = strpos($s, ">", $i1);
                $i3 = strpos(strtolower($s), "selectmodels()", $i1);
                $i4 = strpos(strtolower($s), "clearmodels()", $i1);
                $i5 = strpos(strtolower($s), "clearsearchform()", $i1);
                if ((!$i3 || $i3>$i2) && (!$i4 || $i4>$i2) && (!$i5 || $i5>$i2)) {
                        $s = substr($s, 0, $i1).substr($s, $i2+1);
                        $i2 = strpos(strtolower($s), "</a", $i1);
                        if ($i2) {
                                $i2_2 = strpos(strtolower($s), ">", $i2);
                                $s = substr($s, 0, $i2).substr($s, $i2_2+1);
                        }
                } else if ($i5 && $i5<$i2) {
                        $i5 = strpos(strtolower($s), "href=", $i1);
                        $i5 += 6;$i5_2 = strpos($s, $s[$i5-1], $i5);
                        $s = substr($s, 0, $i5)."./index.php?direct".substr($s, $i5_2);
                }
        }
        $i1 = strpos(strtolower($s), 'class="pan1"');
        if ($i1) $s = substr($s, 0, $i1).'bgColor="#f9ffd6"'.substr($s, $i1+12);
        $i1 = strpos(strtolower($s), 'class="pan2"');
        if ($i1) $s = substr($s, 0, $i1).'bgColor="#c9E296"'.substr($s, $i1+12);
        $i1 = strpos(strtolower($s), 'class="pan3"');
        if ($i1) $s = substr($s, 0, $i1).'bgColor="#99ff66"'.substr($s, $i1+12);

        $i1 = strpos(strtolower($s), 'type="radio"');
        $i1 = strrpos(strtolower(substr($s,0,$i1)), '<tr>');
        $i2 = strpos(strtolower($s), '</tr>', $i1);
        $s = substr($s, 0, $i1).'<input type="hidden" name="dsp" value="pl">'.substr($s, $i2+5);
        $i1 = strpos(strtolower($s), 'start bid:');
        if ($i1) { $i1 = strpos(strtolower($s), '<td', $i1);$i1 = strpos(strtolower($s), '<td', $i1+1); }
        if ($i1) $s = substr($s,0,$i1+3)." nowrap".substr($s,$i1+3);
        return "<br><form action='' name='frmSearch' method=get><input type=hidden name=direct>".$s;
}

function get_cars($post) {
        global $next_page, $page_result, $lang_id, $host;
        $result = mysqli_query($pdo,"SELECT value FROM cv_content_value WHERE content_id = 0 and language_id = 0 and to_days(ts) = to_days(NOW())") or error();
        if ($rows = mysqli_fetch_array($result)) $cookie = $rows[0]; else $cookie = "";
        if (!$cookie) $cookie = (($lang_id==1)?"config=lang=Russian":"config=lang=English");
        $res = get_site($host, "/cars/", $cookie);
        $cookie = set_cook(get_param($res[0],"set-cookie: "),$cookie);
        $l = get_param($res[0],"location: ");
        if ($l) {
                $res = get_site($host, $l, $cookie);
                $cookie = set_cook(get_param($res[0],"set-cookie: "),$cookie);
                $l = get_param($res[0],"location: ");
                if ($l) return 0;
        }
        if (strpos($res[1], '<form action="/cars/login.asp"')) {
                $post = "login=".urlencode("cvectorguest2")."&pass=".urlencode("cvrguest2");
                $res = get_site($host, "/cars/login.asp", $cookie, $post);
                $cookie = set_cook(get_param($res[0],"set-cookie: "),$cookie);
                $l = get_param($res[0],"location: ");
                if ($l) {
                        $res = get_site($host, $l, $cookie);
                        $cookie = set_cook(get_param($res[0],"set-cookie: "),$cookie);
                        $l = get_param($res[0],"location: ");
                        if ($l) {
                                $res = get_site($host, $l, $cookie);
                                $cookie = set_cook(get_param($res[0],"set-cookie: "),$cookie);
                                $l = get_param($res[0],"location: ");
                                if ($l) return 1;
                        }
                }
        }
        $res = get_site($host, "/cars/showcars.asp", $cookie, $post);
        $cookie = set_cook(get_param($res[0],"set-cookie: "),$cookie);
        $l = get_param($res[0],"location: ");
        if ($l) {
                $res = get_site($host, $l, $cookie);
                $cookie = set_cook(get_param($res[0],"set-cookie: "),$cookie);
                $l = get_param($res[0],"location: ");
                if ($l) return 0;
        }
        $s = $res[1];
        $i1 = strpos(strtolower($s), "<b>results</b>");
		$i1 = strpos(strtolower($s), "<b>", $i1+1);
        $i2 = strpos(strtolower($s), "</td>", $i1);
		$page_result = substr($s, $i1, $i2-$i1);
        $next_page = strpos(strtolower($s), "&nbsp;|&nbsp;<a ");
        $i = strpos(strtolower($s), "<form "); if (!$i) return 1; $s = substr($s, $i);
        $i = strpos(strtolower($s), "</form>"); if (!$i) return 2; $s = substr($s, 0, $i+7);
        $s = str_replace(chr(9), " ", $s);
        while (true) {
                $i1 = strpos(strtolower($s), "<script");
				$i2 = strpos(strtolower($s), "</script>");
                if ($i1 && $i2) $s = substr($s, 0, $i1).substr($s, $i2+9); else break;
        }
        $i1 = 0; 
		$img = array();
        while (true) {
                $i1 = strpos(strtolower($s), "<a ", $i1+1);
				if (!$i1) break; 
				$i2 = strpos($s, ">", $i1);
                if (strtolower(substr($s,$i2+1,5)) != '<img ') {
                        $s = substr($s, 0, $i1).substr($s, $i2+1);
                        $i2 = strpos(strtolower($s), "</a>", $i1);
                        if ($i2) $s = substr($s, 0, $i2).substr($s, $i2+4);
                } else {
                        $i1 = strpos(strtolower($s), ' href="', $i1); $i1+=7;
                        $i2 = strpos(strtolower($s), '"', $i1);
                        $hr = split("/",substr($s,$i1,$i2-$i1));
                        $s = substr($s, 0, $i1)."./index.php?direct&car=".$hr[2]."&ai=".$hr[3].substr($s, $i2);
                        $i1 = strpos(strtolower($s), ' src="', $i1); $i1+=6;
                        $i2 = strpos(strtolower($s), '"', $i1);
						array_push($img, substr($s,$i1,$i2-$i1));
                }
        }
		
        while (true) {
                $i1 = strpos(strtolower($s), "<input "); if (!$i1) break; $i2 = strpos($s, ">", $i1);
                $s = substr($s, 0, $i1).substr($s, $i2+1);
        }
        $ss = " onmouseover=";
        while (true) {
                $i1 = strpos(strtolower($s), $ss);if (!$i1) break;
                $i2 = strpos($s, $s[$i1+strlen($ss)], $i1+strlen($ss)+1);
                $s = substr($s, 0, $i1).substr($s, $i2+1);
        }
        $ss = " onmouseout=";
        while (true) {
                $i1 = strpos(strtolower($s), $ss);if (!$i1) break;
                $i2 = strpos($s, $s[$i1+strlen($ss)], $i1+strlen($ss)+1);
                $s = substr($s, 0, $i1).substr($s, $i2+1);
        }
        $ss = " ondblclick=";
        while (true) {
                $i1 = strpos(strtolower($s), $ss);if (!$i1) break;
                $i2 = strpos($s, $s[$i1+strlen($ss)], $i1+strlen($ss)+1);
                $s = substr($s, 0, $i1).substr($s, $i2+1);
        }
        $i1 = strpos(strtolower($s), "[+/-]");if (!$i1) return 3;
        if ($i1) $s = substr($s, 0, $i1).substr($s, $i1+5);
        $i1 = strpos(strtolower($s), "<table");if ($i1) $s = substr($s, $i1);
        $i1 = strpos(strtolower($s), "<table", 1);if ($i1) $s = substr($s, $i1);
        $i1 = strrpos(strtolower($s), "</td>");if ($i1) $s = substr($s, 0, $i1);
        $ss = "<tr bgcolor=";$sss = "height=";$i1 = 0;
        while (true) {
                $i1 = strpos(strtolower($s), $ss, $i1);if (!$i1) break;$i1 += strlen($ss);
                $s = substr($s, 0, $i1).'"#99ff66"'.substr($s, $i1+9);
                $i1 = strpos(strtolower($s), $sss, $i1);if ($i1) $s[$i1+strlen($sss)+1] = "1";
        }
        $i = strpos(strtolower($s), "<td");$i += 3;
        $s = substr($s, 0, $i).' width=10 style="background:url(./pics/head2.gif);"'.substr($s, $i);
        $i = strpos(strtolower($s), "<td", $i+1);
        $i = strpos(strtolower($s), "<td", $i+1);$i += 3;
        $s = substr($s, 0, $i).' style="font-size:10"'.substr($s, $i);
        $i = strpos(strtolower($s), "</tr>");
        $i = strrpos(strtolower(substr($s,0,$i)), "<td");$i += 3;
        $s = substr($s, 0, $i).' width=50 style="background:url(./pics/head2.gif) right top;"'.substr($s, $i);
        $i = strpos(strtolower($s), "<tr");$i += 3;
        $s = substr($s, 0, $i).' height=25 bgColor=#99ff66'.substr($s, $i);
        $i = strpos($s, ">");$s = substr($s, $i+1);
        $s = str_replace('<TD class="lgr">', '<TD nowrap>', $s);
        $b = true;$dt = time();
        return "<table border=0 cellspacing=0 cellpadding=0 width=100% style='margin:0px 0px 10px 0px;'>".$s;
}

function get_car() {
        global $lang_id, $host;
        $result = mysqli_query($pdo,"SELECT value FROM cv_content_value WHERE content_id = 0 and language_id = 0 and to_days(ts) = to_days(NOW())") or error();
        if ($rows = mysqli_fetch_array($result)) $cookie = $rows[0]; else $cookie = "";
        if (!$cookie) $cookie = (($lang_id==1)?"config=lang=Russian":"config=lang=English");
        $res = get_site($host, "/cars/", $cookie);
        $cookie = set_cook(get_param($res[0],"set-cookie: "),$cookie);
        $l = get_param($res[0],"location: ");
        if ($l) {
                $res = get_site($host, $l, $cookie);
                $cookie = set_cook(get_param($res[0],"set-cookie: "),$cookie);
                $l = get_param($res[0],"location: ");
                if ($l) return 0;
        }
        if (strpos($res[1], '<form action="/cars/login.asp"')) {
                $post = "login=".urlencode("cvectorguest2")."&pass=".urlencode("cvrguest2");
                $res = get_site($host, "/cars/login.asp", $cookie, $post);
                $cookie = set_cook(get_param($res[0],"set-cookie: "),$cookie);
                $l = get_param($res[0],"location: ");
                if ($l) {
                        $res = get_site($host, $l, $cookie);
                        $cookie = set_cook(get_param($res[0],"set-cookie: "),$cookie);
                        $l = get_param($res[0],"location: ");
                        if ($l) {
                                $res = get_site($host, $l, $cookie);
                                $cookie = set_cook(get_param($res[0],"set-cookie: "),$cookie);
                                $l = get_param($res[0],"location: ");
                                if ($l) return 1;
                        }
                }
        }
        $res = get_site($host, "/cars/".$_GET["car"]."/".$_GET["ai"], $cookie);
        $cookie = set_cook(get_param($res[0],"set-cookie: "),$cookie);
        $l = get_param($res[0],"location: ");
        if ($l) {
                $res = get_site($host, $l, $cookie);
                $cookie = set_cook(get_param($res[0],"set-cookie: "),$cookie);
                $l = get_param($res[0],"location: ");
                if ($l) return 0;
        }
        $s = $res[1];$i = strpos(strtolower($s), ' name="cardatatable"');if (!$i) return 1;
        $i = strrpos(strtolower(substr($s,0,$i)), "<table");if (!$i) return 2;$s = substr($s, $i);
        $i = strpos(strtolower($s), "</form>");if (!$i) return 3;$s = substr($s, 0, $i);
        $i = strrpos(strtolower($s), "</table>");if (!$i) return 4;$s = substr($s, 0, $i);
        $i = strrpos(strtolower($s), "</table>");if (!$i) return 4;$s = substr($s, 0, $i);
        $i = strrpos(strtolower($s), "</table>");if (!$i) return 4;$s = substr($s, 0, $i+8);
        $s = str_replace(chr(9), " ", $s);
        while (true) {
                $i1 = strpos(strtolower($s), "<script");$i2 = strpos(strtolower($s), "</script>");
                if ($i1 && $i2) $s = substr($s, 0, $i1).substr($s, $i2+9); else break;
        }
        while (true) {
                $i1 = strpos(strtolower($s), "<input ");if (!$i1) break;$i2 = strpos($s, ">", $i1);
                $s = substr($s, 0, $i1).substr($s, $i2+1);
        }
        $ss = " onmouseover=";
        while (true) {
                $i1 = strpos(strtolower($s), $ss);if (!$i1) break;
                $i2 = strpos($s, $s[$i1+strlen($ss)], $i1+strlen($ss)+1);
                $s = substr($s, 0, $i1).substr($s, $i2+1);
        }
        $ss = " onmouseout=";
        while (true) {
                $i1 = strpos(strtolower($s), $ss);if (!$i1) break;
                $i2 = strpos($s, $s[$i1+strlen($ss)], $i1+strlen($ss)+1);
                $s = substr($s, 0, $i1).substr($s, $i2+1);
        }
        $ss = " ondblclick=";
        while (true) {
                $i1 = strpos(strtolower($s), $ss);if (!$i1) break;
                $i2 = strpos($s, $s[$i1+strlen($ss)], $i1+strlen($ss)+1);
                $s = substr($s, 0, $i1).substr($s, $i2+1);
        }
        $i1 = strpos(strtolower($s), "[+/-]");if (!$i1) return 2;
        if ($i1) $s = substr($s, 0, $i1).substr($s, $i1+5);
        $img = array();
        while (true) {
                $i1 = strpos(strtolower($s), "<a ", $i1+1);
				if (!$i1) break; 
				$i2 = strpos($s, ">", $i1);
                $i3 = strpos(strtolower($s), "?lrg=", $i1);
                if (!$i3 || $i3>$i2) {
                        $s = substr($s, 0, $i1).substr($s, $i2+1);
                        $i2 = strpos(strtolower($s), "</a>", $i1);
                        if ($i2) $s = substr($s, 0, $i2).substr($s, $i2+4);
                } else {
						$s = substr($s, 0, $i2).' target="blank"'.substr($s, $i2);
                        $i1 = strpos(strtolower($s), ' href="', $i1); $i1+=7;
                        $i2 = strpos(strtolower($s), '"', $i1);
						$ss = substr($s, $i1, $i2-$i1);
                        $ss = str_replace("?", "/", $ss);
						$hr = split("/", $ss);
                        $s = substr($s, 0, $i1)."./index.php?direct&car=".$hr[2]."&ai=".$hr[3]."&".$hr[4].substr($s, $i2);
                        $i1 = strpos(strtolower($s), ' src="', $i1); $i1+=6;
                        $i2 = strpos(strtolower($s), '"', $i1);
						array_push($img, substr($s,$i1,$i2-$i1));
                }
        }
        $i = strpos(strtolower($s), "<img ");if (!$i) return 5;
        $i1 = strrpos(strtolower(substr($s,0,$i)), "<td");if (!$i1) return 5;
        $i2 = strpos(strtolower($s), "</td>", $i1);if (!$i2) return 5;
        $s = substr($s, 0, $i1).substr($s, $i2+5);
        $s = str_replace("#bbbbbb", "#99ff66", $s);

        $b = true;$dt = time();
        return "<br>".$s."<br>";
}

function get_car_lrg() {
        global $lang_id, $host;
        $result = mysqli_query($pdo,"SELECT value FROM cv_content_value WHERE content_id = 0 and language_id = 0 and to_days(ts) = to_days(NOW())") or error();
        if ($rows = mysqli_fetch_array($result)) $cookie = $rows[0]; else $cookie = "";
        if (!$cookie) $cookie = (($lang_id==1)?"config=lang=Russian":"config=lang=English");
        $res = get_site($host, "/cars/", $cookie);
        $cookie = set_cook(get_param($res[0],"set-cookie: "),$cookie);
        $l = get_param($res[0],"location: ");
        if ($l) {
                $res = get_site($host, $l, $cookie);
                $cookie = set_cook(get_param($res[0],"set-cookie: "),$cookie);
                $l = get_param($res[0],"location: ");
                if ($l) return 0;
        }
        if (strpos($res[1], '<form action="/cars/login.asp"')) {
                $post = "login=".urlencode("cvectorguest2")."&pass=".urlencode("cvrguest2");
                $res = get_site($host, "/cars/login.asp", $cookie, $post);
                $cookie = set_cook(get_param($res[0],"set-cookie: "),$cookie);
                $l = get_param($res[0],"location: ");
                if ($l) {
                        $res = get_site($host, $l, $cookie);
                        $cookie = set_cook(get_param($res[0],"set-cookie: "),$cookie);
                        $l = get_param($res[0],"location: ");
                        if ($l) {
                                $res = get_site($host, $l, $cookie);
                                $cookie = set_cook(get_param($res[0],"set-cookie: "),$cookie);
                                $l = get_param($res[0],"location: ");
                                if ($l) return 1;
                        }
                }
        }
        $res = get_site($host, "/cars/".$_GET["car"]."/".$_GET["ai"]."?lrg=".$_GET["lrg"], $cookie);
        $cookie = set_cook(get_param($res[0],"set-cookie: "),$cookie);
        $l = get_param($res[0],"location: ");
        if ($l) {
                $res = get_site($host, $l, $cookie);
                $cookie = set_cook(get_param($res[0],"set-cookie: "),$cookie);
                $l = get_param($res[0],"location: ");
                if ($l) return 0;
        }
        $s = $res[1];$i = strpos(strtolower($s), '</form>');if (!$i) return 1;$s = substr($s, 0, $i);
        $i = strrpos(strtolower($s), '</a>');if (!$i) return 1;$s = substr($s, 0, $i);
        $i = strrpos(strtolower($s), '<img');if (!$i) return 1;$s = "<img width=975".substr($s, $i+4);
        return "<br>".$s."<br>";
}

set_content(array("409-411","361-362"));
$direct_form = "";
$direct_page = "";
$curr_page = 1;
$next_page = "";
if (isset($_SESSION["direct_currpage"])) $curr_page = $_SESSION["direct_currpage"];
if (isset($_SESSION["direct_form_sess"])) $direct_form = $_SESSION["direct_form_sess"];
if (isset($_GET["stx"])) {
        $curr_page = $_GET["stx"];
        $_SESSION["direct_currpage"] = $curr_page;
        $direct_page = get_cars("stx=".$curr_page."&".$direct_form);
} else if (isset($_GET["list"])) {
        $direct_page = get_cars("stx=".$curr_page."&".$direct_form);
} else if (isset($_GET["dss"])) {
        $direct_form = $_SERVER["QUERY_STRING"];
        $i = strpos($direct_form, "dss=");
        if ($i) $direct_form = substr($direct_form, $i);
        $_SESSION["direct_form_sess"] = $direct_form;
        $curr_page = 1;
        $_SESSION["direct_currpage"] = $curr_page;
        $direct_page = get_cars($direct_form);
} else if (isset($_GET["lrg"])) {
        $smarty->assign("direct_model", "car=".$_GET["car"]."&ai=".$_GET["ai"]);
        $smarty->assign("direct_model_id", substr($_GET["car"],4));
        $direct_page = get_car_lrg();
} else if (isset($_GET["car"])) {
        $smarty->assign("direct_model", "car=".$_GET["car"]."&ai=".$_GET["ai"]);
        $smarty->assign("direct_model_id", substr($_GET["car"],4));
        $direct_page = get_car();
}
if (strlen($direct_page)<=1) { $direct_page = get_form();$direct_form = ""; }
$smarty->assign("direct_list", $direct_form);
$smarty->assign("direct_page", $direct_page);
$smarty->assign("page", $curr_page);
$smarty->assign("next_page", $next_page);

if (isset($page_result)) {
	$spos = strpos($page_result, "results")+6;
	$page_result = substr($page_result, 0, $spos);
	$smarty->assign("page_result", $page_result);
}

?>
