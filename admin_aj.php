<?php

require_once("./scripts_admin/db_config.php");

if (isset($_GET['users'])) $part = "admin_users_aj";  else
if (isset($_GET['content_catalog'])) $part = "admin_content_catalog_aj"; else $part = "";

if ($part) require "scripts_admin/".$part.".php";

