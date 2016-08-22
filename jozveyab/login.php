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


    if($count == 1){
        echo 1;

        header('Location : index.php');
        $_SESSION['user'] = $row['id'];
        header('Location : index.php');
        $conn = null;

    }
    else{
        $errTyp = "red";
        $errMSG = "نام کاربری یا رمز عبور وارد شده اشتباه می باشد";
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
    <form action="" method="post" class="login-form">
        <div class="row valign-wrapper">
            <div style="margin-top: 3%" class="col s12">
                <img width="200px" height="150px"  class="circle responsive-img" src="https://s.graphiq.com/sites/default/files/2307/media/images/Light_Green_429730_i0.png" alt="جزوه یاب">
                <a href="index.html"><h6 class="center login-form-text">جزوه یاب ،اولین سایت مرجع جزوه</h6></a>
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
                <i class="material-icons prefix">lock_outline</i>
                <input id="password" type="password" name="pass" required>
                <label for="username" class="active right-align">رمز عبور</label>
            </div>
        </div>

        <div class="col s12">
            <button style="margin-bottom: 5%;width: 100%" class="btn waves-effect waves-light" type="submit" name="btn-login">ورود</button>
        </div>


    </form>
    <div class="row">
        <div class="input-field col s6 m6 l6">
            <p class="margin left-align medium-small"><a href="register.php">ثبت نام</a></p>
        </div>
        <div class="input-field col s6 m6 l6">
            <p class="margin right-align medium-small"><a href="forget.php">فراموشی رمز عبور</a></p>
        </div>
    </div>
</div>
</div>
</body>

</html>

