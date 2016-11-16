<?php 
session_start();
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

        <link rel="stylesheet" href="assets/css/bootstrap.min.css">
        <link rel="stylesheet" href="assets/css/font-awesome.css">
        <link rel="stylesheet" href="assets/css/main.css">
    </head>
    <body>
        <!--[if lt IE 8]>
            <p class="browserupgrade">You are using an <strong>outdated</strong> browser. Please <a href="http://browsehappy.com/">upgrade your browser</a> to improve your experience.</p>
        <![endif]-->

        <div class="container">
            <form action="<?php echo $_SERVER['PHP_SELF'];?>" method="post">
                 <?php
                    if ($_SERVER['REQUEST_METHOD'] == 'POST') {

                        $name = $con->real_escape_string($_POST['name']);
                        $cat_id = $con->real_escape_string($_POST['category_id']);

                        $insert_data = $con->query("INSERT INTO course_subcategories (course_category_id, name) VALUES('$cat_id', '$name')");
                        
                        if(!$insert_data) {
                            die('Error : ('. $con->errno .') '. $con->error);
                        } else {
                        ?>
                            <div class="alert alert-success" role="alert">New Sub-Category has been added.</div>
                            <?php
                        }
                    }
                ?>
                <h1>Add Sub-Category Name</h1>
                
                

                <div class="form-group">
                    <label for="title">Title:</label>
                    <input type="text" class="form-control" id="title" placeholder="Lecture Title" name="title">
                </div>

                <div class="form-group">
                    <label for="Description">Description:</label>
                    <textarea class="form-control" rows="3" name="description"></textarea>
                </div>

                <div class="form-group">
                    <label for="name">Video Url:</label>
                    <input type="text" class="form-control" id="name" placeholder="Sub-category Name" name="name">
                </div>
                

                <button type="submit" class="btn btn-default">Add Sub-category</button>
            </form>
            <div class="footer">
                <p class="pull-right"><span class="fa fa-shield"></span> from Zahidul Hossain</p>
            </div>
        </div>


        <script src="assets/js/jquery.min.js"></script>
        <script src="assets/js/bootstrap.min.js"></script>
        <script src="assets/js/main.js"></script>
    </body>
</html> 