<?php

set_content(array(13,14,17,18,19,20,21,22,315,316,"376-379"));

$result = mysqli_query($pdo,"SELECT * FROM cv_hotpr WHERE language_id = '$lang_id' ORDER BY id DESC") or error();
while ($rows = mysqli_fetch_array($result)) {
        $rows['notes'] = mb_substr($rows['note'], 0, 150, 'UTF-8');
        $fn = ext_to_pic("./files/hotpr/".$rows['id'].".");
        if ($fn) $rows['photo'] = urlencode($fn); else $rows['photo'] = "";
        $rows['dt'] = date("YmdHis");
        $smarty->append("hotpr", $rows);
}

$result = mysqli_query($pdo,"SELECT * FROM cv_responses WHERE language_id = '$lang_id' and confirm = 1 ORDER BY date DESC limit 0,4") or error();
while ($rows = mysqli_fetch_array($result)) {
        $rows['messages'] = mb_substr(preg_replace('/&#60;.+&#62;/sUi', '', $rows['message']), 0, 200, 'UTF-8');
        $smarty->append("responses", $rows);
}

require __DIR__ . "/../functions_s2x.php";
set_content(array("144-223",326,359,360,373, 374));

if (isset($_SESSION['login_user_id'])) $smarty->assign("login_user_id", $_SESSION['login_user_id']);
if (isset($_SESSION['direct_user'])) $smarty->assign("direct_user", $_SESSION['direct_user']);

if (isset($_GET['lotid'])) $lotid = $_GET['lotid']; else $lotid = ""; $smarty->assign("lotid", $lotid);
if (isset($_GET['lotidst'])) $lotidst = $_GET['lotidst']; else $lotidst = ""; $smarty->assign("lotidst", $lotidst);
if (isset($_POST['reset'])) $reset = $_POST['reset']; else $reset = "";

if (isset($_GET['page'])) {
	$page = $_GET['page']; $_SESSION['page'] = $page;
} else if (isset($_SESSION['page'])) {
	$page = $_SESSION['page'];
} else {
	$page = 1; $_SESSION['page'] = 1;
}
if ($page < 0 || $page*1==0) {$page = 1; $_SESSION['page'] = 1;}

if (isset($_POST['stats']) || isset($_GET['stats'])) {
	if (isset($_POST['stats'])) {
		$stats = $_POST['stats']; $page = 1; $_SESSION['page'] = 1;
	} elseif (isset($_GET['stats'])) {
		$stats = $_GET['stats'];
	}
	$smarty->assign("stats", $stats); 
} else $stats = ""; 

if (isset($_POST['ssearch']) || isset($_GET['ssearch'])) {
	if (isset($_POST['ssearch'])) {
		$ssearch = $_POST['ssearch']; $page = 1; $_SESSION['page'] = 1;
	} else if (isset($_GET['ssearch'])) {
		$ssearch = $_GET['ssearch'];
	}
	$smarty->assign("ssearch", $ssearch);
} else $ssearch = ""; 

if (isset($_POST['marka_id'])) {$marka_id = $_POST['marka_id']; $_SESSION['marka_id'] = $marka_id;
} else if (isset($_SESSION['marka_id'])) $marka_id = $_SESSION['marka_id']; else {$marka_id = ""; $_SESSION['marka_id'] = $marka_id;}

if (isset($_POST['model_id'])) {$model_id = $_POST['model_id']; $_SESSION['model_id'] = $model_id;
} else if (isset($_SESSION['model_id'])) $model_id = $_SESSION['model_id']; else {$model_id = ""; $_SESSION['model_id'] = $model_id;}

if (isset($_POST['kuzov'])) {$kuzovarr = $_POST['kuzov']; $_SESSION['kuzov'] = $kuzovarr;
} else if (isset($_SESSION['kuzov'])) $kuzovarr = $_SESSION['kuzov']; else {$kuzovarr = array(); $_SESSION['kuzov'] = $kuzovarr;}

if (isset($_POST['aucs'])) {$aucarr = $_POST['aucs']; $_SESSION['aucs'] = $aucarr;
} else if (isset($_SESSION['aucs'])) $aucarr = $_SESSION['aucs']; else {$aucarr = array(); $_SESSION['aucs'] = $aucarr;}

if (isset($_POST['rates'])) {$ratearr = $_POST['rates']; $_SESSION['rates'] = $ratearr;
} else if (isset($_SESSION['rates'])) $ratearr = $_SESSION['rates']; else {$ratearr = array(); $_SESSION['rates'] = $ratearr;}

