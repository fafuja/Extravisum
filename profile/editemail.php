<?php session_start(); ?>
<?php 
    $initial_user = isset($_SESSION["user"])?$_SESSION["user"]:"";
    $editemail = isset($_GET["editemail"])?$_GET["editemail"]:"";
    require_once "../inc/db.php";
    if($initial_user != ""){
        
        if($editemail != ""){
            $_SESSION['email'] = $editemail;
            $db = new ExtravisumDB();
            $db->updateEmail($initial_user, $editemail);
            header("Location: https://extravisum.com/user/".$_SESSION['user']."/email");
        }else{
            header("Location: https://extravisum.com/user/".$_SESSION['user']."/email");
        }
    }else{
        header('Location: https://extravisum.com/');
    }
?>


