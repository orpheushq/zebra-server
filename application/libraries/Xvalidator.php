<?php
class Xvalidator {
    function __construct ()
    {
        /*$CI =& get_instance();

        $CI->load->database();

        $this->db = $CI->db;*/
    }
    public function telno($strTel, $ret = FALSE)
    {
        /**
         * To check the verification code 
         * If $ret = TRUE, the returned value would be a standardised versino of the phone number OR FALSE
         */
        if (!$ret) {
            return preg_match('/^[1-9]{1}[0-9]{8}$/', $strTel);
        } else {
            $strTel = strval(intval($strTel));
            if (strlen($strTel) < 9) {
                //less than the minimum number of digits, might be a fake
                return FALSE;
            } else {
                return substr($strTel, -(9)); //get the 9 digits from right -> left so that extra detail like 94..etc is omitted
            }
            return $strTel;
        }
    }
}
?>