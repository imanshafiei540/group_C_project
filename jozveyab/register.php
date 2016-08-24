<?php
session_start();
ob_start();
if (isset($_SESSION['user']) != ""){
    header('Location: index.php');
}


if( isset($_POST['btn-signup'])){

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
    $email = mysqli_real_escape_string($conn, $_POST['email']);
    $pass = mysqli_real_escape_string($conn, $_POST['pass']);
    $re_pass = mysqli_real_escape_string($conn, $_POST['retype_pass']);

    //can not sql injection for server
    //strip string from tags like script tags
    $username = strip_tags($username);
    $email = strip_tags($email);
    $pass = strip_tags($pass);
    $re_pass = strip_tags($re_pass);



    $query = "SELECT `email` FROM `user` WHERE email='$email'";
    $result = mysqli_query($conn, $query);

    //the number of email that similar to user email
    $email_count = mysqli_num_rows($result);


    $query = "SELECT `username` FROM `user` WHERE username='$username'";
    $result = mysqli_query($conn, $query);

    //the number of username that similar to user email
    $username_count = mysqli_num_rows($result);

    if(isset($username) && !empty($username)){
        if(isset($email) && !empty($email)){
            if(isset($pass) && !empty($pass)){

                //hash the password for trust
                $pass = hash('sha256', $pass);
                $re_pass = hash('sha256', $re_pass);

                if($email_count == 0){
                    if($pass == $re_pass){
                        if($username_count == 0){
                            $query = "INSERT INTO `user`(`username`, `email`,`password`) VALUES ('$username', '$email', '$pass')";
                            $result = mysqli_query($conn, $query);
                            if($result){
                                $errTyp = "teal";
                                $errMSG = "ثبت نام شما با موفقیت انجام شد . لطفا وارد شوید";
                                $conn = null;
                            }
                        }
                        else{
                            $errTyp = "red";
                            $errMSG = "نام کاربری وارد شده تکراری می باشد";
                            $conn = null;
                        }
                    }
                    else{
                        $errTyp = "red";
                        $errMSG = "رمز عبور وارد شده با تکرار آن مطابقت ندارد";
                        $conn = null;
                    }
                }
                else{
                    $errTyp = "red";
                    $errMSG = "پست الکترونیک وارد شده تکراری می باشد";
                    $conn = null;
                }
            }
            else{
                $errTyp = "red";
                $errMSG = "رمز عبور و تکرار آن را وارد کنید";
                $conn = null;
            }
        }
        else{
            $errTyp = "red";
            $errMSG = "پست الکترونیک خود را وارد کنید";
            $conn = null;
        }
    }
    else{
        $errTyp = "red";
        $errMSG = "نام کاربری خود را وارد کنید";
        $conn = null;
    }



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

        @font-face{
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


    </style>
</head>
<body class="cyan loaded">

<div id="login-form" class="row">
    <div class="col s4 offset-s4 center z-depth-4 card-panel">
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
    <form action="" method="post">
        <div class="row valign-wrapper">
            <div style="margin-top: 3%" class="col s12">
                <img width="200px" height="150px"  class="circle responsive-img" src="https://s.graphiq.com/sites/default/files/2307/media/images/Light_Green_429730_i0.png" alt="جزوه یاب">
                <a href="index.php"><h6 class="center login-form-text">جزوه یاب ،اولین سایت مرجع جزوه</h6></a>
            </div>
        </div>
        <div class="row">
            <div class="input-field col s11">
                <i class="material-icons prefix">account_circle</i>
                <input id="username" name="username" type="text" required>
                <label for="username" class="active right-align">نام کاربری</label>
            </div>
        </div>
        <div class="row">
            <div class="input-field col s11">
                <i class="material-icons prefix">email</i>
                <input id="username" name="email" type="email" required>
                <label for="username" class="active right-align">پست الکترونیک</label>
            </div>
        </div>
        <div class="row">
            <div class="input-field col s11">
                <i class="material-icons prefix">lock_outline</i>
                <input id="password" type="password" name="pass" required>
                <label for="password" class="active right-align">رمز عبور</label>
            </div>
        </div>
        <div class="row">
            <div class="input-field col s11">
                <i class="material-icons prefix">lock_outline</i>
                <input id="re-password" type="password" name="retype_pass" required>
                <label for="re-password" class="active right-align">تکرار رمز عبور</label>
            </div>
        </div>

        <div class="col s12">
            <button type="submit" style="margin-bottom: 5%;width: 100%"  class="btn waves-effect waves-light"  name="btn-signup">ثبت نام</button>
        </div>


    </form>

    <div class="row">
        <div class="input-field col s6 m6 l6">
            <p class="margin left-align medium-small"><a href="login.php">ورود</a></p>
        </div>
        <div class="input-field col s6 m6 l6">
            <p class="margin right-align medium-small"><a href="forget.php">فراموشی رمز عبور</a></p>
        </div>
    </div>
</div>
    </div>

</body>

</html>

