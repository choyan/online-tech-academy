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
        <title>Payment History</title>
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
            <h1>Payment History:</h1>
            <form action="payment-history-search.php" method="post" class="pure-form">
            	 <?php
                    if ($_SERVER['REQUEST_METHOD'] == 'POST') {

                    }
                ?>
                <fieldset>
			        <legend>Search</legend>
	                <label for="year">Year:</label>
			        <select id="year" name="year" style="margin-right: 30px;">
			            <option>2016</option>
			            <option>2015</option>
			            <option>2014</option>
			        </select>
			        <label for="month">Month:</label>
			        <select id="month" name="month">
			            <option value="1">January</option>
			            <option value="2">February</option>
			            <option value="3">March</option>
			            <option value="4">April</option>
			            <option value="5">May</option>
			            <option value="6">June</option>
			            <option value="7">July</option>
			            <option value="8">August</option>
			            <option value="9">September</option>
			            <option value="10">October</option>
			            <option value="11">November</option>
			            <option value="12">December</option>
			        </select>
			        <button type="submit" class="button" style="margin-left: 10px">Search</button>
			    </fieldset>
            </form>
            <table class="pure-table pure-table-striped text-center" style="margin-bottom: 50px;">
                <thead class="text-center">
                    <th  class="text-center">Instructor Name</th>
                    <th  class="text-center">Payment Method</th>
                    <th  class="text-center">Amount</th>
                    <th class="text-center">Date</th>
                </thead>
                <tbody>
                    <?php
                        $timestamp = date('Y-m-d');
                        $payment_list = $con->query("SELECT * FROM payment");
                        while ($row = $payment_list->fetch_array()) {
                     ?>   
                    <tr>
                        <td>
                            <?php 
                                $id = $row['instructor_id'];
                                $fullname = $con->query("SELECT full_name FROM users WHERE id = '$id'")->fetch_object()->full_name;
                                echo "$fullname"; 
                             ?>   
                        </td>
                        <td>
                            <?php 
                                echo $row['payment_method'];
                                 ?>                                     
                         </td>
                        <td>
                            <?php 
                                echo $row['amount'];
                            ?>
                        </td>
                        <td>
                            <?php 
                            	$date = date_create($row['full_date']);
                                echo date_format($date, 'jS F g:ia');
                            ?>
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