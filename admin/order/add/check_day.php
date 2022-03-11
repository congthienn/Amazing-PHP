<?php
    include_once __DIR__ . '/../../connect_db.php';
    $delivery_date = $_GET['delivery_date'];
    date_default_timezone_set("Asia/Ho_Chi_Minh");
    $now_date = date("Y-m-d",time());
    if(strtotime($delivery_date) > strtotime($now_date)){
        echo "true";
    }else{
        echo "false";
    }
?>