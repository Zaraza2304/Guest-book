<?php
session_start();
$comments_controller = new Comments($model_comment);
$comments_controller->ajax_listen();

Class Comments {

    private $form_data = array();
    private $model;
    private $guest_login = 'anonimys_lg';

    private $test_array = array();

    public function __construct($model)
    {
        $this->model = $model;
    }

    public function ajax_listen() {

        if ( isset($_POST['button']) ) {

            $page_id = (integer)htmlentities($_POST['id']);
            $name = htmlentities($_POST['comment_name']);
            $user_id = $this->check_current_user($name);

            if(isset($_SESSION['authoris'])) {
                $email = '';
            } else {
                $email = filter_var(htmlentities($_POST['comment_email']), FILTER_VALIDATE_EMAIL);
            }


            $home_url = filter_var(htmlentities($_POST['comment_home_url']), FILTER_VALIDATE_URL);
            $text = htmlentities($_POST['comment_text']);
            $user_agent = $_SERVER["HTTP_USER_AGENT"];
            $client_ip = filter_var($this->get_user_ip(), FILTER_VALIDATE_IP);
            $datetime = $_POST["time"];

            //echo 'Посылка пришла';

            $this->form_data = array(
            'page_id' =>  $page_id,
            'user_name' => $name,
            'user_id' => $user_id,
            'e_mail' => $email,
            'homepage' => $home_url,
            'text' => $text,
            'browser' => $user_agent,
            'ip' => $client_ip,
            'created' => $datetime);

            $this->push_comment();

            $this->form_data = array();

        } elseif ( isset($_POST['id_comment']) && isset($_POST['delete']) ) {

            $id = htmlentities($_POST['id_comment']);

            $result = $this->model->unset_comment($id);

            if(!$result) {
                echo "0";
            } else {
                echo '1';
            }

        } elseif ( isset($_POST['save']) ) {

            /*echo "<pre>";
            var_dump($_POST);
            echo "</pre>";*/

            $id = htmlentities($_POST['id']);
            $name = htmlentities($_POST['comment_name']);
            $user_id = $this->check_current_user($name);
            $home_url = filter_var(htmlentities($_POST['comment_home_url']), FILTER_VALIDATE_URL);
            $text = htmlentities($_POST['comment']);

            $this->form_data = array(
                    'id' => $id,
                    'user_name' => $name,
                    'user_id' => $user_id,
                    'home_page' => $home_url,
                    'text' => $text
                );
            $answer = 'Test';
            $answer = $this->model->update_comment($this->form_data);

            $this->form_data = array();
            $_POST['result_edit'] = $answer;

        } else {
            //echo '0';
            return false;
        }
    }

    public function get_data_user() {

        $url = $_SERVER['REQUEST_URI'];
        $url = explode('=', $url);

        $data = $this->model->get_comment($url[1]);

        if ( isset($_SESSION['lg']) ) {
            $login = $_SESSION['lg'];

            $data[0]['e_mail'] = $this->model->get_email($login);
        }


        if(!is_array($data)) {
            return 'Во время загрузки, что-то пошло не так. попробуйте еще раз';
        }
        return $data;
    }

    private function get_user_ip() {
        if(!empty($_SERVER['HTTP_CLIENT_IP'])){
            //ip from share internet
            $ip = $_SERVER['HTTP_CLIENT_IP'];
        }elseif(!empty($_SERVER['HTTP_X_FORWARDED_FOR'])){
            //ip pass from proxy
            $ip = $_SERVER['HTTP_X_FORWARDED_FOR'];
        }else{
            $ip = $_SERVER['REMOTE_ADDR'];
        }
        return $ip;
    }

    private function check_current_user($name) {

        $answer = $this->model->check_owner($name);
        return $answer;
    }

    private function push_comment() {
        $answer = $this->model->add_comment($this->form_data);
        if(!$answer) {
            echo "0";
        } else {
            echo $answer;
        }
    }
}

