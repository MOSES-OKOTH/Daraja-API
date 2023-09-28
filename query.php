<?php
include "stkpush.php";

$queryUrl = 'https://sandbox.safaricom.co.ke/mpesa/stkpushquery/v1/query';
$queryuHeader = [
  'Content-Type: application/json',
  'Authorization: Bearer ogeS4nXAWTBCXDIGCuJXLxdXh4H4'
];

$transactionResponseData = array(
  "BusinessShortCode" => 174379,
  "Password" => "MTc0Mzc5YmZiMjc5ZjlhYTliZGJjZjE1OGU5N2RkNzFhNDY3Y2QyZTBjODkzMDU5YjEwZjc4ZTZiNzJhZGExZWQyYzkxOTIwMjMwOTE2MTc0MjAw",
  "Timestamp" => "20230916174200",
  "CheckoutRequestID" => "ws_CO_16092023142129026708374149",
);

$queryCurl = curl_init($queryUrl);
curl_setopt($queryCurl, CURLOPT_HTTPHEADER, $queryuHeader);
curl_setopt($queryCurl, CURLOPT_POST, TRUE);
curl_setopt($queryCurl, CURLOPT_POSTFIELDS, json_encode($transactionResponseData));

curl_setopt($queryCurl, CURLOPT_RETURNTRANSFER, TRUE);
$queryResponse = curl_exec($queryCurl);
curl_close($queryCurl);

echo "\n".$queryResponse;