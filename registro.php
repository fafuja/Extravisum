<?php 
    include "./inc/db.php";  
    
    if ($conn->connect_error) {
        echo '{ "return": "erroconexcao" }';
    }else{
        $user = isset($_POST['user'])?$_POST['user']: "fafuja" ;
        $pass = isset($_POST['pass'])?$_POST['user']: "" ;
        $email = isset($_POST['email'])?$_POST['user']: "" ;
    
        $result = $conn->query("SELECT * FROM nlogin WHERE name=".$user);
        if ($result->num_rows > 0 ) {
            echo '{ "return": "usuarioinvalido" }';
        }
    }


?>
