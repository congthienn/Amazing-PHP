<?php
    $server_name = 'localhost';
    $user_name = 'root';
    $password = '';
    $db = 'quanlydathang';
    $conn = mysqli_connect($server_name,$user_name,$password,$db);
    mysqli_set_charset($conn,'UTF8');
    
?>