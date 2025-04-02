<?php
     require 'headers.php';
     require 'connect.php';
     session_start();

    $ordersQuery = "SELECT 
    DISTINCT(orders_table.product_id),
    products_table.product_image,
    orders_table.seller_id, 
    orders_table.product_name, 
    products_table.price,
    products_table.sale_price,
    COUNT(orders_table.product_id) AS quantity,
    customers_table.email, 
    orders_table.created_at
    FROM orders_table 
    JOIN products_table 
        ON orders_table.product_id = products_table.product_id  
        AND orders_table.seller_id = products_table.seller_id  
    JOIN customers_table 
        ON orders_table.customer_id = customers_table.customer_id
        
    WHERE orders_table.customer_id =?
    GROUP BY orders_table.product_id, orders_table.customer_id 
    ORDER BY orders_table.created_at DESC";

if ($_SESSION['customer_id'] !== 0 || $_SESSION['customer_id'] !== null) {
    $response = [
        "status"=> false,
        "message"=> "user not signed in"
        
    ];
    // echo json_encode($_SESSION['customer_id']);
    $id = $_SESSION['customer_id'];
        $prepareOrdersQuery = $connect->prepare($ordersQuery);
        $prepareOrdersQuery->bind_param("i", $id);
        $execute = $prepareOrdersQuery->execute();
        $orderResult = $prepareOrdersQuery->get_result();
        $orderData = $orderResult->fetch_all(MYSQLI_ASSOC);
        echo json_encode($orderData);
    return;
}else{
      
            $response = [
                "status"=> false,
                "message"=> "not executed"
                
            ];
            echo json_encode($response);

    }

    // echo json_encode($_SESSION['customer_id']);
?>