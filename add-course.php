<?php
session_start();
if(!isset($_SESSION['id'])) {
   header("Location: login.php");
}
include 'functions.php';
$user_id = $_SESSION['id'];

?>

<!doctype html>
<html class="no-js" lang="">
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <title>Add New Course</title>
        <meta name="description" content="">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <link rel="apple-touch-icon" href="apple-touch-icon.png">
        <!-- Place favicon.ico in the root directory -->

        <link rel="stylesheet" href="assets/css/pure-table.css">
        <link rel="stylesheet" href="assets/css/font-awesome.css">
        <link rel="stylesheet" href="assets/css/main.css">
    </head>
    <body class="add-course">
        <!--[if lt IE 8]>
            <p class="browserupgrade">You are using an <strong>outdated</strong> browser. Please <a href="http://browsehappy.com/">upgrade your browser</a> to improve your experience.</p>
        <![endif]-->
        <?php 
            include 'header.php';
        ?>

        <div class="container">
            <?php 
                $check_instructor = $con->query("SELECT user_id FROM instructor WHERE user_id='$user_id' AND ins_status=1");
                if(mysqli_num_rows($check_instructor) == 0) {
                    ?>
                    <div class="not-allowed">
                        <div class="panel text-center">You are not an Instructor to create course. Please apply <a href="apply-as-instructor.php"> here </a> to become an Instructor.</div>
                    </div>
                    <?php
                } else {

            ?>
            <form action="<?php echo $_SERVER['PHP_SELF'];?>" method="post" enctype="multipart/form-data" class="pure-form pure-form-aligned">
                <?php
                    if ($_SERVER['REQUEST_METHOD'] == 'POST') {

                        $name = $_POST['course_name'];
                        $category_id = $_POST['category'];
                        $subcategory_id = $_POST['sub-category'];
                        $requirement = $_POST['requirement'];
                        $price = $_POST['price'];
                        $description = $_POST['description'];


                        $verify_name = $con->query("SELECT course_title FROM course_info WHERE course_title='$name'");

                        if(mysqli_num_rows($verify_name) == 0) {

                            //base variable
                            $target_dir = "data/images/";
                            $file_name = $_FILES['banner_img']['name'];
                            $uploadOk = 1;
                            $imageFileType = pathinfo($file_name, PATHINFO_EXTENSION);

                            // Check if really an image
                            $check_image = getimagesize($_FILES["banner_img"]["tmp_name"]);
                            if($check_image !== false) {
                                //echo "File is an image - " . $check_image["mime"] . ".";
                                $uploadOk = 1;
                            } else {
                                echo "File is not an image.";
                                $uploadOk = 0;
                            }

                            // Check file size
                            if ($_FILES["banner_img"]["size"] > 500000) {
                                echo "Sorry, your file is too large.";
                                $uploadOk = 0;
                            }

                            // Allow certain file formats
                            if($imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg") {
                                echo "Sorry, only JPG, JPEG, PNG files are allowed.";
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
                                // $timestamp = date('Y-m-d H:i:s');


                                if (move_uploaded_file($_FILES["banner_img"]["tmp_name"], $target_file)) {
                                    $insert_data = $con->query("INSERT INTO course_info (user_id, course_category, course_sub_category, course_title, course_requirement, course_price, course_description, banner_img, published) VALUES('$user_id', '$category_id', '$subcategory_id', '$name', '$requirement', '$price', '$description', '$newfilename', '$timestamp')");
                                    if(!$insert_data) {
                                        die('Error : ('. $con->errno .') '. $con->error);
                                    } else {
                                        echo "<div class='panel panel-success' role='alert'>New Course has been added.</div>";
                                    }

                                } else {
                                    echo "Sorry, there was an error uploading your file.";
                                }
                            }

                        } else {
                            echo "<div class='panel panel-danger' role='alert'>Same course name already exist</div>";
                        }
                    }

                ?>
                <h1>Add Course</h1>
                <hr>

                <div class="pure-control-group">
                    <label for="username">Course Name</label>
                    <input type="text" class="pure-input-2-3" id="course_name" placeholder="Course Name" name="course_name">
                </div>

                <div class="pure-control-group">
                    <label for="category">Select Category</label>
                    <select class="pure-input-2-3" name="category" id="category_id">
                    <?php
                        $course_categories = $con->query("SELECT * from course_categories");
                        while($row = $course_categories->fetch_array()) {
                    ?>
                        <option value="<?php echo $row['id']; ?>"><?php echo $row['name']; ?></option>
                    <?php
                        }
                    ?>
                    </select>
                </div>

                <div class="pure-control-group">
                    <label for="sub-category">Select Subcategory:</label>
                    <select class="pure-input-2-3" name="sub-category" id="sub-category"></select>
                </div>

                <div class="pure-control-group">
                    <label for="description">Course Description</label>
                    <textarea class="pure-input-2-3" rows="3" name="description"></textarea>
                </div>

                <div class="pure-control-group">
                    <label for="username">Course Requirement</label>
                    <textarea class="pure-input-2-3" rows="3" name="requirement"></textarea>
                </div>

                <div class="pure-control-group">
                    <label for="username">Course Price</label>
                    <input type="number" class="pure-input-2-3" id="price" placeholder="Course Price" name="price" min="1">
                </div>

                

                <div class="pure-control-group">
                    <label for="exampleInputFile">Banner Image</label>
                    <input type="file" id="banner_img" name="banner_img" class="text-center center-block panel panel-small">
                </div>


                <button type="submit" class="button">Add Course</button>
            </form>
            <?php 
                }
            ?>
        </div>
        
        <?php 
            include 'footer.php';
        ?>