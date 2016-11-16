<?php 
session_start();
if(!isset($_SESSION['id'])) {
   header("Location: login.php");
}
include 'functions.php';
$user_id = $_SESSION['id'];
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
            <form class="pure-form pure-form-aligned" action="<?php echo $_SERVER['PHP_SELF'];?>" method="post" >
                 <?php
                    if ($_SERVER['REQUEST_METHOD'] == 'POST') {

                        $institute = $con->real_escape_string($_POST['institute']);
                        $designation = $con->real_escape_string($_POST['designation']);
                        $office = $con->real_escape_string($_POST['office']);                        
                        $paypal = $con->real_escape_string($_POST['paypal']);
                        $payment = $con->real_escape_string($_POST['payment']);


                        $verify_info = $con->query("SELECT * FROM instructor WHERE user_id='$user_id'");

                        if(mysqli_num_rows($verify_info) == 0) {

                            $insert_data = $con->query("INSERT INTO instructor (user_id, institute, designation, office, paypal, payment_info) VALUES('$user_id', '$institute', '$designation', '$office', '$paypal', '$payment')");
                            if(!$insert_data) {
                                die('Error : ('. $con->errno .') '. $con->error);
                            } else {
                                ?>
                                <div class="panel panel-sm panel-success text-center bold" role="alert">Your requested has been received. Please wait for the verification.</div>
                                <?php
                            }
                        } else {
                            $check_req = $con->query("SELECT user_id FROM instructor WHERE user_id='$user_id' AND ins_status=1");
                            if(mysqli_num_rows($check_req) == 1) {
                                ?>
                                <div class="panel panel-sm text-center bold">You are already an Instructor</div>
                                <?php
                            } else {
                                ?>
                                <div class="panel panel-sm text-center bold">You have already applied. We will let you know after reviewing it.</div>
                                <?php
                            }
                            ?>
                            <?php
                        }
                        mysqli_close($con);
                    ?>


                    <?php
                    }
                ?>
                <h1>Apply As Instructor</h1>

                <fieldset>
                    <div class="pure-control-group">
                        <label for="institute">Institute</label>
                        <input type="text" name="institute" class="pure-input-2-3" placeholder="Institute">
                    </div>

                    <div class="pure-control-group">
                        <label for="designation">Designation</label>
                        <input type="text" name="designation" class="pure-input-2-3" placeholder="Designation">
                    </div>

                    <div class="pure-control-group">
                        <label for="office">Office</label>
                        <input type="text" name="office" class="pure-input-2-3" placeholder="Office">
                    </div>

                    <div class="pure-control-group">
                        <label for="paypal">Paypal</label>
                        <input type="text" name="paypal" class="pure-input-2-3" placeholder="Paypal">
                    </div>

                    <div class="pure-control-group">
                        <label for="payment">Payment Info</label>
                        <textarea name="payment" class="pure-input-2-3"></textarea>
                    </div>

                    <div class="pure-controls">
                        <input type="submit" class="button">
                    </div>

                </fieldset>
            </form>
        </div>


        <?php 
        include 'footer.php'; ?>