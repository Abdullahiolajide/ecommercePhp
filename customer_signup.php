<?php
    require 'headers.php';
    require 'connect.php';
    session_start();

     $customer = json_decode(file_get_contents('php://input'));
     $firstname = $customer->firstname;
     $lastname = $customer->lastname;
     $email = $customer->email;
     $password = $customer->password;
     $hashedPassword = password_hash($password, PASSWORD_DEFAULT);

     $checkEmail = "SELECT * FROM `customers_table` WHERE `email`=?";
     $prepareCheck = $connect->prepare($checkEmail);
     $prepareCheck->bind_param('s', $email);
     $executeCheck = $prepareCheck->execute();

     if ($prepareCheck->get_result()->num_rows > 0) {
       $response = [
        'status'=>false,
        'message'=> 'Email Already Exists'
       ];
       echo json_encode($response);
    }else{

         
    $querySignup = "INSERT INTO `customers_table`(`firstname`, `lastname`, `email`, `password`) VALUES (?,?,?,?)";
     $prepareSignup = $connect->prepare($querySignup);
     $prepareSignup->bind_param('ssss', $firstname, $lastname, $email, $hashedPassword);
     $executeSignup = $prepareSignup->execute();

    if ($executeSignup) {
        $response = [
            'status'=>true,
            'message'=> 'User Signed Up successfully'
           ];
        echo json_encode($response);
    }else{
        $response = [
            'status'=>false,
            'message'=> 'User not Signed Up'
        ];
        echo json_encode($response);
    }
    }   
    
?>