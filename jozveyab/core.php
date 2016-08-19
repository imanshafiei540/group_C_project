<?php
session_start();

//Define DB Connections
define('DB_HOST','localhost');
define('DB_USER','root');
define('DB_PASS','');
define('DB_NAME','jozveyab');
//End

function insert_user_data(){
    $conn = mysqli_connect(DB_HOST,DB_USER,DB_PASS,DB_NAME);

    if($conn){
        echo "success";
    }
    else{
        echo "Can not connect to Database.";
    }

}