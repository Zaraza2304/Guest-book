<?php
//include "DB.php";

Class LoadComments {

    private $link;

    public function __construct($link)
    {

        $this->link = $link;
    }

    public function add_comment($data) {
        $sql = 'INSERT INTO Comments (user_id, page_id, user_name, e_mail, comment, home_page,
                ip, browser, created_at) VALUE ("'
            . $data['user_id'].'", "'
            . $data['page_id'] .'", "'
            . $data['user_name'] .'", "'
            . $data['e_mail'] .'", "'
            . $data['text'] .'", "'
            . $data['homepage'] .'", "'
            . $data['ip'] .'", "'
            . $data['browser'] .'", "'
            . $data['created'] . '")';

        $answer = mysqli_query($this->link, $sql);

        if (!$answer) {
            $error = "Error, LoadComments, add_comment: " .mysqli_error($this->link);
            return $error;
        } else {
            return true;
        }

        return $answer;
    }

    public function check_owner($name) {

        $sql = "SELECT id
                FROM Users
                WHERE login = '" . $name . "'";

        $answer = mysqli_query($this->link, $sql);
        $result = mysqli_fetch_array($answer, MYSQLI_ASSOC);

        if (!$result) {
            $sql = "SELECT id
                    FROM Users
                    WHERE login = 'guest_lg'";

            $answer = mysqli_query($this->link, $sql);
            $result = mysqli_fetch_array($answer, MYSQLI_ASSOC);
            return $result['id'];
        }


        return $result['id'];
    }

    public function unset_comment($id) {

        $sql = 'DELETE FROM Comments
                WHERE id = ' . $id;

        $answer = mysqli_query($this->link, $sql);

        if(!$answer) {
            return false;
        }

        return true;
    }

    public function get_comment($id) {
        $sql = 'SELECT id, user_id, user_name, e_mail, comment, home_page, created_at
        FROM Comments
        WHERE id = '.$id;


        $answer = mysqli_query($this->link, $sql);

        if (!$answer) {
            echo "Error fun get_data SELECT: " . mysqli_error($this->link) . "<br>";
            return false;
        } else {
            $result = array();
            while($row = mysqli_fetch_array($answer, MYSQLI_ASSOC))
            {
                $result[] = $row;
            }
        }

        return $result;
    }

    public function update_comment($data) {


        $sql = "UPDATE Comments
                SET comment = '" .$data['text']. "', home_page = '" .$data['home_page']. "', update_at = now()
                WHERE  id = " .$data['id'];

        $answer = mysqli_query($this->link, $sql);
        return $answer;
    }

    public function get_email($login = '') {

        $sql = "SELECT e_mail
                FROM Users
                WHERE login = '" . $login . "'";

        $answer = mysqli_query($this->link, $sql);
        $result = mysqli_fetch_array($answer);

        return $result['e_mail'];
    }
}