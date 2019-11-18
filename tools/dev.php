<?php

/**
 * @return bool
 */
function __IS_DEV__() {
//	if ($_SERVER['REMOTE_ADDR'] === '5.250.138.34') return true;
	return false;
}

/**
 * @return bool
 */
function HAS_FEATURE_LIVE_CHAT() {
	return true;
}

/**
 * @return bool
 */
function HAS_FEATURE_CHB_TERM_AGREE() {
	return true;
}

/**
 * @return bool
 * @deprecated set to TRUE
 */
function HAS_FEATURE_AUC_REGISTER() {
	return true;
}

function HAS_FEATURE_LOGIN_ISSUES() {
	return true;
}

function __ECHO_FANCY_DEV__($logName, $s, $tag = 'h6') {
	$bracedTag = '<' . $tag . '>';
	$bracedCloseTag = '</' . $tag . '>';
	echo $bracedTag . '--- start of ' . $logName . ' ---' . $bracedCloseTag;
	echo $bracedTag;
	var_dump($s);
	echo $bracedCloseTag;
	echo $bracedTag . '--- end of ' . $logName . ' ---' . $bracedCloseTag;
}

function __MYSQLI_QUERY_DEV__($link, $query, $resultmode = MYSQLI_STORE_RESULT) {
	__ECHO_FANCY_DEV__('sql query', $query);
	return true;
}