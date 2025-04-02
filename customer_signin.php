<?php
    require 'headers.php';
    require 'connect.php';
    session_start();

    $data = json_decode(file_get_contents('php://input'));
    $email = $data->email;
    $password = $data->password;

    $getEmail = "SELECT * FROM `customers_table` WHERE `email` = ?";
    $prepareGet = $connect->prepare($getEmail);
    $prepareGet->bind_param('s',$email);
    $executeGet = $prepareGet->execute();

    if ($executeGet) {
        $getNumRow = $prepareGet->get_result();
        if ($getNumRow->num_rows>0) {
            $getAll = $getNumRow->fetch_object();
             $customerId= $getAll->customer_id;
             $_SESSION['customer_id'] = $customerId;
            $verifyPassword = password_verify($password, $getAll->password);
            if ($verifyPassword) {
                $response = [
                    'status'=>true,
                    'message'=>'Successfully logged in',
                    'customer_id'=> $_SESSION['customer_id']
                ];
                echo json_encode($response);
            }else{
                $response = [
                    'status'=>false,
                    'message'=>'Wrong Password'
                ];
                echo json_encode($response);
            }
            
        }else{
            $response = [
                'status'=>false,
                'message'=>'Email does not Exists'
            ];
            echo json_encode($response);

        }
    }
?>
