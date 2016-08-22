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
            padding-right: 5%;
        }
        .card.green-wine{
            background-color: #222222;

        }


    </style>
</head>
<body class="cyan loaded">

<div id="login-form" class="row">

    <div style="text-align: right!important;" class="col s8 offset-s2 center z-depth-6 card-panel">


        <br>
        <h5>درباره ی جزوه یاب و تیم طراحی آن</h5>
        <hr>
        <p style="direction: rtl;font-size: medium">جزوه یاب این افتخار را دارد که اولین سایت ارائه دهنده جزوه های درسی و غیر درسی برای تمام سنین باشد و این سیاست را پیش گرفته است که تمام کسانی که می خواهند در این امر ما را یاری کنند بتوانند جزوه های مفید خود را در سایت قرار دهند و برای حساب کاربری خود امتیاز جمع کنند . به زودی امکان خرید و فروش جزوه نیز به سایت اضافه خواهد شد .</p>
        <p style="font-size: medium">با تشکر از انتخاب شما</p>


        <h5>تیم ما</h5>
        <hr>
        <div style="margin-top: 5%" class="col s12 m6 offset-m3 center">
            <div class="card green-wine">
                <div class="card-content white-text">
                    <a href="https://www.linkedin.com/" class="btn-floating right center green-spring">
                        in
                    </a>
                    <br><br><br>
                    <h5>تیم طراحی سایت بک یارد</h5>
                    <br><br>
                </div>
                <div class="card-content white black-text" style="min-height: 140px;direction: rtl;font-size: medium">
تیم بک یارد با هفت عضو کار خود را در توسعه ی سایت و توسعه ی برنامه های تحت اندروید و IOS ، در سال 1395 آغاز کرد ، تیم طراحی وب سایت بک یارد سایت جزوه یاب را در تابستان 1395 شروع به طراحی کرد و هم اکنون بسیار خوشحالیم که شما سایت ما را انتخاب کرده اید . هم اکنون تمام اعضای این تیم در دانشگاه علم و صنعت ایران در رشته کامپیوتر مشغول به تحصیل هستند و به موازات آن پروژه هایی هم چون جزوه یاب را نیز به پیش می برند .
                </div>
            </div>
        </div>


        <div class="row">
            <div class="input-field col s6 m6 l6">
                <p class="margin left-align medium-small"><a href="contact.php">تماس با ما</a></p>
            </div>
            <div class="input-field col s6 m6 l6">
                <p class="margin right-align medium-small"><a href="index.php">صفحه ی اصلی</a></p>
            </div>
        </div>
</div>
</div>
</body>

</html>
