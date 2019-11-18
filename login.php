<?php 
include "main.php";
$users = new Users($model_users);

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
		$users = new Users($model_users);

		$data = array();
		$data['login'] = $_POST['login'];
		$data['password'] = $_POST['password'];

		$answer = $users->avtoriz($data);
		if($answer === true) {
			$answer = 'Вы успешно авторизировались!';
		}
		echo '<div style="color:dreen;">' .var_dump($_SESSION). '</div><hr>';
		echo '<div style="color:dreen;">' .$answer. '</div><hr>';

	} else {
		echo '<div id="errors" style="color:red;">' .array_shift($errors). '</div><hr>';
	}
}
?>

<div>
	<a href="index.php">Главная</a>
</div>
<form action="" method="POST">
	<strong>Логин</strong>
	<input type="text" name="login"><br/>

	<strong>Пароль</strong>
	<input type="password" name="password"><br/>

	<button type="submit" name="do_login">Войти</button>
</form>