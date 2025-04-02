<?php
     require 'headers.php';
     require 'connect.php';
     session_start();
    $data = json_decode(file_get_contents("php://input")); 
    // echo json_encode($data);
    $firstname = $data->firstname;
    $lastname = $data->lastname;
    $email = $data->email;
    $password = $data->password;
    $hashed = password_hash($password, PASSWORD_DEFAULT);

    $getEmail = "SELECT * FROM `sellers_table` WHERE `email` = ?";
    $prepareGet = $connect->prepare($getEmail);
    $prepareGet->bind_param('s',$email);
    $executeGet = $prepareGet->execute();

    if($executeGet){
        $getNumRows = $prepareGet->get_result();
        if($getNumRows->num_rows>0){
            $response = [
                'status'=>false,
                'message'=> 'Email Already Exists'
            ];
             echo json_encode($response);
        }else{
            
                $saveSeller = "INSERT INTO `sellers_table` (`firstname`, `lastname`, `email`, `password`) VALUES (?,?,?,?)";
                $prepareSave = $connect->prepare($saveSeller);
                $prepareSave->bind_param('ssss', $firstname, $lastname, $email, $hashed);
                $executeSave = $prepareSave->execute();

                
                
                if($executeSave){

                    $getEmail = "SELECT * FROM `sellers_table` WHERE `email` = ?";
                    $prepareGet = $connect->prepare($getEmail);
                    $prepareGet->bind_param('s',$email);
                    $executeGet = $prepareGet->execute();
                    if ($executeGet) {
                        $rowInfo = $prepareGet->get_result();
                        $rowData = $rowInfo->fetch_assoc();
                        $_SESSION['seller_id'] = $rowData['seller_id'];

                    }


                    $response = [
                        'status'=>true,
                        'message'=> 'Successfully Saved'
                    ];
                    echo json_encode($response);
                }else{
                    $response = [
                        'status'=>false,
                        'message'=> 'Error Saving User'
                    ];
                    echo json_encode($response);
                    
                }
                
            }
            
            
        }else{
            $response = [
                'status'=>false,
                'message'=> 'Connection problem, try again later'
            ];
            echo json_encode($response);
        }
        //     $getEmail = "SELECT * FROM `sellers_table` WHERE `email` = ?";
        //     $prepareGet = $connect->prepare($getEmail);
        //     $prepareGet->bind_param('s',$email);
        //     $executeGet = $prepareGet->execute();
        //     //ssssssssssssssssssssssssssssss
        //    if ($executeGet) {
        //     $rowInfo = $prepareGet->get_result();
        //     if ($rowInfo->num_rows>0) {
        //         $row = $row->fetch_object();
        //         $_SESSION['seller_id'] = $row->seller_id;
        //     }
        //    }
?>