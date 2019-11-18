<?php 
	//include('db/db_config.php');

    //$db = new LoadBd();
    //$status = $db->connect_db();
    include 'model/DB.php';

    $db = new LoadBd();
    $status = $db->connect_db();

    include('model/LoadUsers.php');
    include('model/LoadPage.php');
    include('model/LoadComments.php');

    $model_page = new LoadPage($status);
    $model_comment = new LoadComments($status);
    $model_users = new LoadUsers($status);

    include "controller/Pages.php";
    include "controller/Comments.php";
    include "controller/Users.php";

    $param = array();

    $user_controller = new Users($model_users);

    if ($user_controller->maybe()) {
         $param['current_user'] = $user_controller->give_user();
     } else {
        $param['current_user'] = 'Аноним';
     }
   

    $page_controller = new Pages($model_page);
    $param['page'] = $page_controller->get_page_data();
    $param['comments'] = $page_controller->get_page_comments();
