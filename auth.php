<?php
$consumerKey = ""; //Paste your consumer key here
$consumerSecret = ""; //Paste your consumer secret here
$apiUrl = "https://sandbox.safaricom.co.ke/oauth/v1/generate?grant_type=client_credentials";
$headers = [
    'Content-Type:application/json; charset=utf8'
    ];

$ch = curl_init($apiUrl);
curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
curl_setopt($ch, CURLOPT_HEADER, 0);
curl_setopt($ch, CURLOPT_USERPWD, $consumerKey.":".$consumerSecret);

$tokenResponse = curl_exec($ch);
curl_close($ch);

$data = json_decode($tokenResponse);

$accessToken = $data->access_token;

echo "Access token is: ".$accessToken."<br>";   //make sure it returns the Access token