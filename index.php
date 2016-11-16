<?php 
session_start();
include 'functions.php';

?>

<!doctype html>
<html class="no-js" lang="">
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
    <body class="homepage">
        <!--[if lt IE 8]>
            <p class="browserupgrade">You are using an <strong>outdated</strong> browser. Please <a href="http://browsehappy.com/">upgrade your browser</a> to improve your experience.</p>
        <![endif]-->
        
        <?php 
            include 'header.php';
        ?>

        <div class='homepage-hero'>
            <div class='container'>
                <div class='row text-center'>
                    <h2 class='headline'>Learn What You Love</h2>
                    <h3 class='subtitle'>Take High-Quality Online Courses from the Best Online Instructors of Bangladesh &amp; Develop Your Skills.</h3>
                    <?php 
                        if(!isset($_SESSION['id'])) {
                        ?>
                        <a class='button' href='registration.php'>JOIN Repto Education Center</a>
                        <?php                        
                        }
                    ?>
                </div>
            </div>
        </div>

        <div class="services">
            <div class="container">
                <div class="row">
                    <h2 class="text-center">How does Repto work?</h2>
                    <div class="grid-4  text-center">
                        <div class="service">
                            <div class="icon">
                                <i class="fa fa-book"></i>
                            </div>
                            <div class="content">
                                <h4>Choose a Course</h4>
                                <p>Choose your favourite courses from the largest collection of High-Quality Online Bangla courses.</p>
                            </div>
                        </div>
                    </div>
                    <div class="grid-4  text-center">
                        <div class="service">
                            <div class="icon">
                                <i class="fa fa-laptop"></i>
                            </div>
                            <div class="content">
                                <h4>Study Anywhere</h4>
                                <p>Watch videos, take quizzes and complete interactive assignments from anywhere in Office, Home or Class!</p>
                            </div>
                        </div>
                    </div>
                    <div class="grid-4  text-center">
                        <div class="service">
                            <div class="icon">
                                <i class="fa fa-rocket"></i>
                            </div>
                            <div class="content">
                                <h4>Boost Your Career</h4>
                                <p>Boost your career by developing your skills and knowledge and start a new life by creating your own Job.</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <hr>

        <div class="popular-courses category-view">
            <div class="container">
                <h2 class="text-center">Most Popular Courses</h2>
                <div class="row">
                    <?php 
                        $course_list = $con->query("SELECT LEFT(course_description, 130), id, course_title, banner_img, user_id, published FROM course_info WHERE status=1 ORDER BY sell_count DESC LIMIT 3");
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
                     ?>
                </div>
            </div>
        </div>

        <?php 
            include 'footer.php';
        ?>