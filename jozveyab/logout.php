<?php
session_start();
if (isset($_SESSION['user']) != ""){
    session_destroy();

}
else{
    header('Location : login.php');
}