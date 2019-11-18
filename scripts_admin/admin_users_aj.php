<?php

$sn = $_SERVER["SCRIPT_NAME"];
$sn = substr($sn,strrpos($sn,"/")+1);
if ($sn != "admin_aj.php")  exit;
if (isset($_POST['bal'])) $bal = $_POST['bal']; else $bal = "";
if (isset($_POST['act'])) $act = $_POST['act']; else $act = "";
if (isset($_POST['totalid'])) $totalid = int_cip($_POST['totalid']); else $totalid = "";
if (isset($_POST['totalid2'])) $totalid2 = int_cip($_POST['totalid2']); else $totalid2 = "";
if (isset($_POST['col'])) $col = $_POST['col']; else $col = "";
if (isset($_POST['dat'])) $dat = $_POST['dat']; else $dat = "";

if ($act == "edit" && $totalid && $col) {
	if ($col == "date") {
		mysqli_query($pdo,"UPDATE cv_balance set ts = '$dat' WHERE total = '$totalid'") or die('ошибка выполнения запроса '.mysqli_error($pdo));
		$result = mysqli_query($pdo,"SELECT ts FROM cv_balance WHERE total = '$totalid'") or die('ошибка выполнения запроса '.mysqli_error($pdo));
		$res = mysqli_fetch_array($result);
		echo json_encode($res);		
	} else if ($col == "oper") {
		mysqli_query($pdo,"UPDATE cv_balance set operation = '".mysqli_real_escape_string($pdo,$dat)."' WHERE total = '$totalid'") or die('ошибка выполнения запроса '.mysqli_error($pdo));
		$result = mysqli_query($pdo,"SELECT operation FROM cv_balance WHERE total = '$totalid'") or die('ошибка выполнения запроса '.mysqli_error($pdo));
		$res = mysqli_fetch_array($result);
		echo json_encode($res);		
	} else if ($col == "summ" && $bal) {
		mysqli_query($pdo,"UPDATE cv_balance set summ = '$dat' WHERE total = '$totalid'") or die('ошибка выполнения запроса '.mysqli_error($pdo));
		$result = mysqli_query($pdo,"SELECT summ FROM cv_balance WHERE total = '$totalid'") or die('ошибка выполнения запроса '.mysqli_error($pdo));
		$res = mysqli_fetch_array($result);
        $result = mysqli_query($pdo,"SELECT * FROM cv_balance WHERE id_user = '$bal'") or die('ошибка выполнения запроса '.mysqli_error($pdo));
        $summ=0;
		while ($rows = mysqli_fetch_array($result)) { 
			$summ+=$rows["summ"];
			$res["total"]=$summ;
		}
		echo json_encode($res);		
	}
} else if ($act == "add" && $bal) {
	mysqli_query($pdo,"INSERT into cv_balance (id_user, operation, summ) VALUES ('$bal', '', '0')") or die('ошибка выполнения запроса '.mysqli_error($pdo));
	$result = mysqli_query($pdo,"SELECT max(total) FROM cv_balance") or die('ошибка выполнения запроса '.mysqli_error($pdo));
	$row = mysqli_fetch_array($result); 
	$id = $row[0];
	$result = mysqli_query($pdo,"SELECT *, ts+0 AS ts2 FROM cv_balance WHERE total = '$id'") or die('ошибка выполнения запроса '.mysqli_error($pdo));
	$res = mysqli_fetch_array($result);
	$dtime = $res['ts2']*1;
	mysqli_query($pdo,"UPDATE cv_balance set sort_id = '$dtime' WHERE total = '$id'") or die('ошибка выполнения запроса '.mysqli_error($pdo));	// дублируем ключ
	echo json_encode($res);			
} else if ($act == "del" && $totalid && $bal) {
	mysqli_query($pdo,"DELETE FROM cv_balance WHERE total = '$totalid'") or die('ошибка выполнения запроса '.mysqli_error($pdo));
	$result = mysqli_query($pdo,"SELECT * FROM cv_balance WHERE id_user = '$bal'") or die('ошибка выполнения запроса '.mysqli_error($pdo));
	$summ=0; $res = array("total" => "empty");
	while ($rows = mysqli_fetch_array($result)) { 
		$summ+=$rows["summ"];
		$res["total"]=$summ;
	}
	echo json_encode($res);	
} else if ($act == "mov" && $totalid && $totalid2) {
	$result = mysqli_query($pdo,"SELECT sort_id FROM cv_balance WHERE total = '$totalid'") or die('ошибка выполнения запроса '.mysqli_error($pdo));
	$row = mysqli_fetch_array($result); $sort_id = $row[0];
	$result = mysqli_query($pdo,"SELECT sort_id FROM cv_balance WHERE total = '$totalid2'") or die('ошибка выполнения запроса '.mysqli_error($pdo));
	$row = mysqli_fetch_array($result); $sort_id2 = $row[0];
	mysqli_query($pdo,"UPDATE cv_balance set sort_id = '$sort_id2' WHERE total = '$totalid'") or die('ошибка выполнения запроса '.mysqli_error($pdo));	
	mysqli_query($pdo,"UPDATE cv_balance set sort_id = '$sort_id' WHERE total = '$totalid2'") or die('ошибка выполнения запроса '.mysqli_error($pdo));	
	$res = 'ok';
	echo json_encode($res);		
}