<?php
session_start();
ob_start();
if(isset($_SESSION['user']) != "") {

    $user_id = $_SESSION['user'];

    if (isset($_POST['btn-edit-user'])) {

        include_once ('dbconn.php');

        $conn = mysqli_connect($DB_HOST, $DB_USER, $DB_PASS, $DB_NAME);
        mysqli_set_charset($conn, 'utf8');
        if (!$conn) {
            die("Connection failed : " . mysqli_error());
        }

        //scape variables for security
        $username = mysqli_real_escape_string($conn, $_POST['username']);
        $email = mysqli_real_escape_string($conn, $_POST['email']);
        $first_name = mysqli_real_escape_string($conn, $_POST['first_name']);
        $last_name = mysqli_real_escape_string($conn, $_POST['last_name']);
        $uni_name = mysqli_real_escape_string($conn, $_POST['uni_name']);
        $age = mysqli_real_escape_string($conn, $_POST['age']);


        //can not sql injection for server
        //strip string from tags like script tags
        $username = strip_tags($username);
        $email = strip_tags($email);
        $first_name = strip_tags($first_name);
        $last_name = strip_tags($last_name);
        $uni_name = strip_tags($uni_name);
        $age = strip_tags($age);


        if (isset($username) && !empty($username)) {
            $query = "SELECT `username` FROM `user` WHERE username='$username'";
            $result = mysqli_query($conn, $query);

            //the number of username that similar to user email
            $username_count = mysqli_num_rows($result);

            if ($username_count == 0) {
                $query = "UPDATE `user` SET `username`='$username' WHERE `id`='$user_id'";
                $result = mysqli_query($conn, $query);
                if ($result){
                    $errTyp = "teal";
                    $errMSG = "تغییرات با موفقیت ثبت شد";

                }

            }
            else{
                $errTyp = "red";
                $errMSG = "در ایجاد تغییرات مشکلی به وجود آمده است";


            }
        }

        if (isset($email) && !empty($email)) {
            $query = "SELECT `email` FROM `user` WHERE email='$email'";
            $result = mysqli_query($conn, $query);

            //the number of username that similar to user email
            $email_count = mysqli_num_rows($result);

            if ($email_count == 0) {
                $query = "UPDATE `user` SET `email`='$email' WHERE `id`='$user_id'";
                $result = mysqli_query($conn, $query);
                if ($result){
                    $errTyp = "teal";
                    $errMSG = "تغییرات با موفقیت ثبت شد";

                }

            }
            else{
                $errTyp = "red";
                $errMSG = "در ایجاد تغییرات مشکلی به وجود آمده است";


            }
        }

        if (isset($first_name) && !empty($first_name)) {


            $query = "UPDATE `user` SET `first_name`='$first_name' WHERE `id`='$user_id'";
            $result = mysqli_query($conn, $query);
            if ($result){
                $errTyp = "teal";
                $errMSG = "تغییرات با موفقیت ثبت شد";

            }
            else{
                $errTyp = "red";
                $errMSG = "در ایجاد تغییرات مشکلی به وجود آمده است";


            }
        }

        if (isset($last_name) && !empty($last_name)) {


            $query = "UPDATE `user` SET `last_name`='$last_name' WHERE `id`='$user_id'";
            $result = mysqli_query($conn, $query);
            if ($result){
                $errTyp = "teal";
                $errMSG = "تغییرات با موفقیت ثبت شد";

            }
            else{
                $errTyp = "red";
                $errMSG = "در ایجاد تغییرات مشکلی به وجود آمده است";


            }
        }

        if (isset($uni_name) && !empty($uni_name)) {


            $query = "UPDATE `user` SET `uni_name`='$uni_name' WHERE `id`='$user_id'";
            $result = mysqli_query($conn, $query);
            if ($result){
                $errTyp = "teal";
                $errMSG = "تغییرات با موفقیت ثبت شد";

            }
            else{
                $errTyp = "red";
                $errMSG = "در ایجاد تغییرات مشکلی به وجود آمده است";


            }
        }

        if (isset($age) && !empty($age)) {


            $query = "UPDATE `user` SET `age`='$age' WHERE `id`='$user_id'";
            $result = mysqli_query($conn, $query);
            if ($result){
                $errTyp = "teal";
                $errMSG = "تغییرات با موفقیت ثبت شد";

            }
            else{
                $errTyp = "red";
                $errMSG = "در ایجاد تغییرات مشکلی به وجود آمده است";


            }
        }

        $conn = null;
    }
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
            padding-right: 5%;
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
        <?php
        if ( isset($errMSG) ) {

            ?>
            <div class="row">
                <div class="col s12 m12">
                    <div class="card-panel <?php echo $errTyp; ?>">
          <span class="white-text">
               <?php echo $errMSG; ?>
          </span>
                    </div>
                </div>
            </div>

            <?php
        }
        ?>
    <form action="" method="post" class="login-form">

        <div class="row">
            <div class="input-field col s6">
                <label for="username" class="active right-align">پست الکترونیک</label>
                <input id="username" name="email" type="email">
            </div>
            <div class="input-field col s6">
                <label for="username" class="active right-align">نام کاربری</label>
                <input id="username" name="username" type="text">
            </div>
        </div>

        <div class="row">
            <div class="input-field col s6">
                <label for="last_name" class="active right-align">نام خانوادگی</label>
                <input id="last_name" name="last_name" type="text">
            </div>
            <div class="input-field col s6">
                <label for="first_name" class="active right-align">نام</label>
                <input id="first_name" name="first_name" type="text">
            </div>
        </div>



        <div class="row">
            <div class="input-field col s6">
                <label for="age" class="active right-align">سن</label>
                <input id="age" name="age" type="text" >
            </div>
            <div class="input-field col s6">
                <label for="uni_name" class="active right-align">نام دانشگاه</label>
                <input id="uni_name" name="uni_name" type="text" >
            </div>
        </div>


        <div class="col s12">
            <button style="margin-bottom: 5%;margin-top: 5%;width: 100%" class="btn waves-effect waves-light" type="submit" name="btn-edit-user">ویرایش مشخصات کاربری</button>
        </div>


    </form>
    <div class="row">
        <div class="input-field col s6 m6 l6">
            <p class="margin left-align medium-small"><a href="register.php">پنل کاربری</a></p>
        </div>
        <div class="input-field col s6 m6 l6">
            <p class="margin right-align medium-small"><a href="editpass.php">تغییر رمز عبور</a></p>
        </div>
    </div>
</div>
</div>
<?php
include_once('footer.html');
?>
</body>

</html>
