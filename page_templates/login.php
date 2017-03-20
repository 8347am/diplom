
<?php
$message = null;
if($current_user){
	redirect('intropage');
}

if(isset($_POST["login"])){

	if(!empty($_POST['username']) && !empty($_POST['password'])) {
		$username=htmlspecialchars($_POST['username']);
		$password=md5(htmlspecialchars($_POST['password']));

		$founId = mysql_query("SELECT * FROM usertbl WHERE username='$username'");
		$id = mysql_fetch_assoc($founId);
		$result = mysql_query("SELECT * FROM usertbl WHERE id='{$id['id']}'");
		$myrow = mysql_fetch_assoc ($result);

		$query =mysql_query("SELECT * FROM usertbl WHERE username='".$username."' AND password='".$password."' LIMIT 1");
		$numrows=mysql_num_rows($query);
		if($numrows!=0){
			while($row=mysql_fetch_assoc($query)){
				$dbusername=$row['username'];
				$dbpassword=$row['password'];
			}
			if($username == $dbusername && $password == $dbpassword){
				$_SESSION['session_username'] = $username;
				$_SESSION['session_password'] = $password;
				 /* Перенаправление браузера */
				redirect("intropage");
			}
		} else {
			$message = "Invalid username or password!";
		}
	} else {
		$message = "All fields are required!";
	}
}


?>

<div class="container mlogin">
	<div id="login">
		<h1>Вход</h1>
		<form action="" id="loginform" method="post" name="loginform">
			<p><label for="user_login">Имя пользователя<br>
			<input class="input" id="username" name="username"size="20" type="text" value=""></label></p>
			<p><label for="user_pass">Пароль<br>
			<input class="input" id="password" name="password"size="20" type="password" value=""></label></p> 
			<p class="submit"><input class="button" name="login"type= "submit" value="Log In"></p>
			<p class="regtext">Еще не зарегистрированы?<a href="<?php echo get_page_url('register'); ?>">Регистрация</a>!</p>
		</form>
		<?php if ($message): ?>
		<p class="error"> <?php echo $message; ?>
		<?php endif; ?>
	</div>
</div>