if (isset($_POST['year1'])) {$year1 = $_POST['year1']; $_SESSION['year1'] = $year1;
} else if (isset($_SESSION['year1'])) $year1 = $_SESSION['year1']; else {$year1 = ""; $_SESSION['year1'] = $year1;}

if (isset($_POST['year2'])) {$year2 = $_POST['year2']; $_SESSION['year2'] = $year2;
} else if (isset($_SESSION['year2'])) $year2 = $_SESSION['year2']; else {$year2 = ""; $_SESSION['year2'] = $year2;}

if (isset($_POST['mil1'])) {$mil1 = int_cip($_POST['mil1']); $_SESSION['mil1'] = $mil1;
} else if (isset($_SESSION['mil1'])) $mil1 = $_SESSION['mil1']; else {$mil1 = ""; $_SESSION['mil1'] = $mil1;}

if (isset($_POST['mil2'])) {$mil2 = int_cip($_POST['mil2']); $_SESSION['mil2'] = $mil2;
} else if (isset($_SESSION['mil2'])) $mil2 = $_SESSION['mil2']; else {$mil2 = ""; $_SESSION['mil2'] = $mil2;}

if (isset($_POST['eng1'])) {$eng1 = int_cip($_POST['eng1']); $_SESSION['eng1'] = $eng1;
} else if (isset($_SESSION['eng1'])) $eng1 = $_SESSION['eng1']; else {$eng1 = ""; $_SESSION['eng1'] = $eng1;}

if (isset($_POST['eng2'])) {$eng2 = int_cip($_POST['eng2']); $_SESSION['eng2'] = $eng2;
} else if (isset($_SESSION['eng2'])) $eng2 = $_SESSION['eng2']; else {$eng2 = ""; $_SESSION['eng2'] = $eng2;}

if (isset($_POST['kpp'])) {$kpp = $_POST['kpp']; $_SESSION['kpp'] = $kpp;
} else if (isset($_SESSION['kpp'])) $kpp = $_SESSION['kpp']; else {$kpp = ""; $_SESSION['kpp'] = $kpp;}

if (isset($_POST['lotno'])) {$lotno = int_cip($_POST['lotno']); $_SESSION['lotno'] = $lotno;
} else if (isset($_SESSION['lotno'])) $lotno = $_SESSION['lotno']; else {$lotno = ""; $_SESSION['lotno'] = $lotno;}

if ($reset || $lotno) {
	if ($reset) {$lotno = ""; $_SESSION['lotno'] = $lotno;}
	$marka_id = ""; $_SESSION['marka_id'] = $marka_id;
	$model_id = ""; $_SESSION['model_id'] = $model_id;
	$kuzovarr = array(); $_SESSION['kuzov'] = $kuzovarr;
	$aucarr = array(); $_SESSION['aucs'] = $aucarr;
	$ratearr = array(); $_SESSION['rates'] = $ratearr;
	$year1 = ""; $_SESSION['year1'] = $year1;
	$year2 = ""; $_SESSION['year2'] = $year2;
	$mil1 = ""; $_SESSION['mil1'] = $mil1;
	$mil2 = ""; $_SESSION['mil2'] = $mil2;
	$eng1 = ""; $_SESSION['eng1'] = $eng1;
	$eng2 = ""; $_SESSION['eng2'] = $eng2;
	$kpp = ""; $_SESSION['kpp'] = $kpp;
}
$smarty->assign("mil1", $mil1);
$smarty->assign("mil2", $mil2);
$smarty->assign("eng1", $eng1);
$smarty->assign("eng2", $eng2);
$smarty->assign("kpp", $kpp);
$smarty->assign("lotno", $lotno);

