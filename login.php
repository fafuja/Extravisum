<?php session_start(); ?>
<?php 
    include "./inc/db.php"; 
    include "./inc/hash.php";   

    $conn = new ExtravisumDB(); 

    if ($conn->con_error) {
        echo '{ "id": "noconnection" }';
    }else{
        $user = isset($_GET['user'])?$_GET['user']: "";
        $pass = isset($_GET['pass'])?$_GET['pass']: "";
        $remember = isset($_GET['remember'])?$_GET['remember']: "yes";
        if($user != "" AND $pass != ""){
            $result = $conn->isRegistered($user);
            if($result){
                
                $hashpass = $conn->getPass($user, $pass);

                $hash = new Hash($pass, "compare", $hashpass);
                
                if($hash->getCompare()){
                    
                    $email = $conn->getEmail($user);
                    $_SESSION["user"] = $user;
                    $_SESSION["email"] = $email;
                    if($remember == "yes"){
                        $_SESSION["timeexpire"] = "none";
                        header('Location: https://extravisum.com/');
                    }else{
                        $_SESSION["time"] = time();
                        $_SESSION["timeexpire"] = $_SESSION["time"] + (30*60);
                        header('Location: https://extravisum.com/');
                    }
                    
                    

                }else{
                    session_destroy();
                    header('Location: https://extravisum.com/?invalidpass=yes');
                }


            }else{
                session_destroy();
                header('Location: https://extravisum.com/?invaliduser=yes');
            }
        }else{
            session_destroy();
            header('Location: https://extravisum.com/');
        }
    }

?>