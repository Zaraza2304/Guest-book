<?php
Class Users {
	private $model;

	public function __construct($model) {
		$this->model = $model;
	}

	public function new_user($data) {

		$login =  htmlentities($data['login']);
		$email = htmlentities($data['e_mail']);
		$password = password_hash(htmlentities($data['password']), PASSWORD_BCRYPT);

		$answer = $this->model->check_l_e($login, $email);

		if(!$answer) {
			var_dump($answer);
			$status = 'Пользователь с таким логином/email уже существует';
			return $status;
		}

		$answer = $this->model->add_user($login, $password, $email);

		if(!$answer) {
			return 'В процессе регистрации что-то пошло не так. Попробуйте попозже.';
		}

		$this->start_session($login);
		return true;
	}

	public function authorization($data) {

		$login =  htmlentities($data['login']);
		$password = password_hash(htmlentities($data['password']), PASSWORD_BCRYPT);

		$answer = $this->model->check_user($login, $password);
		if(!$answer) {
			return false;
		}
		$this->start_session($login);

		return true;
	}

	public function start_session($login) {

		//header('Content-Type: text/html; charset=utf-8');
		session_start();
		$_SESSION['authoris'] = true;
		$_SESSION['lg'] = $login;
	}

	public function maybe() {
		if (isset($_SESSION["authoris"]) and !(is_null($_SESSION))) {
            return $_SESSION["authoris"];
        }
        else return false;
	}

	public function give_user() {
		if (isset($_SESSION['lg'])) {

			$data = $this->model->data_user($_SESSION['lg']);

			if(!$data) {
				return array('login' => 'Гость', 'e_mail' => '', 'id' => 2);
			}

			return $data;
		}


	}


}