<?php 
session_start();
if(!isset($_SESSION['id'])) {
   header("Location: login.php");
}
include 'functions.php';

$cid = $_GET['cid']; // course id
if(isset($_GET['sid'])) {
    $sid = $_GET['sid'];
}
?>

<!doctype html>
<html class="no-js" lang="">
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <title>Edit Section</title>
        <meta name="description" content="">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <link rel="apple-touch-icon" href="apple-touch-icon.png">
        <!-- Place favicon.ico in the root directory -->

        <link rel="stylesheet" href="assets/css/pure-table.css">
        <link rel="stylesheet" href="assets/css/font-awesome.css">
        <link rel="stylesheet" href="assets/css/main.css">
        <script src="assets/js/jquery.min.js"></script>
        <script src="assets/js/jquery.easyModal.js"></script>
    </head>
    <body class="add-section">
        <?php 
        include "header.php";
         ?>
    <?php       
        if (!empty($_POST['section-submit'])) {

            $name = $con->real_escape_string($_POST['name']);
            $description = $con->real_escape_string($_POST['description']);

            if(empty($name) || empty($description)) {
                ?>
                <div class="container">
                    <div class="row">
                        <div class="panel panel-danger">Cant add an empty Section. Please fill up all fields.</div>
                    </div>
                </div>
                <?php
            } else {
                $verify_info = $con->query("SELECT * FROM sections WHERE title='$name' AND course_id = '$cid'");

                if(mysqli_num_rows($verify_info) == 0) {
                    $insert_data = $con->query("INSERT INTO sections (course_id, title, description) VALUES('$cid','$name', '$description')");
                    if(!$insert_data) {
                        die('Error : ('. $con->errno .') '. $con->error);
                    } else {
                        ?>
                        <div class="container">
                            <div class="row">
                                <div class="panel panel-success" role="alert">New Section has been added.</div>
                            </div>
                        </div>
                        <?php
                    }
                } else {
                    ?>
                    <div class="container">
                        <div class="row">
                            <div class="panel panel-danger">Cant add. Same name already exists.</div>
                        </div>
                    </div>
                    <?php
                }
            }

            
        }

        if (!empty($_POST['lecture-submit'])) {
            $title = $con->real_escape_string($_POST['title']);
            $lec_description = $con->real_escape_string($_POST['lec_description']);
            $target_dir = "data/video/";
            $file_name = $_FILES['video']['name'];
            $uploadOk = 1;
            $file_type = pathinfo($file_name, PATHINFO_EXTENSION);

            if($file_type != "mp4") {
                echo "Sorry, only MP4 files are allowed.";
                $uploadOk = 0;
            }

            // Check if $uploadOk is set to 0 by an error
            if ($uploadOk == 0) {
                echo "Sorry, your file was not uploaded.";
            // if everything is ok, try to upload file
            } else {
                
                $temp = explode(".", $file_name);
                $newfilename = round(microtime(true)) . '.' . end($temp);
                $target_file = $target_dir . basename($newfilename);

                if (move_uploaded_file($_FILES["video"]["tmp_name"], $target_file)) {
                    $insert_data = $con->query("INSERT INTO lectures (course_section_id, title, description, course_id, video_url) VALUES('$sid', '$title', '$lec_description', '$cid', '$newfilename')");
                    if(!$insert_data) {
                        die('Error : ('. $con->errno .') '. $con->error);
                    } else {
                        ?>
                        <div class="container">
                            <div class="row">
                                <div class='panel panel-success' role='alert'>New Lecture has been added.</div>
                            </div>
                        </div>
                        <?php
                    }

                } else {
                    ?>
                    <div class="container">
                        <div class="row">
                            <div class='panel panel-danger' role='alert'>there was an error uploading your file.</div>
                        </div>
                    </div>
                    <?php
                }

            }

        }
    ?>


        <div class="container">
            <div class="row">
                <?php 
                    if(isset($_GET['msg'])) {
                        if($_GET['msg'] == 'sec_success') {
                            ?>
                            <div class="panel panel-success">Section has been deleted successfully</div>
                            <?php
                        } else if($_GET['msg'] == 'lec_success') {
                            ?>
                            <div class="panel panel-success">Lecture has been deleted successfully</div>
                            <?php
                        } else {
                            ?>
                            <div class="panel panel-danger">Errr occured. try again pls.</div>
                            <?php
                        }
                    }
                ?>
                <div class="grid-4">
                    <div class="section-group">
                        <?php
                            $course_setions = $con->query("SELECT * from sections WHERE course_id = '$cid'");
                            while($row = $course_setions->fetch_array()) {
                        ?>
                        <div class="section-single">
                            <div class="section-heading">
                                <a role="button">
                                  <?php echo $row['title']; ?>
                                </a>
                                <a href="delete-section.php?id=<?= $row['id']; ?>&cid=<?= $cid; ?>" class="pull-right delete"><i class="fa fa-trash"></i></a>
                                <button type="button" class="button pull-right" id="open-section-<?php echo $row['id']; ?>" data-target="#section-<?php echo $row['id']; ?>">Add Lecture</button>
                            </div>
                            
                            <div class="section-body">
                                <div class="panel-body">
                                    <?php 
                                        $section_id = $row['id'];
                                        $lectures = $con->query("SELECT * from lectures WHERE course_section_id = '$section_id'");
                                    ?>
                                        <ul>
                                    <?php

                                        while($lecture = $lectures->fetch_array()) {
                                            ?>
                                                <li class="lecture-single">
                                                    <a href="play-lecture.php?course=<?= $cid; ?>&lecture=<?= $lecture['id']; ?>"> <?php echo $lecture['title'] ?></a>
                                                    <a href="delete-lecture.php?id=<?= $lecture['id']; ?>&cid=<?= $cid; ?>" class="pull-right delete" style="margin-right: 10px;"><i class="fa fa-trash"></i></a>
                                                </li>
                                            <?php
                                        }
                                        ?>
                                        </ul>
                                </div>
                            </div>
                            <!-- Add Lecture -->
                            <div class="modal" id="section-<?php echo $row['id']; ?>">       
                                <form action="add-section.php?cid=<?php echo $cid; ?>&sid=<?php echo $row['id']; ?>" method="post" enctype="multipart/form-data" class="pure-form pure-form-stacked"> 
                                    <div class="modal-header">
                                        <h4 class="modal-title" id="section-<?php echo $row['id']; ?>"><?php echo $row['title']; ?></h4>
                                    </div>
                                    <div class="modal-body">
                                        <label for="title">Title:</label>
                                        <input type="text" class="pure-input-2-3" id="title" placeholder="Lecture Title" name="title">

                                        <label for="lec_description">Description:</label>
                                        <textarea class="pure-input-2-3" rows="3" name="lec_description"></textarea>

                                        <label for="video">Video</label>
                                        <input type="file" id="video" name="video" class="text-center center-block panel panel-small file">
                                    </div>
                                    <div class="modal-footer">
                                        <button type="button" class="button close">Close</button>
                                        <input type="submit" name="lecture-submit" value="Add Section" class="button" />
                                    </div>
                                </form>
                            </div>
                            <script>
                                $(function() {
                                    $("#section-<?php echo $row['id']; ?>").easyModal({
                                        overlay : 0.4,
                                        overlayClose: false,
                                        closeOnEscape: false
                                    });
                                    $("#open-section-<?php echo $row['id']; ?>").click(function(e){
                                        $("#section-<?php echo $row['id']; ?>").trigger('openModal');
                                        e.preventDefault();
                                    });
                                });
                            </script>
                        </div>
                        <?php 
                            } 
                        ?>
                    </div>
                </div>
                <div class="grid-8">
                    <form action="add-section.php?cid=<?php echo $cid; ?>" method="post" class="pure-form pure-form-aligned">
                         
                        <h1>Add Section Name</h1>

                        <div class="pure-control-group">
                            <label for="name">Section Name</label>
                            <input type="text" class="pure-input-2-3" id="name" placeholder="Section Name" name="name">
                        </div>

                        <div class="pure-control-group">
                            <label for="name">Description</label>
                            <textarea class="pure-input-2-3" rows="3" name="description"></textarea>
                        </div>
                        
                        <input type="submit" name="section-submit" value="Add Section" class="button"  />
                    </form>
                </div>
            </div>
            <div class="footer">
                <p class="pull-right"><span class="fa fa-shield"></span> from Zahidul Hossain</p>
            </div>
        </div>

        


        <?php 
        include "footer.php";
         ?>