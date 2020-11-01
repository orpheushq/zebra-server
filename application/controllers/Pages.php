<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Pages extends CI_Controller {
    function __construct()
    {
        parent::__construct();

        $this->load->helper('url');
        $this->load->library('parser');
        $this->load->library('form_validation');
        $this->load->library('xuser');
    }

    public function index($page = 'login')
    {
        $response = $this->xuser->verifyToken();
        /*if ( ! file_exists(APPPATH.'views/pages/'.$page.'.php'))
        {
                show_404();
        }*/
        if ($response === false) {
            $data = array(
                'css_path' => base_url()."css",
                'title' => "Login",
                "username"=>"",
                "password"=>"",
                "e"=>$this->input->get("e")
            );
            $this->parser->parse('login', $data);
        } else {
            $this->attendance();
        }
    }
    public function logout()
    {
        $this->xuser->logOut();
        redirect('');
    }

    public function attendance($page = 0)
    {
        $this->load->model(array('attendance'));
        $this->load->library(array('pagination'));

        $response = $this->xuser->verifyToken();
        if ($response === false)
        {
            show_404();
        }

        $config['per_page'] = 10;
        $sortArr = array("field" => "date", "direction" => "DESC");

        $dataList = $this->attendance->get_list(intval($page), $config['per_page'], array(), $sortArr);
        $config['reuse_query_string'] = TRUE;
        $config['base_url'] = base_url("user");
        $config['total_rows'] = $dataList['count'];
        
        $config['attributes'] = array('class' => 'mdl-button mdl-js-button mdl-button--raised mdl-js-ripple-effect');

        $config['cur_tag_open'] = '<a class="mdl-button mdl-js-button mdl-button--raised" disabled>';
        $config['cur_tag_close'] = '</a>';
        $this->pagination->initialize($config);


        $this->parser->parse('attendance', array(
            'username' => $response['fullname'],
            'title' => 'Attendance',
            'data' => $dataList['result'],
            'pagination' => $this->pagination->create_links()
        ));
    }

}
?>