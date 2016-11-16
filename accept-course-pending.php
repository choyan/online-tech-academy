<?php 
session_start();
if(!isset($_SESSION['id'])) {
   header("Location: login.php");
}
include 'functions.php';
if(is_admin($con, $user_id) == 0) {
    header("location: not-allowed.php");
}
$course_id = $_GET['id'];
$accept_pending = $con->query("UPDATE course_info SET status=1 WHERE id='$course_id'");
if($accept_pending) {
    header("location: new-course-pending.php?msg=success");
} else {
    header("location: new-course-pending.php?msg=failed");	
}
?>