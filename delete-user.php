<?php 
session_start();
if(!isset($_SESSION['id'])) {
   header("Location: login.php");
}
include 'functions.php';
if(is_admin($con, $user_id) == 0) {
    header("location: not-allowed.php");
}
$user_id = $_GET['id'];

$check_instructor = $con->query("SELECT user_id FROM instructor WHERE user_id='$user_id'");
if(mysqli_num_rows($check_instructor) > 0) {
	
	$update_course_ownership = $con->query("UPDATE course_info SET user_id = '1' WHERE user_id = '$user_id'");
	$delete_instructor = $con->query("DELETE FROM instructor WHERE user_id = '$user_id'");
	$delete_student = $con->query("DELETE FROM users WHERE id='$user_id'");

	if($update_course_ownership && $delete_instructor && $delete_student) {
   		header("Location: search.php?msg=success");
	} else {
        die('Error : ('. $con->errno .') '. $con->error);		
	}

} else {
	$delete = $con->query("DELETE FROM users WHERE id='$user_id'");
	if($delete) {
	    header("location: search.php?msg=success");
	} else {
        die('Error : ('. $con->errno .') '. $con->error);
	}
}

?>