/* TODO delete block */
$rowsss = array();
if (isset($_POST['send']) && isset($_POST['mlotid']) && isset($_POST['request']) 
			&& isset($_SESSION['login_user']) && isset($_SESSION['login_user_id'])) {
	$result = mysqli_query($pdo,"SELECT name, email FROM cv_customers WHERE id = '".$_SESSION['login_user_id']."' ") or error();
	if ($rowsss = mysqli_fetch_array($result)) {
		$email = $rowsss["email"]; 
		$name = $rowsss["name"];
		$lotid = $_POST['mlotid']; $smarty->assign("lotid", $lotid);
		$main_sql = "SELECT lot, marka_name, model_name, auction, auction_date FROM main WHERE id = '".$lotid."'";
		$idres = array(); $idres = aj_get($main_sql,0,0);
		if ($idres)  {	
			$mline = "Lot:";
			$xlot = $idres[0]["LOT"];
			$xmarka_name = $idres[0]["MARKA_NAME"];
			$xmodel_name = $idres[0]["MODEL_NAME"];
			$xauction = $idres[0]["AUCTION"];
			$xauction_date = format_mysql_date2($idres[0]["AUCTION_DATE"], "kkk f y");
			$url = "https://".$_SERVER['HTTP_HOST']."/index.php?search_3&lotid=$lotid";
		} else {
			$mline = "Data not found:";
			$xlot = "LOT";
			$xmarka_name = "MARKA";
			$xmodel_name = "MODEL";
			$xauction = "AUCTION";
			$xauction_date = "DATE";
			$url = "https://".$_SERVER['HTTP_HOST']."/index.php?search_3";
		}
		if ($_SESSION['direct_user'] == 'direct') $s = 'Dep'; else $s = 'Reg';
		$subj = $s.' '.$_SESSION['login_user_id'].': '.$name.' ('.$mline.' '.$xlot.','.$xmarka_name.' '.$xmodel_name.','.$xauction.','.$xauction_date.')';
		$subj = '=?utf-8?B?'.base64_encode($subj).'?=';
		$link = '<a href = '.$url.'>'.$mline.' '.$xlot.', '.$xmarka_name.' '.$xmodel_name.', '.$xauction.', '.$xauction_date.'</a>';
		$text_email = $s.' '.$_SESSION['login_user_id'].': '.$name.'<br>'.$link.'<br>Message:<br>'.nl2br($_POST['request']);
		$header = "From: ".$email."\n";
		$header .= "Content-type: text/html; charset=\"UTF-8\"\n";
		$semail = "sales@carvector.com".', ';
		$semail .= $email;
		if (@mail($semail, $subj, $text_email, $header))
			$n = "Your request has been sent successfully!"; else $n = "Error while sending the request, try again!";
	} else $n = "Error while sending the request, try again!";
	$smarty->assign("onload", 'alert("'.$n.'");');
}

