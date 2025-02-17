<?php

  include("env.php");


  $sharedSecret = getenv("TYL_SECRET");
  $storename = getenv("TYL_STORE");
  $baseURL =  getenv("BASE_URL") || "http://localhost:8080";

  $timezone= "Europe/London";
  $txntype= "sale";
  $checkoutoption = "combinedpage";
  $chargetotal = "13.00";
  $currency = "826";
  $hash_algorithm = "HMACSHA256";
  $oid = random_int(100, 999) . "-" .random_int(100, 999);

  $txndatetime = getDateTime();
  // $txndatetime = "2025:02:17-07:29:18";


  $responseFailURL = sprintf("%s/fail.php", $baseURL);
  $responseSuccessURL = sprintf("%s/succuss", $baseURL);
  $transactionNotificationURL = sprintf("%s/notify.php", $baseURL);

  $separator = "|";

  $fields = array(
    "chargetotal"                => $chargetotal,
    "checkoutoption"             => $checkoutoption,
    "currency"                   => $currency,
    "hash_algorithm"             => $hash_algorithm,
    "oid"                        => $oid,
    "responseFailURL"            => $responseFailURL,
    "responseSuccessURL"         => $responseSuccessURL,
    "storename"                  => $storename,
    "timezone"                   => $timezone,
    "transactionNotificationURL" => $transactionNotificationURL,
    "txndatetime"                => $txndatetime,
    "txntype"                    => $txntype,
  );

  $stringToHash = implode($separator, array_values($fields));
  $separator = "|";
  $hashExtended = createHash($stringToHash, $sharedSecret);

  $fields["hashExtended"] = $hashExtended;

  function getDateTime() {
    // YYYY:MM:DD-hh:mm:ss
    return date("Y:m:d-H:i:s");
  }

  function createHash($stringToHash, $sharedSecret) {
    return base64_encode(hash_hmac('sha256', $stringToHash, $sharedSecret, true));
  }

?>
<!DOCTYPE HTML>
<html>
<head>
  <title>Tyl example for PHP</title>
  <style type="text/css">
    input {
      padding: 2px 10px;
      width: 400px;
    }
  </style>
</head>
<body>
  <p>
    <h1>Order Form</h1>
    <h2>Payment Form</h2>
    <!-- <pre><?=print_r($fields, 1)?></pre> -->

    <form method="post" action="https://test.ipg-online.com/connect/gateway/processing">

        <?php foreach($fields as $key => $value) { ?>
        <input type="text" disabled name="<?=$key?>" id=<?=$key?> value="<?=$value?>"><br>

        <?php }?>
        <br>
       <input type="submit" id="submit" value="Submit" />
    </form> 

    <br>

    <hr>

    <h2>Combined fields</h2>
    <textarea style="width: 800px; height: 100px;" disabled><?=sprintf("%s", $stringToHash);?></textarea>
    <br>
    <!-- <h2>Shared secret</h2> -->
    <!-- <textarea style="width: 800px; height: 30px;" disabled><?=sprintf("%s", $sharedSecret);?></textarea> -->
    <h2>Extended hash</h2>
    <textarea style="width: 800px; height: 30px;" disabled><?=sprintf("%s", $hashExtended);?></textarea>


  </body>
</html>