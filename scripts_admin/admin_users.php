<?php

$login_admin = $_SESSION['login_admin'];

if (isset($_GET['mid'])) $mid = int_cip($_GET['mid']); else $mid = "";
if (isset($_GET['pid'])) $pid = int_cip($_GET['pid']); else $pid = "";
if (isset($_GET['sent'])) $sent = int_cip($_GET['sent']); else $sent = "";
if (isset($_GET['del'])) $del = int_cip($_GET['del']); else $del = "";
if (isset($_GET['del_favorit'])) $del_favorit = int_cip($_GET['del_favorit']); else $del_favorit = "";
if (isset($_GET['add_favorit'])) $add_favorit = int_cip($_GET['add_favorit']); else $add_favorit = "";
if (isset($_GET['del_direct'])) $del_direct = int_cip($_GET['del_direct']); else $del_direct = "";
if (isset($_GET['add_direct'])) $add_direct = int_cip($_GET['add_direct']); else $add_direct = "";
if (isset($_GET['del_blocked'])) $del_blocked = int_cip($_GET['del_blocked']); else $del_blocked = "";
if (isset($_GET['add_blocked'])) $add_blocked = int_cip($_GET['add_blocked']); else $add_blocked = "";
if (isset($_GET['del_massmail'])) $del_massmail = int_cip($_GET['del_massmail']); else $del_massmail = "";
if (isset($_GET['add_massmail'])) $add_massmail = int_cip($_GET['add_massmail']); else $add_massmail = "";
if (isset($_GET['bal'])) $bal = int_cip($_GET['bal']); else $bal = "";
if (isset($_GET['bal2'])) $bal2 = int_cip($_GET['bal2']); else $bal2 = "";
if (isset($_GET['bal_del'])) $bal_del = int_cip($_GET['bal_del']); else $bal_del = "";
if (isset($_GET['bal_edit'])) $bal_edit = int_cip($_GET['bal_edit']); else $bal_edit = "";
if (isset($_POST['save'])) $save = $_POST['save']; else $save = "";
if (isset($_GET['id'])) {if ($_GET['id']=="add") $id = "add"; else $id = int_cip($_GET['id']);} else $id = "";
if (isset($_GET['page'])) $page = int_cip($_GET['page']); else $page = "";
if (isset($_GET['sort'])) $sort = int_cip($_GET['sort']); else $sort = 1;
if (isset($_GET['sort_str'])) $sort_str = quote_cip($_GET['sort_str']); else $sort_str = "";
if (isset($_GET['confirm_register'])) $confirm_register = int_cip($_GET['confirm_register']); else $confirm_register = 0;
if ($confirm_register) {
        $result = mysqli_query($pdo,"SELECT * FROM cv_customers WHERE id = '$confirm_register'") or die('ошибка выполнения запроса '.mysqli_error($pdo));
        $rows = mysqli_fetch_array($result);$email = $rows["email"];$pass = $rows["cus_pass"];
        if ($_GET["language_id"]) $lang_id = $_GET["language_id"]; else $lang_id = 1;
        set_content(array(309));
        $confirm_code = generate_key();
        $subj = "FROM CARVECTOR";
        $adm_email = "support@carvector.com";
        $url = "https://".$_SERVER['HTTP_HOST']."/index.php?registr&confirm_code=".urlencode($confirm_code);
        $msg = str_replace('{$email}', $email, $smarty->tpl_vars["content_309"]);
        $msg = str_replace('{$pass}', $pass, $msg);
        $msg = str_replace('{$url}', $url, $msg);
        if (substr($msg,0,6)=="From: ") {
          $i = strpos($msg, "\n");
          $adm_email = trim(substr($msg, 6, $i-6));
          $msg = trim(substr($msg, $i+1));
        }
        if (substr($msg,0,6)=="Subj: ") {
          $i = strpos($msg, "\n");
          $subj = trim(substr($msg, 6, $i-6));
          $msg = trim(substr($msg, $i+1));
        }
        $subj = '=?utf-8?B?'.base64_encode($subj).'?=';
        $header = "From: ".$adm_email."\n";
        $header .= "Content-type: text/html; charset=\"UTF-8\"\n";
		@mail($email,$subj,$msg,$header) or die("error send mail");
        mysqli_query($pdo,"UPDATE cv_customers SET confirm_code = '$confirm_code' WHERE id = '$confirm_register'") or die('ошибка выполнения запроса '.mysqli_error($pdo));
        $smarty->assign(array("alert"=>"Подтверждение регистрации отправлено успешно!","url"=>"./admin.php?users&sort=$sort".($sort_str?"&sort_str=$sort_str":"").($page?"&page=$page":"").($confirm_register?"&id=$confirm_register":"")));
        $smarty->display("exec_command.tpl");
        exit;
} else if ($bal_edit) {
	
	
} else if ($bal) {
        $result = mysqli_query($pdo,"SELECT * FROM cv_customers WHERE id = '$bal'") or die('ошибка выполнения запроса '.mysqli_error($pdo));
        $rows2 = mysqli_fetch_array($result);
        $result = mysqli_query($pdo,"SELECT * FROM cv_balance WHERE id_user = '$bal' order by ts") or die('ошибка выполнения запроса '.mysqli_error($pdo));
        $summ=0;
		while ($rows = mysqli_fetch_array($result)) { 
			$summ+=$rows["summ"];
			$rows["summ2"]=$summ;
			$smarty->append("bals", $rows); 
		}
        $smarty->assign(array(  "bal"       => $bal,
								"cl_name"	=>	$rows2["name"],
								"cl_id"		=>	$rows2["id"],
                                "sort"      => $sort,
                                "sort_str"  => $sort_str,
                                "page"      => $page,
                                "summ"      => 0+$summ,
                                ));
} else if ($bal2) {
        $result = mysqli_query($pdo,"SELECT * FROM cv_customers WHERE id = '$bal2'") or die('ошибка выполнения запроса '.mysqli_error($pdo));
        $rows2 = mysqli_fetch_array($result);
        $result = mysqli_query($pdo,"SELECT * FROM cv_balance WHERE id_user = '$bal2' order by sort_id") or die('ошибка выполнения запроса '.mysqli_error($pdo));
        $summ=0;
		while ($rows = mysqli_fetch_array($result)) { 
			$summ+=$rows["summ"];
			$rows["summ2"]=$summ;
			$smarty->append("bals", $rows); 
		}
	$smarty->assign(array(  "bal"		=>	$bal2,
							"bal2"		=>	$bal2,
							"cl_name"	=>	$rows2["name"],
							"cl_id"		=>	$rows2["id"],
							"summ"		=>	0+$summ,
							));
} else if ($id=="add" && $grant[0]) {
        $result = mysqli_query($pdo,"SELECT * FROM cv_language WHERE active=1") or die('ошибка выполнения запроса '.mysqli_error($pdo));
        while ($rows = mysqli_fetch_array($result)) $smarty->append("languages", $rows);
		mysqli_query($pdo,"INSERT INTO cv_customers SET date_reg=now()") or die('ошибка выполнения запроса '.mysqli_error($pdo));
        $result = mysqli_query($pdo,"SELECT max(id) FROM cv_customers") or die('ошибка выполнения запроса '.mysqli_error($pdo));
        $rows = mysqli_fetch_array($result);$id = $rows[0];
        $result = mysqli_query($pdo,"SELECT date_format(u.date_reg,'%d.%m.%Y') dt, u.* FROM cv_customers u WHERE u.id = '$id'") or die('ошибка выполнения запроса '.mysqli_error($pdo));
        $rows = mysqli_fetch_array($result);
        $smarty->assign(array(  "id"            => $id,
                                "user"          => $rows,
                                "customer"      => $rows,
                                "sort"          => 1,
                                ));
		$smarty->assign(array("url"=>"./admin.php?users&id=$id"));
		$smarty->display("exec_command.tpl");
		exit;
} else if ($id) {
		if ($sent) {
				$result = mysqli_query($pdo,"SELECT name FROM cv_administrations WHERE id = '{$_SESSION['login_id']}'") or die('ошибка выполнения запроса _21');
				$rows = mysqli_fetch_array($result); $namespr = $rows[0];
				$result = mysqli_query($pdo,"SELECT note FROM cv_customers WHERE id = '$id'") or die('ошибка выполнения запроса '.mysqli_error($pdo));
				$rows = mysqli_fetch_array($result); $note_s = $rows[0];
				if ($note_s) $perenos = "\n"; else $perenos = "";
				$sent_str = $note_s.$perenos."*".$namespr." sent ".date( "d-M-Y H:i:s" );
				mysqli_query($pdo,"UPDATE cv_customers SET note = '$sent_str' WHERE id = '$id'") or die('ошибка выполнения запроса '.mysqli_error($pdo));
		}
        if ($save && $login_admin=="admin") {
				if (isset($_POST['email'])) {
					$email = latin_cip(str_replace(" ","",mb_substr($_POST['email'], 0, 255)));
					$email = mb_strtolower($email, 'UTF-8');
				} else $email = "";
				if (isset($_POST['name'])) {
					$name = quote_cip(trim(preg_replace('/\s+/', ' ', mb_substr($_POST['name'], 0, 255))));
					preg_match_all("/./u", mb_strtolower($name, 'UTF-8'), $matches);
					$array = $matches[0];
					if ($array) {
						$array[0] = mb_strtoupper($array[0], 'UTF-8');
						foreach ($array as $key => $value) if (($value == "(" || $value == "." || $value == "," || $value == " ") && isset($array[$key+1])) $array[$key+1] = mb_strtoupper($array[$key+1], 'UTF-8');
						$name = "";
						foreach ($array as $value) $name .= $value;
						$name = preg_replace('/\s\.+/', '.', $name);
						$name = preg_replace('/\s,+/', ',', $name);
						$name = preg_replace('/(\.,+)|(,\.+)/', '.', $name);
						$name = preg_replace('/\.+/', '.', $name);
						$name = preg_replace('/,+/', ',', $name);
					}
				} else $name = "";
				if (isset($_POST['cus_name'])) {
					$cus_name = quote_cip(trim(preg_replace('/\s+/', ' ', mb_substr($_POST['cus_name'], 0, 255))));
				} else $cus_name = "";
				if (isset($_POST['phone'])) {
					$phone = phone_cip(str_replace(" ","",mb_substr($_POST['phone'], 0, 50)));
					if ($phone && substr($phone,0,1)!='+') $phone = "+".$phone;
				} else $phone = "";
				if (isset($_POST['cus_phone'])) {
					$cus_phone = phone_cip(str_replace(" ","",mb_substr($_POST['cus_phone'], 0, 50)));
					if ($cus_phone && substr($cus_phone,0,1)!='+') $cus_phone = "+".$cus_phone;
				} else $cus_phone = "";
				if (isset($_POST['mphone'])) {
					$mphone = phone_cip(str_replace(" ","",mb_substr($_POST['mphone'], 0, 50)));
					if ($mphone && substr($mphone,0,1)!='+') $mphone = "+".$mphone;
				} else $mphone = "";
				if (isset($_POST['cus_mphone'])) {
					$cus_mphone = phone_cip(str_replace(" ","",mb_substr($_POST['cus_mphone'], 0, 50)));
					if ($cus_mphone && substr($cus_mphone,0,1)!='+') $cus_mphone = "+".$cus_mphone;
				} else $cus_mphone = "";
				if (isset($_POST['skype'])) $skype = trim(latin_cip(mb_substr($_POST['skype'], 0, 50))); else $skype = "";
				if (isset($_POST['cus_skype'])) $cus_skype = trim(latin_cip(mb_substr($_POST['cus_skype'], 0, 50))); else $cus_skype = "";
                mysqli_query($pdo,"UPDATE cv_customers SET
								  date_reg			= '".mysqli_real_escape_string($pdo,trim($_POST['date_reg']))."'
								, lang_id			= '".int_cip($_POST['lang_id'])."'
								, email				= '".mysqli_real_escape_string($pdo,$email)."'
								, name				= '".mysqli_real_escape_string($pdo,$name)."'
								, sh_name			= '".mysqli_real_escape_string($pdo,trim($_POST['sh_name']))."'
								, address			= '".mysqli_real_escape_string($pdo,trim($_POST['address']))."'
								, country			= '".mysqli_real_escape_string($pdo,trim($_POST['country']))."'
								, phone				= '".mysqli_real_escape_string($pdo,$phone)."'
								, mphone			= '".mysqli_real_escape_string($pdo,$mphone)."'
								, skype				= '".mysqli_real_escape_string($pdo,$skype)."'
								, info				= '".mysqli_real_escape_string($pdo,trim($_POST['info']))."'
								, note				= '".mysqli_real_escape_string($pdo,trim($_POST['note']))."'
								, massmail			= '".int_cip($_POST['massmail'])."'
								, keywords			= '".mysqli_real_escape_string($pdo,trim($_POST['keywords']))."'
								, confirmed			= '".int_cip($_POST['confirmed'])."'
								, blocked			= '".int_cip($_POST['blocked'])."'
								, direct			= '".int_cip($_POST['direct'])."'
								, gender			= '".int_cip($_POST['gender'])."'
								, cus_pass			= '".mysqli_real_escape_string($pdo,trim($_POST['cus_pass']))."'
								, cus_name			= '".mysqli_real_escape_string($pdo,$cus_name)."'
								, cus_address		= '".mysqli_real_escape_string($pdo,trim($_POST['cus_address']))."'
								, cus_country		= '".mysqli_real_escape_string($pdo,trim($_POST['cus_country']))."'
								, cus_phone			= '".mysqli_real_escape_string($pdo,$cus_phone)."'
								, cus_mphone		= '".mysqli_real_escape_string($pdo,$cus_mphone)."'
								, cus_skype			= '".mysqli_real_escape_string($pdo,$cus_skype)."'
								, cus_info			= '".mysqli_real_escape_string($pdo,trim($_POST['cus_info']))."'
								, cus_auclogin		= '".mysqli_real_escape_string($pdo,trim($_POST['cus_auclogin']))."'
								, cus_aucpass		= '".mysqli_real_escape_string($pdo,trim($_POST['cus_aucpass']))."'
								, ip_adress			= '".mysqli_real_escape_string(trim($pdo,$_POST['ip_adress']))."'
								, ip_country_code	= '".mysqli_real_escape_string($pdo,trim($_POST['ip_country_code']))."'
								, ip_country_name	= '".mysqli_real_escape_string($pdo,trim($_POST['ip_country_name']))."'
								, ip_region			= '".mysqli_real_escape_string($pdo,trim($_POST['ip_region']))."'
								, ip_city			= '".mysqli_real_escape_string($pdo,trim($_POST['ip_city']))."'
								WHERE id = '$id'") or die('ошибка выполнения запроса '.mysqli_error($pdo));
								
                $smarty->assign(array("url"=>"./admin.php?users&sort=$sort".($sort_str?"&sort_str=$sort_str":"").($page?"&page=$page":"")."&id=$id"));
                $smarty->display("exec_command.tpl");
                exit;
        } else if ($save && $grant[0]) {
				if (isset($_POST['email'])) {
					$email = latin_cip(str_replace(" ","",mb_substr($_POST['email'], 0, 255)));
					$email = mb_strtolower($email, 'UTF-8');
				} else $email = "";
				if (isset($_POST['name'])) {
					$name = quote_cip(trim(preg_replace('/\s+/', ' ', mb_substr($_POST['name'], 0, 255))));
					preg_match_all("/./u", mb_strtolower($name, 'UTF-8'), $matches);
					$array = $matches[0];
					$array[0] = mb_strtoupper($array[0], 'UTF-8');
					foreach ($array as $key => $value) if (($value == "(" || $value == "." || $value == "," || $value == " ") && isset($array[$key+1])) $array[$key+1] = mb_strtoupper($array[$key+1], 'UTF-8');
					$name = "";
					foreach ($array as $value) $name .= $value;
					$name = preg_replace('/\s\.+/', '.', $name);
					$name = preg_replace('/\s,+/', ',', $name);
					$name = preg_replace('/(\.,+)|(,\.+)/', '.', $name);
					$name = preg_replace('/\.+/', '.', $name);
					$name = preg_replace('/,+/', ',', $name);
				} else $name = "";
				if (isset($_POST['cus_name'])) {
					$cus_name = quote_cip(trim(preg_replace('/\s+/', ' ', mb_substr($_POST['cus_name'], 0, 255))));
					preg_match_all("/./u", mb_strtolower($cus_name, 'UTF-8'), $matches);
					$array = $matches[0];
					$array[0] = mb_strtoupper($array[0], 'UTF-8');
					foreach ($array as $key => $value) if (($value == "(" || $value == "." || $value == "," || $value == " ") && isset($array[$key+1])) $array[$key+1] = mb_strtoupper($array[$key+1], 'UTF-8');
					$cus_name = "";
					foreach ($array as $value) $cus_name .= $value;
					$cus_name = preg_replace('/\s\.+/', '.', $cus_name);
					$cus_name = preg_replace('/\s,+/', ',', $cus_name);
					$cus_name = preg_replace('/(\.,+)|(,\.+)/', '.', $cus_name);
					$cus_name = preg_replace('/\.+/', '.', $cus_name);
					$cus_name = preg_replace('/,+/', ',', $cus_name);
				} else $cus_name = "";
				if (isset($_POST['phone'])) {
					$phone = phone_cip(str_replace(" ","",mb_substr($_POST['phone'], 0, 50)));
					if ($phone && substr($phone,0,1)!='+') $phone = "+".$phone;
				} else $phone = "";
				if (isset($_POST['cus_phone'])) {
					$cus_phone = phone_cip(str_replace(" ","",mb_substr($_POST['cus_phone'], 0, 50)));
					if ($cus_phone && substr($cus_phone,0,1)!='+') $cus_phone = "+".$cus_phone;
				} else $cus_phone = "";
				if (isset($_POST['mphone'])) {
					$mphone = phone_cip(str_replace(" ","",mb_substr($_POST['mphone'], 0, 50)));
					if ($mphone && substr($mphone,0,1)!='+') $mphone = "+".$mphone;
				} else $mphone = "";
				if (isset($_POST['cus_mphone'])) {
					$cus_mphone = phone_cip(str_replace(" ","",mb_substr($_POST['cus_mphone'], 0, 50)));
					if ($cus_mphone && substr($cus_mphone,0,1)!='+') $cus_mphone = "+".$cus_mphone;
				} else $cus_mphone = "";
				if (isset($_POST['skype'])) $skype = trim(latin_cip(mb_substr($_POST['skype'], 0, 50))); else $skype = "";
				if (isset($_POST['cus_skype'])) $cus_skype = trim(latin_cip(mb_substr($_POST['cus_skype'], 0, 50))); else $cus_skype = "";
                mysqli_query($pdo,"UPDATE cv_customers SET
								  lang_id			= '".int_cip($_POST['lang_id'])."'
								, email				= '".mysqli_real_escape_string($pdo,$email)."'
								, name				= '".mysqli_real_escape_string($pdo,$name)."'
								, sh_name			= '".mysqli_real_escape_string($pdo,trim($_POST['sh_name']))."'
								, address			= '".mysqli_real_escape_string($pdo,trim($_POST['address']))."'
								, country			= '".mysqli_real_escape_string($pdo,trim($_POST['country']))."'
								, phone				= '".mysqli_real_escape_string($pdo,$phone)."'
								, mphone			= '".mysqli_real_escape_string($pdo,$mphone)."'
								, skype				= '".mysqli_real_escape_string($pdo,trim($_POST['skype']))."'
								, info				= '".mysqli_real_escape_string($pdo,trim($_POST['info']))."'
								, note				= '".mysqli_real_escape_string($pdo,trim($_POST['note']))."'
								, massmail			= '".int_cip($_POST['massmail'])."'
								, keywords			= '".mysqli_real_escape_string($pdo,trim($_POST['keywords']))."'
								, confirmed			= '".int_cip($_POST['confirmed'])."'
								, blocked			= '".int_cip($_POST['blocked'])."'
								, direct			= '".int_cip($_POST['direct'])."'
								, gender			= '".int_cip($_POST['gender'])."'
								, cus_pass			= '".mysqli_real_escape_string($pdo,trim($_POST['cus_pass']))."'
								, cus_name			= '".mysqli_real_escape_string($pdo,$cus_name)."'
								, cus_address		= '".mysqli_real_escape_string($pdo,trim($_POST['cus_address']))."'
								, cus_country		= '".mysqli_real_escape_string($pdo,trim($_POST['cus_country']))."'
								, cus_phone			= '".mysqli_real_escape_string($pdo,$cus_phone)."'
								, cus_mphone		= '".mysqli_real_escape_string($pdo,$cus_mphone)."'
								, cus_skype			= '".mysqli_real_escape_string($pdo,$cus_skype)."'
								, cus_info			= '".mysqli_real_escape_string(trim($pdo,$_POST['cus_info']))."'
								, cus_auclogin		= '".mysqli_real_escape_string(trim($pdo,$_POST['cus_auclogin']))."'
								, cus_aucpass		= '".mysqli_real_escape_string(trim($pdo,$_POST['cus_aucpass']))."'
								WHERE id = '$id'") or die('ошибка выполнения запроса '.mysqli_error($pdo));
                $smarty->assign(array("url"=>"./admin.php?users&sort=$sort".($sort_str?"&sort_str=$sort_str":"").($page?"&page=$page":"")."&id=$id"));
                $smarty->display("exec_command.tpl");
                exit;
        } else if ($save && $grant[1]) {
                mysqli_query($pdo,"UPDATE cv_customers SET
								  name				= '".mysqli_real_escape_string($pdo,trim($_POST['name']))."'
								, address			= '".mysqli_real_escape_string($pdo,trim($_POST['address']))."'
								, country			= '".mysqli_real_escape_string($pdo,trim($_POST['country']))."'
								, phone				= '".mysqli_real_escape_string($pdo,trim($_POST['phone']))."'
								, mphone			= '".mysqli_real_escape_string($pdo,trim($_POST['mphone']))."'
								, skype				= '".mysqli_real_escape_string($pdo,trim($_POST['skype']))."'
								, info				= '".mysqli_real_escape_string($pdo,trim($_POST['info']))."'
								, note				= '".mysqli_real_escape_string($pdo,trim($_POST['note']))."'
								, direct			= '".int_cip($_POST['massmail'])."'
								WHERE id = '$id'") or die('ошибка выполнения запроса '.mysqli_error($pdo));
                $smarty->assign(array("url"=>"./admin.php?users&sort=$sort".($sort_str?"&sort_str=$sort_str":"").($page?"&page=$page":"")."&id=$id"));
                $smarty->display("exec_command.tpl");
                exit;
        }
		
		if ($pid) {
			$result = mysqli_query($pdo,"SELECT MIN(id) FROM cv_customers WHERE id>'$id'") or die('ошибка выполнения запроса '.mysqli_error($pdo));
			$row = mysqli_fetch_array($result);
			if ($row[0]) $id = $row[0];
		}
		if ($mid) {
			$result = mysqli_query($pdo,"SELECT MAX(id) FROM cv_customers WHERE id<'$id'") or die('ошибка выполнения запроса '.mysqli_error($pdo));
			$row = mysqli_fetch_array($result);
			if ($row[0]) $id = $row[0];
		}

        $result = mysqli_query($pdo,"SELECT * FROM cv_language WHERE active=1") or die('ошибка выполнения запроса '.mysqli_error($pdo));
        while ($rows = mysqli_fetch_array($result)) $smarty->append("languages", $rows);
        $result = mysqli_query($pdo,"SELECT *,(UNIX_TIMESTAMP()-UNIX_TIMESTAMP(ts_lastinput)) ddt
									,date_format(date_reg,'%d %M %Y') AS date_r 
									FROM cv_customers WHERE id='$id'") or die('ошибка выполнения запроса '.mysqli_error($pdo));
        $row = mysqli_fetch_array($result);
		$diff_seconds = $row['ddt'];
		$diff_days = floor($diff_seconds/86400);
		$diff_seconds -= $diff_days * 86400;
		$diff_hours = floor($diff_seconds/3600);
		$diff_seconds -= $diff_hours * 3600;
		$diff_minutes = floor($diff_seconds/60);
		$diff_seconds -= $diff_minutes * 60;
		$row['dtime'] = str_pad($diff_hours, 2, '0', STR_PAD_LEFT).':'.str_pad($diff_minutes, 2, '0', STR_PAD_LEFT).':'.str_pad($diff_seconds, 2, '0', STR_PAD_LEFT);
		$row['ddays'] = $diff_days;
        $smarty->assign(array(  "id"            => $id,
                                "customer"      => $row,
                                "sort"          => $sort,
                                "sort_str"      => $sort_str,
                                "page"          => $page,
                                ));

} else {
		$ep = 10;
		if ($page != "" && $page < 1) $page = 1;
		
        if ($del && $grant[0]) mysqli_query($pdo,"DELETE FROM cv_customers WHERE id = '$del'") or die('ошибка выполнения запроса '.mysqli_error($pdo));
        if ($del_massmail) mysqli_query($pdo,"UPDATE cv_customers SET massmail = 0 WHERE id = '$del_massmail'") or die('ошибка выполнения запроса '.mysqli_error($pdo));
        if ($add_massmail) mysqli_query($pdo,"UPDATE cv_customers SET massmail = 1 WHERE id = '$add_massmail'") or die('ошибка выполнения запроса '.mysqli_error($pdo));
        if ($del_blocked) mysqli_query($pdo,"UPDATE cv_customers SET blocked = 0 WHERE id = '$del_blocked'") or die('ошибка выполнения запроса '.mysqli_error($pdo));
        if ($add_blocked) mysqli_query($pdo,"UPDATE cv_customers SET blocked = 1, session_id = '' WHERE id = '$add_blocked'") or die('ошибка выполнения запроса '.mysqli_error($pdo));
        if ($del_direct) mysqli_query($pdo,"UPDATE cv_customers SET direct = 0 WHERE id = '$del_direct'") or die('ошибка выполнения запроса '.mysqli_error($pdo));
        if ($add_direct) mysqli_query($pdo,"UPDATE cv_customers SET direct = 1 WHERE id = '$add_direct'") or die('ошибка выполнения запроса '.mysqli_error($pdo));
        if ($del_favorit) mysqli_query($pdo,"DELETE FROM cv_favorites WHERE id_user = '$del_favorit' and id_admin = '{$_SESSION['login_id']}'") or die('ошибка выполнения запроса '.mysqli_error($pdo));
        if ($add_favorit) {
                $result = mysqli_query($pdo,"SELECT count(*) FROM cv_favorites WHERE id_user = '$add_favorit' AND id_admin = '{$_SESSION['login_id']}'") or die('ошибка выполнения запроса '.mysqli_error($pdo));
                $rows = mysqli_fetch_array($result);
                if (!$rows[0]) mysqli_query($pdo,"INSERT into cv_favorites (id_user,id_admin) VALUES ('$add_favorit', '{$_SESSION['login_id']}')") or die('ошибка выполнения запроса '.mysqli_error($pdo));
        }
        if ($sort==1) $sql = "FROM cv_customers u WHERE 1=1";
        if ($sort==2) $sql = "FROM cv_customers u WHERE u.confirmed = 1 ";
        if ($sort==3) $sql = "FROM cv_customers u, cv_favorites f WHERE f.id_user = u.id AND f.id_admin = '{$_SESSION['login_id']}'";
        if ($sort==4) $sql = "FROM cv_customers u WHERE u.blocked = 1 ";
        if ($sort==5) $sql = "FROM cv_customers u WHERE u.massmail = 1 ";
        if ($sort==6) $sql = "FROM cv_customers u WHERE u.name LIKE '%$sort_str%' OR u.email LIKE '%$sort_str%' OR u.address LIKE '%$sort_str%' OR u.phone LIKE '%$sort_str%' OR u.mphone LIKE '%$sort_str%' OR u.info LIKE '%$sort_str%' OR u.country LIKE '%$sort_str%' OR u.address LIKE '%$sort_str%' OR u.skype LIKE '%$sort_str%'";
        if ($sort==7) $sql = "FROM cv_customers u WHERE u.id = '$sort_str'";
        if ($sort==8) $sql = "FROM cv_customers u WHERE u.direct = 1";
        if ($sort==9) $sql = "FROM cv_customers u WHERE u.massmail != 1 ";
        if ($sort==10) $sql = "FROM cv_customers u WHERE u.unsubscribed = 1";
        if ($sort==1) {
                $result = mysqli_query($pdo,"SELECT date_format(min(u.date_reg),'%Y%m%d') $sql") or die('ошибка выполнения запроса '.mysqli_error($pdo));
                $rows = mysqli_fetch_array($result);
				$dt_first = $rows[0];
                $dt_last = date("Ymd");
				if (!$page) $page = $dt_last;
                $mm = array("January", "February", "March", "April", "May", "June", "July", "August", "September", "October", "November", "December");
                if (substr($dt_last,0,6)==substr($page,0,6)) { 
					$d = 0+substr($dt_last,6,2);
					$dn = ""; 
				} else {
					$d = 0+date("d", mktime(0,0,0,1+substr($page,4,2),0,substr($page,0,4)));
					$dn = date("Ymd", mktime(0,0,0,1+substr($page,4,2),1,substr($page,0,4)));
                }
                if (substr($dt_first,0,6)==substr($page,0,6)) { 
					$d2 = 0+substr($dt_first,6,2);
					$dp = ""; 
				} else {
					$d2 = 1;
					$dp = date("Ymd", mktime(0,0,0,substr($page,4,2),0,substr($page,0,4)));
                }
                $dd = array();
				for($i=$d2;$i<=$d;$i++) {
					$ii = $i;
					if (strlen($ii)==1) $ii = "0".$ii;
					array_push($dd, array("d"=>$i,"p"=>substr($page,0,6).$ii,"c"=>0));
                }
                $result = mysqli_query($pdo,"SELECT date_format(u.date_reg,'%d'), count(distinct u.id) $sql AND month(u.date_reg) = ".substr($page,4,2)." AND year(u.date_reg) = ".substr($page,0,4)." GROUP BY date_format(u.date_reg,'%d')") or die('ошибка выполнения запроса '.mysqli_error($pdo));
                while ($rows = mysqli_fetch_array($result)) $dd[$rows[0]-$d2]["c"] = $rows[1];
                $c_min = 1000000;
				$c_max = 0;
				$sum = 0;
                for($i=0;$i<count($dd);$i++) {
					$sum += $dd[$i]["c"];
					if ($c_min>$dd[$i]["c"]) $c_min = $dd[$i]["c"];
					if ($c_max<$dd[$i]["c"]) $c_max = $dd[$i]["c"];
                }
                for($i=0;$i<count($dd);$i++) {
					if ($c_max==$c_min) {
						$dd[$i]["f"] = 33;
					} else if ($dd[$i]["c"]==0) {
						$dd[$i]["f"] = 33;
					} else {
						$dd[$i]["f"] = round(33-$dd[$i]["c"]*16/$c_max);
					}
				}
                $result = mysqli_query($pdo,"SELECT u.*, (UNIX_TIMESTAMP()-UNIX_TIMESTAMP(u.ts_lastinput)) ddt $sql AND date_format(u.date_reg,'%Y%m%d')='$page' order by u.id") or die('ошибка выполнения запроса '.mysqli_error($pdo));
                while ($rows = mysqli_fetch_array($result)) {
					$result2 = mysqli_query($pdo,"SELECT count(*) FROM cv_balance WHERE id_user = '{$rows['id']}'") or die('ошибка выполнения запроса '.mysqli_error($pdo));
					$rows2 = mysqli_fetch_array($result2);
					$rows['balance'] = 0+$rows2[0];
					$result2 = mysqli_query($pdo,"SELECT count(*) FROM cv_orders WHERE uid = '{$rows['id']}'") or die('ошибка выполнения запроса '.mysqli_error($pdo));
					$rows2 = mysqli_fetch_array($result2);
					$rows['order'] = 0+$rows2[0];
					$result2 = mysqli_query($pdo,"SELECT count(*) FROM cv_favorites WHERE id_user = '{$rows['id']}' and id_admin = '{$_SESSION['login_id']}'") or die('ошибка выполнения запроса '.mysqli_error($pdo));
					$rows2 = mysqli_fetch_array($result2);
					$rows['favorit'] = $rows2[0];
					$diff_seconds = $rows['ddt'];
					$diff_days = floor($diff_seconds/86400);
					$diff_seconds -= $diff_days * 86400;
					$diff_hours = floor($diff_seconds/3600);
					$diff_seconds -= $diff_hours * 3600;
					$diff_minutes = floor($diff_seconds/60);
					$diff_seconds -= $diff_minutes * 60;
					$rows['dtime'] = str_pad($diff_hours, 2, '0', STR_PAD_LEFT).':'.str_pad($diff_minutes, 2, '0', STR_PAD_LEFT).':'.str_pad($diff_seconds, 2, '0', STR_PAD_LEFT);
					$rows['ddays'] = $diff_days;
					$smarty->append("users", $rows);
					$sss[] = $rows;
                }
                $smarty->assign(array(  "page"          => $page,
                                        "sort"          => $sort,
                                        "sort_str"      => $sort_str,
                                        "pages"         => $dd,
                                        "month"         => $mm[substr($page,4,2)-1]." ".substr($page,0,4),
                                        "sum"           => $sum,
                                        "dn"            => $dn,
                                        "dp"            => $dp,
                                        ));
        } else {
                $result = mysqli_query($pdo,"SELECT count(distinct u.id) $sql") or die('ошибка выполнения запроса '.mysqli_error($pdo));
                if ($rows = mysqli_fetch_array($result)) $pc = ceil($rows[0]/$ep);
				if ($page=="" || $page > $pc) $page = $pc;
                if ($pc) {
                        $result = mysqli_query($pdo,"SELECT u.*, (UNIX_TIMESTAMP()-UNIX_TIMESTAMP(u.ts_lastinput)) ddt $sql order by u.id limit ".(($page-1)*$ep).",$ep") or die('ошибка выполнения запроса '.mysqli_error($pdo));
                        $pb = $page - 5;
						if ($pb<1) $pb = 1;
                        while ($rows = mysqli_fetch_array($result)) {
                                $result2 = mysqli_query($pdo,"SELECT count(*) FROM cv_balance WHERE id_user = '{$rows['id']}'") or die('ошибка выполнения запроса '.mysqli_error($pdo));
                                $rows2 = mysqli_fetch_array($result2);
                                $rows['balance'] = 0+$rows2[0];
                                $result2 = mysqli_query($pdo,"SELECT count(*) FROM cv_orders WHERE uid = '{$rows['id']}'") or die('ошибка выполнения запроса '.mysqli_error($pdo));
                                $rows2 = mysqli_fetch_array($result2);
                                $rows['order'] = 0+$rows2[0];
                                $result2 = mysqli_query($pdo,"SELECT count(*) FROM cv_favorites WHERE id_user = '{$rows['id']}' and id_admin = '{$_SESSION['login_id']}'") or die('ошибка выполнения запроса '.mysqli_error($pdo));
                                $rows2 = mysqli_fetch_array($result2);
                                $rows['favorit'] = $rows2[0];
								$diff_seconds = $rows['ddt'];
								$diff_days = floor($diff_seconds/86400);
								$diff_seconds -= $diff_days * 86400;
								$diff_hours = floor($diff_seconds/3600);
								$diff_seconds -= $diff_hours * 3600;
								$diff_minutes = floor($diff_seconds/60);
								$diff_seconds -= $diff_minutes * 60;
								$rows['dtime'] = str_pad($diff_hours, 2, '0', STR_PAD_LEFT).':'.str_pad($diff_minutes, 2, '0', STR_PAD_LEFT).':'.str_pad($diff_seconds, 2, '0', STR_PAD_LEFT);
								$rows['ddays'] = $diff_days;
								$sss[] = $rows;
                                $smarty->append("users", $rows);
                        }
                        for($i=$pb;$i<$pb+10 && $i<=$pc;$i++) $smarty->append("pages", array("n"=>$i,"p"=>((strlen($i)==1)?"0".$i:$i)));
                }
				if (!isset($pb)) $pb = 1;
                $smarty->assign(array(  "page_beg"      => $pb,
                                        "page"          => $page,
                                        "page_c"        => $pc,
                                        "sort"          => $sort,
                                        "sort_str"      => $sort_str,
                                        ));
        }
}

?>
