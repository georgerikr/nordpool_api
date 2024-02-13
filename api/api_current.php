<?php
// Request URL for current NordPool EE stock market price
// https://dashboard.elering.ee/api/nps/price/EE/current

session_start();

date_default_timezone_set("Europe/Tallinn");

$curl = curl_init();

curl_setopt_array($curl, array(
  CURLOPT_URL => 'https://dashboard.elering.ee/api/nps/price/EE/current',
  CURLOPT_RETURNTRANSFER => true,
  CURLOPT_ENCODING => '',
  CURLOPT_MAXREDIRS => 10,
  CURLOPT_TIMEOUT => 0,
  CURLOPT_FOLLOWLOCATION => true,
  CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
  CURLOPT_CUSTOMREQUEST => 'GET',
  CURLOPT_HTTPHEADER => array(
    'Cookie: _csrf=196f1808-4c25-44ef-b6ba-a1a2e1061219'
  ),
));

$response = curl_exec($curl);

curl_close($curl);

$decoded_response = json_decode($response);
$current_price_mwh = $decoded_response->data[0]->price;
$current_price_kwh = $current_price_mwh / 1000;
$epoch_timestamp = $decoded_response->data[0]->timestamp;
$current_timestamp = date("H", $epoch_timestamp);
$current_date = date("d.m.y");
$current_time = date("H:i");


?>