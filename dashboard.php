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
        <title>Dashboard</title>
        <meta name="description" content="">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <link rel="apple-touch-icon" href="apple-touch-icon.png">
        <!-- Place favicon.ico in the root directory -->

        <link rel="stylesheet" href="assets/css/pure-table.css">
        <link rel="stylesheet" href="assets/css/font-awesome.css">
        <link rel="stylesheet" href="assets/css/main.css">
    </head>
    <body class="dashboard">
        <!--[if lt IE 8]>
            <p class="browserupgrade">You are using an <strong>outdated</strong> browser. Please <a href="http://browsehappy.com/">upgrade your browser</a> to improve your experience.</p>
        <![endif]-->
        <?php 
            include 'header.php';
        ?>
        <div class="container">
            <div class="row">
                <div class="grid-4">
                    <div class="admin-actions">
                        <ul>
                            <li><a href="search.php"><i class="fa fa-angle-double-right"></i> Search Profile</a></li>
                            <li><a href="todays-sell.php"> <i class="fa fa-angle-double-right"></i> Todays Sell</a></li>
                            <li><a href="new-course-pending.php"><i class="fa fa-angle-double-right"></i> New Course Pending Request</a></li>
                            <li><a href="list-pending-request.php"><i class="fa fa-angle-double-right"></i> Payment Pending Request</a></li>
                            <li><a href="instructor-payment.php"><i class="fa fa-angle-double-right"></i> Instructor Payment</a></li>
                            <li><a href="payment-history.php"><i class="fa fa-angle-double-right"></i> Instructor Payment History</a></li>
                            <li><a href="instructor-pending.php"><i class="fa fa-angle-double-right"></i> Accept as Instructor Request Pending</a></li>
                            <li>
                                <a href="#" class="expander">
                                    <i class="fa fa-angle-double-right"></i> Category
                                </a>
                                <ul class="content">
                                    <li><a href="add-category.php"><i class="fa fa-angle-double-right"></i> Add Category</a></li>
                                    <li><a href="delete-category.php"><i class="fa fa-angle-double-right"></i> Delete Category</a></li>
                                </ul>
                            </li>
                            <li>
                                <a href="#" class="expander">
                                    <i class="fa fa-angle-double-right"></i> Sub-Category
                                </a>
                                <ul class="content">
                                    <li><a href="add-subcategory.php"><i class="fa fa-angle-double-right"></i> Add Sub-Category</a></li>
                                    <li><a href="delete-subcategory.php"><i class="fa fa-angle-double-right"></i> Delete Sub-Category</a></li>
                                </ul>
                            </li>
                        </ul>
                    </div>
                </div>
                <div class="grid-8">
                    <div class="todays-action">
                        <h1>Todays Action</h1>
                        <hr>
                        <div class="row">
                            <div class="grid-4">
                                <div class="action">
                                    <?php 
                                        $timestamp = date('Y-m-d');
                                        $total = $con->query("SELECT SUM(amount) AS total FROM course_transaction WHERE date LIKE '%$timestamp%'");
                                        $total = $total->fetch_assoc();
                                    ?>
                                     <?php 
                                        $total_course = $con->query("SELECT id FROM course_transaction WHERE date LIKE '%$timestamp%'");
                                    ?>
                                    <h2><?php echo mysqli_num_rows($total_course); ?></h2>
                                    <div>courses sold</div>   
                                </div>
                            </div>
                            <div class="grid-4">
                                <div class="action">
                                    <h2>
                                        <?php 
                                            if($total['total'] == 0) {
                                                echo "No";
                                            } else {
                                                echo "{$total['total']}৳";  
                                            }
                                         ?>
                                    </h2>
                                    <div>Sell</div>                      
                                </div>
                            </div>
                            <div class="grid-4">
                                <div class="action">
                                    <h2>
                                        <?php 
                                            if($total['total'] == 0) {
                                                echo "No";
                                            } else {
                                            	$rev = $total['total'] * 0.4;
                                                echo "$rev ৳";
                                            }
                                        ?>
                                     </h2>
                                    <div>Reveneue</div>
                                </div>
                            </div>

                        </div>
                    </div>
                </div>
            </div>
        </div>

        <?php 
            include 'footer.php';
        ?>
