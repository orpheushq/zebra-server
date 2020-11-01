<?php
include "token.php";

class Xuser {
    function __construct ()
    {
        $CI =& get_instance();

        $CI->load->database();

        $this->db = $CI->db;
    }
    public function generate_password()
    {
        /**
         * Used to generate a password when an account needs to be created as the result of an oauth flow
         */
        $sym = ['!', '@', '#', '$', '%', '^', '&', '*'];
        $pwd = base64_encode(rand(5555, 555555)).rand(55555, 555555);
        for ($i = 0; $i < 5; $i++) $pwd{rand(0, strlen($pwd))} = $sym[rand(0, count($sym) - 1)];
        $pwd .= base64_encode(rand(55555, 555555)).rand(55555, 555555);
        return $pwd;
    }
    public function create ($email, $password)
    {
        $thisUser = $this->getUser($email);
        if ($thisUser === FALSE)
        {
            $query = $this->db->query("INSERT INTO `user` (`email`, `password`) VALUES (?,?)", array($email, password_hash($password, PASSWORD_DEFAULT)));
            return $this->getUser($email);
        } else {
            return FALSE;
        }
        
    }
    public function getUser ($email) 
    {
        /*
            Returns the user if present otherwise returns false
        */
        $query = $this->db->query("SELECT * FROM `user` WHERE email=?;", array($email));

        $thisUser = $query->row_array();

        if (is_null($thisUser))
        {
            return FALSE;
        }

        return $thisUser;
    }
    public function login ($email, $password, $skipPasswordCheck = false)
    {
        $tokenizer = new Tokenizer($this->db);
        
        $reponse = array(
            "token" => ""
        );
        

        $thisUser = $this->getUser($email);
        if ($thisUser !== false && ($skipPasswordCheck || password_verify($password, $thisUser["password"])) ) {
            $response["user"] = $thisUser;
            $response["token"] = $tokenizer -> setTokenCookie($email);

            return $response;
        } else {
            return false;
        }
    }
    public function verifyToken ($token = null)
    {
        $tokenizer = new Tokenizer($this->db);

        $tokenState = $tokenizer->getCredentials($token);
        
        if ($tokenState["auth"] !== "fail") {
            $thisUser = $this -> getUser($tokenState["username"]);

            //check if account is activated IF the user object has a 'activated' property
            if (array_key_exists("activated", $thisUser) && intval($thisUser['activated']) == 0) {
                //account not activated
                return false;
            } else {
                return $thisUser;
            }

        } else {
            return false;
        }
    }
    public function logOut () {
        $tokenizer = new Tokenizer($this->db);

        $tokenizer -> deleteTokenCookie();
    }
}
?>