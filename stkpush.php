<?php
include "auth.php";

$processrequestUrl = "https://sandbox.safaricom.co.ke/mpesa/stkpush/v1/processrequest";
$callbackUrl = "https://a2d6-41-139-192-199.ngrok-free.app/Daraja%20API/callback.php"; //getting the link from ngrok
$passkey = "bfb279f9aa9bdbcf158e97dd71a467cd2e0c893059b10f78e6b72ada1ed2c919";
$businessShortCode = 174379;
$timestamp = date("YmdHis");
$password = base64_encode($businessShortCode.$passkey.$timestamp);
$phone = 254714263898;
$money = '1';
$partyA = $phone;
$partyB = $businessShortCode;
$accountReference = "ACELTD";
$transactionDescription = "API test";
$stkpushHeader = [
  // "Content-Type: application/json",
  "Authorization: Bearer ".$accessToken
];

$amount = $money;

$stkCurl = curl_init();
curl_setopt($stkCurl, CURLOPT_URL, $processrequestUrl);
curl_setopt($stkCurl, CURLOPT_HTTPHEADER, $stkpushHeader);

$curlPostData = array(
  "BusinessShortCode" => "$businessShortCode",
  "Password" => "$password",
  "Timestamp" => "$timestamp",
  "TransactionType" => "CustomerPayBillOnline",
  "Amount" => "$amount",
  "PartyA" => "$partyA",
  "PartyB" => "$partyB",
  "PhoneNumber" => "$partyA",
  "CallBackURL" => "$callbackUrl",
  "AccountReference" => "$accountReference",
  "TransactionDesc" => "$transactionDescription" 
);

curl_setopt($ch, CURLOPT_POST, TRUE);
curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($curlPostData));
curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE);

$stkResponse = curl_exec($stkCurl);

curl_close($stkCurl);

$stkData = json_decode($stkResponse);

echo $stkData;