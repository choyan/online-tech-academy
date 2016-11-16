<?php 
include 'db.php';
$timestamp = date('Y-m-d H:i:s');

if(isset($_SESSION['id'])) {
	$user_id = $_SESSION['id'];
}

function is_logged_in() {

}

function get_user_id($con, $username) {

	$user_id = $con->query("SELECT * FROM users WHERE username = '$username'")->fetch_object()->id; 
	return $user_id;

}

function get_username($con, $user_id) {

	$username = $con->query("SELECT full_name FROM users WHERE id = '$user_id'")->fetch_object()->full_name; 
	return $username;

}

function get_author_id($con, $course_id) {
	$author_id = $con->query("SELECT user_id FROM course_info WHERE  id= '$course_id'")->fetch_object()->user_id;
	return $author_id;
}

function is_instructor($con, $user_id) {
    $check_instructor = $con->query("SELECT user_id FROM instructor WHERE user_id='$user_id' AND ins_status=1");
    if(mysqli_num_rows($check_instructor) > 0) {
    	return 1;
    } else {
    	return 0;
    }
}

function is_admin($con, $user_id) {
	$admin_conf = $con->query("SELECT role FROM users WHERE id='$user_id'")->fetch_object()->role;
	return $admin_conf;
}
?>