<?php
    $cvv_card = $_GET["cvv_card"];
    if (preg_match("/^[0-9]{3}$/",$cvv_card)) {
        echo "true";
    } else {
        echo "false";
    }
?>