<?php

include("../api_current.php");

header('Content-Type: application/json');

$user_price_limit = 0.0;

if (!$_SESSION) {
    $_SESSION["price_limit"] = 0.0;
} 


if ($_SERVER["REQUEST_METHOD"] === "POST") {

    $user_price_limit = floatval($_POST['price_limit']);

    $_SESSION["price_limit"] = $user_price_limit;

    if (!$user_price_limit) {

        $response = array(
            "message" => "Sisestage hinnalimiit"
        );

        $json_response = json_encode($response);

        echo $json_response;
        
    } else {

        $response = array(
            "message" => "Teie limiit: " . $user_price_limit . "€/MWh"
        );
    
        $json_response = json_encode($response);
    
        echo $json_response;

    }
    
}

$user_price_limit = $_SESSION["price_limit"];

if ($_SERVER["REQUEST_METHOD"] === "GET") {


    if (!$user_price_limit) {
        
        $response = array(
            "message" => ""
        );

        $json_response = json_encode($response);

        echo $json_response;

    } else {

        if ($current_price_mwh > $user_price_limit) {

            $price_difference = round($current_price_mwh - $user_price_limit, 2);

            $response = array(
                "message" => "Hetkehind (" . $current_price_mwh . "€/MWh) ületab Teie hinnalimiiti (" . $user_price_limit . "€/MWh) " . $price_difference . "€/MWh võrra."
            );


            $json_response = json_encode($response);

            echo $json_response;

        } else if ($current_price_mwh === $user_price_limit) {

            $response = array(
                "message" => "Hetkehind on sama mis Teie hinnalimiit."
            );
    
            $json_response = json_encode($response);
    
            echo $json_response;

        } else {

            $response = array(
                "message" => "Hetkehind on odavam kui Teie hinnalimiit."
            );
    
            $json_response = json_encode($response);
    
            echo $json_response;

        }

    }

}


?>