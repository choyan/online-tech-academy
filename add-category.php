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
        <title>Add Category</title>
        <meta name="description" content="">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <link rel="apple-touch-icon" href="apple-touch-icon.png">
        <!-- Place favicon.ico in the root directory -->

        <link rel="stylesheet" href="assets/css/pure-table.css">
        <link rel="stylesheet" href="assets/css/font-awesome.css">
        <link rel="stylesheet" href="assets/css/main.css">
    </head>
    <body>
        <!--[if lt IE 8]>
            <p class="browserupgrade">You are using an <strong>outdated</strong> browser. Please <a href="http://browsehappy.com/">upgrade your browser</a> to improve your experience.</p>
        <![endif]-->
        <?php 
            include 'header.php';
        ?>
        <div class="container">
            <form action="<?php echo $_SERVER['PHP_SELF'];?>" method="post" class="pure-form pure-form-aligned">
                 <?php
                    if ($_SERVER['REQUEST_METHOD'] == 'POST') {

                        $name = $con->real_escape_string($_POST['name']);

                        $verify_info = $con->query("SELECT * FROM course_categories WHERE name='$name'");

                        if(mysqli_num_rows($verify_info) == 0) {
                            $insert_data = $con->query("INSERT INTO course_categories (name) VALUES('$name')");
                            if(!$insert_data) {
                                die('Error : ('. $con->errno .') '. $con->error);
                            } else {
                                ?>
                                <div class="panel panel-success" role="alert">New Category has been added.</div>
                                <?php
                            }
                        } else {
                            ?>
                            <div class="panel panel-danger" role="alert">A category with same name already exists.</div>
                            <?php
                        }
                        mysqli_close($con);
                    ?>


                    <?php
                    }
                ?>
                <h1>Add Category Name</h1>

                <div class="pure-control-group">
                    <label for="name">Category Name</label>
                    <input type="text" class="pure-input-2-3" id="name" placeholder="Category Name" name="name">
                </div>
                

                <button type="submit" class="button">Add Category</button>
            </form>
            
        </div>

        <?php 
            include 'footer.php';
        ?>
