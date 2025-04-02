<?php
     require 'headers.php';
     require 'connect.php';
     session_start();
    $sellerId = $_SESSION['seller_id'];

    $getProfile = "SELECT * FROM `sellers_table` WHERE `seller_id` =?";
    $prepareProfile = $connect->prepare($getProfile);
    $prepareProfile->bind_param('i', $sellerId);
    $executeProfile = $prepareProfile->execute();

    if($executeProfile){
        $reponse = [
            'status'=> true,
            'message'=> 'Profile gotten',
            'profile_info'=> $prepareProfile->get_result()->fetch_assoc(),
            'id'=> $sellerId

        ];
        echo json_encode($reponse);
    }else{
        $reponse = [
            'status'=> false,
            'message'=> 'Profile gotten'

        ];
        echo json_encode($reponse);

    }
?>