if ($lotid || $lotidst) {
	if ($lotid) $main_sql = "SELECT * FROM main WHERE id = '".$lotid."'";
	if ($lotidst) $main_sql = "SELECT * FROM stats WHERE id = '".$lotidst."'";
	$idres = array(); $idres = aj_get($main_sql,0,0);
	if ($idres) {	
		foreach ($idres as $k=>$value) $idres[$k]["AUCTION_DATE"] = format_mysql_date2($value["AUCTION_DATE"], "kkk f y");
		$smarty->assign("idres", $idres);
		$pictures = explode("#", $idres[0]["IMAGES"]);
		$smarty->assign("pictures", $pictures);
	} 
	$smarty->assign("page", $page);
} else {
	$numlots1 = aj_get("SELECT DISTINCT COUNT(id) FROM main",30,0);
	$numlots = $numlots1[0]["TAG0"];
	if (!$numlots or $numlots == 0) {
		{$err = "search3: Error in remote database"; $smarty->assign("err", $err);}
	} else {

		$smarty->assign("numlots", $numlots);

		$marka11 = aj_get("SELECT DISTINCT marka_id,marka_name FROM main ORDER BY marka_id ASC",120,0);
		if ($marka11) {
			$marka1 = array();
			foreach ($marka11 as $value) if ($value["MARKA_NAME"] == latin_cip($value["MARKA_NAME"])) if ($value["MARKA_NAME"] <> null) $marka1[] = $value;
			foreach ($marka1 as $k=>$value) if($value["MARKA_NAME"] == "AMERICA TOYOT") $marka1[$k]["MARKA_NAME"] = "AMERICA TOYOTA";
			foreach ($marka1 as $k=>$value) if($value["MARKA_NAME"] == "MITSUBISHI FU") $marka1[$k]["MARKA_NAME"] = "MITSUBISHI FUSO";
			$marka2 = array(); 
			foreach ($marka1 as $k=>$value) if ($value["MARKA_NAME"] == "TOYOTA") {$marka2[] = $value; unset($marka1[$k]);}
			foreach ($marka1 as $k=>$value) if ($value["MARKA_NAME"] == "NISSAN") {$marka2[] = $value; unset($marka1[$k]);}
			foreach ($marka1 as $k=>$value) if ($value["MARKA_NAME"] == "MAZDA") {$marka2[] = $value; unset($marka1[$k]);}
			foreach ($marka1 as $k=>$value) if ($value["MARKA_NAME"] == "MITSUBISHI") {$marka2[] = $value; unset($marka1[$k]);}
			foreach ($marka1 as $k=>$value) if ($value["MARKA_NAME"] == "HONDA") {$marka2[] = $value; unset($marka1[$k]);}
			foreach ($marka1 as $k=>$value) if ($value["MARKA_NAME"] == "SUZUKI") {$marka2[] = $value; unset($marka1[$k]);}
			foreach ($marka1 as $k=>$value) if ($value["MARKA_NAME"] == "SUBARU") {$marka2[] = $value; unset($marka1[$k]);}
			foreach ($marka1 as $k=>$value) if ($value["MARKA_NAME"] == "ISUZU") {$marka2[] = $value; unset($marka1[$k]);}
			foreach ($marka1 as $k=>$value) if ($value["MARKA_NAME"] == "DAIHATSU") {$marka2[] = $value; unset($marka1[$k]);}
			foreach ($marka1 as $k=>$value) if ($value["MARKA_NAME"] == "MITSUOKA") {$marka2[] = $value; unset($marka1[$k]);}
			$marka_names = array(); foreach ($marka1 as $value) $marka_names[] = $value["MARKA_NAME"]; array_multisort($marka_names, SORT_ASC, $marka1);
			$marka = array(); $marka = array_merge($marka2, $marka1);
			foreach ($marka as $k=>$value) if (strstr($value["MARKA_NAME"], "OTHER")) {$marka_other = $value; unset($marka[$k]); $marka[] = $marka_other;}
			$smarty->assign("marka", $marka);
			if (!$marka_id) $marka_id = $marka[0]["MARKA_ID"];
			$smarty->assign("selmarka_id", $marka_id);
			foreach ($marka as $k=>$value) if ($value["MARKA_ID"] == $marka_id) $marka_name = $value["MARKA_NAME"];
			$smarty->assign("marka_name", $marka_name);
		}
		
		$model1 = aj_get("SELECT DISTINCT model_id,model_name FROM main WHERE marka_id = $marka_id ORDER BY model_name",60,0);
		if ($model1) {
			$model = array(); foreach ($model1 as $value) if ($value["MODEL_NAME"] == latin_cip($value["MODEL_NAME"])) if ($value["MODEL_NAME"] <> null) $model[] = $value;
			foreach ($model as $k=>$value) if (strstr($value["MODEL_NAME"], "OTHER")) {$model_other = $value; unset($model[$k]); $model[] = $model_other;}
			$smarty->assign("model", $model);
			if ($model_id) {
					$modelidarr = array(); foreach ($model as $value) $modelidarr[] = $value["MODEL_ID"];
					if (!in_array($model_id, $modelidarr)) $model_id = $model[0]["MODEL_ID"];
				} else $model_id = $model[0]["MODEL_ID"];
			$smarty->assign("selmodel_id", $model_id);
			foreach ($model as $k=>$value) if ($value["MODEL_ID"] == $model_id) $model_name = $value["MODEL_NAME"];
			$smarty->assign("model_name", $model_name);
		}
		
		$chas1 = aj_get("SELECT DISTINCT kuzov FROM main WHERE model_id = $model_id ORDER BY kuzov",30,0);
		if ($chas1) {
			$chas = array(); foreach ($chas1 as $value) if ($value["KUZOV"] == latin_cip($value["KUZOV"])) if ($value["KUZOV"] <> null) $chas[] = $value;
			array_unshift($chas, array("KUZOV"=>"Any"));
			$smarty->assign("chas", $chas);
			if ($kuzovarr) {
				$chaskod = array();
				foreach ($chas as $value) $chaskod[] = $value["KUZOV"];
				if (!in_array($kuzovarr[0], $chaskod)) $kuzovarr = array("Any");
			} else $kuzovarr = array("Any");
			$smarty->assign("selkuzovarr", $kuzovarr);
		}
		
		$aucs1 = aj_get("SELECT DISTINCT auction FROM main ORDER BY auction",30,0);
		if ($aucs1) {
			$aucs = array(); 
			foreach ($aucs1 as $value) {
				$val = $value["AUCTION"];
				$val=str_replace(array("\r","\n"),"",$val);
				if ($val == latin_cip($val)) if ($val <> null) $aucs[] = $val;
			}
			array_unshift($aucs, "Any");
			$smarty->assign("aucs", $aucs);
			if (!$aucarr) $aucarr = array("Any");
			$smarty->assign("aucarr", $aucarr);
		}

		$rates1 = aj_get("SELECT DISTINCT rate FROM main ORDER BY rate DESC",30,0);
		if ($rates1) {
			$rates2 = array(); 
			foreach ($rates1 as $value) {
				$val = $value["RATE"];
				$val=str_replace(array("\r","\n"),"",$val);
				if($val == latin2_cip($val)) if($val<>null) $rates2[] = $val;
			}
			$rates = array();
			foreach ($rates2 as $k=>$value) if (is_numeric(substr($value,0,1))) {$rates[] = $value; unset($rates2[$k]);}
			foreach ($rates2 as $value) $rates[] = $value;
			array_unshift($rates, "Any");
		$smarty->assign("rates", $rates);
		if (!$ratearr) $ratearr = array("Any");
		$smarty->assign("ratearr", $ratearr);
		}
		
		$years = aj_get("SELECT DISTINCT year FROM main ORDER BY year DESC",30,0);
		if ($years) {
				foreach ($years as $k=>$value) {
				$val = $value["YEAR"];
					$val=str_replace(array("\r","\n"),"",$val);
					$years[$k] = int_cip($val);
				}
				foreach ($years as $k=>$value) if ($value > date('Y') || $value < "1900") unset($years[$k]);
				array_unshift($years, "");
			$smarty->assign("years", $years);
			if (!$year1) $year1 = $years[0];
				$smarty->assign("selyear1", $year1);
			if (!$year2) $year2 = $years[0];
				$smarty->assign("selyear2", $year2);
		}
	}

	if ($ssearch || $stats) {
		if (!in_array("Any", $kuzovarr)) {
			$kuzstr = "(kuzov ='"; $kuzstr .= implode("' OR kuzov = '", $kuzovarr); $kuzstr .= "')";
			$modelid = "";
		} else {
			$kuzstr = "";
			$modelid = "model_id = '".$model_id."'";
		}
		if (!in_array("Any", $aucarr)) {
			$aucstr = " AND (auction ='"; $aucstr .= implode("' OR auction = '", $aucarr); $aucstr .= "')";
		} else $aucstr = "";
		if (!in_array("Any", $ratearr)) {
			$ratestr = " AND (rate ='"; $ratestr .= implode("' OR rate = '", $ratearr); $ratestr .= "')";
		} else $ratestr = "";
		if ($year1 && $year2) {
			if ($year1 == $year2) {
				$yearstr = " AND year = ".$year1;
			} else if ($year1 < $year2){
				$yearstr = " AND (year >= ".$year1." AND year <= ".$year2.")";
			} else $yearstr = " AND (year >= ".$year2." AND year <= ".$year1.")";
		} else if ($year1 && !$year2) {
			$yearstr = " AND year >= ".$year1;
		} else if (!$year1 && $year2) {
			$yearstr = " AND year <= ".$year2;
		} else $yearstr = "";
		if ($mil1 && $mil1 < 999) $mil1 = $mil1 * 1000; if ($mil2 && $mil2 < 999) $mil2 = $mil2 * 1000;	
		if ($mil1 && $mil2) {
			if ($mil1 == $mil2) {
				$milstr = " AND mileage = ".$mil1;
			} else if ($mil1 < $mil2){
				$milstr = " AND (mileage >= ".$mil1." AND mileage <= ".$mil2.")";
			} else $milstr = " AND (mileage >= ".$mil2." AND mileage <= ".$mil1.")";
		} else if ($mil1 && !$mil2) {
			$milstr = " AND mileage >= ".$mil1;
		} else if (!$mil1 && $mil2) {
			$milstr = " AND mileage <= ".$mil2;
		} else $milstr = "";
		if ($eng1 && $eng2) {
			if ($eng1 == $eng2) {
				$engstr = " AND eng_v = ".$eng1;
			} else if ($eng1 < $eng2){
				$engstr = " AND (eng_v >= ".$eng1." AND eng_v <= ".$eng2.")";
			} else $engstr = " AND (eng_v >= ".$eng2." AND eng_v <= ".$eng1.")";
		} else if ($eng1 && !$eng2) {
			$engstr = " AND eng_v >= ".$eng1;
		} else if (!$eng1 && $eng2) {
			$engstr = " AND eng_v <= ".$eng2;
		} else $engstr = "";
		if ($kpp) {
			if ($kpp == "aut") {
			$kppstr = " AND (kpp LIKE '%A%' OR kpp_type = 2)";
			} else $kppstr = " AND (kpp NOT LIKE '%A%' OR kpp_type = 1)";
		} else $kppstr = "";
		$totstr = $modelid.$kuzstr.$aucstr.$ratestr.$yearstr.$milstr.$engstr.$kppstr;
		if ($lotno) {
			$totstr = "lot = ".$lotno;
			$smarty->assign("lotno", $lotno);
		}
		if ($ssearch) $cmain_sql = "SELECT COUNT(DISTINCT id) FROM main WHERE ".$totstr;
		if ($stats) $cmain_sql = "SELECT COUNT(DISTINCT id) FROM stats WHERE ".$totstr;
		$foundlots = array();
		$foundlots = aj_get($cmain_sql);
		if ($foundlots) $smarty->assign("foundlots", $foundlots[0]["TAG0"]); else $smarty->assign("foundlots", 0);
		$strok = 10;
		$blok = 10; $smarty->assign("blok", $blok);
		$pages = ceil($foundlots[0]["TAG0"]/$strok);
		$bloks = ceil($pages / $blok);

		if ($page > $pages) $page = $pages; 
		$_SESSION['page'] = $page;
		$smarty->assign("page", $page);
		
		$blpage = floor(($page-1)/$blok);
		$next_page = ($blpage + 1) * $blok + 1; if ($next_page > $pages) $next_page = $pages; $smarty->assign("next_page", $next_page);
		$prev_page = ($blpage - 1) * $blok + 1; if ($prev_page < 1) $prev_page = 1; $smarty->assign("prev_page", $prev_page);

		$pagesarr = array();
		$l_pages = $pages-($bloks-1)*$blok;
		$fp = $blpage * $blok + 1;
		if ($pages < $blok) $pcount = $pages; else $pcount = $blok;
		if ($blpage > 0) {$pagesarr[] = 1; $pagesarr[] = "..";}
		for ($i = 1; $i <= $pcount; $i++) {
			$pagesarr[] = $fp;
			$fp++;
			if ($fp > $pages) break;
		}
		if ($blpage < $bloks-1) {$pagesarr[] = ".."; $pagesarr[] = $pages;}	
		if ($pages) $smarty->assign("pagesarr", $pagesarr);

		$p = ($page-1)*$strok;
		$totstr .= " LIMIT ".$p.",$strok";

		if ($ssearch) $main_sql = "SELECT * FROM main WHERE ".$totstr;
		if ($stats) $main_sql = "SELECT * FROM stats WHERE ".$totstr;
		$search_res = array();
		$search_res = aj_get($main_sql); 
		if ($search_res) foreach ($search_res as $k=>$value) $search_res[$k]["AUCTION_DATE"] = format_mysql_date2($value["AUCTION_DATE"], "kkk f y");
		$smarty->assign("search_res", $search_res);
	}
	
}

