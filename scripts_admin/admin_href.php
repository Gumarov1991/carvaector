<?php

if (isset($_GET['del'])) $del = $_GET['del']; else $del = "";
if ($save) {
	$result = mysqli_query($pdo,"SELECT * FROM cv_hrefs WHERE language_id = '$lang_id'") or die('ошибка выполнения запроса '.mysqli_error($pdo));
	while ($rows = mysqli_fetch_array($result))
			mysqli_query($pdo,"UPDATE cv_hrefs SET name = '{$_POST['name'.$rows['id']]}',
											 href = '{$_POST['href'.$rows['id']]}'
											 WHERE id = '{$rows['id']}'") or die('ошибка выполнения запроса '.mysqli_error($pdo));
	$smarty->assign(array("alert"=>"Успешно сохранено","url"=>"./admin.php?content&lang_id=$lang_id&id=href"));
	$smarty->display("exec_command.tpl");
	exit;
}

if ($del) mysqli_query($pdo,"DELETE FROM cv_hrefs WHERE id = '$del'") or die('ошибка выполнения запроса '.mysqli_error($pdo));

if (isset($_GET['add'])) mysqli_query($pdo,"INSERT into cv_hrefs (language_id,name,href) VALUES ('$lang_id',' ',' ')") or die('ошибка выполнения запроса '.mysqli_error($pdo));

$result = mysqli_query($pdo,"SELECT * FROM cv_hrefs WHERE language_id = '$lang_id' order by id") or die('ошибка выполнения запроса '.mysqli_error($pdo));
while ($rows = mysqli_fetch_array($result)) $smarty->append("hrefs", $rows);

$smarty->assign("id", $id);

?>
