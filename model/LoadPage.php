<?php
//include "DB.php";

Class LoadPage {
    private $link;


    public function __construct($link)
    {

        $this->link = $link;
    }

    public function get_page_id($url = '/') {

        $sql = "SELECT page_id
                FROM Pages
                WHERE url = '" . $url . "'";

        $answer = mysqli_query($this->link, $sql);
        $result = mysqli_fetch_array($answer, MYSQLI_ASSOC);

        if (!$result) {
            return false;
        }

        return $result['page_id'];
    }

    public function get_data($page_id) {
        $sql = 'SELECT page_id, title, content
                FROM Pages
                WHERE page_id =' .$page_id;


        $answer = mysqli_query($this->link, $sql);

        if (!$answer) {
            echo "Error fun get_data SELECT: " . mysqli_error($this->link) . "<br>";
            return false;
        } else {
            $result = mysqli_fetch_array($answer, MYSQLI_ASSOC);
        }

        return $result;
    }

    public function get_comments($user_id, $access, $page_id, $param) {

        $sql = 'SELECT id, user_id, user_name, e_mail, comment, home_page, created_at
                FROM Comments
                WHERE page_id = '.$page_id. '
                LIMIT ' .$param[0]. ', ' .$param[1];

        /*$sql = 'SELECT id, user_id, user_name, e_mail, comment, home_page, created_at
                FROM Comments
                WHERE page_id = '.$page_id;*/


        $answer = mysqli_query($this->link, $sql);

        if (!$answer) {
            //echo "Error fun get_data SELECT: " . mysqli_error($this->link) . "<br>";
            return false;
        } else {
            $result = array();
            while($row = mysqli_fetch_array($answer, MYSQLI_ASSOC))
            {
                $result[] = $row;
            }
        }

        for ($i=0; $i < count($result); $i++) {
            if($access == 0) {

               $result[$i]['access_open'] = true;

           } else if ($result[$i]['user_id'] == $user_id && $access != 2) {

               $result[$i]['access_open'] = true;

           } else {

            $result[$i]['access_open'] = false;

           }
        }

        return $result;
    }

    public function get_access($user_id) {

        $sql = "SELECT access_level
                FROM Users
                WHERE id = " . $user_id;

        $answer = mysqli_query($this->link, $sql);
        $result = mysqli_fetch_array($answer, MYSQLI_ASSOC);

        return $result['access_level'];
    }

    public function all_posts() {

        $sql = 'SELECT count(*) FROM Comments';

        $answer = mysqli_query($this->link, $sql);

        $result = mysqli_fetch_row($answer);

        return $result[0];

    }

}