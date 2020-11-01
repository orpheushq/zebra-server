<?php
//CORS added only to ease development. Remove it once development finishes
header('Access-Control-Allow-Origin: *');
header("Access-Control-Allow-Methods: GET, OPTIONS");

defined('BASEPATH') OR exit('No direct script access allowed');

class ClassificationApi extends CI_Controller {

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

		$this->output->set_content_type('application/json');
		
		//auth required for this API
        $auth = $this->xuser->verifyToken($this->input->post("token") ? $this->input->post("token"): null);

        if ($auth == false) {
        	//auth fail
        	$response = array("error"=>"auth_error");
        	$this->load->view('api_response', array("response"=> $response));
        	$this->output->_display();
        	exit;
        } else {
        	$this->User = $auth;
		}
		
	}
	public function get($id = NULL)
	{
		/**
		 * API can be used to get only the user's own classifications
		 * No need further authentication as this module is protected anyways.
		 */
		if ($id == NULL) {
			$response = $this->classification->get_list(0, 9999, array('userId' => $this->User['id']));
		} else {
			$response = $this->classification->get($id);
			//check if the item has the userId of the current user
			if (intval($response['userId']) != intval($this->User['id'])) {
				$response = array("error"=>"auth_error");
			}
		}
		$this->load->view('api_response', array("response"=> $response));
	}
	public function update()
	{
		$thisItem = json_decode($this->input->post("item"), true);
		$this->classification->update(intval($this->User['id']), $thisItem);
		$response = array("message" => "success");
		$this->load->view('api_response', array("response"=> $response));
	}
	public function add()
	{
		$thisItem = json_decode($this->input->post("item"), true);
		$insertId = $this->classification->add($this->User['id'], $thisItem);
		$response = array("id" => $insertId);
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
		
		$this->load->view('api_response', array("response"=> $response));
	}
	public function error($code = "")
	{
		$response = array("error"=>"");
		
		switch ($code) {
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
