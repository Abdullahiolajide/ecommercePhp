<?php
        session_start();
        require 'connect.php';
        
        header('Access-Control-Allow-Origin:http://localhost:4200');
        header('Access-Control-Allow-Credentials: true');
        header('Access-Control-Allow-Headers:Content-Type');
        header('Content-Type:application/json');

        $data = json_decode(file_get_contents("php://input"));
        $time = $data->time;
        $itemsQuery = "SELECT 
    DISTINCT(orders_table.product_id),
    products_table.product_image,
    orders_table.seller_id, 
    orders_table.product_name, 
    products_table.price,
    products_table.sale_price,   SUM(products_table.sale_price) AS total,

    COUNT(orders_table.product_id) AS quantity,
    customers_table.email, 
    orders_table.created_at
    FROM orders_table 
    JOIN products_table 
        ON orders_table.product_id = products_table.product_id  
        AND orders_table.seller_id = products_table.seller_id  
    JOIN customers_table 
        ON orders_table.customer_id = customers_table.customer_id
        
    WHERE orders_table.customer_id =? AND orders_table.created_at =?
    GROUP BY orders_table.product_id, orders_table.customer_id 
    ORDER BY orders_table.created_at DESC";
    $id = $_SESSION['customer_id'];
    $prepareItems = $connect->prepare($itemsQuery);
    $prepareItems->bind_param("is", $id,$time);
    $execute = $prepareItems->execute();

    $itemsResult = $prepareItems->get_result();
    $itemsData = $itemsResult->fetch_all(MYSQLI_ASSOC);

    echo json_encode($itemsData);
    



?>