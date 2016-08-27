<?php
session_start();
ob_start();
if(isset($_SESSION['user']) != "") {

    $user_id = $_SESSION['user'];

    if (isset($_POST['btn-edit-pass'])) {
        echo 1;
        $DB_HOST = 'localhost';
        $DB_USER = 'root';
        $DB_PASS = '';
        $DB_NAME = 'jozveyab';

        $conn = mysqli_connect($DB_HOST, $DB_USER, $DB_PASS, $DB_NAME);
        mysqli_set_charset($conn, 'utf8');
        if (!$conn) {
            die("Connection failed : " . mysqli_error());
        }

        //scape variables for security
        $old_pass = mysqli_real_escape_string($conn, $_POST['old-pass']);
        $new_pass = mysqli_real_escape_string($conn, $_POST['new-pass']);
        $re_new_pass = mysqli_real_escape_string($conn, $_POST['re-new-pass']);


        //can not sql injection for server
        //strip string from tags like script tags
        $old_pass = strip_tags($old_pass);
        $new_pass = strip_tags($new_pass);
        $re_new_pass = strip_tags($re_new_pass);


        if (isset($old_pass) && !empty($old_pass) && isset($new_pass) && !empty($new_pass) && isset($re_new_pass) && !empty($re_new_pass)) {

            $old_pass = hash('sha256', $old_pass);
            $new_pass = hash('sha256', $new_pass);
            $re_new_pass = hash('sha256', $re_new_pass);

            $query = "SELECT `password` FROM `user` WHERE `id`='$user_id'";
            $result = mysqli_query($conn, $query);
            $real_pass = mysqli_fetch_assoc($result);

            if ($real_pass['password'] != $old_pass ){
                $errTyp = "red";
                $errMSG = "رمز عبور فعلی خود را اشتباه وارد کردید";
                $conn = null;
            }

            else{
                if ($new_pass != $re_new_pass){
                    $errTyp = "red";
                    $errMSG = "رمز عبور وارد شده با تکرار آن مطابقت ندارد";
                    $conn = null;
                }
                else{
                    $query = "UPDATE `user` SET `password`='$new_pass' WHERE `id`='$user_id'";
                    $result = mysqli_query($conn, $query);
                    if ($result){
                        $errTyp = "teal";
                        $errMSG = "رمز عبور با موفقیت تغییر پیدا کرد";
                        $conn = null;
                    }

                    else{
                        $errTyp = "red";
                        $errMSG = "در ایجاد تغییرات مشکلی به وجود آمده است";
                        $conn = null;

                    }
                }
            }

            $conn = null;
        }

        else{
            $errTyp = "red";
            $errMSG = "لطفا تمام قسمت ها را پر کنید";
            $conn = null;
        }
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
            <div class="input-field col s12">
                <label style="padding-right: 2%" for="old-pass" class="active right-align">رمز عبور کنونی</label>
                <input id="old-pass" name="old-pass" type="password" required>
            </div>
        </div>

        <div class="row">
            <div class="input-field col s6">
                <label for="re-new-pass" class="active right-align">تکرار رمز عبور جدید</label>
                <input id="re-new-pass" name="re-new-pass" type="password" required>
            </div>
            <div class="input-field col s6">
                <label for="new-pass" class="active right-align">رمز عبور جدید</label>
                <input id="new-pass" name="new-pass" type="password" required>
            </div>
        </div>




        <div class="col s12">
            <button style="margin-bottom: 5%;margin-top: 5%;width: 100%" class="btn waves-effect waves-light" type="submit" name="btn-edit-pass">ویرایش مشخصات کاربری</button>
        </div>


    </form>
    <div class="row">
        <div class="input-field col s6 m6 l6">
            <p class="margin left-align medium-small"><a href="userpanel.php">پنل کاربری</a></p>
        </div>
        <div class="input-field col s6 m6 l6">
            <p class="margin right-align medium-small"><a href="edituser.php">ویرایش مشخصات فردی</a></p>
        </div>
    </div>
</div>
</div>
<?php
include_once('footer.html');
?>
</body>

</html>
