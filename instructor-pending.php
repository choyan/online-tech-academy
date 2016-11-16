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
            <div class="row">
                <h1>Instructor Request</h1>
                <hr>
                <div class="instructor-pending">
                	<?php
                        if(isset($_GET['msg'])) {
                            if($_GET['msg'] == 'success') {
                                echo "<div class='panel panel-small panel-success text-center' role='alert'>Accepted user Successfully</div>";
                            } else if($_GET['msg'] == 'failed') {
                                echo "<div class='panel panel-small panel-danger text-center' role='alert'>Error Occured. Cant add at the moment.</div>";
                            } else if($_GET['msg'] == 'success-reject'){
                                echo "<div class='panel panel-small panel-success text-center' role='alert'>Rejected the requested</div>";
                            } else {
                                echo "<div class='panel panel-small panel-success text-center' role='alert'>Error Occured. Cant reject at the moment.</div>";
                            }
                        }
                		$list_profile = $con->query("SELECT user_id FROM instructor WHERE ins_status=0");
                		if(mysqli_num_rows($list_profile) > 0) {
                			?>
    		            <table class="pure-table pure-table-striped" style="margin-bottom: 40px;">
    	                    <thead>
    	                    	<tr>
    		                        <th class="text-center">Name</th>
    		                        <th class="text-center">Profile</th>
                                    <th class="text-center">Accept</th>
                                    <th class="text-center">Reject</th>
    	                        </tr>
    	                    </thead>
    	                    <tbody>
    	                    <?php
    	                        while ($user = $list_profile->fetch_array()) {
    	                    ?>	
    	                    <tr class="text-center">
    	                        <td>
    	                        	<?php 
    	                        		$name = get_username($con, $user['user_id']);
    	                        		echo "$name";
    	                        	?>
    	                        </td>
    	                        <td><a href="student.php?id=<?= $user['user_id']; ?>" title="">View Profile  </a></td>
                                <td><a href="accept-ins-pending.php?id=<?= $user['user_id']; ?>"><i class="fa fa-check"></i></a></td>
                                <td><a href="cancel-ins-pending.php?id=<?= $user['user_id']; ?>"><i class="fa fa-times"></i></a></td>
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
