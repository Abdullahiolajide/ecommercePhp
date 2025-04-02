<?php
 require 'headers.php';
 require 'connect.php';
 session_start();

    $getProducts = "SELECT * FROM `products_table`";
    $runGet = $connect->query($getProducts);
    echo json_encode($runGet->fetch_all(MYSQLI_ASSOC))


?>