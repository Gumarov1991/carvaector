<?php

function get_content($id, $name, $level, $id_sel) {
	global $pdo;
	$res = array();
	$i = 0;
	$bol = false;
	$result = mysqli_query($pdo, "SELECT * FROM cv_content WHERE content_id = '$id' ORDER BY position") or die('ошибка выполнения запроса ' . mysqli_error($pdo));
	while ($rows = mysqli_fetch_array($result)) {
		$r = get_content($rows["id"], $rows["name"], $level + 1, $id_sel);
		if ($rows["id"] == $id_sel || $r[2]) $bol = true;
		if ($r[2]) $rows['dis'] = 'yes';
		$rows["res"] = $r[0];
		$rows['last'] = '';
		if ($r[1] > 0) array_push($res, $rows);
		$i++;
	}
	if (count($res) > 0) $res[count($res) - 1]['last'] = 'yes';
	return array($res, $i, $bol);
}


if (isset($_GET['cked'])) {
	if ($_GET['cked'] == "true") $cked = 1; else if ($_GET['cked'] == "false") $cked = 0;
	if ($cked == 1 || $cked == 0) mysqli_query($pdo, "UPDATE cv_administrations SET cked = '$cked' WHERE id = '" . $_SESSION['login_id'] . "'") or die('ошибка выполнения запроса ' . mysqli_error($pdo));
}
$result = mysqli_query($pdo, "SELECT cked FROM cv_administrations WHERE id = '" . $_SESSION['login_id'] . "'") or die('ошибка выполнения запроса ' . mysqli_error($pdo));
$row = mysqli_fetch_array($result);
$smarty->assign("cked", $row["cked"]);

if (isset($_GET['id'])) $id = $_GET['id']; else $id = "";
if (isset($_GET['lang_id'])) $lang_id = $_GET['lang_id']; else $lang_id = 1;
if (isset($_POST['save'])) $save = $_POST['save']; else $save = "";
if (isset($_GET['edit'])) $edit = $_GET['edit']; else $edit = "";
if ($id == 4 && isset($_GET["del"]) && $_SESSION['login_admin'] == "admin") {
	$del = $_GET["del"];
	$result = mysqli_query($pdo, "SELECT * FROM cv_content WHERE content_id = '$del'") or die('ошибка выполнения запроса ' . mysqli_error($pdo));
	while ($rows = mysqli_fetch_array($result)) $del .= "," . $rows["id"];
	mysqli_query($pdo, "DELETE FROM cv_content_value WHERE content_id in ($del)") or die('ошибка выполнения запроса ' . mysqli_error($pdo));
	mysqli_query($pdo, "DELETE FROM cv_content WHERE id in ($del)") or die('ошибка выполнения запроса ' . mysqli_error($pdo));
	$result = mysqli_query($pdo, "SELECT * FROM cv_content WHERE content_id = '4'") or die('ошибка выполнения запроса ' . mysqli_error($pdo));
	$i = 1;
	while ($rows = mysqli_fetch_array($result)) {
		mysqli_query($pdo, "UPDATE cv_content SET name = 'Услуга $i', position = '" . ($i * 10) . "' WHERE id = '" . $rows["id"] . "'") or die('ошибка выполнения запроса ' . mysqli_error($pdo));
		mysqli_query($pdo, "UPDATE cv_content SET name = 'Содержание услуги $i' WHERE content_id = '" . $rows["id"] . "'") or die('ошибка выполнения запроса ' . mysqli_error($pdo));
		$i++;
	}
}
if ($id == 4 && isset($_GET["add"]) && $_SESSION['login_admin'] == "admin") {
	mysqli_query($pdo, "INSERT into cv_content (position,content_id,name,`type`) VALUES (1000,4,'111',0)") or die('ошибка выполнения запроса ' . mysqli_error($pdo));
	$result = mysqli_query($pdo, "SELECT max(id) FROM cv_content") or die('ошибка выполнения запроса ' . mysqli_error($pdo));
	$rows = mysqli_fetch_array($result);
	$i = $rows[0];
	mysqli_query($pdo, "INSERT into cv_content (position,content_id,name,`type`) VALUES (10,$i,'111',1)") or die('ошибка выполнения запроса ' . mysqli_error($pdo));
	$result = mysqli_query($pdo, "SELECT * FROM cv_content WHERE content_id = '4'") or die('ошибка выполнения запроса ' . mysqli_error($pdo));
	$i = 1;
	while ($rows = mysqli_fetch_array($result)) {
		mysqli_query($pdo, "UPDATE cv_content SET name = 'Услуга $i', position = '" . ($i * 10) . "' WHERE id = '" . $rows["id"] . "'") or die('ошибка выполнения запроса ' . mysqli_error($pdo));
		mysqli_query($pdo, "UPDATE cv_content SET name = 'Содержание услуги $i' WHERE content_id = '" . $rows["id"] . "'") or die('ошибка выполнения запроса ' . mysqli_error($pdo));
		$i++;
	}
}
$result = mysqli_query($pdo, "SELECT * FROM cv_language") or die('ошибка выполнения запроса ' . mysqli_error($pdo));
while ($rows = mysqli_fetch_array($result)) $smarty->append("languages", $rows);

