<?php

    header('Content-Type: application/json');

    date_default_timezone_set("Europe/Tallinn");
    $date_time = date("d.m.Y H:i");
    
    $responseArray = array(
        "date_time_EE" => $date_time
    );

    $jsonResponse = json_encode($responseArray);

    echo $jsonResponse;

?>