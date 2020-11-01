<?php

/*
	This Tokenizer module is adapted for CodeIgniter usage
*/

ini_set('display_errors',1);
ini_set('display_startup_errors',1);
error_reporting(-1);

class Tokenizer
{
	function __construct ($dbHandle) {
        $this -> dbh = $dbHandle;
    }

	public function getCredentials ($authCode = null) {
		$retObj = array(
			"auth" => "fail"
		);
		if (isset($_COOKIE["auth"])) {
			//cookie present
			$token = $_COOKIE["auth"];
		} else {
			//no cookie. check for authCode
			if (isset($authCode)) {
				$token = $authCode;
			} else {
				//no cookie OR authCode
				return $retObj;
			}
		}
		$sth = $this -> dbh->query("SELECT `username` FROM tbltoken WHERE `token` = ?", array($token));
		$tokenInfo = $sth->row_array();
        
        if ($tokenInfo !== false) {
            $tokenParts = explode(",", base64_decode(base64_decode($token)));
            $userFromToken = $tokenParts[1];
            $timeFromToken = $tokenParts[0];
            //echo $userFromToken;
            //echo " tokenCheck dump: ".$userFromToken;
            if ($tokenInfo["username"] === $userFromToken && (time() < $timeFromToken)) {
                //username belonging to token from tbltoken matches username decoded from token AND token hasn't expired
                //$retObj = array(
                //	"newToken" => 
                //);
                //echo " token match! ";
                $retObj = array(
                    "auth" => "pass",
                    "username" => $tokenInfo["username"]
                );
            } else {
                if (time() > $timeFromToken && isset($token)) {
                    //token has expired. Remove token from tbltoken
                    //echo "token removed";
                    $this -> dbh -> query("DELETE FROM `tbltoken` WHERE `tbltoken`.`token` = ?", array($token));
                }
            }
        }
		return $retObj;
	}
	public function setTokenCookie($username) {
		date_default_timezone_set("UTC");
		$expireTime = time() + (30 * 24 * 60 * 60); //expire after 30 days
		$newToken = $expireTime.",".$username; //attach expiration time not just time()
		//setcookie("auth", "", time() - 1); //expire previous cookies
		$encodedNewToken = base64_encode(base64_encode($newToken));
		setcookie("auth", $encodedNewToken, $expireTime, "/");
		$this -> dbh -> query("INSERT INTO `tbltoken` (`id`, `token`, `username`, `expireTime`) VALUES (NULL, '$encodedNewToken', '$username', '$expireTime')");
		//echo $_COOKIE["auth"];
		return $encodedNewToken;
	}
	public function deleteTokenCookie() {
		date_default_timezone_set("UTC");
		setcookie("auth", "false", time() - 1, "/");
	}
}
?>
