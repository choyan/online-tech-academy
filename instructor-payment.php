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
        <title>Daily Sell Count</title>
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
            <table class="pure-table pure-table-striped text-center" style="margin-bottom: 50px;">
                <thead class="text-center">
                    <th  class="text-center">Instructor Name</th>
                    <th  class="text-center">Payment Information</th>
                    <th  class="text-center">Amount</th>
                    <th class="text-center">Paid</th>
                </thead>
                <tbody>
                    <?php
                        $timestamp = date('Y-m-d');
                        $course_info = $con->query("SELECT * FROM instructor WHERE credit_amount > 0");
                        while ($row = $course_info->fetch_array()) {
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
                                // $cid = $row['course_id'];
                                // $cname = $con->query("SELECT course_title FROM course_info WHERE id = '$cid'")->fetch_object()->course_title;
                                echo $row['payment_info'];
                                 ?>                                     
                         </td>
                        <td>
                            <?php 
                                // $date = date_create($row['date']);
                                //echo date_format($date, 'g:ia \o\n l jS F Y');
                                // echo date_format($date, 'g:ia  jS F');
                            echo $row['credit_amount'];
                            ?>
                        </td>
                        <td>
                            <a href="payment-done-instructor.php?id=<?=  $id; ?>"><i class="fa fa-check"></i></a>
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