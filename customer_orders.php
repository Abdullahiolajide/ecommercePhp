<?php
   require 'headers.php';
   require 'connect.php';
   session_start();


    $getCustomerOrders = "SELECT 
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

    

    $prepareGet = $connect->prepare($getCustomerOrders);
    $prepareGet->bind_param('i', $_SESSION['customer_id']);
    $execute = $prepareGet->execute();

    $rowInfo = $prepareGet->get_result();
    $rowData = $rowInfo->fetch_all(MYSQLI_ASSOC);
    // echo json_encode($prepareGet->get_result()->fetch_all(MYSQLI_ASSOC));
    echo json_encode($rowData)
    

    ?>