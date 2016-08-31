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

        #login-form label {
            text-align: right !important;
            position: relative;
        !important;
            padding-right: 5%;
        }

        #info p {
            font-size: larger;
            padding-right: 2%;
        }

        #info h5 {
            padding-right: 2%;

        }

        h4{
            text-align: right;
        }
        #box:nth-child(7){
            clear: both;
        }
    </style>
</head>
<body class="cyan loaded">
<?php

if (isset($_SESSION['user']) != "") {
    include_once('header-after-login.html');
} else {
    include_once('header-before-login.html');
}
?>
<br><br>


<div class="row">
    <div id="box" style="text-align: right!important;" class="container">
        <h4>نتیجه ی جست و جو</h4>
        <hr>
        <?php
        if(isset($_GET['q']))
        {
            $val = $_GET['q'];


            if(strlen($val)>=4 && !empty($val))
            {
                include_once ('dbconn.php');

                $conn = mysqli_connect($DB_HOST,$DB_USER,$DB_PASS,$DB_NAME);

                mysqli_set_charset($conn, 'utf8');
                if (!$conn) {
                    die('Cannot connect to db :/ <br>');
                }

                $query = "SELECT * FROM `jozve` WHERE";
                $query .=" `jozve_name` LIKE '%".          mysqli_real_escape_string($conn, $val)    ."%' OR";
                $query .=" `jozve_ostad` LIKE '%".        mysqli_real_escape_string($conn, $val)    ."%' OR";
                $query .=" `jozve_lesson` LIKE '%".    mysqli_real_escape_string($conn, $val)    ."%' OR";
                $query .=" `jozve_uni` LIKE '%".   mysqli_real_escape_string($conn, $val)    ."%' ";

                //$query .="LIMIT 30";
                $result = mysqli_query($conn, $query);
                if($result && mysqli_num_rows($result) > 0)
                {
                    $num_rows = mysqli_num_rows($result);
                    while($data = mysqli_fetch_assoc($result))
                    {


                        echo '<div id="box" style="margin: 2%;width: 21%" class="col s3 center z-depth-2 card-panel">
                <img width="80%" height="150px" src="static/images/icon_Linkedin.png">
                <hr>
                <p>'.$data['jozve_name'].'</p>
                <hr>
                <a href="http://localhost/group_C_project/jozveyab/detail.php?post_id='.$data['id'].'" class="green-text" target="_blank" style="font-size: 0.9rem; float: left">دانلود جزوه</a>
                <span style="float: right;"><i class="material-icons light-blue-text tooltipped" data-position="top" data-delay="50" data-tooltip="45 Views" style="font-size: 1.3rem; padding-right: 10px;cursor: pointer;">visibility</i> <i class="material-icons pink-text tooltipped action-like" data-workpad-key="D84lCquI0azsJt7V5qQEHn" data-position="top" data-delay="50" data-tooltip="Likes 1" style="font-size: 1.3rem; padding-right: 10px; cursor: pointer;">favorite</i> <span style="float: left;"></span></span>

            </div>';

                    }
                    $conn = null;
                }
                else
                {

                    echo '<p style="text-align: right;">.نتیجه ایی یافت نشد</p>';
                    $conn = null;
                }

            }
            else
            {
                echo '<p style="text-align: right">عبارت مورد جستجو حداقل باید 4 حرف باشد</p>';
            }
        }

        ?>
        <br><br><br><br><br>


    </div>
</div>



<script>
    $(document).ready(function () {
        $('.slider').slider();
    });</script>
<?php
include_once('footer.html');
?>
</body>

</html>

