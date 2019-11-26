<?php
include "../main.php";

 if(isset($_REQUEST['do_login']))
 {
    $errors = array();
	if ( trim($_POST['login']) == '' )
	{
		$errors[] = 'Введите логин';
	}

	if (  trim($_POST['password']) == '' )
	{
		$errors[] = 'Введите пароль';
	}


	if ( empty($errors) )
	{

		$data = array();
		$data['login'] = $_POST['login'];
		$data['password'] = $_POST['password'];

		$answer = $user_controller->authorization($data);
		if($answer === true) {
			$answer = 'Вы успешно авторизировались!';
		}
		//echo '<div style="color:dreen;">' .var_dump($_SESSION). '</div><hr>';
		echo '<div style="color:dreen;">' .$answer. '</div><hr>';

	} else {
		echo '<div id="errors" style="color:red;">' .array_shift($errors). '</div><hr>';
	}
}
?>
<!DOCTYPE html>
<html>
<head>
	<link rel="stylesheet" type="text/css" href="../public/css/reset.css">
	<link rel="stylesheet" type="text/css" href="../public/css/main.css">
	<title><?php echo $global_params['page']['title']; ?></title>
</head>
<body>
	<?php //var_dump($global_params); ?>
<div class="container">

	<div class="home_link">
		<a class="link" href="../">Главная</a>
	</div>

	<form action="" method="POST">
		<strong>Логин</strong>
		<input type="text" name="login"><br/>

		<strong>Пароль</strong>
		<input type="password" name="password"><br/>

		<button type="submit" name="do_login">Войти</button>
	</form>
</div>
</body>
</html>
