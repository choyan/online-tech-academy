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
        <title>Your website title</title>
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
            <h1>List Pending requests</h1>
            <table class="pure-table pure-table-striped" style="margin-bottom: 50px;">
                <thead>
                    <th>Username</th>
                    <th>Payment Method</th>
                    <th>Time</th>
                    <th>Course Name</th>
                    <th>Price</th>
                    <th>Payment Address</th>
                    <th>Accept / Reject</th>
                    <tr>
                </tr>
                </thead>
                <tbody>
                    <?php
                        $course_info = $con->query("SELECT * FROM user_transaction WHERE status = '0'");
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
                        <td><?php echo $row['payment_method']; ?></td>
                        <td>
                            <?php 
                                $date = date_create($row['time']);
                                //echo date_format($date, 'g:ia \o\n l jS F Y');
                                echo date_format($date, 'g:ia  jS F');
 
                            ?>
                        </td>
                        <td>
                            <?php 
                                $cid = $row['course_id'];
                                $cname = $con->query("SELECT course_title FROM course_info WHERE id = '$cid'")->fetch_object()->course_title;
                                echo "$cname";
                            ?>
                        </td>
                        <td>
                            <?php 
                                $cprice = $con->query("SELECT course_price FROM course_info WHERE id = '$cid'")->fetch_object()->course_price;
                                echo "$cprice";
                            ?>
                        </td>
                        <td>
                            <?php 
                                echo $row['pay_address'];
                            ?>
                        </td>
                        <td>
                            <a href="accept-pending.php?id=<?php echo $row['id']; ?>" class="icon accept"><i class="fa fa-check"></i></a>
                            <a href="reject-pending.php?id=<?php echo $row['id']; ?>" class="icon reject"><i class="fa fa-times"></i></a>
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