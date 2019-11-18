<?php

$query = "SELECT u.id, u.name, SUM(b.summ) AS summ FROM cv_customers u, cv_balance b WHERE b.id_user = u.id GROUP BY u.id HAVING(SUM(b.summ) <> 0) ORDER BY summ";
$result = mysqli_query($pdo, $query) or die('ошибка выполнения запроса ' . mysql_error());
$count = 0;

$total_sum_result = mysqli_query(
		$pdo,
		"SELECT SUM(x.summ) as total_sum FROM (" . $query . ") as x"
);
$total_sum = mysqli_fetch_assoc($total_sum_result)['total_sum'];

while ($rows = mysqli_fetch_assoc($result)) {
	$count++;
	$rows["num"] = $count;
	$balanses[] = $rows;
}
$smarty->assign(["balances" => $balanses, "total_sum" => $total_sum]);

?>
