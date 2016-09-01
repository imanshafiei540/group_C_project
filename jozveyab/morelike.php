<?php
session_start();
ob_start();


include_once ('dbconn.php');

$conn = mysqli_connect($DB_HOST,$DB_USER,$DB_PASS,$DB_NAME);
mysqli_set_charset($conn, 'utf8');


if ( !$conn ) {
    die("Connection failed : " . mysqli_error());
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
    <script type="text/javascript" src="https://code.jquery.com/jquery-2.1.1.min.js"></script>
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
        <h4>جدیدترین جزوه ها</h4>
        <hr>

        <?php
        $query = "SELECT * FROM likes ORDER BY likes DESC LIMIT 24";
        $res = mysqli_query($conn, $query);
        while ($data = mysqli_fetch_assoc($res)){
            $id = $data['post_id'];
            $query2 = "SELECT * FROM jozve WHERE `id`='$id'";
            $res2 = mysqli_query($conn, $query2);
            $row = mysqli_fetch_assoc($res2);

            $post_id = $row['id'];
            $download = mysqli_query($conn, "SELECT `views` FROM `views` WHERE `post_id`='$post_id'");
            $counter_for_download = mysqli_fetch_array($download);
            $counter_for_download = $counter_for_download['views'];

            $like = mysqli_query($conn, "SELECT `likes` FROM `likes` WHERE `post_id`='$post_id'");
            $likes = mysqli_fetch_array($like);
            $likes = $likes['likes'];

            echo '<div id="box" style="margin: 2%;width: 21%;float: right" class="col s3 center z-depth-2 card-panel">
                <img width="80%" height="150px" src="static/images/icon_Linkedin.png">
                <hr>
                <p>'.$row['jozve_name'].'</p>
                <hr>
                <a href="detail.php?post_id='.$row['id'].'" class="green-text" target="_blank" style="font-size: 0.9rem; float: left">دانلود جزوه</a>
                <span style="float: right;"><i class="material-icons light-blue-text tooltipped" data-position="top" data-delay="50" data-tooltip="'.$counter_for_download.' Views" style="font-size: 1.3rem; padding-right: 10px;cursor: pointer;">visibility</i> <i class="material-icons pink-text tooltipped action-like" data-workpad-key="D84lCquI0azsJt7V5qQEHn" data-position="top" data-delay="50" data-tooltip="Likes '.$likes.'" style="font-size: 1.3rem; padding-right: 10px; cursor: pointer;">favorite</i> <span style="float: left;"></span></span>

            </div>';

        }

        $conn = null;
        ?>

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
