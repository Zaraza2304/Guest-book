<?php
Class Pages {

    private $model;
    private $session = false;

    public function __construct($model)
    {
        $this->model = $model;
    }

    public function get_page_data($page_id = 1) {

        return $this->model->get_data($page_id);
    }

    public function get_page_comments($page_id = 1) {

        $data = $this->model->get_comments($page_id, $this->session);
        
        return $data;
    }

}