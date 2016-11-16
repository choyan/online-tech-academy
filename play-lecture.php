<?php
session_start();
if(!isset($_SESSION['id'])) {
   header("Location: login.php?msg=2");
}
$student_id = $_SESSION['id'];
include 'functions.php';

?> 

<!doctype html>
<html class="no-js" lang="">
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <title>Your website title</title>
        <meta name="description" content="">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <link rel="apple-touch-icon" href="apple-touch-icon.png">
        <!-- Place favicon.ico in the root directory -->
        <link rel="stylesheet" href="assets/css/pure-table.css">
        <link rel="stylesheet" href="assets/css/font-awesome.css">
        <link rel="stylesheet" href="assets/css/main.css">
    </head>
    <body class="not-allowed  play-course">
        <!--[if lt IE 8]>
            <p class="browserupgrade">You are using an <strong>outdated</strong> browser. Please <a href="http://browsehappy.com/">upgrade your browser</a> to improve your experience.</p>
        <![endif]-->

        <?php 
        include 'header.php'; ?>

        <div class="container">
            <div class="row">
                <?php 
                    if (empty($_GET)) {
                        ?>
                        <div class="panel text-center">No Course ID available. Please check again.</div>
                        <?php
                    } else {
                        $course_id = $_GET['course'];
                        $lecture_id = $_GET['lecture'];

                        $course_info = $con->query("SELECT course_title, user_id, published FROM course_info WHERE id='$course_id'");
                        $course_info = $course_info->fetch_assoc();

                        $lecture_info  = $con->query("SELECT * FROM lectures WHERE id='$lecture_id'");
                        $lecture_info = $lecture_info->fetch_assoc();

                        $author_id = $course_info['user_id'];
                        $author_info = $con->query("SELECT id, full_name, about_me, profile_pic FROM users WHERE id='$author_id'");
                        $author_info = $author_info->fetch_assoc();

                        $section_id = $lecture_info['course_section_id'];


                        if(mysqli_num_rows($con->query("SELECT course_id FROM sections WHERE id = '$section_id'")) == 0) {
                            ?>
                            <div class="panel text-center">No Course ID available. Please check again.</div>
                        <?php
                        } else {
                            $check_section = $con->query("SELECT course_id FROM sections WHERE id = '$section_id'")->fetch_object()->course_id;
                            if((!$check_section) || ($course_id != $check_section)) {
                                ?>
                                <div class="panel text-center">No Course ID available. Please check again.</div>
                                <?php
                            } else {
                                $check_course_allowance = $con->query("SELECT user_id FROM student_courses WHERE user_id='$student_id'");
                                if((mysqli_num_rows($check_course_allowance) > 0) || $course_info['user_id'] == $user_id ) {
                                    ?>
                                <div class="title-area">
                                    <h1><?= $course_info['course_title']; ?></h1>
                                    <div class="desc">
                                        <?php 
                                            $date = date_create($course_info['published']);
                                        ?>
                                        <p class="author">by <a href="instructor.php?id=<?= $author_info['id']; ?>"><?= $author_info['full_name']; ?></a> on <?= date_format($date, 'jS F Y'); ?> </p>
                                    </div>
                                </div>
                                <div class="grid-4">
                                    <div class="lecture-list">
                                    <?php 
                                        $section_list = $con->query("SELECT id, title FROM sections WHERE course_id = '$course_id'");
                                        while ($section = $section_list->fetch_array()) {
                                            ?>
                                            <div class="section-divide">
                                                <ul>
                                                    <li><?php echo $section['title']; ?></li>
                                                    <?php
                                                        $section_id = $section['id'];
                                                        $lecture_list = $con->query("SELECT id, title FROM lectures WHERE course_section_id = '$section_id'");
                                                        ?>
                                                        <ul>
                                                        <?php
                                                        while ($lecture = $lecture_list->fetch_array()) {
                                                            ?>
                                                                <li>
                                                                    <a href="play-lecture.php?course=<?= $course_id; ?>&lecture=<?= $lecture['id'];; ?>"><i class="fa fa-angle-double-right"></i> <?php echo $lecture['title']; ?>
                                                                    </a>
                                                                </li>
                                                            <?php
                                                        }
                                                        ?>
                                                        </ul>
                                                        <?php
                                                    ?>
                                                </ul>
                                            </div>
                                            <?php
                                        }
                                    ?>
                                    </div>
                                </div>
                                
                                <div class="grid-8">
                                    <?php 
                                        $poster_url = $con->query("SELECT banner_img FROM course_info WHERE id = '$course_id'")->fetch_object()->banner_img;
                                        $poster_url = "data/images/{$poster_url}";

                                        $file_path = "data/video/{$lecture_info['video_url']}";
                                    ?>

                                    <video controls autoplay="yes" name="media">
                                        <source src="get-file.php?file=<?php echo $lecture_info['video_url']; ?>" type="video/mp4">
                                    </video>


                                </div>
                                
                                <?php
                            } else {
                                ?>
                                <div class="panel text-center">You dont have access to this course. Please <a href="show-course.php?id=<?= $course_id; ?>" class="strong">BUY</a> it to gain access.</div>
                                <?php
                            }
                        }
                    }
                }
                ?>
                <div class="author-info">
                    <div class="pro_pic text-center">
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
                    <p class="name text-center"><?= $author_info['full_name']; ?></p>
                    <div class="desc">
                        <p><?= $author_info['about_me']; ?></p>
                    </div>
                </div>
            </div>
            
        </div>
        <?php 
        include 'footer.php'; ?>
