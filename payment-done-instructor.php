<?php 
session_start();
if(!isset($_SESSION['id'])) {
   header("Location: login.php");
}
include 'functions.php';
if(is_admin($con, $user_id) == 0) {
    header("location: not-allowed.php");
}

$instructor_id = $_GET['id'];

$clear_amount = $con->query("UPDATE instructor SET credit_amount=0 WHERE user_id='$instructor_id'");

if($accept_pending) {
    header("location: new-course-pending.php?msg=success");
} else {
    header("location: new-course-pending.php?msg=failed");	
}
?>