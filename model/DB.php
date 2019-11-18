<?php
//Добавить запросы на создание таблиц
Class LoadBd {

    private $host = '127.0.0.1';
    private $db_name = 'NewContact';
    private $user_name = 'root';
    private $password_db = '';
    public $status;

    public function connect_db() {

        $answer = mysqli_connect(
            $this->host,
            $this->user_name,
            $this->password_db);
        $this->status = $answer;
        if (!$answer) {
            echo "Ошибка: Невозможно установить соединение с MySQL." . PHP_EOL . "<br>";
            echo "Код ошибки errno: " . mysqli_connect_errno() . PHP_EOL . "<br>";
            echo "Текст ошибки error: " . mysqli_connect_error() . PHP_EOL . "<br>";

            return false;
        }

        //echo "Соединение с MySQL установлено!" . PHP_EOL . "<br>";
        //echo "Информация о сервере: " . mysqli_get_host_info($answer) . PHP_EOL . "<br>";
        if(!$this->check_db()) {
            echo "Error, tabels not found and not create!!!<br>";
            return false;
        }

        $answer = mysqli_connect(
            $this->host,
            $this->user_name,
            $this->password_db,
            $this->db_name);
        $this->status = $answer;
        if (!$answer) {
            echo "Ошибка: Невозможно установить соединение с MySQL." . PHP_EOL . "<br>";
            echo "Код ошибки errno: " . mysqli_connect_errno() . PHP_EOL . "<br>";
            echo "Текст ошибки error: " . mysqli_connect_error() . PHP_EOL . "<br>";

            return false;
        }

        if(!$this->check_tabels()) {
            return false;
        }
        return $answer;

    }

    public function disconnect_db() {

        mysqli_close($this->status);

    }

    private function check_db() {

        $db_selected = mysqli_select_db($this->status, $db_name);

        if (!$db_selected) {
            $sql = 'CREATE DATABASE IF NOT EXISTS NewContact';

            if(!mysqli_query($this->status, $sql)) {
                echo "Error create datbase! " . mysqli_error($this->status) . "<br>";
                return false;
            }
        }  

        $this->disconnect_db();
        return true;
    }

    private function check_tabels() {

        $sql_pages = 'CREATE TABLE IF NOT EXISTS Pages (
                        page_id int(11) AUTO_INCREMENT,
                        title varchar(500),
                        content text,
                        PRIMARY KEY (page_id)
                        )';
        $result = mysqli_query($this->status, $sql_pages);
        if (!$result) {
            echo "Error create table Pages!!! " . mysqli_error($this->status) . "<br>";
            return false;
        }

        /*Access level:
        0 - admin (change and delete all comments)
        1 - user (change and delete their comments)
        2 - anonymous (don't change and delete comments)
        */

        $sql_users = 'CREATE TABLE IF NOT EXISTS Users (
                    id int(11) AUTO_INCREMENT,
                    login varchar(255) NOT NULL,
                    password TEXT NOT NULL,
                    e_mail TEXT NOT NULL,
                    access_level int NOT NULL DEFAULT 2,
                    PRIMARY KEY (id)
                    )';

        $result = mysqli_query($this->status, $sql_users);
        if(!$result) {
            echo "Error create table Users!!! " . mysqli_error($this->status) . "<br>";
            return false;
        }


        $sql_comments = 'CREATE TABLE IF NOT EXISTS Comments (
                        id int(11) AUTO_INCREMENT,
                        user_id int(11) NOT NULL,
                        page_id int(11) NOT NULL,
                        user_name varchar(255) NOT NULL,
                        e_mail varchar(255),
                        text TEXT NOT NULL,
                        ip varchar(500) NOT NULL,
                        browser TEXT NOT NULL,
                        home_page TEXT,
                        created_at timestamp,
                        update_at timestamp,
                        PRIMARY KEY (id),
                        FOREIGN KEY (page_id) REFERENCES Pages(page_id) on delete cascade on update cascade,
                        FOREIGN KEY (user_id) REFERENCES Users(id) on delete cascade on update cascade
                        )';
        
        $result = mysqli_query($this->status, $sql_comments);
        if(!$result) {
            echo "Error create table Comments!!! " . mysqli_error($this->status) . "<br>";
            return false;
        }
        return true;
    }

}