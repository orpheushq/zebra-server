<?php
//CORS added only to ease development. Remove it once development finishes
header('Access-Control-Allow-Origin: *');
header("Access-Control-Allow-Methods: GET, OPTIONS");

defined('BASEPATH') OR exit('No direct script access allowed');

class UploadApi extends CI_Controller {

	/**
	 * All APIs in this file require an authenticated entity.
	 * The identity verification is in the __construct function.
	 * Endpoint is `<root>/supplierapi`
	 */
	private $User = array();
    function __construct()
    {
        parent::__construct();

		$this->load->model('classification');

		$this->load->library('xuser');
		$this->load->helper('url');
	

		$this->output->set_content_type('application/json');
		
		//auth requirement defined on a per-function
		
	}
	public function picture()
	{
		$config['upload_path']          = './uploads/classification/';
		$config['allowed_types']        = 'gif|jpg|png';
		$config['max_size']             = 3000; //3000MB
		$config['max_width']            = 5000;
		$config['max_height']           = 5000;

		$this->load->library('upload', $config);

		//$response = array("message"=>rand());

		if ( ! $this->upload->do_upload('image'))
		{
			$error = array('error' => $this->upload->display_errors());
			var_dump($error);
			$this->error("upload_failed");
		}
		else
		{
			$data = array('upload_data' => $this->upload->data());

			$response = array("fileName" => base_url()."uploads/classification/".$data["upload_data"]["file_name"]);
		}
		
		$this->load->view('api_response', array("response"=> $response));
	}
	public function index()
	{
		$response = array("test"=>rand());
		
		$this->load->view('api_response', array("response"=> $response));
	}
	public function test($x, $y)
	{
		

		$response = array(
			"spit"=>$this->input->post("test"),
			"param1"=>$x,
			"param2"=>$y,
		);
		echo base_url();
		$this->load->view('api_response', array("response"=> $response));
	}
	public function error($code = "")
	{
		$response = array("error"=>"");
		
		switch ($code) {
			case "upload_failed":
			case "auth_error":
			{
				$response["error"] = $code;
				break;
			}
			default: {
				$response["error"] = "undefined_command";
				break;
			}
		}

		$this->load->view('api_response', array("response"=> $response));
	}
}
