    <?php
    require 'headers.php';
    require 'connect.php';
    session_start();
    
    $curl = curl_init();
    $data = json_decode(file_get_contents('php://input'));
    $reference = $data->reference;

        // // print_r($data);
        // $response = [
        //     'status'=>true,
        //     'message'=> $referenceKey
        //    ];
        // echo json_encode($response);

    curl_setopt_array($curl, array(
        CURLOPT_URL => "https://api.paystack.co/transaction/verify/".$reference,
        CURLOPT_RETURNTRANSFER => true,
        CURLOPT_ENCODING => "",
        CURLOPT_MAXREDIRS => 10,
        CURLOPT_TIMEOUT => 30,
        CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
        CURLOPT_CUSTOMREQUEST => "GET",
        CURLOPT_HTTPHEADER => array(
        "Authorization: Bearer sk_test_1f848f8494234b444c15182d4b4ce2c89c368ca4",
        "Cache-Control: no-cache",
        ),
    ));
    
    $response = curl_exec($curl);
    $err = curl_error($curl);

    curl_close($curl);
    
    if ($err) {
        echo "cURL Error #:" . $err;
    } else {
        echo $response;
    }
    ?>