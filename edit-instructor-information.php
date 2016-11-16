<?php 
session_start();
if(!isset($_SESSION['id'])) {
   header("Location: login.php");
}
include 'functions.php';
$user_id = $_SESSION['id'];
$instructor_id = $_GET['id'];
$name = get_username($con, $instructor_id);

?>

<!doctype html>
<html class="no-js" lang="">
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <title>Edit <?= $name; ?>'s Profile</title>
        <meta name="description" content="">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <link rel="apple-touch-icon" href="apple-touch-icon.png">
        <!-- Place favicon.ico in the root directory -->

        <link rel="stylesheet" href="assets/css/pure-table.css">
        <link rel="stylesheet" href="assets/css/font-awesome.css">
        <link rel="stylesheet" href="assets/css/main.css">
    </head>
    <body>
        <!--[if lt IE 8]>
            <p class="browserupgrade">You are using an <strong>outdated</strong> browser. Please <a href="http://browsehappy.com/">upgrade your browser</a> to improve your experience.</p>
        <![endif]-->
        <?php 
        include 'header.php'; ?>
        <div class="container">
            <form class="pure-form pure-form-aligned" action="edit-instructor-information.php?id=<?= $instructor_id; ?>" method="post" >
                 <?php
                    if ($_SERVER['REQUEST_METHOD'] == 'POST') {

                        $institute = $con->real_escape_string($_POST['institute']);
                        $designation = $con->real_escape_string($_POST['designation']);
                        $office = $con->real_escape_string($_POST['office']);                        
                        $paypal = $con->real_escape_string($_POST['paypal']);
                        $payment = $con->real_escape_string($_POST['payment']);


                        $update = $con->query("UPDATE instructor SET institute = '$institute', designation = '$designation', office = '$office', payment_info = '$payment', paypal = '$paypal' WHERE user_id = '$instructor_id'");
                        if($update) {
                            echo "<div class='panel panel-success text-center'>Information has been updated successfully</div>";
                        } else {
                            die('Error : ('. $con->errno .') '. $con->error);
                        }
                        
                    ?>


                    <?php
                    }
                ?>
                <h1>Edit <?= $name ?>'s Instructor Profile</h1>
                <hr>
                <?php 
                    $instructor_inf = $con->query("SELECT * FROM instructor WHERE user_id='$instructor_id'");
                    $instructor_info = $instructor_inf->fetch_assoc();
                ?>
                <fieldset>
                    <div class="pure-control-group">
                        <label for="institute">Institute</label>
                        <input type="text" name="institute" class="pure-input-2-3" value="<?= $instructor_info['institute']; ?>">
                    </div>

                    <div class="pure-control-group">
                        <label for="designation">Designation</label>
                        <input type="text" name="designation" class="pure-input-2-3" value="<?= $instructor_info['designation']; ?>">
                    </div>

                    <div class="pure-control-group">
                        <label for="office">Office</label>
                        <input type="text" name="office" class="pure-input-2-3" value="<?= $instructor_info['office']; ?>">
                    </div>

                    <div class="pure-control-group">
                        <label for="paypal">Paypal</label>
                        <input type="text" name="paypal" class="pure-input-2-3" value="<?= $instructor_info['paypal']; ?>">
                    </div>

                    <div class="pure-control-group">
                        <label for="payment">Payment Info</label>
                        <textarea name="payment" class="pure-input-2-3"><?= $instructor_info['payment_info']; ?></textarea>
                    </div>

                    <div class="pure-controls">
                        <input type="Update" class="button">
                    </div>

                </fieldset>
            </form>
        </div>


        <?php 
        include 'footer.php'; ?>