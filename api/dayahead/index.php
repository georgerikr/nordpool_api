<?php

include("../api_day-ahead.php");

header('Content-Type: application/json');


// This line is needed, if you modified the timezone in api_current.php to output the correct timestamps
// date_default_timezone_set("Europe/Tallinn");


$responseArray = array();

foreach ($ee_data as $data) {
    $da_epoch_timestamp = $data->timestamp;
    $da_price_mwh = $data->price;

    $da_price_kwh = round($da_price_mwh / 1000, 2);
    $da_timestamp = date("d.m H:i", $da_epoch_timestamp);

    $responseArray[] = array(
        "timestamp" => $da_timestamp,
        "price_mwh" => $da_price_mwh,
        "price_kwh" => $da_price_kwh,
    );
}

$jsonResponse = json_encode($responseArray);

echo $jsonResponse;

?>