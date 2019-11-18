<?php 
include "main.php";


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
		$users = new Users($model_users);

		$data = array();
		$data['login'] = $_POST['login'];
		$data['e_mail'] = $_POST['email'];
		$data['password'] = $_POST['password'];

		$answer = $users->registration($data);
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

<form action="" method="POST">
	<strong>Ваш логин</strong>
	<input type="text" name="login" value="<?php echo @$data['login']; ?>"><br/>

	<strong>Ваш Email</strong>
	<input type="email" name="email" value="<?php echo @$data['email']; ?>"><br/>

	<strong>Ваш пароль</strong>
	<input type="password" name="password" value="<?php echo @$data['password']; ?>"><br/>

	<strong>Повторите пароль</strong>
	<input type="password" name="password_2" value="<?php echo @$data['password_2']; ?>"><br/>

	<button type="submit" name="do_signup">Регистрация</button>
</form>