<?php
//CORS added only to ease development. Remove it once development finishes
header('Access-Control-Allow-Origin: *');
header("Access-Control-Allow-Methods: GET, OPTIONS");

defined('BASEPATH') OR exit('No direct script access allowed');

class MachineApi extends CI_Controller {

	/**
	 * All APIs in this file require an authenticated entity.
	 * The identity verification is in the __construct function.
	 * Endpoint is `<root>/supplierapi`
	 */
    function __construct()
    {
        parent::__construct();

        $this->load->library('xuser');

		$this->output->set_content_type('application/json');
	}
	public function get_tags() {
		$response = $this->supplier->getTags();
		$this->load->view('api_response', array("response"=> $response));
	}
	public function get($id = null)
	{
		if (is_null($id)) {
			//retrieve all suppliers
			//TODO: add sorting and filtering options
			$filters = $this->input->post("filters");
			$response = array();
			if (is_null($filters)) {
				//no filters provided; get all
				$response = $this->supplier->get_list();
			} else {
				$response = $this->supplier->get_list(0, 9999, json_decode($filters, true));
			}
			foreach ($response['result'] as &$r) {
				$r["company"] = htmlspecialchars_decode($r["company"], ENT_QUOTES);
				$r["tags"] = htmlspecialchars_decode($r["tags"], ENT_QUOTES);
			}
		} else {
			//send only one supplier
		}
		$this->load->view('api_response', array("response"=> $response));
	}
	public function start_enrolment()
	{
		//enrolls the student AND if enrolment is successful, marks attendance for the same student
		$this->load->model(array('student', 'attendance'));

		$fullname = $this->input->post("fullname");
		$swinId = $this->input->post("swin_id");
		$rfid = $this->input->post("rfid");

		$thisStudent = array(
			"fullname"=>$fullname,
			"swinId"=>$swinId,
			"rfid"=>$rfid
		);
		$this->student->add($thisStudent);
		$this->send_attendance($rfid);
	}
	public function send_attendance($serialNum = null)
	{
		$this->load->model(array('student', 'attendance'));

		//fetch RFID from request
		if ($serialNum === null) {
			//serial number is not specified
			$rfid = $this->input->post("rfid");
		} else {
			//retrieve serial number from the function param
			$rfid = $serialNum;
		}
		/*var_dump(
			$this->student->get_list(0,1,$rfid)['result'][0]
		);*/

		//fetch the student entry from the database
		$thisStudent = $this->student->get_list(0,1,array("rfid"=>$rfid))['result'];

		if (count($thisStudent) === 0) {
			//no student found. This means it's a new student so enroll the student first
			$this->error("student_nonexistent");
			return;
		} else {
			$thisStudent = $thisStudent[0]; //get only the first item (there will only be one student anyways as the rfid is unique)
		}

        $today = new DateTime();
		$date = $today->format("Y-m-d"); //get today's date
		$time = $today->format("H:i:s"); //get the current time
		
		//check if an attendance exists for this student, for today's date
		$thisAttendance = $this->attendance->get_list(0, 1, array(
			"studentId"=>intval($thisStudent['id']),
			"date"=>$date
		))['result'];

		if (count($thisAttendance) === 0) {
			//previous attendance doesnt exist.Insert new attendance
			$thisAttendance = array(
				"studentId"=>intval($thisStudent['id']),
				"date"=>$date,
				"time"=>$time
			);
			$this->attendance->add($thisAttendance);
		}

		//send the JSON response out
		$this->load->view('api_response', array("response"=> $thisStudent));
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
			case "student_nonexistent":
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
