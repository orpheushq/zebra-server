<?php
//CORS added only to ease development. Remove it once development finishes
header('Access-Control-Allow-Origin: *');
header("Access-Control-Allow-Methods: GET, OPTIONS");

defined('BASEPATH') OR exit('No direct script access allowed');

class AuthApi extends CI_Controller {

	/**
	 * Auth APIs so do not require authentication
	 * * Endpoint is `<root>/api/auth/` OR `<root>/auth/`
	 */
    function __construct()
    {
        parent::__construct();

		$this->load->library('xuser');
		$this->load->model('user');

        $this->output->set_content_type('application/json');
    }
    public function create_user() {
    	/**
    	* Creates a user given the password and username
    	* The DB table's default is type 2 user
    	* Does not have the facility to create other types of users
		*/
		$this->load->library('xvalidator');

    	$email = $this->xvalidator->telno($this->input->post("email"), TRUE);
		$password = $this->input->post("password");
		$fullName = $this->input->post("fullName");
    	$thisUser = $this->xuser->create($email, $password);

		if ($email == FALSE) {
			//error in phone number, can't be validated nor tracked
			$this->error("invalid_format");
			return;
		}

    	if ($thisUser == false) {
    		//user already exists
    		$this->error("user_exists");
    	} else {
			//set extra properties
			$thisUser['fullName'] = $fullName;
			$this->user->update($thisUser);
    		$thisUser["password"] = "";
    		$this->load->view('api_response', array("response"=> $thisUser));
    	}
	}
	/*public function gauth() {
		require_once APPPATH.'third_party/google-api-php-client/vendor/autoload.php';

		$gclient = new Google_Client();

		$ticket = $gclient->verifyIdToken($this->input->post("token"));
		if ($ticket) {
			//var_dump($ticket["email"]);
			$email = $ticket["email"];

			if ($email !== $this->input->post("email")) {
				//something is fishy...Emails does not match
				$this->error("auth_error");
			} else {
				$this->login($email); //continue with usual flow, albeit login() will know that it is a continuation of oauth
			}
		} else {
			$this->error("gauth_error");
		}
	}*/
    public function login($oauthEmail = null, $isNewUser = false) {
		/**
		 * $oauthEmail = To continue login process from an oauth flow
		 * $isNewUser = TRUE if continuation of oauth create account login flow
		 */
		$this->load->library('xvalidator');

		$auth = false;
		if (is_null($oauthEmail)) {
    		$email = $this->xvalidator->telno($this->input->post("email"), TRUE);
			$password = $this->input->post("password");
			
			$auth = $this->xuser->login($email, $password);
		} else {
			$email = $oauthEmail;
			$password = "";

			$auth = $this->xuser->login($email, $password, true);
		}

		if (isset($auth) && $auth != false) {
			//user auth successful
			$auth["user"]["password"] = "";
			$this->load->view('api_response', array("response"=> $auth));
	    } else {
			//if this error happens after going through oauth process, technically shouldn't throw an error. Create an account and sign in
			if (is_null($oauthEmail)) {
				$this->error("auth_error");
			} else {
				//result of oauth flow, create an account
				$res = $this->xuser->create($oauthEmail, $this->xuser->generate_password());
				if ($res === FALSE) {
					$this->error("oauth_create_account_error");
				} else {
					//successfully created the account
					$this->login($oauthEmail, true); //retry login flow as now the account has been created
				}
			}
	    }
	}
    public function verify_token() {
		$this->load->library('xuser');

    	$token = $this->input->post("token");
        $auth = $this->xuser->verifyToken($this->input->post("token") ? $this->input->post("token"): null);

        if ($auth == false) {
        	//auth fail
        	$response = array("error"=>"auth_error");
        	$this->load->view('api_response', array("response"=> $response));
        	$this->output->_display();
        	exit;
        } else {
			$auth["password"] = "";
        	$this->load->view('api_response', array("response"=> $auth));
        }
    }
	public function test()
	{
		$response = array("test"=>rand());
		
		$this->load->view('api_response', array("response"=> $response));
	}
	public function index()
	{
		$response = array("test"=>rand());
		
		$this->load->view('api_response', array("response"=> $response));
	}
	public function error($code)
	{
		$response = array("error"=>"");
		
		switch ($code) {
			case "invalid_format":
			case "oauth_create_account_error":
			case "gauth_error":
			case "user_exists":
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
