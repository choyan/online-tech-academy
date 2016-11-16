<?php 
session_start();
if(!isset($_SESSION['id'])) {
   header("Location: login.php");
}
include 'functions.php';
$course_id = $_GET['id'];

?>

<!doctype html>
<html class="no-js" lang="">
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <title>Edit Course</title>
        <meta name="description" content="">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <link rel="apple-touch-icon" href="apple-touch-icon.png">
        <!-- Place favicon.ico in the root directory -->

        <link rel="stylesheet" href="assets/css/pure-table.css">
        <link rel="stylesheet" href="assets/css/font-awesome.css">
        <link rel="stylesheet" href="assets/css/main.css">
    </head>
    <body class="edit-profile form edit-course add-course">
        <!--[if lt IE 8]>
            <p class="browserupgrade">You are using an <strong>outdated</strong> browser. Please <a href="http://browsehappy.com/">upgrade your browser</a> to improve your experience.</p>
        <![endif]-->
        <?php 
        include 'header.php'; ?>
        <?php 

            $course_info = $con->query("SELECT * FROM course_info WHERE id='$course_id'");
            $course_info = $course_info->fetch_assoc();

            if (!empty($_POST['data_submit'])) {
                $name = $_POST['name'];
                $category = $_POST['category'];
                $sub_category = $_POST['sub-category'];
                $description = $_POST['description'];
                $requirement = $_POST['requirement'];
                $price = $_POST['price'];

                $update_profile = $con->query("UPDATE course_info SET course_category='$category', course_sub_category='$sub_category', course_title='$name', course_requirement='$requirement', course_description='$description', course_price='$price' WHERE id='$course_id'");

                if($update_profile) {
                    echo "<div class='panel text-center'>Profile has been updated successfully</div>";
                } else {
                    die('Error : ('. $con->errno .') '. $con->error);    
                }

            }
            if (!empty($_POST['pic_submit'])) {
                //var_dump($_FILES);
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
                    echo "<div class='panel panel-danger text-center'> File is not an image.</div>";
                    $uploadOk = 0;
                }

                // Check file size
                if ($_FILES["banner_img"]["size"] > 500000) {
                    echo "<div class='panel panel-danger text-center'> Sorry, your file is too large.</div>";
                    $uploadOk = 0;
                }
                // Allow certain file formats
                if($imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg") {
                    echo "<div class='panel panel-danger text-center'> Sorry, only JPG, JPEG, PNG files are allowed.</div>";
                    $uploadOk = 0;
                }

                // Check if $uploadOk is set to 0 by an error
                if ($uploadOk == 0) {
                    echo "<h2 class='text-center'>Sorry, your file was not uploaded.</h2>";
                // if everything is ok, try to upload file
                } else {
                    $temp = explode(".", $file_name);
                    $newfilename = round(microtime(true)) . '.' . end($temp);
                    $target_file = $target_dir . basename($newfilename);

                    if (move_uploaded_file($_FILES["banner_img"]["tmp_name"], $target_file)) {
                        $insert_data = $con->query("UPDATE course_info SET banner_img='$newfilename' WHERE id='$course_id'");
                        $delete_file = "data/images/{$course_info['banner_img']}";
                        unlink($delete_file);
                        if(!$insert_data) {
                            die('Error : ('. $con->errno .') '. $con->error);
                        } else {
                            echo "<div class='panel text-center' role='alert'>New Photo has been uploaded.</div>";
                        }

                    } else {
                        echo "Sorry, there was an error uploading your file.";
                    }

                }

            }
        ?>
        <div class="container">
            <h1 class="page-header">Edit Course</h1>
            <div class="row">
                
                <!-- left column -->
                <div class="grid-4">
                    <div class="text-center">
                        <?php 
                            if($course_info['banner_img'] == NULL) {
                                $img_src = 'assets/img/200.png';
                                echo "<img src='$img_src' class='avatar img-thumbnail' alt='avatar'>";
                            } else {
                                $img_src = $course_info['banner_img'];
                                echo "<img src='data/images/$img_src' class='avatar img-thumbnail' alt='avatar'>";
                            }
                        ?>
                        
                        <form class="pure-form pure-form-aligned" action="edit-course.php?id=<?= $course_id; ?>" method="post"  enctype="multipart/form-data">
                            <input type="file" class="text-center center-block panel panel-small" name="banner_img">
                            <input type="submit" name="pic_submit" class="button" value="Upload">
                            <a href="edit-course.php?id=<?= $course_id; ?>" class="button refresh">Refresh</a>
                        </form>
                    </div>
                </div>

                <div class="grid-8 personal-info">
                    <form class="pure-form pure-form-aligned" action="edit-course.php?id=<?= $course_id; ?>" method="post" >
                        <fieldset>
                            <div class="pure-control-group">
                                <label for="name">Course Name</label>
                                <input type="text" class="pure-input-2-3" name="name" value='<?php echo $course_info['course_title']; ?>'>
                            </div>

	                        <div class="pure-control-group">
			                    <label for="category">Select Category</label>
			                    <select class="pure-input-2-3" name="category" id="category_id">
			                    <?php
			                        $course_categories = $con->query("SELECT * from course_categories");
			                        while($row = $course_categories->fetch_array()) {
			                    ?>
			                        <option value="<?php echo $row['id']; ?>" <?php if($course_info['course_category'] == $row['id']){ ?> selected="selected" <?php } ?> ><?php echo $row['name']; ?></option>
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
                                <textarea class="pure-input-2-3" rows="3" name="description"><?= $course_info['course_description'] ?></textarea>
                            </div>

                            <div class="pure-control-group">
                                <label for="username">Course Requirement</label>
                                <textarea class="pure-input-2-3" rows="3" name="requirement"><?= $course_info['course_requirement'] ?></textarea>
                            </div>

                            <div class="pure-control-group">
                                <label for="username">Course Price</label>
                                <input type="number" class="pure-input-2-3" id="price" placeholder="Course Price" name="price" min="1" value="<?= $course_info['course_price'] ?>">
                            </div>
                            
                            <div class="pure-controls">
                                <input type="submit" class="button" name="data_submit">
                            </div>

                        </fieldset>
                    </form>
                </div>
            </div>
        </div>
        <?php 
        include 'footer.php';
         ?>
