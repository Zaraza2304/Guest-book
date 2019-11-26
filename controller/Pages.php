<?php
Class Pages {

    private $model;
    private $session = false;
    private $url_current_page;

    private $on_page = 5;
    private $paginate_data = array();


    public function __construct($model)
    {
        $this->model = $model;
        $this->current_page();
    }

    private function current_page() {

        $client_page = $_SERVER['REQUEST_URI'];

        $this->url_current_page = explode('?', $client_page);
    }

    public function get_page_data() {


        $page_id = $this->model->get_page_id($this->url_current_page[0]);

        if(!$page_id) {
            return NULL;
        }

        $data = $this->model->get_data($page_id);
        $data['url'] = $this->url_current_page;

        return $data;

        //return $this->url_current_page;
    }

    public function get_page_comments($user_id = 2, $page_id = 1) {

        $answer = $this->logic_paginate();

        if (!$answer) {
            return array();
        } else {
           $param = array($this->paginate_data['offset'], $this->paginate_data['on_page']);

            $access = 2;

            if($user_id != 2) {
                $access = $this->model->get_access($user_id);
            }

            $data = $this->model->get_comments($user_id, $access, $page_id, $param);

            if($data == false) {
                return array();
            }
            return $data;
        }
    }

    private function logic_paginate() {

        $post_count = (int)$this->model->all_posts();

        if ($post_count === 0) {
            return false;
        }

        $all_page = intdiv($post_count, $this->on_page);

        if (!($all_page * $this->count_on_page) == $post_count) {
            $all_page += 1;
        }

        $clear_url = explode('&', $this->url_current_page[1]);
        $curr_page = explode('=', $clear_url[0]);

        $offset = 0;

        if( count($curr_page) > 1 && $curr_page[1] == 1 ) {

            $offset = 0;

        } elseif ( $curr_page[1] == 1 ) {

            $offset = $curr_page[1] * ($this->on_page - 1) + 1;

        }
        elseif ( 1 < $curr_page[1] && $curr_page[1] < $all_page ) {

            $offset = ($curr_page[1] - 1) * $this->on_page;

        }
        elseif ( $curr_page[1] == $all_page ) {

            $offset = ($all_page - 1) * $this->on_page;

        }

        if(count($curr_page) == 1 ) {
            $number_p = 1;
        } else {
            $number_p = $curr_page[1];
        }

        $this->paginate_data = array(
                    'offset' => $offset,
                    'on_page' => $this->on_page,
                    'all_pages' => $all_page,
                    'curr_page' => $number_p,
                );
        return true;
    }

    public function paginate() {

        $temp_span_st = '<span class="';
        $temp_a_st = '<a href="';
        $temp_span_end = '</a></span>';

        $span_cl_n = 'n_link';
        $span_cl_y = 'y_link';



        if($this->paginate_data['curr_page'] == 1 && $this->paginate_data['all_pages'] == 1) {

            $next = $this->paginate_data['curr_page'] + 1;


            $paginate['pred_page'] = $temp_span_st . $span_cl_n . '">' . $temp_a_st . '#">Previous' . $temp_span_end;


            $paginate['curr_page'] =
            $temp_span_st . $span_cl_y . '">' . $temp_a_st . $this->url_current_page[0] . '">1' . $temp_span_end;


            $paginate['nex_page'] =
            $temp_span_st . $span_cl_n . '">' .$temp_a_st . '#">Next' . $temp_span_end;

        } elseif ($this->paginate_data['curr_page'] == 1) {

            $next = $this->paginate_data['curr_page'] + 1;


            $paginate['pred_page'] = $temp_span_st . $span_cl_n . '">' . $temp_a_st . '#">Previous' . $temp_span_end;


            $paginate['curr_page'] =
            $temp_span_st . $span_cl_y . '">' . $temp_a_st . $this->url_current_page[0] . '">1' . $temp_span_end;


            $paginate['nex_page'] =
            $temp_span_st . $span_cl_y . '">' .$temp_a_st .
            $this->url_current_page[0] . '?page=' . $next . '">Next' . $temp_span_end;


        } elseif (  (1 < $this->paginate_data['curr_page']) &&
                    ($this->paginate_data['curr_page'] < $this->paginate_data['all_pages']) ) {


            $next = $this->paginate_data['curr_page'] + 1;
            $previous = $this->paginate_data['curr_page'] - 1;


            $paginate['pred_page'] =
                $temp_span_st . $span_cl_y . '">' . $temp_a_st .
                $this->url_current_page[0]. '?page=' .$previous. '">Previous' . $temp_span_end;


            $paginate['curr_page'] =
                $temp_span_st . $span_cl_y . '">' . $temp_a_st .
                $this->url_current_page[0] . '?page=' .$this->paginate_data['curr_page']. '">' .
                $this->paginate_data['curr_page'] . $temp_span_end;


            $paginate['nex_page'] =
                $temp_span_st . $span_cl_y . '">' .$temp_a_st .
                $this->url_current_page[0] . '?page=' . $next . '">Next' . $temp_span_end;


        } elseif ($this->paginate_data['curr_page'] == $this->paginate_data['all_pages']) {

            $next = $this->paginate_data['curr_page'] + 1;
            $previous = $this->paginate_data['curr_page'] - 1;


            $paginate['pred_page'] =
                $temp_span_st . $span_cl_y . '">' . $temp_a_st .
                $this->url_current_page[0]. '?page=' .$previous. '">Previous' . $temp_span_end;


            $paginate['curr_page'] =
                $temp_span_st . $span_cl_y . '">' . $temp_a_st .
                $this->url_current_page[0] . '?page=' .$this->paginate_data['curr_page']. '">' .
                $this->paginate_data['curr_page'] . $temp_span_end;


            $paginate['nex_page'] = $temp_span_st . $span_cl_n . '">' . $temp_a_st . '#">Next' . $temp_span_end;
        }

        $result['paginate'] = $paginate;
        $result['data_paginate'] = $this->paginate_data;
        return $result;

    }

}