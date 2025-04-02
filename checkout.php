<?php
 require 'headers.php';
 require 'connect.php';
 session_start();

 $data = json_decode(file_get_contents('php://input'));
//  print_r($data);
 $checkoutPrice = $data->cPrice;
 
 $customer_id = $_SESSION['customer_id'];

    $getUser = "SELECT * FROM `customers_table` WHERE `customer_id` =?";
  $prepareGet = $connect->prepare($getUser);
  $prepareGet->bind_param('i', $customer_id);
  $executeGet = $prepareGet->execute();
  $userRowInfo = $prepareGet->get_result();
  $userInfo = $userRowInfo->fetch_object();
  
 
 


  $url = "https://api.paystack.co/transaction/initialize";


  $fields = [
    'email' => $userInfo->email,
    'amount' => $checkoutPrice,
    'callback_url' => "http://localhost:4200/verify",
    'metadata' => ["cancel_action" => "http://localhost:4200/checkout"]
  ];

  $fields_string = http_build_query($fields);

  //open connection
  $ch = curl_init();
  
  //set the url, number of POST vars, POST data
  curl_setopt($ch,CURLOPT_URL, $url);
  curl_setopt($ch,CURLOPT_POST, true);
  curl_setopt($ch,CURLOPT_POSTFIELDS, $fields_string);
  curl_setopt($ch, CURLOPT_HTTPHEADER, array(
    "Authorization: Bearer sk_test_1f848f8494234b444c15182d4b4ce2c89c368ca4",
    "Cache-Control: no-cache",
  ));
  
  //So that curl_exec returns the contents of the cURL; rather than echoing it
  curl_setopt($ch,CURLOPT_RETURNTRANSFER, true); 
  
  //execute post
  $result = curl_exec($ch);
  echo $result;
?>