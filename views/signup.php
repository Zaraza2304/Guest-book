<?php
include "../main.php";

 if(isset($_POST['do_signup']))
 {
    $errors = array();
	if ( trim($_POST['login']) == '' )
	{
		$errors[] = 'Введите логин';
	}

	if (  trim($_POST['email']) == '' )
	{
		$errors[] = 'Введите Email';
	}

	if ( $_POST['password'] == '' )
	{
		$errors[] = 'Введите пароль';
	}

	if ( $data['password_2'] != $data['password'] )
	{
		$errors[] = 'Повторный пароль введен не верно!';
	}

	if ( empty($errors) )
	{

		$data = array();
		$data['login'] = $_POST['login'];
		$data['e_mail'] = $_POST['email'];
		$data['password'] = $_POST['password'];

		$answer = $user_controller->new_user($data);
		if($answer === true) {
			$answer = 'Вы успешно зарегистрировались!';
		}
		//echo '<div style="color:dreen;">' .var_dump($_SESSINON). '</div><hr>';
		echo '<div style="color:dreen;">' .$answer. '</div><hr>';

	} else {
		echo '<div id="errors" style="color:red;">' .array_shift($errors). '</div><hr>';
	}

}
?>
<!DOCTYPE html>
<html>
<head>
	<link rel="stylesheet" href="../public/css/reset.css">
	<link rel="stylesheet" href="../public/css/main.css">
	<title><?php echo $global_params['page']['title']; ?></title>
</head>
<body>
	<?php //var_dump($global_params['page']); ?>
	<?php //var_dump($_SESSINON); ?>
	<div class="container">
		<div class="link_home">
			<a class="link" href="/">Главная</a>
		</div>
		<form action="" method="POST">

			<label for="login">Логин</label>
			<input type="text" name="login" value="<?php echo @$data['login']; ?>">

			<label for="email">Ваш Email</label>
			<input type="email" name="email" value="<?php echo @$data['email']; ?>">

			<label for="password">Ваш пароль</label>
			<input type="password" name="password" value="<?php echo @$data['password']; ?>">

			<label for="password_2">Повторите пароль</label>
			<input type="password" name="password_2" value="<?php echo @$data['password_2']; ?>">

		  	<button class="submit_save" type="submit" name="do_signup">Регистрация</button>
		</form>
</div>
</body>
</html>
