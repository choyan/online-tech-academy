<?php 
session_start();
if(!isset($_SESSION['id'])) {
   header("Location: login.php");
}

include 'functions.php';
$user_id = $_SESSION['id'];
$student_id = $_GET['id'];
$name = get_username($con, $student_id);

?>

<!doctype html>
<html class="no-js" lang="">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title><?= $name ?>'s' Profile</title>
    <meta name="description" content="">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <link rel="apple-touch-icon" href="apple-touch-icon.png">
    <!-- Place favicon.ico in the root directory -->

    <!-- <link rel="stylesheet" href="assets/css/bootstrap.min.css"> -->

    <link rel="stylesheet" href="assets/css/pure-table.css">
    <link href="https://fonts.googleapis.com/css?family=Lato:400,700" rel="stylesheet">
    <link rel="stylesheet" href="assets/css/font-awesome.css">
    <link rel="stylesheet" href="assets/css/main.css">
</head>

<body class="profile">
    <!--[if lt IE 8]>
        <p class="browserupgrade">You are using an <strong>outdated</strong> browser. Please <a href="http://browsehappy.com/">upgrade your browser</a> to improve your experience.</p>
    <![endif]-->

    <?php 
    include 'header.php';
     ?>

    <div class="container">
        <div class="row">
            <div class="grid-10 push-1">
                <?php 
                    $check_instructor = $con->query("SELECT user_id FROM instructor WHERE user_id = '$student_id'");
                    if(mysqli_num_rows($check_instructor) == 0) {
                        echo "<h1 class='text-center'>No Instructor Found</h1>";
                    } else {
                        $user_info = $con->query("SELECT * FROM users WHERE id='$student_id'");
                        $user_info = $user_info->fetch_assoc();
                        $instructor_info = $con->query("SELECT * FROM instructor WHERE user_id='$student_id'");
                        $instructor_info = $instructor_info->fetch_assoc();
                ?>
                <!-- profile -->
                <div class="section info">
                    <div class="row">
                        <div class="grid-4">
                            <figure class="text-center">
                                <?php 
                                    if($user_info['profile_pic'] == NULL) {
                                        $img_src = 'assets/img/200.png';
                                        echo "<img src='$img_src' class='avatar img-circle img-thumbnail' alt='avatar'>";
                                    } else {
                                        $img_src = $user_info['profile_pic'];
                                        echo "<img src='data/images/$img_src' class='avatar img-circle img-thumbnail' alt='avatar'>";
                                    }
                                ?>
                            </figure>
                            <?php 
                                if(($user_id == $student_id) || (is_admin($con, $user_id) == 1)) {
                                    echo "<a href='edit-instructor-information.php?id=$student_id' class='button button-small'>Edit Instructor Information</a>";
                                }
                            ?>
                        </div>
                        <div class="grid-8">
                            <ul class="list-group user-info">
                                <li class="list-group-item"><i class="fa fa-user"></i> <?php echo $user_info['full_name'] ?></li>
                                <li class="list-group-item"><i class="fa fa-address-card-o" aria-hidden="true"></i> <?php echo $instructor_info['institute']; ?>
                                </li>
                                <li class="list-group-item"><i class="fa fa-user-circle" aria-hidden="true"></i> <?php echo $instructor_info['designation']; ?>
                                </li>
                                <li class="list-group-item"><i class="fa fa-address-book-o" aria-hidden="true"></i> <?php echo $instructor_info['office']; ?>
                                </li>
                                <li class="list-group-item"><i class="fa fa-phone"></i> <?php echo $user_info['phone'] ?> </li>
                                <li class="list-group-item"><i class="fa fa-envelope"></i> <?php echo $user_info['email'] ?></li>
                            </ul>
                        </div>
                    </div>
                </div>

                <div class="section about-me">
                    <span class="h3">About Me:</span>
                    <p>
                        <?php echo $user_info['about_me'] ?>
                    </p>
                </div>

                <div class="section course">
                    <span class="h3">Uploaded Courses:</span>
                    <table class="pure-table pure-table-striped">
                        <thead>
                            <tr>
                                <th>Course Name:</th>
                                <th>Date of Upload</th>
                                
                            </tr>
                        </thead>
                        <tbody>
                            <?php 
                                $instructor_courses = $con->query("SELECT * FROM course_info WHERE user_id = '$student_id'");
                                while($row = $instructor_courses->fetch_array()) {
                            ?>
                            <tr>
                                <td>
                                    <?php 
                                        $course_id = $row['id'];
                                        $course_name = $con->query("SELECT course_title FROM course_info WHERE id = '$course_id'")->fetch_object()->course_title;
                                        echo "<a href='show-course.php?id=$course_id'>$course_name</a>";
                                    ?>
                                </td>
                                <td>
                                    <?php 
                                        $date = date_create($row['published']);
                                        echo date_format($date, 'jS F g:ia');
                                    ?>
                                </td>
                                
                                
                            </tr>
                            <?php 
                                }
                            }
                            ?>
                        </tbody>
                    </table>
                </div>
            </div>
            <!-- resume -->

        </div>
        
    </div>

        <?php 
    include 'footer.php';
     ?>