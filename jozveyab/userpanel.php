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

    $user_id = $_SESSION['user'];

    $query = "SELECT `id`, `username`, `email`, `first_name`, `last_name`, `uni_name`, `age`, `password` FROM `user` WHERE `id`='$user_id'";
    $result = mysqli_query($conn, $query);

    $row = mysqli_fetch_assoc($result);

    $conn = null;


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
            font-family: Font;
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
            padding-right: 2%;
        }
        #panel p{
            padding-right: 2%;
        }
        #panel{
            margin-top: 5%;
            box-shadow: 3px 3px 8px 8px #dbdcf5;
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
<div id="login-form" class="row">

    <div style="text-align: right!important;" class="col s8 offset-s2 center z-depth-6 card-panel">
        <div id="panel" style="text-align: right!important;" class="col s6 offset-s3 center z-depth-6 card-panel">
            <div class="row">
                <p style="font-weight: bolder;font-size: x-large" class="margin right-align medium-small">پنل کاربری من</p>
                <hr>
            </div>
            <div class="row">
                <p class="margin right-align medium-small"><?php echo $row['username']; ?></p>
                <hr>
            </div>
            <div class="row">
                <p class="margin right-align medium-small"><?php echo $row['email']; ?></p>
                <hr>
            </div>
            <div class="row">
                <p class="margin right-align medium-small"><?php echo $row['first_name'] ." ". $row['last_name']; ?></p>
                <hr>
            </div>
            <div class="row">
                <p class="margin right-align medium-small">تعداد جزوه های پست شده توسط من</p>
                <hr>
            </div>
            <div class="row">
                <p class="margin right-align medium-small">امتیاز من</p>
                <hr>
            </div>
            <div class="row">
                <p class="margin right-align medium-small">رتبه من</p>
                <hr>
            </div>
            <div class="row">
                <p class="margin right-align medium-small"><?php echo $row['uni_name'] == "" ? 'دانشگاه شما در سیستم موجود نیست' : $row['uni_name']; ?></p>
                <hr>
            </div>
            <div class="row">
                <p class="margin right-align medium-small"><?php echo $row['age'] == "0" ? 'سن شما در سیستم موجود نیست' : $row['age']; ?></p>
                <hr>
            </div>


        </div>

        <div class="row">
        <div class="input-field col s6 m6 l6">
            <p class="margin left-align medium-small"><a href="edituser.php">ویرایش مشخصات فردی</a></p>
        </div>
        <div class="input-field col s6 m6 l6">
            <p class="margin right-align medium-small"><a href="myposts.php">پست های من</a></p>
        </div>
    </div>
    </div>
</div>
<?php
include_once('footer.html');
?>
</body>

</html>