if ($_SESSION['login_admin'] == "admin") {
	$res = get_content(0, '', 0, $id);
	$res[0][0]['last'] = '';
	$res[0][0]["res"][count($res[0][0]["res"]) - 1]["last"] = "";
	if ($id == "error") $res[0][0]["dis"] = "yes";
	array_push($res[0][0]["res"], array("id" => "error", "name" => "Страница ошибки", "level" => 1, "last" => "yes"));
} else $res = array(array());

if ($_SESSION['login_admin'] == "admin") array_push($res[0], array("id" => "href", "name" => "Полезные ссылки", "level" => 0, "last" => ""));
if ($grant[6]) array_push($res[0], array("id" => "response", "name" => "Отзывы", "level" => 0, "last" => ""));
if ($grant[4]) array_push($res[0], array("id" => "hot", "name" => "Горячие предложения", "level" => 0, "last" => ""));
if ($grant[7]) array_push($res[0], array("id" => "faq", "name" => "Вопрос-Ответ", "level" => 0, "last" => ""));
if ($grant[5]) array_push($res[0], array("id" => "dostavka", "name" => "Таблица доставки", "level" => 0, "last" => ""));

$res[0][count($res[0]) - 1]['last'] = 'yes';

$smarty->assign("contents", $res[0]);
$smarty->assign("lang_id", $lang_id);

