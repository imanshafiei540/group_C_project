<?php
session_start();
ob_start();
if(isset($_SESSION['user']) != ""){

    $DB_HOST = 'localhost';
    $DB_USER = 'root';
    $DB_PASS = '';
    $DB_NAME = 'jozveyab';

    $conn = mysqli_connect($DB_HOST,$DB_USER,$DB_PASS,$DB_NAME);
    mysqli_set_charset($conn, 'utf8');


    if ( !$conn ) {
        die("Connection failed : " . mysqli_error());
    }

    //scape variables for security
    $user_id = mysqli_real_escape_string($conn, $_SESSION['user']);

    //can not sql injection for server
    //strip string from tags like script tags
    $user_id = strip_tags($user_id);

    $result = mysqli_query($conn, "SELECT `id`, `jozve_name`, `jozve_ostad`, `jozve_author`, `jozve_lesson`, `jozve_uni`, `author_id` FROM `jozve` WHERE `author_id`='$user_id'");




}
else{
    header('Location: login.php');
}





?>
<!DOCTYPE html>
<html lang="fa">
<head>
    <meta charset="UTF-8">
    <title>جزوه یاب، اولین مرجع جزوه های درسی و غیر درسی</title>


    <meta name="viewport" content="width=device-width, initial-scale=1">

    <link href="http://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
    <!-- Compiled and minified CSS -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/materialize/0.97.7/css/materialize.min.css">

    <!-- Compiled and minified JavaScript -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/materialize/0.97.7/js/materialize.min.js"></script>


    <style>
        @font-face {
            font-family: 'Font';
            src: url(static/font/BPaatchBold.ttf) format('truetype');
        }

        body {
            font-family: "B Mitra";
            font-size: large;

        }

        #login-form input {
            font-family: Font;
            text-align: right;

        }

        #login-form {
            margin-top: 5%;
        }
        #login-form label{
            text-align: right!important;
            position: relative;!important;
            padding-right: 5%;
        }
        #box:nth-child(5){
            clear: both;
        }

    </style>
</head>
<body class="cyan loaded">
<?php

if(isset($_SESSION['user']) != ""){
    include_once('header-after-login.html');
}
else{
    include_once('header-before-login.html');
}
?>
    <div class="row">
        <div id="box" style="text-align: right!important;" class="col s8 offset-s2 center z-depth-6">
<?php
while ($row = mysqli_fetch_array($result)){
    echo '<div id="box" style="margin: 2%;width: 21%" class="col s3 center z-depth-2 card-panel">
                <img width="80%" height="150px" src="static/images/icon_Linkedin.png">
                <hr>
                <p>'.$row['jozve_name'].'</p>
                <hr>
                <a href="http://localhost/group_C_project/jozveyab/detail.php?post_id='.$row['id'].'" class="green-text" target="_blank" style="font-size: 0.9rem; float: left">دانلود جزوه</a>
                <span style="float: right;"><i class="material-icons light-blue-text tooltipped" data-position="top" data-delay="50" data-tooltip="45 Views" style="font-size: 1.3rem; padding-right: 10px;cursor: pointer;">visibility</i> <i class="material-icons pink-text tooltipped action-like" data-workpad-key="D84lCquI0azsJt7V5qQEHn" data-position="top" data-delay="50" data-tooltip="Likes 1" style="font-size: 1.3rem; padding-right: 10px; cursor: pointer;">favorite</i> <span style="float: left;"></span></span>

            </div>';
}
     ?>


        </div>
    </div>
    <?php
    include_once('footer.html');
    ?>
</body>

</html>
