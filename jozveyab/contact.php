<?php
session_start();
ob_start();

if(isset($_POST['btn-contact'])){

    include_once ('dbconn.php');
    $conn = mysqli_connect($DB_HOST,$DB_USER,$DB_PASS,$DB_NAME);

    if ( !$conn ) {
        die("Connection failed : " . mysqli_error());
    }

    //scape variables for security
    $email = mysqli_real_escape_string($conn, $_POST['email']);
    $subject = mysqli_real_escape_string($conn, $_POST['subject']);
    $text = mysqli_real_escape_string($conn, $_POST['text']);

    //can not sql injection for server
    //strip string from tags like script tags
    $email = strip_tags($email);
    $subject = strip_tags($subject);
    $text = strip_tags($text);


    if(isset($email) && !empty($email) && isset($subject) && !empty($subject) && isset($text) && !empty($text)) {
        $errTyp = "teal";
        $errMSG = "پیام شما ثبت شد ، تشکر از همکاری شما";
        $conn = null;
    }

    else{
        $errTyp = "red";
        $errMSG = "لطفا همه ی قسمت ها را پر کنید";
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
        #login-form label{
            text-align: right!important;
            position: relative;!important;
            padding-right: 2%;
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

        <br>
        <h5>تماس با جزوه یاب</h5>
    <hr>
        <p style="font-size: medium">برای تماس با جزوه یاب می توانید از راه های زیر استفاده کنید و یا فرم زیر را پر کنید و سوال ، پیشنهاد و یا انتقاد خود را با در میان بگذارید ، اعضای بخش پشتیبانی در اسرع وقت به شما پاسخ خواهند داد</p>
        <p style="font-size: medium">با تشکر از حسن انتخاب شما</p>
        <hr>
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
                <label for="email" class="active right-align">پست الکترونیک</label>
                <input id="email" name="email" type="email" required>
            </div>
        </div>

        <div class="row">
            <div class="input-field col s12">
                <label for="subject" class="active right-align">موضوع</label>
                <input id="subject" name="subject" type="text" required>
            </div>
        </div>

        <div class="row">
            <div class="input-field col s12">
                <label for="text" class="active right-align">متن پیام</label>
                <textarea style="margin-top: 3%;height: 150px;direction: rtl" id="text" name="text" required></textarea>
            </div>
        </div>



        <div class="col s12">
            <button style="margin-bottom: 5%;margin-top: 5%;width: 100%" class="btn waves-effect waves-light" type="submit" name="btn-contact">فرستادن پیام</button>
        </div>


    </form>
    <div class="row">
        <div class="input-field col s6 m6 l6">
            <p class="margin left-align medium-small"><a href="about.php">درباره ما</a></p>
        </div>
        <div class="input-field col s6 m6 l6">
            <p class="margin right-align medium-small"><a href="index.php">صفحه ی اصلی</a></p>
        </div>
    </div>
</div>
</div>
<?php
include_once('footer.html');
?>
</body>

</html>
