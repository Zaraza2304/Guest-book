<?php
Class LoadBd {

    private $host = '127.0.0.1';
    private $db_name = 'Guest_book';
    private $user_name = 'root';
    private $password_db = '';

    private $status_connect;
    public $status_db;


    public function __construct() {

        $this->check_db();
        $this->check_tabels();
    }

    private function check_db() {

        $answer = mysqli_connect(
            $this->host,
            $this->user_name,
            $this->password_db);

        if (!$answer) {
            /*

                echo "Ошибка: Невозможно установить соединение с MySQL." . PHP_EOL . "<br>";
                echo "Код ошибки errno: " . mysqli_connect_errno() . PHP_EOL . "<br>";
                echo "Текст ошибки error: " . mysqli_connect_error() . PHP_EOL . "<br>";
            */

            $this->status_connect = false;
            $this->status_db = false;

            return false;
        } else {

            $sql = 'CREATE DATABASE IF NOT EXISTS ' . $this->db_name;

            if(!mysqli_query($answer, $sql)) {
                //echo "Error create datbase! " . mysqli_error($this->status) . "<br>";
                //return false;
                $this->status_db = false;
                return false;

            } else {
                mysqli_select_db($answer, $this->db_name);
                $this->status_db = true;
            }
        }

        $this->status_connect = $answer;
    }

    private function check_tabels() {

        $sql_pages = 'CREATE TABLE IF NOT EXISTS Pages (
                        page_id int(11) AUTO_INCREMENT,
                        title varchar(500),
                        content text,
                        url text NOT NULL,
                        PRIMARY KEY (page_id)
                        )';
        $result = mysqli_query($this->status_connect, $sql_pages);

        if (!$result) {
            //echo "Error create table Pages!!! " . mysqli_error($this->status_connect) . "<br>";
            return false;
        }

        /*Access level:
        0 - admin (change and delete all comments)
        1 - user (change and delete their comments)
        2 - guest (don't change and delete comments)
        */

        $sql_users = 'CREATE TABLE IF NOT EXISTS Users (
                    id int(11) AUTO_INCREMENT,
                    login varchar(255) NOT NULL,
                    password TEXT NOT NULL,
                    e_mail TEXT NOT NULL,
                    access_level int NOT NULL DEFAULT 2,
                    PRIMARY KEY (id)
                    )';

        $result = mysqli_query($this->status_connect, $sql_users);
        if(!$result) {
            echo "Error create table Users!!! " . mysqli_error($this->status_connect) . "<br>";
            return false;
        }


        $sql_comments = 'CREATE TABLE IF NOT EXISTS Comments (
                        id int(11) AUTO_INCREMENT,
                        user_id int(11) NOT NULL,
                        page_id int(11) NOT NULL,
                        user_name varchar(255) NOT NULL,
                        e_mail varchar(255),
                        comment TEXT NOT NULL,
                        ip varchar(500) NOT NULL,
                        browser TEXT NOT NULL,
                        home_page TEXT,
                        created_at timestamp,
                        update_at timestamp,
                        PRIMARY KEY (id),
                        FOREIGN KEY (page_id) REFERENCES Pages(page_id) on delete cascade on update cascade,
                        FOREIGN KEY (user_id) REFERENCES Users(id) on delete cascade on update cascade
                        )';

        $result = mysqli_query($this->status_connect, $sql_comments);

        if(!$result) {
            //echo "Error create table Comments!!! " . mysqli_error($this->status_connect) . "<br>";
            return false;
        }

        $availability_admin = "SELECT id FROM Users WHERE login = 'Zaraza2304'";
        $answer_admin = mysqli_query($this->status_connect, $availability_admin);
        $result_admin = mysqli_fetch_array($answer_admin, MYSQLI_ASSOC);

        if ($result_admin == 0) {
            $this->add_defaul_data_users();
        }

        $home_page = "SELECT page_id FROM Pages WHERE title = 'Гостевая книга'";
        $answer_page = mysqli_query($this->status_connect, $home_page);
        $result_page = mysqli_fetch_array($answer_page, MYSQLI_ASSOC);

        if ($result_page == 0) {
            $this->add_defaul_data_pages();
        }

        mysqli_close($this->status_connect);
        return true;
    }

    private function add_defaul_data_users() {

        $admin = array(
                'login' => 'Zaraza2304',
                'passsword' => 1234,
                'e_mail' => 'Zaraza2304@yandex.ru',
                'access_level' => 0
            );

        $guest = array(
            'login' => 'guest_lg',
            'passsword' => 9876,
            'e_mail' => 'anonimys_lg@yandex.ru',
            'access_level' => 2
            );

        $sql_user = array(
                        "INSERT INTO Users(login, password, e_mail, access_level)
                            VALUES ('"
                            .$admin['login']. "', '"
                            .password_hash($admin['passsword'], PASSWORD_BCRYPT). "', '"
                            .$admin['e_mail']. "', '"
                            .$admin['access_level']. "');",
                        "INSERT INTO Users(login, password, e_mail, access_level)
                            VALUES ('"
                            .$guest['login']. "', '"
                            .password_hash($guest['passsword'], PASSWORD_BCRYPT). "', '"
                            .$guest['e_mail']. "', '"
                            .$guest['access_level']. "')"
                     );

        //mysqli_multi_query($this->status_connect, $sql_user);

        for ($i=0; $i < 2; $i++) {
            mysqli_query($this->status_connect, $sql_user[$i]);
        }

        //mysqli_multi_query($this->status_connect, $sql_user);
        /*$a = mysqli_error($this->status_connect);
        return $a;*/
    }

    private function add_defaul_data_pages() {

        $pages_array = array (
                        array(
                            'title' => 'Гостевая книга',
                            'content' => 'Добро пожаловать на сайт. Вы можете оставить любой коментарий.',
                            'url' => '/'),
                        array('title' => 'Регистрация', 'content' => '', 'url' => '/views/signup.php'),
                        array('title' => 'Авторизация', 'content' => '', 'url' => '/views/login.php'),
                        array('title' => 'Редактирование', 'content' => '', 'url' => '/views/edit.php'),
                    );


        $sql_page = array(
                    "INSERT INTO Pages (title, content, url)
                    VALUES ('" .$pages_array[0]['title']. "', '".$pages_array[0]['content']. "', '".$pages_array[0]['url']. "')",

                    "INSERT INTO Pages (title, content, url)
                    VALUES ('" .$pages_array[1]['title']. "', '".$pages_array[1]['content']. "', '".$pages_array[1]['url']. "')",

                    "INSERT INTO Pages (title, content, url)
                    VALUES ('" .$pages_array[2]['title']. "', '".$pages_array[2]['content']. "', '".$pages_array[2]['url']. "')"
                        ,
                    "INSERT INTO Pages (title, content, url)
                    VALUES ('" .$pages_array[3]['title']. "', '".$pages_array[3]['content']. "', '".$pages_array[3]['url']. "')"
                );

        for ($i=0; $i < 4; $i++) {
            mysqli_query($this->status_connect, $sql_page[$i]);
        }

        //mysqli_multi_query($this->status_connect, $sql_page);
        /*$a = mysqli_error($this->status_connect);
        return $a;*/
    }

    public function connect_db() {

        if(!$this->status_db) {
            return false;
        }

        $answer = mysqli_connect(
                $this->host,
                $this->user_name,
                $this->password_db,
                $this->db_name);

        $this->status_connect = $answer;

        if (!$answer) {
            /*
                echo "Ошибка: Невозможно установить соединение с MySQL." . PHP_EOL . "<br>";
                echo "Код ошибки errno: " . mysqli_connect_errno() . PHP_EOL . "<br>";
                echo "Текст ошибки error: " . mysqli_connect_error() . PHP_EOL . "<br>";
            */

            return false;
        }

        return $answer;
    }

    public function disconnect_db() {

        mysqli_close($this->status_connect);
    }


}