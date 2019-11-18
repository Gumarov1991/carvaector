<?php

set_content(array(301, 302, 303, 265, 382, 402));

$result = mysqli_query($pdo,"SELECT date_format(b.ts,'%d %b %Y') dt, b.*FROM cv_balance b WHERE b.id_user = '{$_SESSION['login_user_id']}' ORDER by b.ts") or error();
$summ = 0;
while ($rows = mysqli_fetch_array($result)) {
        $summ += (float)$rows['summ'];
        $rows["summ2"] = $summ;
        $smarty->append("bals", $rows);
}
$smarty->assign("summ", $summ);

?>
