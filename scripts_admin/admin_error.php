<?php

$smarty->assign("id", $id);
$fn = "./templates/error_".$lang_id.".tpl";
if ($save) {
        if (file_exists($fn)) unlink($fn);
        $f = fopen($fn, "w");fwrite($f,$_POST["error"]);fclose($f);
        $smarty->assign("onload",'alert("Успешно сохранено");');
}
if (file_exists($fn)) $f = implode("", file($fn)); else $f = "";
$smarty->assign("error", quote_cip($f));

?>
