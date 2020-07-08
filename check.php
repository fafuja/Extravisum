<?php
    include "./inc/db.php"; 
    include "./inc/hash.php";   
    $conn = new ExtravisumDB(); 
    
    if ($conn->con_error) {
        echo '{ "id": "noconnection" }';
    }else{
        $user = isset($_GET['user'])?$_GET['user']: "";
        $pass = isset($_GET['pass'])?$_GET['pass']: "";
        $email = isset($_GET['email'])?$_GET['email']: "";
        $ip = $_SERVER['REMOTE_ADDR'];
        if($user != "" AND $pass != "" AND $email != ""){
           
            $json = file_get_contents("https://api.mojang.com/users/profiles/minecraft/".$user);
            $id = json_decode($json);
            if(!$id->id) {
                echo '{ "id": "nouserfound" }';
            }else{
                $_user = strtolower($user);
                $result = $conn->isRegistered($user);
                if ($result) {
                    echo '{ "id": "invaliduser" }';
                }else{
                    $ipused = $conn->isIpUsed($ip);
                    if($ipused){
                        echo '{ "id": "ipused" }';
                    }else{
                        $hash = new Hash($pass,"generate");
                        $pass = $hash->getNewpass();
                        
                        $register = $conn->register($_user, $user, $pass, $ip, $email);
                        echo '{ "id": "registered" }';
                        //echo '{ "id": "'.$id->id.'", "name": "'.$id->name.'" }';
                    }
                }
            }
        
        }else{
            
            header('Location: https://extravisum.com/');
            //echo '{ "id": "nodata" }';
        }

    }
    
?>