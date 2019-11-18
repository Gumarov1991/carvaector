<?php

define("DBName", "carvectornet_db");
define("HostName", "localhost");
define("UserName", "carvector_dba");
define("Password", "Rbid8rdSfgQrp");


if (!isset($no_connect_mysql)) {
	if (!$pdo = mysqli_connect(HostName, UserName, Password, DBName)) {
		echo "___Не могу сконнектиться с базой " . DBName . "!___<br>";
		exit;
	}
#        if(!mysqli_select_db(DBName))
#        { echo "___Не могу сделать активной базу ".DBName."!___<br>"; exit;}
	mysqli_query($pdo, "set names UTF8");
	mysqli_query($pdo, "SET SQL_BIG_SELECTS=1");
}