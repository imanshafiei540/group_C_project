<?php
session_start();
ob_start();
if(isset($_SESSION['user']) != ""){
    header('Location : index.php');
    echo 1;
}

if(isset($_POST['btn-login'])){
    echo 1;
    $DB_HOST = 'localhost';
    $DB_USER = 'root';
    $DB_PASS = '';
    $DB_NAME = 'jozveyab';

    $conn = mysqli_connect($DB_HOST,$DB_USER,$DB_PASS,$DB_NAME);

    if ( !$conn ) {
        die("Connection failed : " . mysqli_error());
    }

    //scape variables for security
    $username = mysqli_real_escape_string($conn, $_POST['username']);
    $pass = mysqli_real_escape_string($conn, $_POST['pass']);


    //can not sql injection for server
    //strip string from tags like script tags
    $username = strip_tags($username);
    $pass = strip_tags($pass);


    //hash the password for trust
    $pass = hash('sha256', $pass);

    $result = mysqli_query($conn, "SELECT `id`, `username`, `email`, `password` FROM `user` WHERE username='$username' AND password='$pass'");
    header('Location : index.php');
    $row = mysqli_fetch_array($result);

    //there is one row if username and password is correct
    $count = mysqli_num_rows($result);

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

<div id="login-form" class="row">

    <div style="text-align: right!important;" class="col s8 offset-s2 center z-depth-6 card-panel">
        <div id="panel" style="text-align: right!important;" class="col s6 offset-s3 center z-depth-6 card-panel">
            <div class="row">
                <p style="font-weight: bolder;font-size: x-large" class="margin right-align medium-small">پنل کاربری من</p>
                <hr>
            </div>
            <div class="row">
                <p class="margin right-align medium-small">نام کاربری</p>
                <hr>
            </div>
            <div class="row">
                <p class="margin right-align medium-small">پست الکترونیک</p>
                <hr>
            </div>
            <div class="row">
                <p class="margin right-align medium-small">نام و نام خانوادگی</p>
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
</body>

</html>
