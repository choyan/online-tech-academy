<?php 
session_start();
if(!isset($_SESSION['id'])) {
   header("Location: login.php");
}
include 'functions.php';
if(is_admin($con, $user_id) == 0) {
    header("location: not-allowed.php");
}

$course_id = $_GET['cid'];
$section_id = $_GET['id'];

$delete_lectures = $con->query("DELETE FROM lectures WHERE course_section_id='$section_id'");
$delete_section = $con->query("DELETE FROM sections WHERE id='$section_id'");

if($delete_lectures && $delete_section) {
    header("Location: add-section.php?cid=$course_id&msg=sec_success");
} else {
    header("location: new-course-pending.php?msg=sec_failed");	
}
?>