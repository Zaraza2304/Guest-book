<?php
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

    $global_params = array();

    $user_controller = new Users($model_users);

    if ($user_controller->maybe()) {
        $tmp = $user_controller->give_user();
        $global_params['current_user'] = $tmp['login'];
        $global_params['user_email'] = $tmp['e_mail'];
        $global_params['user_id'] = $tmp['id'];
     } else {
        $global_params['current_user'] = 'Гость';
        $global_params['user_id'] = 2;
     }


    $page_controller = new Pages($model_page);

    $global_params['page'] = $page_controller->get_page_data();

    if ($global_params['page']['title'] === 'Гостевая книга') {

        $global_params['comments'] = $page_controller->get_page_comments($global_params['user_id']);

        if (count($global_params['comments']) > 0) {
            $global_params['paginate'] = $page_controller->paginate();
        } else {
             $global_params['paginate'] = array();
        }


    } else {
        $global_params['comments'] = array();
    }

