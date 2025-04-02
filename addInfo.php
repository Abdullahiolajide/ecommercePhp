<?php
     require 'headers.php';
     require 'connect.php';
     session_start();

     $sellerId = $_SESSION['seller_id'];

     $additionalInfo = json_decode(file_get_contents('php://input'));
     $address = $additionalInfo->address;
     $phoneNumber = $additionalInfo->phone_number;
     $zipcode = $additionalInfo->zipcode;

     $addInfoQuery = "UPDATE `sellers_table` SET `phone_number`=?,`address`=?, `zipcode`=? WHERE `seller_id` =?";
     $prepareAdd = $connect->prepare($addInfoQuery);
     $prepareAdd->bind_param('sssi', $phoneNumber, $address, $zipcode, $sellerId);
     $executeAdd = $prepareAdd->execute();

     if($executeAdd){
        $response = [
            'status'=> true,
            'meaasge'=>'Added additional Info'
        ];
        echo json_encode($response);
    }else{
        $response = [
            'status'=> false,
            'meaasge'=>'Unable to add additional Info'
        ];
        echo json_encode($response);
     }


?>