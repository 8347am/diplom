<?php
	session_start();
	define("DB_SERVER", "localhost");
	define("DB_USER", "root");
	define("DB_PASS", "");
	define("DB_NAME", "chat");
	define("SITE_DIR", __DIR__);
	define("DEFAULT_PAGE", SITE_DIR . '\\page_templates\\login.php');
	define("SITE_URL", '//127.0.0.1/prototypelastvers/');
	require_once("load.php");
?>