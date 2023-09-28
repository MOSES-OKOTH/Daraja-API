<?php
include "auth.php";
date_default_timezone_set('Africa/Nairobi');

if(isset($_POST['phone'])){
  //variables from the form - by the user
  $phoneNumber = $_POST['phone'];
  $accountNumber = $_POST['acc'];


  //API request variables
  $processrequestUrl = "https://sandbox.safaricom.co.ke/mpesa/stkpush/v1/processrequest";
  $callbackUrl = "https://9ab3-154-159-237-185.ngrok-free.app/Daraja-API/callback.php"; //get the link from ngrok
  $passkey = "bfb279f9aa9bdbcf158e97dd71a467cd2e0c893059b10f78e6b72ada1ed2c919";
  $businessShortCode = 174379;
  $timestamp = date("YmdHis");
  $password = base64_encode($businessShortCode.$passkey.$timestamp);
  $amount = 1;
  $accountReference = $accountNumber;
  $transactionDescription = 'API Test';
  $stkpushHeader = [
    'Authorization: Bearer '.$accessToken
    // "Content-Type: application/json"
  ];

  $stkCurl = curl_init();
  curl_setopt($stkCurl, CURLOPT_URL, $processrequestUrl);
  curl_setopt($stkCurl, CURLOPT_HTTPHEADER, $stkpushHeader);

  $curlPostData = array(
    "BusinessShortCode" => "$businessShortCode",
    "Password" => "$password",
    "Timestamp" => "$timestamp",
    "TransactionType" => "CustomerPayBillOnline",
    "Amount" => "$amount",
    "PartyA" => "$phoneNumber",
    "PartyB" => "$businessShortCode",
    "PhoneNumber" => "$phoneNumber",
    "CallBackURL" => "$callbackUrl",
    "AccountReference" => "$accountNumber",
    "TransactionDesc" => "$transactionDescription" 
  );

  curl_setopt($ch, CURLOPT_POST, 1);
  curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($curlPostData));
  curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);

  $stkResponse = curl_exec($stkCurl);

  curl_close($stkCurl);

  if($stkResponse){
    echo $stkResponse;
  } else{
    echo "An error occured when processing this payment";
  }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link rel="stylesheet" href="styles.css">
  <title>ACE Pay</title>
</head>
<body>
  <div id='form'>
    <form action="" method='POST'>
      <h1>Daraja API Test</h1> <br>

      <p>Enter Phone Number</p>
      <input type="text" min='12' max='12' name="phone" placeholder="Phone Number e.g 254*********"> <br> <br>

      <p>Account Number</p>
      <input type="text" max='13' name="acc" placeholder="Account Number"> <br> <br>

      <center>
        <button type='submit'>Pay</button>
      </center>
    </form>
  </div>
</body>
</html>