<?php

include("../api_day-ahead.php");

header('Content-Type: application/json');

$responseArray = array(
    "timestamp" => $next_epoch_timestamp,
    "next_hour_timestamp_EE" => $next_timestamp,
    "next_hour_price_EE_in_MWh" => $next_price_mwh,
    "next_hour_price_EE_in_kWh" => $next_price_kwh,
    "message" => "Kell " . $next_timestamp . " on elektri jooksva tunni hind Eestis " . $next_price_mwh . "€/MWh - " . $next_price_kwh . "€/kWh"
);

$jsonResponse = json_encode($responseArray);

echo $jsonResponse;

?>