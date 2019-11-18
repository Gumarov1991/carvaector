<?php
set_content(array("361-362"));

$blok = 10; $smarty->assign("blok", $blok);

$result = mysqli_query($pdo,"SELECT id FROM cv_responses WHERE language_id = '$lang_id' AND confirm = 1 ORDER BY date DESC") or error();
$ttab[] = 0;
while ($rows = mysqli_fetch_assoc($result)) $ttab[] = $rows["id"];
end($ttab);
$cnum = key($ttab);

$bloks = ceil($cnum / $blok);

if (isset($_GET['fid'])) {$fid = $_GET['fid'];} else {$fid = $ttab[1]; $fpage = 1;}

$fpage = array_search($fid,$ttab);
if ($fpage===FALSE) {$fpage = 1; $fid = $ttab[1];}
$blfpage = floor(($fpage-1)/$blok);
$smarty->assign("fpage", $fpage);

$next_fpage = ($blfpage + 1) * $blok + 1;
if ($next_fpage > $cnum) $next_fpage = $cnum;
$next_id = $ttab[$next_fpage];
$smarty->assign("next_id", $next_id);

$prev_fpage = ($blfpage - 1) * $blok + 1;
if ($prev_fpage < 1) $prev_fpage = 1;
$prev_id = $ttab[$prev_fpage];
$smarty->assign("prev_id", $prev_id);

$fpagesarr = array();
$fp = $blfpage * $blok + 1;

if ($cnum < $blok) $pcount = $cnum; else $pcount = $blok;

if ($blfpage > 0) {
	$fpagesarr[0] = array("p" => "01", "id" => $ttab[1]);
	$fpagesarr[1] = array("p" => "02", "id" => $ttab[2]);
	$fpagesarr[2] = array("p" => "03", "id" => $ttab[3]); 
	$fpagesarr[3] = array("p" => "...");
}
$count = 0;
for ($i = 1; $i <= $pcount; $i++) {
	$count++;
	if ($fp > $cnum-3) break;
	if (strlen($fp) < 2) $strfp = '0'.$fp; else $strfp = $fp;
	$fpagesarr[] = array("p" => $strfp, "id" => $ttab[$fp]);
	$fp++; 
	if ($fp > $cnum-3) break;
}
if ($blfpage < $bloks) {
	if ($count >= $blok) $fpagesarr[] = array("p" => "..."); 
	$fpagesarr[] = array("p" => $cnum-2, "id" => $ttab[$cnum-2]);
	$fpagesarr[] = array("p" => $cnum-1, "id" => $ttab[$cnum-1]);
	$fpagesarr[] = array("p" => $cnum, "id" => $ttab[$cnum]);
}
$smarty->assign("fpagesarr", $fpagesarr);

$result = mysqli_query($pdo,"SELECT * FROM cv_responses WHERE id = '$fid'") or error();
$row = mysqli_fetch_array($result);
$data = str_replace("&#62;", ">", $row["message"]);
$data = str_replace("&#60;", "<", $data);
$data = str_replace("&#39;", "'", $data);
$data = str_replace('&#34;', '"', $data);
$data = str_replace("&#92;", "\\\\", $data);
$data = str_replace("&#39;", "\\'", $data);
$data = str_replace('&#34;', '\\"', $data);
$response = str_replace("&#38;", "&", $data);
$smarty->assign("response", $response);
?>
