<?php

if (isset($_GET['id'])) $id = $_GET['id']; else $id = "";

if (isset($_GET['prid']) && !empty($_GET['prid']) && is_numeric($_GET['prid']) ) {
	$hotpr_id = $_GET['prid']; 
	$is_single_hotpr = true; 
} 
else {
	$hotpr_id = ""; 
	$is_single_hotpr = false; 
}

// $smarty->assign("id", $id);
$smarty->assign("issingle", $is_single_hotpr);

if (!$is_single_hotpr)
{
	$result = mysqli_query($pdo,"SELECT * FROM cv_hotpr WHERE language_id = '$lang_id' ORDER BY id DESC") or error();

	while ($rows = mysqli_fetch_array($result)) {
	        $fn = ext_to_pic("./files/hotpr/".$rows['id'].".");
	        if ($fn) $rows['photo'] = urlencode($fn); else $rows['photo'] = "";
	        $rows['dt'] = date("YmdHis");
	        $smarty->append("hotpr", $rows);
	}
}
else
{

	$result = mysqli_query($pdo,"SELECT * FROM cv_hotpr WHERE language_id = '$lang_id' AND id = '$hotpr_id'") or error();

	$hotpr_single = mysqli_fetch_assoc($result);

	$fn = ext_to_pic("./files/hotpr/".$hotpr_single['id'].".");
	if ($fn) $hotpr_single['photo'] = urlencode($fn); else $hotpr_single['photo'] = "";

	$smarty->assign("hotpr_data", $hotpr_single);

	
	
	// $hotpr_single['dt'] = date("YmdHis");
	
	// $smarty->append("hotpr", $rows);
}

set_content(array(13,317));



?>
