<?php

set_content(array("225-240", 324, 325));

$res = 0;
$result = mysqli_query($pdo,"SELECT * FROM cv_dostavka WHERE language_id = '$lang_id'") or error();
while ($rows = mysqli_fetch_array($result)) {
        if (!$res) { $smarty->assign("d", $rows);$res = 1; }
        $smarty->append("dostavka", $rows);
}
$result = mysqli_query($pdo,"SELECT distinct exp FROM cv_dostavka WHERE language_id = '$lang_id' order by exp") or error();
while ($rows = mysqli_fetch_array($result)) $smarty->append("exp", $rows);
$result = mysqli_query($pdo,"SELECT distinct imp FROM cv_dostavka WHERE language_id = '$lang_id' order by imp") or error();
while ($rows = mysqli_fetch_array($result)) $smarty->append("imp", $rows);
$result = mysqli_query($pdo,"SELECT distinct dest FROM cv_dostavka WHERE language_id = '$lang_id' order by dest") or error();
while ($rows = mysqli_fetch_array($result)) $smarty->append("dest", $rows);


if (isset($_GET['back'])) $smarty->assign("back", "yes");

?>
