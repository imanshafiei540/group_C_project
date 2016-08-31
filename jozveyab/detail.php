<?php


session_start();
ob_start();

//The function with example headers
function send_download($file) {
    $basename = basename($file);
    $length   = sprintf("%u", filesize($file));

    header('Content-Description: File Transfer');
    header('Content-Type: application/octet-stream');
    header('Content-Disposition: attachment; filename="' . $basename . '"');
    header('Content-Transfer-Encoding: binary');
    header('Connection: Keep-Alive');
    header('Expires: 0');
    header('Cache-Control: must-revalidate, post-check=0, pre-check=0');
    header('Pragma: public');
    header('Content-Length: ' . $length);

    ob_clean();
    set_time_limit(0);
    readfile($file);
}


$post_id = $_GET['post_id'];
if (isset($post_id) && !empty($post_id)) {

    include_once ('dbconn.php');

    $conn = mysqli_connect($DB_HOST, $DB_USER, $DB_PASS, $DB_NAME);
    mysqli_set_charset($conn, 'utf8');
    if (!$conn) {
        die("Connection failed : " . mysqli_error());
    }

    //scape variables for security
    $post_id = mysqli_real_escape_string($conn, $post_id);

    //can not sql injection for server
    //strip string from tags like script tags
    $post_id = strip_tags($post_id);


    $query = "SELECT * FROM `jozve` WHERE `id`='$post_id'";
    $result = mysqli_query($conn, $query);

    $download = mysqli_query($conn, "SELECT `userip`, `post_id` FROM `downloaders_ip` WHERE `post_id`='$post_id'");
    $counter_for_download = mysqli_num_rows($download);

    $count = mysqli_num_rows($result);
    if ($count == 1) {
        $row = mysqli_fetch_assoc($result);
        $j_name = $row['jozve_name'];
        $j_ostad = $row['jozve_ostad'];
        $j_author = $row['jozve_author'];
        $j_lesson = $row['jozve_lesson'];
        $j_uni = $row['jozve_uni'];
        $author_id = $row['author_id'];
        $file_name = $row['file_name'];

        $user_id = mysqli_real_escape_string($conn, $author_id);
        $query = "SELECT * FROM `user` WHERE `id`='$author_id'";
        $result = mysqli_query($conn, $query);
        $row = mysqli_fetch_assoc($result);

        $post_creator = $row['username'];


        $conn = null;



    } else {
        echo "Something wrong";
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


    </style>
    <script type="text/javascript" src="static/js/jquery-1.2.6.min.js"></script>
    <script type="text/javascript" src="static/js/jquery.livequery.js"></script>

    <script type="text/javascript">

        // <![CDATA[

        $(document).ready(function () {

            $('.ViewComments').livequery("click", function (e) {

                var parent = $(this).parent();
                var getID = parent.attr('id').replace('collapsed-', '');

                var total_comments = $("#totals-" + getID).val();

                $("#loader-" + getID).html('<img src="loader.gif" alt="" />');

                $.post("view_comments.php?postId=" + getID + "&totals=" + total_comments, {}, function (response) {

                    $('#CommentPosted' + getID).prepend($(response).fadeIn('slow'));
                    $('#collapsed-' + getID).hide();

                });
            });

            /// like

            $('.LikeThis').livequery("click", function (e) {

                var getID = $(this).attr('id').replace('post_id', '');

                $("#like-loader-" + getID).html('<img src="loader.gif" alt="" />');

                $.post("like.php?postId=" + getID, {}, function (response) {

                    $('#like-stats-' + getID).html(response);

                    $('#like-panel-' + getID).html('<a href="javascript: void(0)" id="post_id' + getID + '" class="Unlike">Unlike</a>');

                    $("#like-loader-" + getID).html('');
                });
            });

            /// unlike

            $('.Unlike').livequery("click", function (e) {

                var getID = $(this).attr('id').replace('post_id', '');

                $("#like-loader-" + getID).html('<img src="loader.gif" alt="" />');

                $.post("unlike.php?postId=" + getID, {}, function (response) {

                    $('#like-stats-' + getID).html(response);

                    $('#like-panel-' + getID).html('<a href="javascript: void(0)" id="post_id' + getID + '" class="LikeThis">Like</a>');

                    $("#like-loader-" + getID).html('');
                });
            });


        });

        // ]]>

    </script>
</head>
<body class="cyan loaded">
<?php

if (isset($_SESSION['user']) != "") {
    include_once('header-after-login.html');
} else {
    include_once('header-before-login.html');
}
?>
<div id="login-form" class="row">

    <div style="text-align: right!important;" class="col s2 offset-s2 center z-depth-6">
        <div style="text-align: right!important;" class="col s12 center z-depth-12 card-panel">
            <img width="100%" height="40%" src="static/images/icon_Linkedin.png">

        </div>

        <div style="text-align: right!important;" class="col s12 center z-depth-12 card-panel">
            <form action="" method="post">
                <a href="">
                    <button style="width: 100%;margin-top: 20%;margin-bottom: 20%" name="btn-download"
                            class="btn waves-effect waves-light">دانلود جزوه
                    </button>
                </a>
            </form>
            <?php
            $file = 'uploads/' . $file_name;

            if (isset($_POST['btn-download']) && file_exists($file)) {

                include_once ('dbconn.php');

                $conn = mysqli_connect($DB_HOST, $DB_USER, $DB_PASS, $DB_NAME);
                mysqli_set_charset($conn, 'utf8');
                if (!$conn) {
                    die("Connection failed : " . mysqli_error());
                }
                $userip = $_SERVER['REMOTE_ADDR'];

                $result4 = mysqli_query($conn, "SELECT `userip`, `post_id` FROM `downloaders_ip` WHERE `userip`='$userip' AND `post_id`='$post_id'");
                $counter_for_view = mysqli_num_rows($result4);
                if ($counter_for_view == 0){
                    $res = mysqli_query($conn,"update views set views=views+1 where `post_id`='$post_id'");

                    $query3 = "INSERT INTO `downloaders_ip`(`userip`, `post_id`) VALUES ('$userip', '$post_id')";
                    $result3 = mysqli_query($conn, $query3);
                }


                send_download($file);



            }
            $conn = null;
            ?>
        </div>
        <div style="text-align: right!important;" class="col s12 center z-depth-12 card-panel">
            <p>تعداد دانلود های این جزوه</p>
            <hr>
            <h5><?php echo $counter_for_download; ?></h5>
        </div>
        <div style="text-align: right!important;" class="col s12 center z-depth-12 card-panel">
            <?php

            include_once('liker.php');
            ?>
        </div>


    </div>

    <div style="text-align: right!important;margin-left: 2%" class="col s6 z-depth-6">
        <div class="col s12 z-depth-12 card-panel">
            <h1 style="text-align: center"><?php echo $j_name; ?></h1>
        </div>

        <div style="width: 49%" class="col s6 right z-depth-6 card-panel">
            <p>موضوع جزوه</p>
            <hr>
            <h5><?php echo $j_lesson; ?></h5>
        </div>
        <div style="width: 49%" class="col s6 left z-depth-6 card-panel">
            <p>دانشگاه</p>
            <hr>
            <h5><?php
                if (!empty($j_uni)) {
                    echo $j_uni;
                } else {
                    echo "دانشگاه این جزوه در سیستم موجود نیست";
                }
                ?></h5>
        </div>
        <div style="width: 49%" class="col s6 right z-depth-6 card-panel">
            <p>نام استاد</p>
            <hr>
            <h5><?php
                if (!empty($j_ostad)) {
                    echo $j_ostad;
                } else {
                    echo "استاد تدریس کننده این جزوه در سیستم موجود نیست";
                }
                ?></h5>
        </div>
        <div style="width: 49%" class="col s6 left z-depth-6 card-panel">
            <p>نویسنده جزوه</p>
            <hr>
            <h5><?php
                if (!empty($j_author)) {
                    echo $j_author;
                } else {
                    echo "دانشگاه این جزوه در سیستم موجود نیست";
                }
                ?></h5>
        </div>
        <div class="col s12 left z-depth-12 card-panel">
            <p>این پست توسط این کاربر گذاشته شده است</p>
            <hr>
            <h5><?php
                if (!empty($post_creator)) {
                    echo $post_creator;
                } else {
                    echo "پست کننده این جزوه در سیستم موجود نیست";
                }
                ?></h5>
        </div>

    </div>

</div>

<?php
include_once('footer.html');
?>
</body>

</html>
