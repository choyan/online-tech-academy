<?php
session_start();

if(!isset($_SESSION['id'])) {
   header("Location: login.php");
}
include 'functions.php';
$user_id = $_SESSION['id'];

$dir="data/video/"; 
if (isset($_REQUEST["file"])) { 
    $file = $dir.$_REQUEST["file"]; 

    $file_name = $_REQUEST['file'];
	$check_file = file_exists($file);

	if($check_file == 1) {

		$course_id = $con->query("SELECT course_id FROM lectures WHERE video_url='$file_name'")->fetch_object()->course_id;
		$instructor_id = $con->query("SELECT user_id FROM course_info WHERE id='$course_id'")->fetch_object()->user_id;
		$check_access = $con->query("SELECT user_id FROM student_courses WHERE course_id = '$course_id' AND user_id = '$user_id'");
		if(mysqli_num_rows($check_access) == 1 || is_admin($con, $user_id) == 1 || $instructor_id == $user_id) {
		    header("Content-type: application/force-download"); 
		    header("Content-Transfer-Encoding: Binary"); 
		    header("Content-length: ".filesize($file)); 
		    readfile("$file");
		} else {
			header("Location: not-allowed.php");
		}

	} else {
		header("Location: 404.php");
	}

	echo $check_file;


} else { 
    echo "No file selected"; 
} 
 ?>