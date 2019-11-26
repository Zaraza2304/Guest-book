<?php
Class LoadUsers {
	private $link;
	private $default_access_user = 1;

	public function __construct($link) {
		$this->link = $link;
	}

	public function check_l_e($login, $email) {
		//$login = 'Zaraza2304';
		//$email = 'Zaraza2304@yandex.ru';

		$sql = "SELECT login, e_mail
				FROM Users
				WHERE login = '" .$login. "' and e_mail = '" .$email. "'";

		$answer = mysqli_query($this->link, $sql);
		$result = mysqli_fetch_array($answer, MYSQLI_ASSOC);

		if($result == false) {
			return true;
		} else {
			return false;
		}
	}

	public function add_user($login, $password, $email) {

		$sql = 'INSERT INTO Users(login, password, e_mail, access_level)
				VALUES ("' .$login. '", "' .$password. '", "' .$email. '", "' .$this->default_access_user. '")';
		$answer = mysqli_query($this->link, $sql);

		if (!$answer) {
			return false;
		}

		return true;
	}

	public function check_user($login, $password) {

		$sql = "SELECT login, password
				FROM Users
				WHERE login = '" .$login. "' and password = '" .$password. "'";


		$answer = mysqli_query($this->link, $sql);
		$result = mysqli_fetch_array($answer, MYSQLI_ASSOC);

		if($result == false) {
			return true;
		} else {
			return false;
		}
	}

	public function data_user($login) {

		$sql = "SELECT id, e_mail, login
				FROM Users
				WHERE login = '" .$login. "'";

		$answer = mysqli_query($this->link, $sql);
		$result = mysqli_fetch_array($answer, MYSQLI_ASSOC);

		if(!$result) {
			return false;
		}

		return $result;
	}
}