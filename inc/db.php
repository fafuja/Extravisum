<?php 

class ExtravisumDB{
    private $dbhost = "localhost";
    private $dbuser = "";
    private $dbpass = "";
    private $dbname = "";

    public $connection;
    public $con_error = false;

    public function __construct(){
        
        $this->connection = new mysqli($this->dbhost, $this->dbuser, $this->dbpass, $this->dbname);
        if($this->connection->connect_error){
            $this->$con_error = true;
        }
    } 

    public function isRegistered($user){
        $sql = "SELECT * FROM nlogin WHERE name='{$user}'";
        $query = mysqli_query($this->connection, $sql);
        $registered = false;
        if (mysqli_num_rows($query) > 0) {
            $registered = true;
        }
        return $registered;
    }

    public function isIpUsed($ip){
        $sql = "SELECT * FROM nlogin WHERE address='{$ip}'";
        $query = mysqli_query($this->connection, $sql);
        $registered = false;
        if (mysqli_num_rows($query) > 0) {
            $registered = true;
        }
        return $registered;
    }


    public function register($name, $realname, $pass, $ip, $email){
        $name =  addslashes($name);
        $realname =  addslashes($realname);
        $pass =  addslashes($pass);
        $ip =  addslashes($ip);
        $email =  addslashes($email);
        $sql = "INSERT INTO nlogin (name, realname, password, address, email, settings) VALUES ('{$name}', '{$realname}', '{$pass}', '{$ip}', '{$email}', 'LvK0K3NNrKgi7lUTYU/m4EPtgu/Jek+pEVT1vNtwMSO5NTetZyG5bqYheH8Pd9Qn')";
        return $this->connection->query($sql);
    }

    public function getPass($user){
        $sql = "SELECT password FROM nlogin WHERE name='".$user."'";
        $result = $this->connection->query($sql);
        $dbpass = $result->fetch_array(MYSQLI_ASSOC)["password"];
        
        return $dbpass;
    }
    public function getEmail($user){
        $sql = "SELECT email FROM nlogin WHERE name='".$user."'";
        $result = $this->connection->query($sql);
        $email = $result->fetch_array(MYSQLI_ASSOC)["email"];
        
        return $email;
    }
    public function getUserByReference($reference){
        $sql = "SELECT user FROM shopping_info WHERE ref='".$reference."' LIMIT 1";
        $result = $this->connection->query($sql);
        $user = $result->fetch_array(MYSQLI_ASSOC)["user"];
        $sql = "SELECT name FROM nlogin WHERE id='".$user."'";
        $result = $this->connection->query($sql);
        $user = $result->fetch_array(MYSQLI_ASSOC)["name"];
        return $user;
    }
    public function updateEmail($user, $email){
        $sql = "UPDATE nlogin SET email='{$email}' WHERE name='{$user}'";
        return $this->connection->query($sql);
    }
    public function getUserId($user){
        $sql = $sql = "SELECT id FROM nlogin WHERE name='".$user."'";
        $result = $this->connection->query($sql);
        $userid = $result->fetch_array(MYSQLI_ASSOC)["id"];
        return $userid;
    }
    public function getProductInfo($productid){
        $sql = $sql = "SELECT * FROM products WHERE id='{$productid}'";
        $result = $this->connection->query($sql);
        $product = $result->fetch_array(MYSQLI_ASSOC);
        return $product;
    }
    public function getProducts(){
        $sql = "SELECT * FROM products";
        $result = $this->connection->query($sql);
        $products = $result->fetch_all(MYSQLI_ASSOC);
        return $products;
    }
    public function getProductsCheckout($user){
        $sql = "SELECT DISTINCT usercheckout.product FROM usercheckout INNER JOIN nlogin ON usercheckout.user = nlogin.id WHERE nlogin.id = {$user}";
        $result = $this->connection->query($sql);
        $products = $result->fetch_all(MYSQLI_ASSOC);
        return $products;
    }
   
    public function getProductsShip($user){
        $sql = "SELECT DISTINCT * FROM shopping_info INNER JOIN nlogin ON shopping_info.user = nlogin.id WHERE nlogin.id = {$user}";
        $result = $this->connection->query($sql);
        $products = $result->fetch_all(MYSQLI_ASSOC);
        return $products;
    }
    
    public function getTotalProductsCheckout($user){
        $sql = "SELECT usercheckout.product FROM usercheckout INNER JOIN nlogin ON usercheckout.user = nlogin.id WHERE nlogin.id = {$user}";
        $result = $this->connection->query($sql);
        $products = $result->fetch_all(MYSQLI_ASSOC);
        return $products;
    }
    public function getProductTotalCheckout($user, $productid){
        $sql = "SELECT usercheckout.product FROM usercheckout INNER JOIN nlogin ON usercheckout.user = nlogin.id WHERE nlogin.id = {$user} AND usercheckout.product ='{$productid}'";
        $result = $this->connection->query($sql);
        $products = $result->fetch_all(MYSQLI_ASSOC);
        return $products;
    }
    public function addProductsCheckout($user, $productid){
        $userid = self::getUserId($user);
        $sql = "INSERT INTO usercheckout (user, product) VALUES ('{$userid}', '{$productid}')";
        return $this->connection->query($sql);
    }
    public function addShoppingInfo($ref, $user, $productid, $price, $quantity, $status, $initialdate, $updatedate){
       
        $sql = "INSERT INTO shopping_info (ref, user, product, price, quantity, status, initialdate, updatedate) VALUES ('{$ref}', '{$user}', '{$productid}', '{$price}', '{$quantity}', '{$status}', '{$initialdate}','$updatedate')";
        return $this->connection->query($sql);
    }
    public function deleteSpecifiedProducts($user, $productid){
        $userid = self::getUserId($user);
        $sql = "DELETE FROM usercheckout WHERE user='{$userid}' AND product='{$productid}'";
        return $this->connection->query($sql);
    }

    public function deleteSpecifiedProduct($user, $productid){
        $userid = self::getUserId($user);
        $sql = "DELETE FROM usercheckout WHERE user='{$userid}' AND product='{$productid}' LIMIT 1";
        return $this->connection->query($sql);
    }
    public function deleteCheckoutProducts($user){
        $userid = self::getUserId($user);
        $sql = "DELETE FROM usercheckout WHERE user='{$userid}'";
        return $this->connection->query($sql);
    }

    public function checkUser($user){
        
        $sql = "SELECT * FROM nlogin WHERE name='".$user."'";
        $query = mysqli_query($this->connection, $sql);
        $registered = false;
        if (mysqli_num_rows($query) > 0) {
            $registered = true;
        }
        return $registered;
    }

    public function updateShipInfo($ref, $status, $updatedate){
        
        $sql = "UPDATE shopping_info SET status='{$status}', updatedate='{$updatedate}' WHERE ref='".$ref."'";
        return $this->connection->query($sql);
    }

    public function updateShipCode($ref, $code){
        
        $sql = "UPDATE shopping_info SET code='{$code}' WHERE ref='".$ref."'";
        return $this->connection->query($sql);
    }

    

}

?>