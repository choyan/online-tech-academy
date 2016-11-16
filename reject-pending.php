<?php 
session_start();
include 'functions.php';

if(!isset($_SESSION['id'])) {
   header("Location: login.php");
}
if(is_admin($con, $user_id) == 0) {
    header("location: not-allowed.php");
}


?>

<!doctype html>
<html class="no-js" lang="">
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <title>Your website title</title>
        <meta name="description" content="">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <link rel="apple-touch-icon" href="apple-touch-icon.png">
        <!-- Place favicon.ico in the root directory -->

        <link rel="stylesheet" href="assets/css/bootstrap.min.css">
        <link rel="stylesheet" href="assets/css/font-awesome.css">
        <link rel="stylesheet" href="assets/css/main.css">
    </head>
    <body class="list-request">
        <!--[if lt IE 8]>
            <p class="browserupgrade">You are using an <strong>outdated</strong> browser. Please <a href="http://browsehappy.com/">upgrade your browser</a> to improve your experience.</p>
        <![endif]-->
        <?php 
        include 'header.php'; ?>
        <div class="container">
            <?php 
                $pending_id = $_GET['id'];
                $results = $con->query("DELETE FROM user_transaction WHERE id = '$pending_id'");
                if($results) {
                    echo "<div class='panel panel-success'>Rejected Course</div>";
                } else {
                    die('Error : ('. $con->errno .') '. $con->error);
                }
            ?>
        </div>

        <?php 
        include 'footer.php'; ?>