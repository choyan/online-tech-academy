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
        <title>Search</title>
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
                <h1>Search</h1>
                <hr>
                <div class="pure-control-group">
                    <label for="name">User Name</label>
                    <input type="text" class="pure-input-2-3" id="name" placeholder="User Name" name="name">
                </div>
                <button type="submit" class="button" style="margin-left: 70px; padding: 10px 40px;">Search</button>
            </form>
            <div class="search-result">
            <?php

                if(isset($_GET['msg'])) {
                    if($_GET['msg'] == 'success') {
                    ?>
                    <div class="panel panel-success text-center">User Profile has been Deleted Successfully.</div>
                    <?php
                    } else {
                        ?>
                        <div class="panel panel-success text-center">Error occured. Try agian pls.</div>
                        <?php
                    }
                }

                if ($_SERVER['REQUEST_METHOD'] == 'POST') {

                    $name = $con->real_escape_string($_POST['name']);

                    $search = $con->query("SELECT id, full_name FROM users WHERE username like '%$name%' OR id like '%$name%' OR full_name like '%$name%'");
                    if(mysqli_num_rows($search) > 0) {
                    	?>
                    	<table class="pure-table pure-table-striped" style="margin: 40px;">
	                        <thead>
	                        	<tr>
			                        <th class="text-center">Name</th>
			                        <th class="text-center">Student Profile</th>
                                    <th class="text-center">Instructor Profile</th>
                                    <th class="text-center">Delete</th>
		                        </tr>
	                        </thead>
	                        <tbody>
	                        <?php
		                        while ($user = $search->fetch_array()) {
	                        ?>	
	                        <tr class="text-center">
	                            <td><?= $user['full_name']; ?></td>
	                            <td><a href="student.php?id=<?= $user['id']; ?>" title="">View Profile</a></td>
                                <td>
                                    <?php 
                                        if(is_instructor($con, $user['id']) == 1) {
                                            ?>
                                            <a href="instructor.php?id=<?= $user['id']; ?>" title="">View Profile</a>
                                            <?php
                                        } else {
                                            ?>
                                            User is not an Instructor
                                            <?php
                                        }
                                     ?>
                                </td>
                                <td><a href="delete-user.php?id=<?= $user['id']; ?>">Delete</a></td>
	                        </tr>
	                        <?php
	                            }
	                        ?>

	                        </tbody>
	                        

	                    </table>
                    	<?php

                        	?>
                        	<li> <a href="student.php?id=<?= $user['id']; ?>"></a> </li>
                        	<?php
                                            }
                    else {
                        ?>
                        <div class="panel panel-danger text-center">No profile found</div>
                        <?php
                    } 
                    mysqli_close($con);
                ?>

                <?php
                }
            ?>
            </div>
            
        </div>

        <?php 
            include 'footer.php';
        ?>
