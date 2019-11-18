<?php

if (isset($_GET['maker'])) $maker = $_GET['maker']; else $maker = "";
if (isset($_GET['model'])) $model = $_GET['model']; else $model = "";
if (isset($_GET['id'])) $id = $_GET['id']; else $id = "";
if ($id) {
	$result = mysqli_query($pdo, "SELECT * FROM cv_catalog_cars WHERE id = '$id'") or error();
	if ($rows = mysqli_fetch_array($result)) $smarty->assign("car", $rows);

	$result = mysqli_query($pdo, " SELECT pvv.value name, pv.value
                                FROM cv_catalog_car_params pv, cv_content pvc, cv_content_value pvv
                                WHERE pv.param_id = pvc.position AND pv.car_id = '$id'
                                AND pvv.content_id = pvc.id AND pvv.language_id = '$lang_id'
                                AND pvc.content_id = 4
                                ORDER BY pvc.position") or error();
	while ($rows = mysqli_fetch_array($result)) {
		$smarty->append("car_params", $rows);
	}
} else if ($model) {
	set_content(array(142, 85, 86, 52, 53, 64));
	$result = mysqli_query($pdo, "SELECT * FROM cv_catalog_params" .
			" WHERE name = 'Кузов'" .
			" OR name = 'Модификация'" .
			" OR name = 'Привод'" .
			" OR name = 'Модель двигателя'" .
			" OR name = 'Тип трансмиссии'" .
			" ORDER BY name") or error();
	$pq = "";
	while ($rows = mysqli_fetch_array($result))
		$pq .= "UNION SELECT value FROM cv_catalog_car_params" .
				" WHERE param_id = " . $rows['id'] . " AND car_id = [CAR] ";
	$pq = substr($pq, 6);
	$result = mysqli_query($pdo, "SELECT dates, min(pic) pic FROM cv_catalog_cars WHERE LCASE(marka)='$maker' AND LCASE(model)='$model' group by dates order by substr(dates,4,4),dates") or error();
	while ($rows = mysqli_fetch_array($result)) $mm[] = $rows[0] . $rows[1];
	$mm = array_unique($mm);
	foreach ($mm as $value) if (!empty($value)) $nn[] = $value;
	$nn = array_reverse($nn);
	for ($i = 0, $counter = sizeof($nn); $i < $counter; $i++) {
		$result = mysqli_query($pdo, "SELECT id FROM cv_catalog_cars WHERE LCASE(marka)='$maker' AND LCASE(model)='$model' AND dates='" . substr($nn[$i], 0, 7) . "' ") or error();
		$res = array();
		$res['date'] = substr($nn[$i], 0, 7);
		$res['pic'] = substr($nn[$i], 7);
		$res['res'] = array();
		while ($rows = mysqli_fetch_array($result)) {
			$r = array();
			$query = str_replace("[CAR]", $rows[0], $pq);
			$result2 = mysqli_query($pdo, $query) or error();
			while ($rows2 = mysqli_fetch_array($result2)) array_push($r, $rows2);
			$rr = array();
			foreach ($r as $k => $v) {
				if ($v[0]) $rr[$k][0] = $v[0]; else $rr[$k][0] = '---';
				if ($v['value']) $rr[$k]['value'] = $v['value']; else $rr[$k]['value'] = '---';
			}
			if (!isset($rr[0])) $rr[0] = array(0 => '---', 'value' => '---');
			if (!isset($rr[1])) $rr[1] = array(0 => '---', 'value' => '---');
			if (!isset($rr[2])) $rr[2] = array(0 => '---', 'value' => '---');
			if (!isset($rr[3])) $rr[3] = array(0 => '---', 'value' => '---');
			if (!isset($rr[4])) $rr[4] = array(0 => '---', 'value' => '---');
			$rows['res'] = array($rr[2], $rr[0], $rr[1], $rr[4], $rr[3]);
			array_push($res['res'], $rows);
		}
		usort($res['res'], "cmp");
		$smarty->append('modifs', $res);
	}
	$smarty->assign("model", $model);
	$smarty->assign("maker", $maker);
} else if ($maker) {
	$result = mysqli_query($pdo, "SELECT DISTINCT(model) FROM cv_catalog_cars WHERE LCASE(marka) = '$maker' ORDER BY model") or error();
	while ($rows = mysqli_fetch_array($result)) $mdls[] = $rows;
	$mcnt = sizeof($mdls);

	$n = 5;
	$ln = ceil($mcnt / $n);
	$tln = $ln;
	$st = $mcnt % $n;
	$cnt = 0;
	for ($j = 0; $j < $n; $j++) {
		for ($i = 0; $i < $tln; $i++) {
			$tempar[$j][$i] = $mdls[$cnt];
			$cnt++;
			if ($cnt >= $mcnt) break;
		}
		if ($cnt >= $mcnt) break;
		$st--;
		if ($st == 0) $tln--;
	}
	for ($i = 0; $i < $ln; $i++) {
		for ($j = 0; $j < $n; $j++) {
			if (isset($tempar[$j][$i])) {
				$models[] = $tempar[$j][$i];
			}
		}
	}
	$smarty->assign("models", $models);
	$smarty->assign("maker", $maker);
} else {
	set_content(array(418, 419, 420, 421, 422, 423, 424, 425, 426));
	$countries[] = array("country" => "Japan");
	$countries[] = array("country" => "USA");
	$countries[] = array("country" => "Germany");
	$countries[] = array("country" => "France");
	$countries[] = array("country" => "Italy");
	$countries[] = array("country" => "Great Britain");
	$countries[] = array("country" => "Korea");
	$countries[] = array("country" => "Sweden");
	$countries[] = array("country" => "Other");
	$smarty->assign("countries", $countries);

	$result = mysqli_query($pdo, "SELECT DISTINCT(marka),country FROM cv_catalog_cars WHERE 1=1 ORDER BY marka") or error();
	while ($rows = mysqli_fetch_assoc($result)) $rmarka[] = $rows;

	$n = 4;
	foreach ($countries as $vc) {
		$mcnt = 0;
		$selmarkas = array();
		foreach ($rmarka as $vm) {
			if ($vc['country'] == $vm['country']) {
				$selmarkas[] = $vm;
				$mcnt++;
			}
		}
		$ln = ceil($mcnt / $n);
		$tln = $ln;
		$st = $mcnt % $n;
		$cnt = 0;
		$tempar = array();
		for ($j = 0; $j < $n; $j++) {
			for ($i = 0; $i < $tln; $i++) {
				$tempar[$j][$i] = $selmarkas[$cnt];
				$cnt++;
				if ($cnt >= $mcnt) break;
			}
			if ($cnt >= $mcnt) break;
			$st--;
			if ($st == 0) $tln--;
		}
		for ($i = 0; $i < $ln; $i++) {
			for ($j = 0; $j < $n; $j++) {
				if (isset($tempar[$j][$i])) {
					$rmarka2[] = $tempar[$j][$i];
				}
			}
		}
	}
	$smarty->assign("markas", $rmarka2);
}

function cmp($a, $b) {
	if ($a['res'][0][0] < $b['res'][0][0]) return -1;
	elseif ($a['res'][0][0] > $b['res'][0][0]) return 1;
	elseif ($a['res'][0][0] == $b['res'][0][0] && $a['res'][1][0] < $b['res'][1][0]) return -1;
	elseif ($a['res'][0][0] == $b['res'][0][0] && $a['res'][1][0] > $b['res'][1][0]) return 1;
	else return 0;
}

?>
