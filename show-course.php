<?php 
session_start();
if(!isset($_SESSION['id'])) {
   header("Location: login.php?msg=2");
}
include 'functions.php';
$user_id = $_SESSION['id'];
$course_id = $_GET['id'];
?>

<!doctype html>
<html class="no-js" lang="">
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <title>Show Course</title>
        <meta name="description" content="">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <link rel="apple-touch-icon" href="apple-touch-icon.png">
        <!-- Place favicon.ico in the root directory -->

        <link rel="stylesheet" href="assets/css/pure-table.css">
        <link rel="stylesheet" href="assets/css/font-awesome.css">
        <link rel="stylesheet" href="assets/css/main.css">
    </head>
    <body class="add-course play-course show-course">
        <!--[if lt IE 8]>
            <p class="browserupgrade">You are using an <strong>outdated</strong> browser. Please <a href="http://browsehappy.com/">upgrade your browser</a> to improve your experience.</p>
        <![endif]-->

        <?php 
        include "header.php";
         ?>

        <div class="container">
            <div class="row">
                <div class="grid-8">
                    <div class="lecture-intro">
                        <?php
                            $course_info = $con->query("SELECT course_category, course_sub_category, banner_img, course_description, course_requirement, course_title, course_price FROM course_info WHERE id= '$course_id'");
                            $course_info = $course_info->fetch_assoc();

                            $cat_id = $course_info['course_category'];
                            $category_name = $con->query("SELECT name FROM course_categories WHERE id='$cat_id' ")->fetch_object()->name;

                            $sub_id = $course_info['course_sub_category'];
                            $sub_name = $con->query("SELECT name FROM course_subcategories WHERE id='$sub_id' ")->fetch_object()->name;
                            
                        ?>
                        <h1>
                            <span style="font-size: 16px;">
                                <a href="category.php?id=<?= $cat_id; ?>">
                                    <?= $category_name; ?>
                                </a>
                                <i class="fa fa-angle-right"></i>
                                <a href="sub-category.php?id=<?= $sub_id; ?>">
                                    <?= $sub_name; ?>
                                </a>
                                <i class="fa fa-angle-right"></i>
                            </span>
                            <?= $course_info['course_title']; ?>
                        </h1>
                        <img src="data/images/<?= $course_info['banner_img']; ?>" alt="">
                    </div>

                    <div class="section about-me">
                        <span class="h3">Description:</span>
                        <p>
                            <?= $course_info['course_description']; ?>
                        </p>
                    </div>

                    <div class="section about-me">
                        <span class="h3">Course Requirement:</span>
                        <p>
                            <?= $course_info['course_requirement']; ?>
                        </p>
                    </div>
                    
                    <div class="section about-me lecture-list">
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
                <div class="grid-4">
                    <div class="buy">
                        <div class="price">
                             ৳ <?= $course_info['course_price']; ?>
                        </div>
                        <?php
                            $author_id = get_author_id($con, $course_id);
                            $is_admin = is_admin($con, $user_id);
                            $check_bought = $con->query("SELECT id FROM student_courses WHERE user_id = '$user_id' AND course_id = '$course_id'");
                            $chk = mysqli_num_rows($check_bought);

                            if($author_id == $user_id || $is_admin == 1) {
                                ?>
                                <a class="button" href="edit-course.php?id=<?php echo $course_id; ?>" class="btn btn-info">Edit Course Info</a>
                                <a class="button" href="add-section.php?cid=<?php echo $course_id; ?>" class="btn btn-info">Edit Lectures</a>
                                <?php
                            }
                            else if($author_id != $user_id && $chk == 1 ){
                                ?>
                                <?php
                            } else {
                                ?>
                                <a class="button" href="pay.php?id=<?php echo $course_id; ?>" class="btn btn-info">Buy Course</a>                    
                                <?php
                            }

                        ?>
                    </div>
                    <div class="author-widget">
                        <div class="author-image"></div>
                        <div class="bio">
                            <?php 
                                $author_bio = $con->query("SELECT * FROM instructor WHERE user_id='$author_id'");
                                $author_name = $con->query("SELECT full_name FROM users WHERE id = '$author_id'")->fetch_object()->full_name;
                                $author_desc = $con->query("SELECT about_me FROM users WHERE id = '$author_id'")->fetch_object()->about_me;
                                ?>
                                <p><strong>Name:</strong> <a href="instructor.php?id=<?= $author_id; ?>"> <?php echo $author_name; ?></a></p>
                                <?php
                                while ($row = $author_bio->fetch_array()) {
                                    ?>
                                    <p><strong>Institute: </strong> <?php echo $row['institute'] ?></p>
                                    <p><strong>Designation: </strong> <?php echo $row['designation'] ?></p>
                                    <p><strong>Bio:</strong> <?php echo $author_desc; ?></p>
                                    <?php
                                }
                            ?>
                        </div>
                    </div>
                </div>
            </div>
        </div>


        <?php 
        include "footer.php";
        ?>