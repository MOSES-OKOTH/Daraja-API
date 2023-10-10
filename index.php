<?php
include 'auth.php';

date_default_timezone_set('Africa/Nairobi');

if(isset($_POST['phone']) && isset($_POST['amount'])){
  $phone = $_POST['phone'];
  $Amount = $_POST['amount'];

  $processrequestUrl = 'https://sandbox.safaricom.co.ke/mpesa/stkpush/v1/processrequest';
  $callbackurl = 'https://6c26-154-159-237-174.ngrok-free.app/Daraja-API/callback.php'; //get from ngrok
  $passkey = "bfb279f9aa9bdbcf158e97dd71a467cd2e0c893059b10f78e6b72ada1ed2c919";
  $BusinessShortCode = '174379';
  $Timestamp = date('YmdHis');

  $Password = base64_encode($BusinessShortCode . $passkey . $Timestamp);
  $AccountReference = 'ACE SOFTWARES';
  $TransactionDesc = 'stkpush test';
  $stkpushheader = ['Content-Type:application/json', 'Authorization:Bearer ' . $access_token];


  $curl = curl_init();
  curl_setopt($curl, CURLOPT_URL, $processrequestUrl);
  curl_setopt($curl, CURLOPT_HTTPHEADER, $stkpushheader); //setting custom header
  $curl_post_data = array(
    'BusinessShortCode' => $BusinessShortCode,
    'Password' => $Password,
    'Timestamp' => $Timestamp,
    'TransactionType' => 'CustomerPayBillOnline',
    'Amount' => $Amount,
    'PartyA' => $phone,
    'PartyB' => $BusinessShortCode,
    'PhoneNumber' => $phone,
    'CallBackURL' => $callbackurl,
    'AccountReference' => $AccountReference,
    'TransactionDesc' => $TransactionDesc
  );

  $data_string = json_encode($curl_post_data);
  curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
  curl_setopt($curl, CURLOPT_POST, true);
  curl_setopt($curl, CURLOPT_POSTFIELDS, $data_string);
  $curl_response = curl_exec($curl);

  $data = json_decode($curl_response);
  $CheckoutRequestID = $data->CheckoutRequestID;
  $ResponseCode = $data->ResponseCode;
  if ($ResponseCode == "0") {
    echo "The CheckoutRequestID for this transaction is : " . $CheckoutRequestID;
  } else{
    echo $ResponseCode."An error occured!";
  }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link rel="stylesheet" href="styles.css">
  <title>ACE PAY | Mpesa</title>
</head>
<body>
  <div id="notification">

  </div>

  <section class='container'>
    <center>
      <div id='form'>
        <form class='grid' action="" method='POST'>
          <div class="grid-1-1 title">
            <h1>ACE PAY</h1>
            <h4>| Powered By Mpesa</h4>
            <h6>Made with love by <a href="https://github.com/MOSES-OKOTH">Moses Okoth</a></h6>
          </div>

          <div class="grid-1-2 main">
            <p>Phone Number</p>
            <p id='phone'>
              <!-- <span>+254</span> -->
              <input type="text" name='phone' placeholder="Phone number 2547********" required>
            </p>

            <p>Amount</p>
            <input type="number" min='1' value='1' name='amount' placeholder="Enter the amount" required> <br> <br>

            <button type='submit' onclick="clicked()">Pay Now</button>
          </div>
        </form>
      </div>
    </center>
  </section>

  <script>
    function clicked(){
      let notification = document.getElementById('notification');

      notification.style = "display: block;";

      let myDiv = document.createElement('div');
      myDiv.classList.add('notify');

      myDiv.innerHTML = "<p>Enter your Mpesa PIN to compelete the payment";

      notification.appendChild(myDiv);

      window.setInterval(() => {
        myDiv.style = "display: none;";
      }, 5500);
    }
  </script>
</body>
</html>