<?php 
    require 'headers.php';
    require 'connect.php';
    session_start();
    $sellerId = $_SESSION['seller_id'];

      $getProducts = "SELECT * FROM `products_table` WHERE `seller_id`=?";
      $prepareGetProducts = $connect->prepare($getProducts);
      $prepareGetProducts->bind_param('i', $sellerId);
      $executeGetProducts = $prepareGetProducts->execute();

      if($executeGetProducts){
        $productRow = $prepareGetProducts->get_result();
        $product = $productRow->fetch_all(MYSQLI_ASSOC);
        $response = [
            'status'=> true,
            'meaasge'=> 'Products Retrieved Successfully'
        ];
        echo json_encode($product);
      }else{
        $response = [
            'status'=> false,
            'meaasge'=> 'Error Retrieving Products'
        ];
        echo json_encode($response);

      }
      
      ?>