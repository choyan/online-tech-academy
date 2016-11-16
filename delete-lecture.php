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
$lecture_id = $_GET['id'];
$get_lecture_video = $con->query("SELECT video_url FROM lectures WHERE id='$lecture_id'")->fetch_object()->video_url;
$file_path = "data/video/{$get_lecture_video}";
unlink($file_path);

$delete_lectures = $con->query("DELETE FROM lectures WHERE id='$lecture_id'");

if($delete_lectures) {
    header("Location: add-section.php?cid=$course_id&msg=lec_success");
} else {
    header("location: new-course-pending.php?msg=lec_failed");	
}
?>