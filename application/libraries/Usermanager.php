<?php
include "token.php";

class UserManager {
	function __construct ($dbHandle) {
        $this -> dbh = $dbHandle;
    }
    public function login ($email, $password) {
        $tokenizer = new Tokenizer($this -> dbh);
        
        $reponse = array(
            "token" => ""
        );
        
        $thisUser = $this -> getUser($email);
        
        if ($thisUser !== false && password_verify($password, $thisUser["password"])) {
            $response["user"] = $thisUser;
            $response["token"] = $tokenizer -> setTokenCookie($email);
            
            return $response;
        } else {
            return false;
        }
    }
    public function create ($email, $password) {
        /*
            $email is the user's email that the user logs with
            $password is the human readable password that will be hashed
            $humanName maps to the human readable name of the user
        */
        $hash = password_hash($password, PASSWORD_DEFAULT);
        $this -> dbh -> query("INSERT INTO `user` (email, password) VALUES('{$email}', '{$hash}');");
        return $this -> getUser($email);
    }
    public function verifyToken ($token = null) {
        $tokenizer = new Tokenizer($this -> dbh);

        $tokenState = $tokenizer -> getCredentials($token);
        
        if ($tokenState["auth"] !== "fail") {
            return $this -> getUser($tokenState["username"]);
        } else {
            return false;
        }
    }
    public function logOut () {
        $tokenizer = new Tokenizer($this -> dbh);

        $tokenizer -> deleteTokenCookie();
    }
    public function getUser ($email) {
        /*
            Returns the user if present otherwise returns false
        */
        $sth = $this -> dbh -> query("SELECT * FROM `user` WHERE email='{$email}';");
        $sth -> setFetchMode(PDO::FETCH_ASSOC);
        $thisUser = $sth -> fetch();
        
        return $thisUser;
    }
}
?>