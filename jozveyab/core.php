<?php
session_start();

//Define DB Connections
define('DB_HOST','localhost');
define('DB_USER','root');
define('DB_PASS','');
define('DB_NAME','jozveyab');
//End

function get_jozve_data($jozve_id){
    $conn = mysqli_connect(DB_HOST,DB_USER,DB_PASS,DB_NAME);

    if ( !$conn ) {
        die("Connection failed : " . mysqli_error());
    }
    $jozve_id = mysqli_real_escape_string($jozve_id);
    $query = "SELECT * FROM `jozve` WHERE `id`='$jozve_id'";

    $result = mysqli_query($conn, $query);

    $row = mysqli_fetch_assoc($result);

    return $row;

    $jozve_name = $row['jozve_name'];
    $jozve_ostad = $row['jozve_ostad'];
    $jozve_author = $row['jozve_author'];
    $jozve_lesson = $row['jozve_lesson'];
    $jozve_uni = $row['jozve_uni'];
    $author_id = $row['author_id'];


}

function get_user_data($user_id){
    $conn = mysqli_connect(DB_HOST,DB_USER,DB_PASS,DB_NAME);

    if ( !$conn ) {
        die("Connection failed : " . mysqli_error());
    }

    $user_id = mysqli_real_escape_string($user_id);
    $query = "SELECT * FROM `jozve` WHERE `id`='$user_id'";
    $result = mysqli_query($conn, $query);
    $row = mysqli_fetch_assoc($result);
    return $row;

}

function get_posts($limit){
    $conn = mysqli_connect(DB_HOST,DB_USER,DB_PASS,DB_NAME);

    if ( !$conn ) {
        die("Connection failed : " . mysqli_error());
    }

    $limit = mysqli_real_escape_string($limit);

    $query = "SELECT * FROM jozve ORDER BY id DESC LIMIT '$limit'";

    $result = mysqli_query($conn, $query);

    $row = mysqli_fetch_assoc($result);

    return $row;

}

function

