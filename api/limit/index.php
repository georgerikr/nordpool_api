<?php

include("../api_current.php");

header('Content-Type: application/json');

if ($_SERVER["REQUEST_METHOD"] === "GET") {

    if (!$_SESSION) {

        $response = array(
            "message" => ""
        );

        $json_response = json_encode($response);

        echo $json_response;
        
    } else {

        $response = array(
            "message" => "Teie limiit: " . $_SESSION["price_limit"] . "€/MWh"
        );
    
        $json_response = json_encode($response);
    
        echo $json_response;
        
    }
    
}


?>