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

        <link rel="stylesheet" href="assets/css/pure-table.css">
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

				$transaction_info = $con->query("SELECT * FROM user_transaction WHERE id = '$pending_id'");
				$transaction_info = $transaction_info->fetch_assoc();

				$user_id = $transaction_info['user_id'];
                $course_id = $transaction_info['course_id'];
                $date_taken = $transaction_info['time'];
                $payment_method = $transaction_info['payment_method'];
                $pay_address = $transaction_info['pay_address'];
                $time = $transaction_info['time'];

                $instructor_id = $con->query("SELECT user_id FROM course_info WHERE id='$course_id'")->fetch_object()->user_id;

				$username = $con->query("SELECT full_name FROM users WHERE id = '$user_id'")->fetch_object()->full_name;

				$course_title = $con->query("SELECT course_title FROM course_info WHERE id = '$course_id'")->fetch_object()->course_title;
				$price = $con->query("SELECT course_price FROM course_info WHERE id = '$course_id'")->fetch_object()->course_price;
                $sell_count = $con->query("SELECT sell_count FROM course_info WHERE id='$course_id'")->fetch_object()->sell_count;
                $sell_count++;

                $instructor_percentage = round($price * 0.6);                
                $repto_percentage = $price * 0.4;

				$student_courses = $con->query("INSERT INTO student_courses (user_id, course_id, date_taken) VALUES ('$user_id', '$course_id', '$date_taken')");

				$course_transaction = $con->query("INSERT INTO course_transaction (user_id, course_id, amount, date) VALUES('$user_id', '$course_id', '$price', '$time')");

				$user_transaction = $con->query("UPDATE user_transaction SET status='1' WHERE id='$pending_id'");

                $increase_sell_count = $con->query("UPDATE course_info SET sell_count='$sell_count' WHERE id= '$course_id'");

                $instructor_credit = $con->query("UPDATE instructor SET credit_amount = credit_amount + '$instructor_percentage' WHERE user_id = '$instructor_id'");


				if($student_courses && $course_transaction && $user_transaction && $increase_sell_count && $instructor_credit) {
					echo "<div class='panel panel-success'>$course_title has been added to the $username</div>";
				} else {
					echo "<div class='panel panel-danger'>Error adding course</div>";
				}
			?>
        </div>


        <?php 
        include 'footer.php'; ?>