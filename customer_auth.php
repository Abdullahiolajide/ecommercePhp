<?php
     require 'headers.php';
     require 'connect.php';
     session_start();
    
    // $customerId = $_SESSION['customer_id'];                           
    
    if(isset($_SESSION['customer_id'])){
            $response = [
                    'status'=> true,
                    'message'=> 'user authenticated'
                ];
                echo json_encode($response);
            }
            else{
                    $response = [
                            'status'=> false,
                            'message'=> 'user not authenticated'
        ];
        echo json_encode($response);
    }
?>