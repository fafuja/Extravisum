<?php 

$currentsite = isset($_GET['site'])?$_GET['site']: "";

if ($currentsite == "") {
    session_start();
    // remove all session variables
    session_unset();

    // destroy the session
    session_destroy();
    header('Location: https://extravisum.com/');
}else{
    session_start();
    // remove all session variables
    session_unset();

    // destroy the session
    session_destroy();
    header('Location: '.$currentsite);
}

?>