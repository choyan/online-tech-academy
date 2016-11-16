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
$delete_cat = $con->query("DELETE FROM course_categories WHERE id='$cat_id'");
$delete_sub = $con->query("DELETE FROM course_subcategories WHERE course_category_id='$cat_id'");
if($delete_cat && $delete_sub) {
    header("location: delete-category.php?msg=success");
} else {
   header("location: delete-category.php?msg=failed");	
}
?>