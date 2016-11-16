<?php 
session_start();
// if(!isset($_SESSION['id'])) {
//    header("Location: login.php");
// }
include 'functions.php';
$cat = $_GET['id'];
?>

<!doctype html>
<html class="no-js" lang="en">
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <title>Repto Education</title>
        <meta name="description" content="">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <link rel="apple-touch-icon" href="apple-touch-icon.png">
        <!-- Place favicon.ico in the root directory -->

        <link rel="stylesheet" href="assets/css/font-awesome.css">
        <link rel="stylesheet" href="assets/css/main.css">
    </head>
    <body class="category-view">
        <!--[if lt IE 8]>
            <p class="browserupgrade">You are using an <strong>outdated</strong> browser. Please <a href="http://browsehappy.com/">upgrade your browser</a> to improve your experience.</p>
        <![endif]-->

        <?php 
            include 'header.php';
         ?>

        <div class="container">
            <div class="row">
                <?php 
                    $cat_name = $con->query("SELECT name FROM course_categories WHERE id='$cat'")->fetch_object()->name;
                ?>
                <div class="sort-type">
                    Categories
                </div>
        
                <h1><?php echo $cat_name; ?></h1>
                <hr>
                <?php 
                    $course_list = $con->query("SELECT LEFT(course_description, 130), id, course_title, banner_img, user_id, published FROM course_info WHERE course_category = '$cat' AND status=1");
                    while ($course_single = $course_list->fetch_array() ) {
                        ?>
                        <div class="grid-4">            
                            <div class="course-single">
        
                                <div class="banner">
                                    <img src="data/images/<?= $course_single['banner_img']; ?>" alt="">
                                </div>
                                <div class="course-info">
                                    <a href="show-course.php?id=<?= $course_single['id']; ?>" class="title"><?= $course_single['course_title']; ?></a>
                                    <div class="desc"><?= $course_single['LEFT(course_description, 130)']; ?>...</div>
                                    <div class="author-info">
                                        <?php 
                                            $author_id = $course_single['user_id'];
                                            $author_info = $con->query("SELECT id, full_name, profile_pic FROM users WHERE id='$author_id'");
                                            $author_info = $author_info->fetch_assoc();
                                        ?>
                                        <div class="pro-pic">
                                            <?php 
                                                if($author_info['profile_pic'] == NULL) {
                                                    $img_src = 'assets/img/200.png';
                                                    echo "<img src='$img_src' class='avatar img-circle img-thumbnail' alt='avatar'>";
                                                } else {
                                                    $img_src = $author_info['profile_pic'];
                                                    echo "<img src='data/images/$img_src' class='avatar img-circle img-thumbnail' alt='avatar'>";
                                                }
                                            ?>
                                        </div>
                                        <?php 
                                            $date = date_create($course_single['published']);
                                        ?>
                                        <div class="name"> <a href="instructor.php?id=<?= $author_info['id']; ?>"> <?= $author_info['full_name']; ?></a> <br> <?= date_format($date, 'jS F Y'); ?></div>
                                    </div>
                                </div>
                            </div>            
                        </div>
                            <?php
                        }
                        mysqli_close($con);
                    ?>

            </div>
        </div>


        <?php 
            include 'footer.php';
         ?>