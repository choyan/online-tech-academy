<?php 
session_start();
if(!isset($_SESSION['id'])) {
   header("Location: login.php");
}
include 'functions.php';
if(is_admin($con, $user_id) == 0) {
    header("location: not-allowed.php");
}

$ins_id = $_GET['id'];

$month = date(m);
$year = date(Y);
$timestamp = date('Y-m-d H:i:s');

$amount = $con->query("SELECT credit_amount FROM instructor WHERE user_id='$ins_id'")->fetch_object()->credit_amount;

$payment = $con->query("INSERT INTO payment(instructor_id, amount, month, year, full_date) VALUES('$ins_id', '$amount', '$month', '$year', '$timestamp') ");
$accept_pending = $con->query("UPDATE instructor SET credit_amount=0 WHERE user_id='$ins_id'");

if($payment && $accept_pending) {
    header("location: instructor-payment.php?msg=success");
} else {
   header("location: instructor-payment.php?msg=failed");	
}
?>