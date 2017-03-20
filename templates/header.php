<!DOCTYPE html>
<html lang="en" ng-app="chat" ng-controller="mainCtrl">
	<head>
		<meta charset="utf-8">
		<title> StudChat </title>
		<link href="css/style.css" media="screen" rel="stylesheet">
		<link href='http://fonts.googleapis.com/css?family=Open+Sans:300italic,400italic,600italic,700italic,800italic,400,300,600,700,800'rel='stylesheet' type='text/css'>
		<script src="js/angular.min.js"></script>
		<script src="js/main.js"></script>
	</head>
	
	<body>
	<div id="head">
		<div id="logo">ЛОГОТИП</div>
		<p id="exit"><a href="logout.php">Выйти</a></p>
		<p id="uname"><a href="<?php echo get_user_url($current_user['id']); ?>">Профиль <?php echo $current_user['name']; ?></a></p>
		<p id="ulist"><a href="<?php echo get_page_url('userlist'); ?>">Все пользователи</a></p>
	</div>