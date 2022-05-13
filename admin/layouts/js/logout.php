<?php
    if(session_id() === ''){
        session_start();
    }
    include_once __DIR__ . '/../../connect_db.php';
    setcookie("Staff",$_SESSION['staff'],time()-60,'/');
    setcookie("Email_staff",$_SESSION['email_staff'],time()-60,'/');
    unset($_SESSION['staff']);
    unset($_SESSION['email_staff']);
?>