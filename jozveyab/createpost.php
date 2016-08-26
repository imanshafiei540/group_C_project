<?php
session_start();
ob_start();
if(isset($_SESSION['user']) != ""){
    if(isset($_POST['btn-create-post'])){
        echo 1;
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
        $name = mysqli_real_escape_string($conn, $_POST['name']);
        $subject = mysqli_real_escape_string($conn, $_POST['subject']);
        $author = mysqli_real_escape_string($conn , $_POST['author']);
        $ostad = mysqli_real_escape_string($conn , $_POST['ostad']);
        $uni = mysqli_real_escape_string($conn , $_POST['uni']);


        //can not sql injection for server
        //strip string from tags like script tags
        $name = strip_tags($name);
        $subject = strip_tags($subject);
        $author = strip_tags($author);
        $ostad = strip_tags($ostad);
        $uni = strip_tags($uni);
        $author_id = $_SESSION['user'];

        if(isset($name) && !empty($name) && isset($subject) && !empty($subject)){

            $query = "INSERT INTO `jozve`(`jozve_name`, `jozve_ostad`, `jozve_author`, `jozve_lesson`, `jozve_uni`, `author_id`) VALUES ('$name', '$ostad', '$author', '$subject','$uni', '$author_id')";
            $result = mysqli_query($conn, $query);

            if($result){
                $errTyp = "teal";
                $errMSG = "پست شما با موفقیت پست گردید";
                $conn = null;
            }
            else{
                $errTyp = "red";
                $errMSG = "مشکلی در وارد کردن اطلاعات جزوه ی شما در سیستم به وجود آمده ، لطفا دوباره تلاش کنید";
                $conn = null;
            }
        }
        else{
            $errTyp = "red";
            $errMSG = "نام جزوه و موضوع جزوه حتما باید وارد شود";
            $conn = null;
        }




    }

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
            font-size: large;

        }
        
    </style>
</head>
<body class="cyan loaded">

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
                <label style="padding-right: 2%" for="name" class="active right-align">:(نام جزوه(اجباری</label>
                <input id="name" name="name" type="text" required>
            </div>
        </div>

        <div class="row">
            <div class="input-field col s12">
                <label style="padding-right: 2%" for="subject" class="active right-align">:(موضوع جزوه(اجباری</label>
                <input id="subject" name="subject" type="text" required>
            </div>

        </div>

        <div class="row">
            <div class="input-field col s12">
                <label style="padding-right: 2%" for="author" class="active right-align">:(نام نویسنده جزوه(اختیاری</label>
                <input id="author" name="author" type="text">
            </div>

        </div>

        <div class="row">
            <div class="input-field col s6">
                <label for="ostad" class="active right-align">:(نام استاد(اختیاری</label>
                <input id="ostad" name="ostad" type="text" >
            </div>
            <div class="input-field col s6">
                <label for="uni" class="active right-align">:(نام دانشگاه(اختیاری</label>
                <input id="uni" name="uni" type="text" >
            </div>
        </div>


        <div class="col s12">
            <button style="margin-bottom: 5%;margin-top: 5%;width: 100%" class="btn waves-effect waves-light" type="submit" name="btn-create-post">ایجاد پست</button>
        </div>


    </form>
    <div class="row">
        <div class="input-field col s6 m6 l6">
            <p class="margin left-align medium-small"><a href="userpanel.php">پنل کاربری</a></p>
        </div>
        <div class="input-field col s6 m6 l6">
            <p class="margin right-align medium-small"><a href="myposts.php">پست های من</a></p>
        </div>
    </div>
</div>
</div>
</body>

</html>
