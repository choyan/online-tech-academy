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
        <title>Delete Subcategory</title>
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
            <div class="row">
                <h1>Delete Category</h1>
                <hr>
                <div class="instructor-pending">
                    <?php
                        if(isset($_GET['msg'])) {
                            if($_GET['msg'] == 'success') {
                                echo "<div class='panel panel-small panel-success text-center' role='alert'>Deleted Subcategories.</div>";
                            } else {
                                echo "<div class='panel panel-small panel-danger text-center' role='alert'>Error Occured. Cant delete at the moment.</div>";
                            }
                        }
                        $list_categories = $con->query("SELECT * FROM course_subcategories");
                        if(mysqli_num_rows($list_categories) > 0) {
                            ?>
                        <table class="pure-table pure-table-striped" style="margin-bottom: 40px;">
                            <thead>
                                <tr>
                                    <th class="text-center">Sub-Cateogory Name</th>
                                    <th class="text-center">Category Name</th>
                                    <th class="text-center">Delete</th>
                                </tr>
                            </thead>
                            <tbody>
                            <?php
                                while ($category = $list_categories->fetch_array()) {
                            ?>  
                            <tr class="text-center">
                                <td><?= $category['name']; ?></td>
                                <td>
                                    <?php
                                        $cat_id = $category['course_category_id'];
                                        $cat_name = $con->query("SELECT name FROM course_categories WHERE id = '$cat_id'")->fetch_object()->name;
                                        echo "$cat_name";
                                    ?>
                                </td>
                                <td><a href="delete-subcategory-confirm.php?id=<?= $category['id']; ?>" title="">Delete</a></td>
                            </tr>
                            <?php
                                }
                            ?>
                            </tbody>
                        </table>
                            <?php
                        } else {
                            echo "<h3 class='text-center' style='margin-bottom: 40px;''>No new Request</h3>";
                        }
                    ?>

                </div>
            </div>    
        </div>

        <?php 
            include 'footer.php';
        ?>
