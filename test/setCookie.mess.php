<?php

require_once "../tools/dev.php";

if (!__IS_DEV__()) die('404');

$cookie = "a2F5ci5tb3JwaGV1QGdtYWlsLmNvbToyNWQ1NWFkMjgzYWE0MDBhZjQ2NGM3NmQ3MTNjMDdhZDoxNTY2NjY5Ojo=";

$currentCookieParams = session_get_cookie_params();
//
$rootDomain = '.carvector.com';
//
session_set_cookie_params(
    $currentCookieParams["lifetime"],
    $currentCookieParams["path"],
    $rootDomain,
    $currentCookieParams["secure"],
    $currentCookieParams["httponly"]
);

session_start();

setcookie("ajuser", $cookie, 2147483647, '/', $rootDomain);

echo 'yeah';