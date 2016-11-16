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
$reject_pending = $con->query("DELETE FROM instructor WHERE user_id = $ins_id");
if($reject_pending) {
    header("location: instructor-pending.php?msg=success-reject");
} else {
    header("location: instructor-pending.php?msg=failed-reject");
}
?>