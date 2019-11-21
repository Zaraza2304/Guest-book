<?php
Class LoadBd {

    private $host = '127.0.0.1';
    private $db_name = 'Guest_book';
    private $user_name = 'root';
    private $password_db = '';

    private $status_db;
    public $status_con;


    public function __construct() {

        $this->check_db();
        $this->check_tabels();
    }

    private function check_db() {

        $answer = mysqli_connect(
            $this->host,
            $this->user_name,
            $this->password_db,
            $this->db_name);

        if (!$answer) {
            /*echo "Ошибка: Невозможно установить соединение с MySQL." . PHP_EOL . "<br>";
            echo "Код ошибки errno: " . mysqli_connect_errno() . PHP_EOL . "<br>";
            echo "Текст ошибки error: " . mysqli_connect_error() . PHP_EOL . "<br>";

            return false;*/

            $sql = 'CREATE DATABASE IF NOT EXISTS NewContact';

            if(!mysqli_query($this->status, $sql)) {
                //echo "Error create datbase! " . mysqli_error($this->status) . "<br>";
                //return false;
                $this->status_db = false;
            } else {
                $this->status_db = true;
            }
        } else {

            $this->status_db = true;
            $this->status_con = $answer;
        }

        mysqli_close($this->status_con);
        mysqli_close();
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
            //echo "Error create table Pages!!! " . mysqli_error($this->status) . "<br>";
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

        $result = mysqli_query($this->status, $sql_comments);

        if(!$result) {
            //echo "Error create table Comments!!! " . mysqli_error($this->status) . "<br>";
            return false;
        }
        return true;
    }

    public function connect_db() {

        /*$answer = mysqli_connect(
            $this->host,
            $this->user_name,
            $this->password_db);
        $this->status = $answer;
        if (!$answer) {
            echo "Ошибка: Невозможно установить соединение с MySQL." . PHP_EOL . "<br>";
            echo "Код ошибки errno: " . mysqli_connect_errno() . PHP_EOL . "<br>";
            echo "Текст ошибки error: " . mysqli_connect_error() . PHP_EOL . "<br>";

            return false;
        }*/


        if(!$this->check_db()) {
            echo "Error, tabels not found and not create!!!<br>";
            return false;
        }

        $answer = mysqli_connect(
            $this->host,
            $this->user_name,
            $this->password_db,
            $this->db_name);
        $this->status_con = $answer;
        if (!$answer) {
            echo "Ошибка: Невозможно установить соединение с MySQL." . PHP_EOL . "<br>";
            echo "Код ошибки errno: " . mysqli_connect_errno() . PHP_EOL . "<br>";
            echo "Текст ошибки error: " . mysqli_connect_error() . PHP_EOL . "<br>";

            return false;
        }

        return $answer;
    }

    public function disconnect_db() {

        mysqli_close($this->status);
    }


}