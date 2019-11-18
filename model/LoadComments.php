<?php
//include "DB.php";

Class LoadComments {

    private $link;

    public function __construct($link)
    {
        $this->link = $link;

    }
    /*
    public function get_comments($page_id = 1) {

        $sql = 'SELECT id, page_id, user_name, e_mail, text, created_at, home_page 
        FROM Comments, Users 
        WHERE page_id =' . $page_id . ' and Comments.user_id = Users.id';

        $answer = mysqli_query($this->link, $sql);

        //$result = array();

        if (!$answer) {
            echo "Error, LoadComments, get_comments: " .mysqli_error($this->link) . "<br>";
            return false;
        } else {
            return mysqli_fetch_array($answer, MYSQLI_ASSOC);
        }

    }*/

    public function add_comment($data) {
        $sql = 'INSERT INTO Comments (page_id, user_id, user_name, e_mail, text, home_page,
                browser, ip, created_at) VALUE ("'
            . $data['page_id'] .'", "'
            . $data['user_id'].'", "'
            . $data['user_name'] .'", "'
            . $data['e_mail'] .'", "'
            . $data['text'] .'", "'
            . $data['homepage'] .'", "'
            . $data['browser'] .'", "'
            . $data['ip'] .'", "'
            . $data['created'] . '")';

        $answer = mysqli_query($this->link, $sql);

        if (!$answer) {
            $error = "Error, LoadComments, add_comment: " .mysqli_error($this->link);
            return $error;
        } else {
            return true;
        }

    }

    public function check_owner($name) {

        $sql = "SELECT id
                FROM Users
                WHERE login = '" . $name . "'";

        $answer = mysqli_query($this->link, $sql);
        $result = mysqli_fetch_array($answer, MYSQLI_ASSOC);
        if(!$answer) {
            echo "Error cheking user!!! " . mysqli_error($this->link) . "<br>";
            return false;
        }
        return $result;

    }


}