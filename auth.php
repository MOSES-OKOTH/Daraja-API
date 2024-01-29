<?php
$consumerKey = "voHidHuYSFiyPsomrRLAkMgiBFGtGKPR";
$consumerSecret = "D7scJI4Id1mA7uMG";

$access_token_url = 'https://sandbox.safaricom.co.ke/oauth/v1/generate?grant_type=client_credentials';

$curl = curl_init();
curl_setopt($curl, CURLOPT_URL, $access_token_url);
curl_setopt($curl, CURLOPT_HTTPHEADER, array(
    'Content-Type: application/json',
    'Charset: utf8',
    'Authorization: Basic '.base64_encode($consumerKey.':'.$consumerSecret)
));
curl_setopt($curl, CURLOPT_RETURNTRANSFER, TRUE);
// curl_setopt($curl, CURLOPT_HEADER, FALSE);
// curl_setopt($curl, CURLOPT_USERPWD, $consumerKey.':'.$consumerSecret);
$results = curl_exec($curl);
$status = curl_getinfo($curl, CURLINFO_HTTP_CODE);
$result = json_decode($results);
curl_close($curl);

if($status >= 200 && $status <= 299){
    // echo "Successful request";
    $access_token = $result->access_token;
    // echo "The access token is: ".$access_token;
} else if($status >= 400 && $status <= 499){
    echo "<h1>Client Side error! Unable to generate access token</h1>";
} else{
    echo "<h1>An unknown error occured while fetching the access token</h1>";
}