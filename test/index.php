<?php

require_once "../tools/dev.php";
if (!__IS_DEV__()) die();

__ECHO_FANCY_DEV__('$_SERVER[\'REMOTE_ADDR\']', $_SERVER['REMOTE_ADDR']);
__ECHO_FANCY_DEV__('TEST', __IS_DEV__() ? 'true' : 'false');
__ECHO_FANCY_DEV__('$_SERVER[\'HTTP_USER_AGENT\']', $_SERVER['HTTP_USER_AGENT']);
__ECHO_FANCY_DEV__('$_SERVER[\'HTTP_HOST\']', $_SERVER['HTTP_HOST']);
