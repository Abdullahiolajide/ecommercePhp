<?php
     require 'headers.php';
     require 'connect.php';
     session_start();

    $listQuery = "SELECT 
    DISTINCT(orders_table.created_at),
    products_table.product_image,
    COUNT(orders_table.created_at) AS amount_of_items,
    customers_table.email, 
    SUM(products_table.sale_price) AS price_total
    FROM orders_table 
    JOIN products_table 
        ON orders_table.product_id = products_table.product_id  
        AND orders_table.seller_id = products_table.seller_id  
    JOIN customers_table 
        ON orders_table.customer_id = customers_table.customer_id
        
        WHERE orders_table.customer_id =?
    
    GROUP BY orders_table.created_at
    ORDER BY orders_table.created_at DESC";
    $id = $_SESSION['customer_id'];
    $prepareListQuery = $connect->prepare($listQuery);
    $prepareListQuery->bind_param('i',$id);
    $execute = $prepareListQuery->execute();

    $listResult = $prepareListQuery->get_result();
    $listData = $listResult->fetch_all(MYSQLI_ASSOC);

    echo json_encode($listData);


?>