<?php

$array_id_to_code = [
		1 => 'ru', 2 => 'en', 3 => 'jp', 4 => 'de',
];

function langCodeToId($langCode) {
	global $array_id_to_code;
	$lang_id = array_search($langCode, $array_id_to_code);
	if ($lang_id === false) {
		$lang_id = 2;
	}
	return $lang_id;
}