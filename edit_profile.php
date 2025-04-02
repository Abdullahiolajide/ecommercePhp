<?php
 require 'headers.php';
 require 'connect.php';
 session_start();

$sellerId = $_SESSION['seller_id'];

$values = json_decode(file_get_contents('php://input'));
$email = $values->email;
$phoneNumber = $values->phoneNumber;
$address = $values->address;
$zipcode = $values->zipcode;

$edit = "UPDATE `sellers_table` SET `email`=?,`phone_number`=?,`address`=?,`zipcode`=? WHERE `seller_id`=?";
$prepareEdit = $connect->prepare($edit);
$prepareEdit->bind_param('ssssi', $email, $phoneNumber, $address, $zipcode, $sellerId);
$executeEdit = $prepareEdit->execute();

if($executeEdit){
    $response = [
        'status'=> true,
        'meaasge'=> 'Edited Successfully'
    ];
    echo json_encode($response);
}else{
    $response = [
        'status'=> false,
        'meaasge'=> 'Not Edited'
    ];
    echo json_encode($response);
}
?>