if ($id == "ipload" && $_SESSION['login_admin'] == "admin") include "admin_ipload.php"; else
	if ($id == "files" && $_SESSION['login_admin'] == "admin") include "admin_files.php"; else
		if ($id == "href" && $_SESSION['login_admin'] == "admin") include "admin_href.php"; else
			if ($id == "error" && $_SESSION['login_admin'] == "admin") include "admin_error.php"; else
				if ($id == "dostavka" && $grant[5]) include "admin_dostavka.php"; else
					if ($id == "hot" && $grant[4]) include "admin_hot.php"; else
						if ($id == "faq" && $grant[7]) include "admin_faq.php"; else
							if ($id == "response" && $grant[6]) include "admin_response.php"; else
								if ($_SESSION['login_admin'] == "admin") {
									if ($id) {
										$result = mysqli_query($pdo, "SELECT name FROM cv_content WHERE id = '$id'") or die('ошибка выполнения запроса ' . mysqli_error($pdo));
										$row = mysqli_fetch_array($result);
										$smarty->assign("mname", $row["name"]);

										$sub_content1 = 0;
										$sub_content2 = 0;
										$err_str = "";

										$result = mysqli_query($pdo, "SELECT * FROM cv_content WHERE content_id = '$id' ORDER BY position") or die('ошибка выполнения запроса ' . mysqli_error($pdo));
										$temprows = [];

										while ($rows = mysqli_fetch_array($result)) {

											if ($rows['type']) $sub_content2++; else $sub_content1++;

											$result2 = mysqli_query($pdo, "SELECT * FROM cv_content_value WHERE content_id = '{$rows['id']}' and language_id = '$lang_id'") or die('ошибка выполнения запроса ' . mysqli_error($pdo));

											if ($rows2 = mysqli_fetch_array($result2)) {
												$rows["value"] = $rows2["value"];
												if ($save) {
													if ($rows["type"] == 2) {
														if (isset($_FILES['v' . $rows['id']]["name"])) $fn = $_FILES['v' . $rows['id']]["name"]; else $fn = "";
														if ($rows["value"] == $fn || ($fn && !file_exists("./pics/content/" . $fn))) {
															if (isset($rows["value"]) && !empty($rows["value"]) && file_exists("./pics/content/" . $rows["value"]))
																unlink("./pics/content/" . $rows["value"]);
															move_uploaded_file($_FILES['v' . $rows['id']]["tmp_name"], "./pics/content/" . $fn);
															$rows["value"] = $fn;
														} else if ($fn) $err_str .= "\\n" . "Файл с именем &#171;" . $fn . "&#187; уже существует";
													} else if (isset($_POST['v' . $rows['id']])) $rows["value"] = $_POST['v' . $rows['id']];
													mysqli_query($pdo, "UPDATE cv_content_value set value = '" . mysqli_real_escape_string($pdo, $rows['value']) . "' WHERE id = '{$rows2['id']}'") or die('ошибка выполнения запроса 105' . mysqli_error($pdo));
												}
												if ($rows["type"] == 2 && $rows["value"] && file_exists("./pics/content/" . $rows["value"])) {
													$rows["pic_xy"] = get_image_xy("./pics/content/" . $rows["value"]);
													$rows["pic_size"] = filesize("./pics/content/" . $rows["value"]);
												}
											} else if ($save) {
												if ($rows["type"] == 2) {
													if (isset($_FILES['v' . $rows['id']]["name"])) $fn = $_FILES['v' . $rows['id']]["name"]; else $fn = "";
													if ($fn) if (!file_exists("./pics/content/" . $fn)) {
														move_uploaded_file($_FILES['v' . $rows['id']]["tmp_name"], "./pics/content/" . $fn);
														$rows["value"] = $fn;
													} else $err_str .= "\\n" . "Файл с именем &#171;" . $fn . "&#187; уже существует";
													else $rows["value"] = "";
												} else $rows["value"] = $_POST['v' . $rows['id']];
//												if (__IS_DEV__()) var_dump($rows['value']);
												mysqli_query($pdo, "INSERT into cv_content_value (language_id, content_id, value) VALUES ('$lang_id', '{$rows['id']}', '{$rows['value']}')") or die('ошибка выполнения запроса ' . mysqli_error($pdo));
												if ($rows["type"] == 2 && $rows["value"] && file_exists("./pics/content/" . $rows["value"])) {
													$rows["pic_xy"] = get_image_xy("./pics/content/" . $rows["value"]);
													$rows["pic_size"] = filesize("./pics/content/" . $rows["value"]);
												}
											}
											if (!isset($rows["value"])) $rows["value"] = "";
											$rows["value"] = quote_cip($rows["value"]);
											$result2 = mysqli_query($pdo, "SELECT count(*) FROM cv_content WHERE content_id = '{$rows['id']}'") or die('ошибка выполнения запроса ' . mysqli_error($pdo));
											if ($rows2 = mysqli_fetch_array($result2)) $rows["sub_content"] = $rows2[0];
											$smarty->append("content_list", $rows);
											$temprows[] = $rows;
										}

										if ($save) if ($err_str) {
											$smarty->assign("onload", 'alert("' . $err_str . '");');
										} else {
											$smarty->assign("onload", 'alert("Успешно сохранено");');
										}
										$smarty->assign(array("sub_content1" => $sub_content1,
												"sub_content2" => $sub_content2,
												"id" => $id,
										));
									}
								}

?>
