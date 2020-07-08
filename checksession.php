<?php 
$expiretime = isset($_SESSION["timeexpire"])?$_SESSION["timeexpire"]: "none";
if($expiretime == "none"){

}else{
    if(time() > $_SESSION["timeexpire"]){
        session_start();
        // remove all session variables
        session_unset();
    
        // destroy the session
        session_destroy();
        
    }
}


?>