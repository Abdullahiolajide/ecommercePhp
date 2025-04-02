<?php
    $localhost='localhost';
    $username='root';
    $password='';
    $db='project_e_commerce';

    $connect = new mysqli($localhost, $username, $password, $db);

    if($connect->connect_error){
        echo 'error connecting to database';
    }else{
        // echo 'Connected Successfully';
    }

?>