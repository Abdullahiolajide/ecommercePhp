<?php
     require 'headers.php';
     require 'connect.php';
     session_start();

    $data = json_decode(file_get_contents('php://input'));
    $orderArray = $data->storedOrders;
    $orderQuery = "INSERT INTO `orders_table`(`product_id`, `seller_id`, `product_name`, `customer_id`) VALUES (?,?,?,?)";
    for ($i=0; $i < count($orderArray); $i++) { 
    $prepareOrder = $connect->prepare($orderQuery);
    $prepareOrder->bind_param('iisi', $orderArray[$i]->productId, $orderArray[$i]->sellerId, $orderArray[$i]->productName, $_SESSION['customer_id']);
    $executed = $prepareOrder->execute();
    }

    if ($executed) {
        $response = [
            "status" => true,
            "message" => "Order Placed Successfully"
        ];

        echo json_encode($response);
    }else{
        $response = [
            "status" => false,
            "message" => "Order failed"
        ];

        echo json_encode($response);
    }
?>