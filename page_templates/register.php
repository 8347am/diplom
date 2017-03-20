
<?php
	
if(isset($_POST["register"])){
	
if(!empty($_POST['name']) && !empty($_POST['email']) && !empty($_POST['username']) && !empty($_POST['password'])) {
	$name= htmlspecialchars($_POST['name']);
	$subname= htmlspecialchars($_POST['subname']);
	$email=htmlspecialchars($_POST['email']);
	$username=htmlspecialchars($_POST['username']);
	$password=md5(htmlspecialchars($_POST['password']));
	$query=mysql_query("SELECT * FROM usertbl WHERE username='".$username."'");
	$numrows=mysql_num_rows($query);
	if($numrows==0){
		$sql="INSERT INTO usertbl(name, subname, email, username,password) VALUES('$name','$subname','$email', '$username', '$password')";
		$result=mysql_query($sql);
		if($result){
			$message = "Account Successfully Created";
			$_SESSION['session_username'] = $username;
			$_SESSION['session_password'] = $password;
			header("Location: index.php?page=intropage");
		} 
	} else 
		$message = "That username already exists! Please try another one!";
	}
}
?>

<?php if (!empty($message)) {echo "<p class=\"error\">" . "MESSAGE: ". $message . "</p>";} ?>

<div class="container mregister">
	<div id="login">
	<h1>Регистрация</h1>
	<form action="<?php echo get_page_url('register'); ?>" id="registerform" method="post" name="registerform">
		<p><label for="user_login">Имя<br>
		<input class="input" id="full_name" name="name"size="32"  type="text" value=""></label></p>
		
		<p><label for="user_login">Фамилия<br>
		<input class="input" id="full_name" name="subname"size="32"  type="text" value=""></label></p>
		
		<p><label for="user_pass">E-mail<br>
		<input class="input" id="email" name="email" size="32"type="email" value=""></label></p>
		
		<p><label for="user_pass">Имя пользователя<br>
		<input class="input" id="username" name="username"size="20" type="text" value=""></label></p>
		
		<p><label for="user_pass">Пароль<br>
		<input class="input" id="password" name="password"size="32"   type="password" value=""></label></p>
		
		<p class="submit"><input class="button" id="register" name= "register" type="submit" value="Зарегистрироваться"></p>
		<p class="regtext">Уже зарегистрированы? <a href= "login.php">Введите имя пользователя</a>!</p>
	 </form>
	</div>
</div>