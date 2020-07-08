<?php 

class Hash{

    const MD5 = "md5";
    const DOUBLE_MD5 = "md5";
    const MD5_WITH_SALT = "md5";
    const SHA256 = "sha256";
    const SHA512 = "sha512";

    private $pass;
    private $algorithm;
    private $newpass;
    private $hash_pass;
    private $_compare;

    public function __construct($_pass, $action, $hashpass="", $method = 'sha256'){
        $this->pass = $_pass;
        $this->hash_pass = $hashpass;
        $this->algorithm = $method;
        if($action == "generate"){
            $this->newpass = $this->AMHash($this->pass);
        }else{
            if($action == "compare"){
                $this->_compare = $this->compare($this->pass, $this->hash_pass);
            }
        }
        
    }
    
    private function compare($pass, $hash_pass) {
        switch ($this->algorithm) {
            case self::SHA256:
                $shainfo = explode("$", $hash_pass);
                $salt = explode("@", $shainfo[2])[1];
                $hash = explode("@", $shainfo[2])[0];
                
                $pass = hash('sha256', $pass) . $salt;
                
                return strcasecmp($hash, hash('sha256', $pass)) == 0;
                
            case self::SHA512:
                $shainfo = explode("$", $hash_pass);
                $salt = explode("@", $shainfo[2])[1];
                $hash = explode("@", $shainfo[2])[0];
                
                $pass = hash('sha512', $pass) . $salt;
                return strcasecmp($hash, hash('sha512', $pass)) == 0;
                
            case self::MD5_WITH_SALT:
                $md5info = explode("$", $hash_pass);
                $salt = explode("@", $md5info[2])[1];
                $hash = explode("@", $md5info[2])[0];
                
                $pass = hash('md5', $pass) . $salt;
                return strcasecmp($hash, hash('md5', $pass)) == 0;
                
            case self::MD5:
                $md5info = explode("$", $hash_pass);
                $hash = explode("@", $md5info[2])[0];
                return strcasecmp($hash, hash('md5', $pass)) == 0;
                
            case self::DOUBLE_MD5:
                $md5info = explode("$", $hash_pass);
                $hash = explode("@", $md5info[2])[0];
                return strcasecmp($hash, hash('md5', hash('md5', $pass))) == 0;

            default:
                return false;
        }
    }

    public function getNewpass(){
        return $this->newpass;
    }
    public function getCompare(){
        return $this->_compare;
    }

    private function AMHash($pass) {
        switch ($this->algorithm) {
            case self::SHA256:
                $salt = self::createSalt();
                return "\$SHA256\$" . hash("sha256", hash('sha256', $pass) . $salt) . "@" . $salt;

            case self::SHA512:
                $salt = self::createSalt();
                return "\$SHA512\$" . hash("sha512", hash('sha512', $pass) . $salt) . "@" . $salt;

            case self::MD5_WITH_SALT:
                $salt = self::createSalt();
                return "\$MD5\$" . hash("md5", hash('md5', $pass) . $salt) . "@" . $salt;
                
            case self::MD5:
                $salt = self::createSalt();
                return "\$MD5\$" . hash('md5', $pass) . "@" . $salt;
                
            case self::DOUBLE_MD5:
                $salt = self::createSalt();
                return "\$MD5\$" . hash("md5", hash('md5', $pass)) . "@" . $salt;

            default:
                return null;
        }
    }
    
    private function createSalt() {
        $salt = "";        

        $alphaNumeric = implode('', range('A', 'Z')).implode('', range('a', 'z'));
        #implode(glue, pieces) = Join array elements with a glue string.
        #strlen() = Returns the length of the given string.
        #range() = Create an array containing a range of elements from "0" to "5".
        for($i = 0; $i < 24; $i++) {
            $salt .= $alphaNumeric[rand(0, strlen($alphaNumeric) - 1)];
        }
        return $salt;
    }
}

?>