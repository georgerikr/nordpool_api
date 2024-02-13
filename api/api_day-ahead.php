<?php
// Request URL for NordPool day-ahead stock market prices for selected time period
// Accepted date formats are 'yyyy-MM-dd HH:mm', 'yyyy-MM-dd'T'hh:mm:ssZ'
// https://dashboard.elering.ee/api/nps/price?start=2024-02-08T20%3A59%3A59.999Z&end=2024-02-09T20%3A59%3A59.999Z


// This line might be needed if your webservers timezone is different from the one, we're using
// date_default_timezone_set('GMT-0');


$current_timestamp = time();
$end_timestamp = $current_timestamp + (2 * 24 * 3600);

$start_date = date('Y-m-d\TH:i:s\Z', $current_timestamp);
$end_date = date('Y-m-d\TH:i:s\Z', $end_timestamp);

$request_url = "https://dashboard.elering.ee/api/nps/price?start={$start_date}&end={$end_date}";

$curl = curl_init();

curl_setopt_array($curl, array(
  CURLOPT_URL => $request_url,
  CURLOPT_RETURNTRANSFER => true,
  CURLOPT_ENCODING => '',
  CURLOPT_MAXREDIRS => 10,
  CURLOPT_TIMEOUT => 0,
  CURLOPT_FOLLOWLOCATION => true,
  CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
  CURLOPT_CUSTOMREQUEST => 'GET',
  CURLOPT_HTTPHEADER => array(
    'Cookie: _csrf=07ff0dcc-58e3-454e-bca3-83f344e71add'
  ),
));

$response = curl_exec($curl);

curl_close($curl);

$decoded_response = json_decode($response);
$ee_data = $decoded_response->data->ee;

date_default_timezone_set('Europe/Tallinn');

$next_hour_data = $ee_data[0];
$next_price_mwh = $next_hour_data->price;
$next_price_kwh = $next_price_mwh / 1000;
$next_epoch_timestamp = $next_hour_data->timestamp;
$next_timestamp = date("H", $next_epoch_timestamp);

?>