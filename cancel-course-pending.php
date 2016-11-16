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
$cancel_pending = $con->query("DELETE FROM course_info WHERE id='$course_id'");
if($cancel_pending) {
    header("location: new-course-pending.php?msg=success-reject");
} else {
    header("location: new-course-pending.php?msg=failed-reject");	
}
?>