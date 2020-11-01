<?php
//CORS added only to ease development. Remove it once development finishes
header('Access-Control-Allow-Origin: *');
header("Access-Control-Allow-Methods: GET, OPTIONS");

defined('BASEPATH') OR exit('No direct script access allowed');

class OtpApi extends CI_Controller {

	/**
	 * Auth APIs so do not require authentication
	 * * Endpoint is `<root>/api/auth/` OR `<root>/auth/`
	 */
    function __construct()
    {
        parent::__construct();

        $this->load->library('otp');

        $this->output->set_content_type('application/json');
	}
	public function create()
	{
		/**
		 * Creates an OTP and sends an SMS
		 * TODO: add code to send SMS
		 */
		$username = $this->input->post("username");

		$response = $this->otp->create($username);

		if ($response === FALSE) {
			$this->error("otp_failed");
		} else {
			$r = "success";
			$this->load->view('api_response', array("response"=> $r));
		}


		//send SMS
		$msg = "Your Best COOP registration OTP is ".$response['otp'];
		$this->otp->sendSMS('94'.$response["email"], $msg);
	}
	public function verify()
	{
		/**
		 * Verifies the OTP and if validated, activates the account
		 */
		$username = $this->input->post("username");
		$otp = $this->input->post("otp");
		$response = $this->otp->verify($username, $otp);

		switch ($response) {
			case 'otp_expired':
			case 'otp_notFound': {
				$this->error($response);
				break;
			}
			case 'otp_success':
			{
				$response = array(
					"message" => $response
				);
				$this->load->view('api_response', array("response"=> $response));
				break;
			}
		}
	}
	public function test()
	{
		$response = array("test"=>rand());
		
		$this->load->view('api_response', array("response"=> $response));
	}
	public function error($code)
	{
		$response = array("error"=>"");
		
		switch ($code) {
			case 'otp_expired':
			case "otp_notFound":
			case "otp_failed":
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
