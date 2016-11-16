<?php 
session_start();
if(!isset($_SESSION['id'])) {
   header("Location: login.php");
}
include 'functions.php';
if(is_admin($con, $user_id) == 0) {
    header("location: not-allowed.php");
}
$cat_id = $_GET['id'];
$delete_sub = $con->query("DELETE FROM course_subcategories WHERE id='$cat_id'");
if($delete_sub) {
    header("location: delete-subcategory.php?msg=success");
} else {
   header("location: delete-category.php?msg=failed");	
}
?>