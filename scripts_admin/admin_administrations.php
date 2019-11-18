<?php

if (isset($_GET['logg'])) $logg = $_GET['logg']; else $logg = "";
if (isset($_GET['del'])) $del = $_GET['del']; else $del = "";
if (isset($_POST['save'])) $save = $_POST['save']; else $save = "";
if (isset($_GET['id'])) $id = $_GET['id']; else $id = "";

if ($id == "add") {
	mysqli_query($pdo, "INSERT INTO cv_administrations (login,email,type) VALUES ('new','new',2)") or die('ошибка выполнения запроса ' . mysqli_error($pdo));
	$result = mysqli_query($pdo, "SELECT max(id) FROM cv_administrations") or die('ошибка выполнения запроса ' . mysqli_error($pdo));
	$rows = mysqli_fetch_array($result);
	$id = $rows[0];
	$result = mysqli_query($pdo, "SELECT * FROM cv_administrations WHERE id = '$id'") or die('ошибка выполнения запроса ' . mysqli_error($pdo));
	$rows = mysqli_fetch_array($result);
	$smarty->assign(array("id" => $id,
			"r" => $rows,
	));
} else if ($id) {
	if ($save) {
		$result = mysqli_query($pdo, "SELECT count(*) FROM cv_administrations WHERE id <> '$id' and login = '" . latin_cip($_POST["log"]) . "'") or die('ошибка выполнения запроса ' . mysqli_error($pdo));
		$r1 = mysqli_fetch_array($result);
		$result = mysqli_query($pdo, "SELECT count(*) FROM cv_administrations WHERE id <> '$id' and email = '" . latin_cip($_POST["email"]) . "'") or die('ошибка выполнения запроса ' . mysqli_error($pdo));
		$r2 = mysqli_fetch_array($result);
		$r2[0] = "";
		if ($r1[0] || $r2[0]) {
			if ($r1[0] && $r2[0]) $smarty->assign("onload", 'alert("Такие LOG и E-mail уже используются");'); else
				if ($r1[0]) $smarty->assign("onload", 'alert("Такой LOG уже используются");'); else
					if ($r2[0]) $smarty->assign("onload", 'alert("Такой E-mail уже используются");');
		} else {
			mysqli_query($pdo, "UPDATE cv_administrations SET      login = '" . latin_cip($_POST["log"]) . "',
																	pass = '" . latin_cip($_POST["pass"]) . "',
																	name = '" . quote_cip($_POST["name"]) . "',
																	email = '" . latin_cip($_POST["email"]) . "',
																	note = '" . quote_cip($_POST["note"]) . "',
																	idocs = '" . int_cip($_POST["idocs"]) . "',
																	type = '" . int_cip($_POST["type"]) . "'
																	WHERE id = '" . int_cip($id) . "'") or die('ошибка выполнения запроса ' . mysqli_error($pdo));
			$smarty->assign("onload", 'alert("Успешно сохранено");');
			$smarty->assign(array("alert" => "Успешно сохранено", "url" => "./admin.php?admins"));
			$smarty->display("exec_command.tpl");
			exit;
		}
	}
	$result = mysqli_query($pdo, "SELECT * FROM cv_administrations WHERE id = '$id'") or die('ошибка выполнения запроса ' . mysqli_error($pdo));
	$rows = mysqli_fetch_array($result);
	$smarty->assign(array("id" => $id,
			"r" => $rows,
	));
} else {
	if ($save) {
		$result = mysqli_query($pdo, "SELECT * FROM cv_administrations") or die('ошибка выполнения запроса ' . mysqli_error($pdo));
		while ($rows = mysqli_fetch_array($result)) {
			$j = 1;
			$res = 0;
			for ($i = 1; $i <= 9; $i++) {
				if (isset($_POST["gr" . $i . "_" . $rows["id"]]) && !empty($_POST["gr" . $i . "_" . $rows["id"]])) $res += $j;
				$j *= 2;
			}
			if ($rows["id"] == 1) $res = 32767;
			mysqli_query($pdo, "UPDATE cv_administrations SET `grant` = '$res' WHERE id = '{$rows['id']}'") or die('ошибка выполнения запроса ' . mysqli_error($pdo));
		}
		$smarty->assign("onload", 'alert("Успешно сохранено");');
	}
	if ($del && $del > 1) {
		mysqli_query($pdo, "DELETE FROM cv_administrations WHERE id = '$del'") or die('ошибка выполнения запроса ' . mysqli_error($pdo));
		$result = mysqli_query($pdo, "SELECT max(id) FROM cv_administrations") or die('ошибка выполнения запроса ' . mysqli_error($pdo));
		$rows = mysqli_fetch_array($result);
		$m_id = $rows[0] + 1;
		mysqli_query($pdo, "ALTER TABLE cv_administrations AUTO_INCREMENT = $m_id");
	}
	if ($logg) {
		$result = mysqli_query($pdo, "SELECT * FROM cv_sadm_logips WHERE date > (CURDATE() - INTERVAL 30 DAY) ORDER BY date DESC") or die('ошибка выполнения запроса ' . mysqli_error($pdo));
		$logs = array();
		while ($rows = mysqli_fetch_array($result)) $logs[] = $rows;
		$smarty->assign("logg", $logg);
		$smarty->assign("logs", $logs);
	}

	$result = mysqli_query($pdo, "SELECT *, (UNIX_TIMESTAMP()-UNIX_TIMESTAMP(dateinput)) ddt FROM cv_administrations ORDER BY id") or die('ошибка выполнения запроса ' . mysqli_error($pdo));
	while ($rows = mysqli_fetch_array($result)) {
		$rows["grants"] = array();
		$j = $rows["grant"];
		for ($i = 1; $i <= 9; $i++) {
			array_push($rows["grants"], array("id" => $i, "ch" => fmod($j, 2)));
			$j = floor($j / 2);
		}
		$diff_seconds = $rows['ddt'];
		$diff_days = floor($diff_seconds / 86400);
		$diff_seconds -= $diff_days * 86400;
		$diff_hours = floor($diff_seconds / 3600);
		$diff_seconds -= $diff_hours * 3600;
		$diff_minutes = floor($diff_seconds / 60);
		$diff_seconds -= $diff_minutes * 60;
		$rows['ddays'] = $diff_days;
		$rows['dtime'] = str_pad($diff_hours, 2, '0', STR_PAD_LEFT) . ':' . str_pad($diff_minutes, 2, '0', STR_PAD_LEFT) . ':' . str_pad($diff_seconds, 2, '0', STR_PAD_LEFT);
		$smarty->append("admins", $rows);
	}
}