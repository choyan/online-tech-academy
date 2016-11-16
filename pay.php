<?php 
session_start();
if(!isset($_SESSION['id'])) {
   header("Location: login.php");
}

include 'functions.php';
$user_id = $_SESSION['id'];
$course_id = $_GET['id'];
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
    <body class="pay">
        <!--[if lt IE 8]>
            <p class="browserupgrade">You are using an <strong>outdated</strong> browser. Please <a href="http://browsehappy.com/">upgrade your browser</a> to improve your experience.</p>
        <![endif]-->
        <?php 
            include 'header.php';
        ?>
        <div class="container">
            <?php 
                $course_amount = $con->query("SELECT course_price FROM course_info WHERE id = '$course_id'")->fetch_object()->course_price;
                $usd_amount = $course_amount/77;
            ?>
            <h1 style="margin-bottom: 0;">Course Price:</h1>
            <h2>bKash: <?= $course_amount; ?>৳</h2>
            <h2>Paypal: <?= round($usd_amount); ?><i class="fa fa-usd"></i></h2>
            <p>Please send us the Course price via bKash or Paypal and provide us the infomation accordingly. After verifying it, we will let you access the course.</p>
            <p><strong>bKash Number:</strong> 01722222222</p>
            <p><strong>Paypal:</strong> repto-paypal@repto.edu</p>

            <h2>How would you like to pay ?</h2>
            <form action="pay.php?id=<?php echo $course_id; ?>" method="post" class="pure-form pure-form-aligned">
                <?php

                    if ($_SERVER['REQUEST_METHOD'] == 'POST') {

                        $pay_method = $con->real_escape_string($_POST['pay_method']);
                        $pay_address = $con->real_escape_string($_POST['pay_address']);

                        $check_pending_request = $con->query("SELECT * FROM user_transaction WHERE user_id = '$user_id' AND course_id = '$course_id'");
                        if(mysqli_num_rows($check_pending_request) == 0) {
                            if($pay_method == 'bKash') {
                                if(is_numeric($pay_address)) {
                                    
                                    $timestamp = date('Y-m-d H:i:s');

                                    $insert_data = $con->query("INSERT INTO user_transaction (user_id, payment_method, time, course_id, pay_address) VALUES('$user_id', '$pay_method', '$timestamp', '$course_id', '$pay_address')");
                                    if(!$insert_data) {
                                        die('Error : ('. $con->errno .') '. $con->error);
                                    } else {
                                        ?>
                                        <div class="panel panel-success" role="alert">We have accepted your Request. After reviewing it, you'lle find the course in your profile.</div>
                                        <?php
                                    }

                                } else {
                                    ?>
                                        <div class="panel panel-danger" role="alert">Please provide a valid mobile number.</div>
                                    <?php
                                }
                            } else if ($pay_method == 'paypal') {
                                // Same Course Verification
                                $email = filter_var($pay_address, FILTER_SANITIZE_EMAIL);
                                if (!filter_var($email, FILTER_VALIDATE_EMAIL) === false) {
                                    $timestamp = date('Y-m-d H:i:s');

                                    $insert_data = $con->query("INSERT INTO user_transaction (user_id, payment_method, time, course_id) VALUES('$user_id', '$pay_method', '$timestamp', '$course_id')");
                                    if(!$insert_data) {
                                        die('Error : ('. $con->errno .') '. $con->error);
                                    } else {
                                        ?>
                                        <div class="panel panel-success" role="alert">New Category has been added.</div>
                                        <?php
                                    }
                                } else {
                                    echo("$email is not a valid email address");
                                }

                            } else {
                                echo "You have to choose a method";
                            }
                        } else {
                            ?>
                                <div class="panel panel-danger" role="alert">You have already requested fot the Course. Please wait pationately.</div>
                            <?php
                        }

                    }

                ?>
                <fieldset>
                    <div class="pure-control-group">
                        <label for="name">Payment Method</label>
                        <select name="pay_method" id="payment" class="pure-input-2-3">
                            <option value="bKash">bKash</option>
                            <option value="paypal">Paypal</option>  
                        </select>
                    </div>
                    <div class="pure-control-group" id="pay-address">
                        <label for="pay-address">Please provide Phone Number for bKash / Email address for Paypal</label>
                        <input type='text' class='pure-input-2-3' name="pay_address" />
                    </div>

                    <button type="submit" class="button" style="width: 150px;">Pay</button>
                </fieldset>
            </form>
                
            <div class="footer">
                <p class="pull-right"><span class="fa fa-shield"></span> from Zahidul Hossain</p>
            </div>
        </div>

        <?php 
            include 'footer.php';
        ?>