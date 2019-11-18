<?php

$obj_c = new Comments($model_comment);
$obj_c->ajax_listen();

Class Comments {

    private $form_data = array();
    private $model;
    private $session = false;

    public function __construct($model)
    {
        $this->model = $model;
    }

    public function ajax_listen() {

        if ( isset($_POST['button']) ) {

            $page_id = (integer)htmlentities($_POST['id']);
            $name = htmlentities($_POST['comment_name']);
            $user_id = $this->check_current_user($name); //ПРОВЕРКА НА СЕССИЮ//ДОПИСАТЬ
            $email = filter_var(htmlentities($_POST['comment_email']), FILTER_VALIDATE_EMAIL);
            $home_url = filter_var(htmlentities($_POST['comment_home_url']), FILTER_VALIDATE_URL);
            $text = htmlentities($_POST['comment_text']);
            $user_agent = $_SERVER["HTTP_USER_AGENT"];
            $client_ip = filter_var($this->get_user_ip(), FILTER_VALIDATE_IP);
            $datetime = $_POST["time"];

            //echo 'Посылка пришла'; //Change

        } else {
            //echo 'Error, ajax_listen';
            return false;
        }

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
        /*
            Проверка сессии:
            Если аноним (нет сессии) тогда return selece from users where login - anonymus
            Если пользователь (есть сессия), взять из сессии, сравнить с именем с формы, 
                                        select user_id from users where login = name
        */
        /*
            Проверка на сессию и изменение глобальной переменной $this->session
        */
        $this->session = false; //Аноним
        //$this->session = true; //Пользователь   

        if(!$this->session) {
            //Нет сессии, аноним
            $name = 'anonymous_l';
            $answer = $this->model->check_owner($name);
            if($answer == 0) {
                return false;
            } 
            return $answer['id'];
        } else {
            //Взять имя из сессии и проверить его через модель как выше
        }
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

