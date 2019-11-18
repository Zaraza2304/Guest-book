<?php
//include "DB.php";

Class LoadPage {
    private $link;
    private $user_admin = array(
                            'login' => 'Zaraza2304',
                            'password' => 12345,
                            'e_mail' => 'Zaraza2304@yandex.ru',
                            'access_level' => 0);
    private $user_anonymus = array(
                            'login' => 'anonymous_l',
                            'password' => 9876,
                            'e_mail' => 'Anonymous@yandex.ru',
                            'access_level' => 2);

    private $home_page_param = array('title' => 'Гостевая книга',
                                    'content' => 'Вы можете оставить любой комментарий');


    public function __construct($link)
    {
        $this->link = $link;
        $this->set_default_data();
    }

    private function set_default_data() {
        $availability_admin = "SELECT id FROM Users WHERE login = '" . $this->user_admin['login'] . "'";
        $answer = mysqli_query($this->link, $availability_admin);
        $result = mysqli_fetch_array($answer, MYSQLI_ASSOC);
        
        if ($result == 0) {

            $pass_admin = password_hash($this->user_admin['passwrod'], PASSWORD_BCRYPT);

            $sql_admin = 'INSERT INTO Users(login, password, e_mail, access_level) 
                    VALUES ("'
                            . $this->user_admin['login'] . '", "' 
                            . $pass_admin . '", "' 
                            . $this->user_admin['e_mail'] .'", "' 
                            . $this->user_admin['access_level'] .'")';

            $answer = mysqli_query($this->link, $sql_admin);
        }


        $availability_anonymus = "SELECT id FROM Users WHERE login = '" . $this->user_anonymus['login'] . "'";
        $answer = mysqli_query($this->link, $availability_anonymus);
        $result = mysqli_fetch_array($answer, MYSQLI_ASSOC);

        if ($result == 0) {

            $pass_anonymus = password_hash($this->user_anonymus['password'], PASSWORD_BCRYPT);

            $sql_anonymus = 'INSERT INTO Users(login, password, e_mail, access_level) 
                    VALUES ("'
                            . $this->user_anonymus['login'] . '", "' 
                            . $pass_anonymus . '", "' 
                            . $this->user_anonymus['e_mail'] .'", "' 
                            . $this->user_anonymus['access_level'] .'")';

            $answer = mysqli_query($this->link, $sql_anonymus);
        }


        $home_page = "SELECT page_id FROM Pages WHERE title = '" . $this->home_page_param['title'] . "'";
        $answer = mysqli_query($this->link, $home_page);
        $result = mysqli_fetch_array($answer, MYSQLI_ASSOC);

        if ($result == 0) {

            $sql_home_page = 'INSERT INTO Pages(title, content) 
                         VALUES("'. $this->home_page_param['title'] . '", "'. $this->home_page_param['content'] .'")';
            $answer = mysqli_query($this->link, $sql_home_page);
        }
    }

    public function get_data($page_id) {

        $sql = 'SELECT page_id, title, content FROM Pages WHERE page_id =' . $page_id;
        $answer = mysqli_query($this->link, $sql);

        if (!$answer) {
            echo "Error fun get_data SELECT: " . mysqli_error($this->link) . "<br>";
            return false;
        } else {
            $result = mysqli_fetch_array($answer, MYSQLI_ASSOC);
        }

        return $result;
    }

    public function get_comments($page_id, $session) {

        $sql = 'SELECT user_name, e_mail, text, home_page, created_at, home_page 
                FROM Comments 
                WHERE page_id = '.$page_id;


        $answer = mysqli_query($this->link, $sql);

        if (!$answer) {
            echo "Error fun get_data SELECT: " . mysqli_error($this->link) . "<br>";
            return false;
        } else {
            $result = array();
            while($row = mysqli_fetch_array($answer,MYSQLI_ASSOC))
            {
                $result[] = $row;
            }
        }


        return $result;
    }

}