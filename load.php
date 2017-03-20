<?php
global $con;
$con = mysql_connect(DB_SERVER, DB_USER, DB_PASS) or die(mysql_error());
mysql_select_db(DB_NAME) or die("Cannot select DB");

global $current_user;
if (isset($_SESSION['session_username']) && isset($_SESSION['session_password'])){
	$user_login = $_SESSION['session_username'];
	$user_password = $_SESSION['session_password'];
	$userdata = mysql_query("SELECT * FROM usertbl WHERE username='$user_login' AND password='$user_password' LIMIT 1");
	$current_user = mysql_fetch_assoc($userdata);
} else {
	$current_user = null;
}
require_once("functions.php");
?>