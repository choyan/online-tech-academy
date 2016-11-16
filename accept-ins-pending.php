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
$accept_pending = $con->query("UPDATE instructor SET ins_status=1 WHERE user_id='$ins_id'");
if($accept_pending) {
    header("location: instructor-pending.php?msg=success");
} else {
    header("location: instructor-pending.php?msg=failed");	
}
?>