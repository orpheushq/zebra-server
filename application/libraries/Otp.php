<?php
class Otp {
	function __construct () {
        $CI =& get_instance();

        $CI->load->database();

        $this->db = $CI->db;
    }
    public function sendSMS ($phoneNumber, $message) {
        $username = 'VO04-helplk';//'VO04-demo';
        $password = urlencode('Inc123!@');//'demo1234';
        $source = '94115964406';
        $message = urlencode($message);

        $f="";
        $f = file_get_contents("http://rslr.connectbind.com/bulksms/bulksms?username={$username}&password={$password}&type=0&dlr=1&destination={$phoneNumber}&source={$source}&message={$message}");
        //$f = file_get_contents("https://orpheus.digital?lang=si");
        return $f;
    }
    public function create ($username) {
		date_default_timezone_set("UTC");
		/**
		 * Creates an OTP
		 */
        
        //validation
        $query = $this->db->query("SELECT * FROM `user` WHERE email=?;", array($username));
        $thisUser = $query->row_array();

        //remove previous OTPs of the same username
        $this->db-> query("DELETE FROM `verify` WHERE `username`=?;", array($username));

        //if a user does not exist or if the user is already validation, return FALSE
        if (is_null($thisUser) || intval($thisUser['activated']) == 1)
        {
            return FALSE;
        }

		//generate random token
        $token = rand(1,9).rand(0,9).rand(0,9).rand(0,9);
        $thisUser['otp'] = $token;

		//generate expireTime
        $expireTime = time() + (5 * 60); //expire after 5 minutes
        
        //insert new otp into database
        $this->db-> query("INSERT INTO `verify` (username, token, expireTime) VALUES('{$username}', {$token}, {$expireTime});");

        return $thisUser;
    }
    public function verify ($username, $otpCode) {
        date_default_timezone_set("UTC");

        $query = $this->db->query("SELECT * FROM `verify` WHERE username=? AND token=?;", array($username, $otpCode));
        $thisOtp = $query->row_array();

        if (is_null($thisOtp)) {
            //opt not found
            return "otp_notFound";
        } else {
            //remove previous OTPs of the same username
            $this->db-> query("DELETE FROM `verify` WHERE `username`=?;", array($username));
            if (time() > intval($thisOtp['expireTime'])) {
                //expired token
                return "otp_expired";
            } else {
                //activate user
                $this->db-> query("UPDATE `user` SET `activated`=1 WHERE `email`=?", array($username));
                return "otp_success";
            }
        }
    }
}
?>