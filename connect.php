<?php
    $localhost='mysql.railway.internal';
    $username='root';
    $password='pVRSMmdTCLuBEAcSeeqCLSopQFMeXxUx';
    $db='joyful-art';

    $connect = new mysqli($localhost, $username, $password, $db);

    if($connect->connect_error){
        echo 'error connecting to database';
    }else{
        // echo 'Connected Successfully';
    }

?>
