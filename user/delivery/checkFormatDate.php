<?php
    $date_card = $_GET["date_card"];
    if (preg_match("/^(0[1-9]|1[0-2])\/[0-9]{4}$/",$date_card)) {
        echo "true";
    } else {
        echo "false";
    }
?>