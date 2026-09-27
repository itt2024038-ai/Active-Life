<?php
if  (session_status() ===PHP_SESSION_NONE){
    session_start();
}

function is_authenticated(){
    return isset($_SESSION['user_id']);
}

function require_login(){
    if(!is_authenticated()){
        header ("Location:../auth/login.php");
        exit();
    }
}
?>
