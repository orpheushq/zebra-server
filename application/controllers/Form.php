<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Form extends CI_Controller {
    function __construct()
    {
        parent::__construct();

        $this->load->helper(array('form', 'url'));
        $this->load->library('parser');
        $this->load->library('form_validation');
        $this->load->library('xuser');
    }

    public function login()
    {
        $this->form_validation->set_rules('username', 'Username', 'required');
        $this->form_validation->set_rules('password', 'Password', 'required');
        
        if ($this->form_validation->run() == FALSE)
        {
            $this->parser->parse('login', array(
                "title"=> "Login",
                "username"=>set_value("username"),
                "password"=>set_value("password")
            ));
        }
        else
        {   
            $response = $this->xuser->login(set_value('username'), set_value('password'));
            if ($response == false) {
                //bad auth
                redirect('?e=auth_fail');
            } else {
                //user auth successful
                //redirect('');
                if (intval($response['user']['type']) == 0) {//only admin users can log into backend
                    redirect('');
                } else {
                    $this->xuser->logOut();
                    redirect('?e=non_admin');
                }
            }
        }
    }
    private function echoExceptionList($exceptions) {
        $strRet = '';
        if (count($exceptions) == 0) {
            $strRet = "<span>Upload processed with no log to show.</span></br>";
        } 
        foreach ($exceptions as $exception) {
            switch ($exception['weight']) {
                case 0: {
                    $strRet .= "<span>".$exception['error']."</span></br>";
                    break;
                }
                case 1: {
                    $strRet .= "<span style='color:red;'>".$exception['error']."</span></br>";
                }
            }
        }
        return $strRet;
    }
    public function data_upload()
    {
        $response = $this->xuser->verifyToken();
        if ($response === false)
        {
            redirect('');
        }
        
        $config['upload_path']          = './uploads/';
        $config['allowed_types']        = 'xlsx|xls';

        $this->load->library('upload', $config);
        $this->load->library('proc');

        $response = $this->xuser->verifyToken();
        $data = array(
            'username' => $response['humanName'],
            'title' => "Upload Error"
        );
        
        //exit;
        if ( ! $this->upload->do_upload('file'))
        {
            $data['error'] = $this->upload->display_errors();
        }
        else
        {
            switch (intval(set_value('type'))) {
                case 1: {
                    //attendance upload
                    $result = $this->proc->proc_attendance_list($this->upload->data()['full_path'], set_value('isTest') == '' ? FALSE: TRUE);
                    break;
                }
            }
            $data['title'] = "Upload Info";
            $data['log'] = $result;
        }
        $this->parser->parse('upload_info_view.php', $data);
    }

    public function csv_validation($str)
    {
        /*$theseCategories = explode(",", $str);
        if ()*/
        //TODO: device of a way to validate CSV

        return TRUE;

        $isValid = FALSE;
        if (!$isValid)
        {
            $this->form_validation->set_message('csv_validation', 'The {field} is not a correct CSV value');
            return FALSE;
        }
        else
        {
            return TRUE;
        }
    }
    public function telno_validation($str) {
        $this->load->library('xvalidator');
        if ($this->xvalidator->telno($str)) {
            return TRUE;
        } else {
            $this->form_validation->set_message('telno_validation', 'The {field} is not in the correct format');
            return FALSE;
        }
    }
}
?>