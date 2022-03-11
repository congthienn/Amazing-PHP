<?php
    if(session_id() === ''){
        session_start();
    }
    include_once __DIR__ . '/../../../../Amazing-PHP/admin/connect_db.php';
    setcookie("User",$_SESSION['user'],time()-60,'/');
    setcookie("Email",$_SESSION['email'],time()-60,'/');
    setcookie("Staff",$_SESSION['staff'],time()-60,'/');
    unset($_SESSION['user']);
    unset($_SESSION['email']);
    unset($_SESSION['staff']);
?>