function format_mysql_date2($datetime, $style = "y.m.kkk h:i:s") {
        if (mb_strlen($datetime, "UTF-8") != 19) return $datetime;
        $ex = explode(" ", $datetime);
        $ex_date = explode("-", $ex[0]);
        $ex_time = explode(":", $ex[1]);
        if ((count($ex_date)==3) && (count($ex_time)==3)) {
                $text_month = "";
                switch ($ex_date[1]) {
                    case 1: $text_month = "Jan"; break;
                    case 2: $text_month = "Feb"; break;
                    case 3: $text_month = "Mar"; break;
                    case 4: $text_month = "Apr"; break;
                    case 5: $text_month = "May"; break;
                    case 6: $text_month = "Jun"; break;
                    case 7: $text_month = "Jul"; break;
                    case 8: $text_month = "Aug"; break;
                    case 9: $text_month = "Sep"; break;
                    case 10: $text_month = "Oct"; break;
                    case 11: $text_month = "Nov"; break;
                    case 12: $text_month = "Dec"; break;
                }
            $style = str_replace("y", $ex_date[0], $style);
            $style = str_replace("m", $ex_date[1], $style);
            $style = str_replace("kkk", $ex_date[2], $style);
            $style = str_replace("f", $text_month, $style);
            $style = str_replace("h", $ex_time[0], $style);
            $style = str_replace("i", $ex_time[1], $style);
            $style = str_replace("s", $ex_time[2], $style);
            return $style;
        }
    return $datetime;
}

function latin2_cip($data) {
        return trim(preg_replace('/[^\?\kkk@a-zA-Z0-9-_\.\,\*\s\(\) ]/i', '', $data));
}

function ascii_cip($data) {
        return trim(preg_replace('/[^(\x20-\x7F)]*/', '', $data));
}

?>
