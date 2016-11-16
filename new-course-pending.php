<?php 
session_start();
if(!isset($_SESSION['id'])) {
   header("Location: login.php");
}
include 'functions.php';
if(is_admin($con, $user_id) == 0) {
    header("location: not-allowed.php");
}
?>

<!doctype html>
<html class="no-js" lang="">
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <title>New Course Pending</title>
        <meta name="description" content="">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <link rel="apple-touch-icon" href="apple-touch-icon.png">
        <!-- Place favicon.ico in the root directory -->

        <link rel="stylesheet" href="assets/css/pure-table.css">
        <link rel="stylesheet" href="assets/css/font-awesome.css">
        <link rel="stylesheet" href="assets/css/main.css">
    </head>
    <body>
        <!--[if lt IE 8]>
            <p class="browserupgrade">You are using an <strong>outdated</strong> browser. Please <a href="http://browsehappy.com/">upgrade your browser</a> to improve your experience.</p>
        <![endif]-->
        <?php 
            include 'header.php';
        ?>
        <div class="container">
            <div class="row">
                <h1>New Course Pending</h1>
                <hr>
                <div class="instructor-pending">
                	<?php
                        if(isset($_GET['msg'])) {
                            if($_GET['msg'] == 'success') {
                                echo "<div class='panel panel-small panel-success text-center' role='alert'>Coursee published Successfully</div>";
                            } else if($_GET['msg'] == 'failed') {
                                echo "<div class='panel panel-small panel-danger text-center' role='alert'>Error Occured. Cant publish at the moment.</div>";
                            } else if($_GET['msg'] == 'success-reject'){
                                echo "<div class='panel panel-small panel-success text-center' role='alert'>Rejected the requested</div>";
                            } else {
                                echo "<div class='panel panel-small panel-success text-center' role='alert'>Error Occured. Cant reject at the moment.</div>";
                            }
                        }
                		$list_request = $con->query("SELECT * FROM course_info WHERE status=0");
                		if(mysqli_num_rows($list_request) > 0) {
                			?>
    		            <table class="pure-table pure-table-striped" style="margin-bottom: 40px;">
    	                    <thead>
    	                    	<tr>
    		                        <th class="text-center">Course Name</th>
                                    <th class="text-center">Category</th>
    		                        <th class="text-center">Description</th>
                                    <th class="text-center">Total Lecture Uploaded</th>
                                    <th class="text-center">Price</th>
                                    <th class="text-center">Accept</th>
                                    <th class="text-center">Reject</th>
    	                        </tr>
    	                    </thead>
    	                    <tbody>
    	                    <?php
    	                        while ($course = $list_request->fetch_array()) {
    	                    ?>	
    	                    <tr class="text-center">
    	                        <td><a href="show-course.php?id=<?= $course['id']; ?>"><?= $course['course_title']; ?></a></td>
    	                        <td>
                                    <?php
                                        $cat = $course['course_category'];
                                        $get_category = $con->query("SELECT name FROM course_categories WHERE id='$cat'")->fetch_object()->name;
                                     ?>
                                     <a href="category.php?id=<?= $cat ?>"><?= $get_category; ?></a>
                                </td>
                                <td><?= $course['course_description']; ?></td>
                                <td>
                                    <?php 
                                        $course_id = $course['id'];
                                        $total_lecture = $con->query("SELECT COUNT(*) FROM lectures WHERE course_id = '$course_id'");
                                        $row = $total_lecture->fetch_row();
                                        echo $row[0];

                                     ?>
                                </td>
                                <td><?= $course['course_price']; ?></td>
                                <td><a href="accept-course-pending.php?id=<?= $course_id; ?>"><i class="fa fa-check"></i></a></td>
                                <td><a href="cancel-course-pending.php?id=<?= $course_id; ?>"><i class="fa fa-times"></i></a></td>
    	                    </tr>
    	                    <?php
    	                        }
    	                    ?>
    	                    </tbody>
    	                </table>
                			<?php
                		} else {
                			echo "<h3 class='text-center' style='margin-bottom: 40px;''>No new Request</h3>";
                		}
                	?>

                </div>
            </div>    
        </div>

        <?php 
            include 'footer.php';
        ?>
