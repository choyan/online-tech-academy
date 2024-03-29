<?php 
session_start();
include 'functions.php';

if(is_admin($con, $user_id) == 0) {
    header("location: not-allowed.php");
}


?>

<!doctype html>
<html class="no-js" lang="">
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <title>Instructor Payment</title>
        <meta name="description" content="">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <link rel="apple-touch-icon" href="apple-touch-icon.png">
        <!-- Place favicon.ico in the root directory -->

        <link rel="stylesheet" href="assets/css/pure-table.css">
        <link rel="stylesheet" href="assets/css/font-awesome.css">
        <link rel="stylesheet" href="assets/css/main.css">
    </head>
    <body class="list-request">
        <!--[if lt IE 8]>
            <p class="browserupgrade">You are using an <strong>outdated</strong> browser. Please <a href="http://browsehappy.com/">upgrade your browser</a> to improve your experience.</p>
        <![endif]-->

        <?php 
        include 'header.php';
         ?>
        <div class="container">
            <h1>Pending Instructor Payment:</h1>
            <?php 
                if(isset($_GET['msg'])) {
                    if($_GET['msg'] == 'success') {
                        echo "<div class='row'><div class='panel panel-small panel-success text-center' role='alert'>Instructor Payment done!</div></div>";
                    } else {
                        echo "<div class='row'><div class='panel panel-small panel-success text-center' role='alert'>Error Occured. Cant process at the moment.</div></div>";
                    }
                }
            ?>
            <table class="pure-table pure-table-striped text-center" style="margin-bottom: 50px;">
                <thead class="text-center">
                    <th  class="text-center">Instructor Name</th>
                    <th  class="text-center">Payment Information</th>
                    <th  class="text-center">Amount</th>
                    <th class="text-center">Pay</th>
                </thead>
                <tbody>
                    <?php
                        $timestamp = date('Y-m-d');
                        $pending_list = $con->query("SELECT * FROM instructor WHERE credit_amount > 0");
                        while ($row = $pending_list->fetch_array()) {
                     ?>   
                    <tr>
                        <td>
                            <?php 
                                $id = $row['user_id'];
                                $fullname = $con->query("SELECT full_name FROM users WHERE id = '$id'")->fetch_object()->full_name;
                                echo "$fullname"; 
                             ?>   
                        </td>
                        <td>
                            <?php 
                                echo $row['payment_info'];
                                 ?>                                     
                         </td>
                        <td>
                            <?php 
                                echo $row['credit_amount'];
                            ?>
                        </td>
                        <td>
                            <a href="payment-done-instructor.php?id=<?=  $id; ?>" class="button">Pay Now</a>
                        </td>
                       
                        
                    </tr>
                    <?php
                        }
                    ?>
                    
                </tbody>
            </table>

           
        </div>


        <?php 
        include 'footer.php'; ?>