<?php
    require 'headers.php';
    require 'connect.php';
    session_start();

    $productIdObj = json_decode(file_get_contents('php://input'));
    $productId = $productIdObj->productId;

    $delete = "DELETE FROM `products_table` WHERE `product_id`=?";
    $prepareDelete = $connect->prepare($delete);
    $prepareDelete->bind_param('i', $productId);
    $executeDelete = $prepareDelete->execute();

    if ($executeDelete) {
        $response =[
            'status'=>true,
            'message'=>'Product deleted successfully'
        ];
        echo json_encode($response);
    }else{
        $response =[
            'status'=>false,
            'message'=>'Item not deleted'
        ];
        echo json_encode($response);
    }
?>