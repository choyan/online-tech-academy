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
        <style>
            tbody tr:last-child td {
                background: #8BC34A !important;
            }
        </style>
    </head>
    <body class="list-request">
        <!--[if lt IE 8]>
            <p class="browserupgrade">You are using an <strong>outdated</strong> browser. Please <a href="http://browsehappy.com/">upgrade your browser</a> to improve your experience.</p>
        <![endif]-->

        <?php 
        include 'header.php';
         ?>
        <div class="container">
            <h1>Todays Sell</h1>
            <table class="pure-table pure-table-striped text-center" style="margin-bottom: 50px;">
                <thead class="text-center">
                    <th  class="text-center">Username</th>
                    <th  class="text-center">Course Name</th>
                    <th  class="text-center">Time</th>
                    <th  class="text-center">Course Price</th>
                    <th  class="text-center">Revenue</th>
                </thead>
                <tbody>
                    <?php
                        $timestamp = date('Y-m-d');
                        $course_info = $con->query("SELECT * FROM course_transaction WHERE date LIKE '%$timestamp%'");
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
                                $cid = $row['course_id'];
                                $cname = $con->query("SELECT course_title FROM course_info WHERE id = '$cid'")->fetch_object()->course_title;
                                echo $cname;
                                 ?>                                     
                         </td>
                        <td>
                            <?php 
                                $date = date_create($row['date']);
                                //echo date_format($date, 'g:ia \o\n l jS F Y');
                                echo date_format($date, 'g:ia  jS F');
 
                            ?>
                        </td>
                        <td>
                            <?php 
                                echo $row['amount'];
                            ?>
                        </td>
                        <td>
                            <?php
                                $revenue = $row['amount'] * 0.4;
                                echo "$revenue";
                            ?>
                        </td>
                        
                    </tr>
                    <?php
                        }
                    ?>
                    <tr>
                        <td> </td>
                        <td> </td>
                        <td style="text-align: right">Total:</td>
                        <td>
                            <?php 
                                $total = $con->query("SELECT SUM(amount) AS total FROM course_transaction WHERE date LIKE '%$timestamp%'");
                                $total = $total->fetch_assoc();
                                echo $total['total'];
                            ?>
                        </td>
                        <td>
                            <?php                                 
                                echo $total['total']*0.4;
                            ?>
                        </td>

                    </tr>
                </tbody>
            </table>

           
        </div>


        <?php 
        include 'footer.php'; ?>