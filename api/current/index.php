<?php

include("../api_current.php");

header('Content-Type: application/json');

$responseArray = array(
    "timestamp" => $epoch_timestamp,
    "local_date_EE" => $current_date,
    "local_time_EE" => $current_time,
    "current_timestamp_EE" => $current_timestamp,
    "current_price_EE_in_MWh" => $current_price_mwh,
    "current_price_EE_in_kWh" => $current_price_kwh,
    "message" => "Kell " . $current_timestamp . " on elektri jooksva tunni hind Eestis " . $current_price_mwh . "€/MWh - " . $current_price_kwh . "€/kWh"
);

$jsonResponse = json_encode($responseArray);

echo $jsonResponse;

?>