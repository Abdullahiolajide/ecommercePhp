<?php
require 'headers.php';
    session_start();
    $sellerId = $_SESSION['seller_id'];
    require 'connect.php';
    $productInfo = json_decode(file_get_contents('php://input'));
    

    $productName = $productInfo->productName;
    $price = $productInfo->price;
    $salePrice = $productInfo->salePrice;
    $discount = $productInfo->discount;
    $quantity = $productInfo->quantity;
    $description = $productInfo->description;
    $productImage = $productInfo->productImage;

    
    $addProduct = "INSERT INTO `products_table`(`product_name`, `price`, `sale_price`, `discount`, `quantity`, `description`, `product_image`, `seller_id`) VALUES (?,?,?,?,?,?,?,?)";
    $prepareAddProduct = $connect->prepare($addProduct);
    $prepareAddProduct->bind_param('siiiissi', $productName, $price, $salePrice, $discount, $quantity, $description, $productImage, $sellerId);
    $executeAddProduct = $prepareAddProduct->execute();

    if ($executeAddProduct) {
        $response = [
            'status'=>true,
            'message'=>'Product Added Successfully',
            'session'=>$sellerId
        ];
        echo json_encode($response);
        
    }else{
        $response = [
            'status'=>false,
            'message'=>'Error adding!!!!'
        ];
        echo json_encode($response);

    }
?>