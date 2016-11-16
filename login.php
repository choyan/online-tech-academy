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

        <link rel="stylesheet" href="assets/css/pure-table.css">
        <link rel="stylesheet" href="assets/css/font-awesome.css">
        <link rel="stylesheet" href="assets/css/main.css">
    </head>
    <body class="login">
        <!--[if lt IE 8]>
            <p class="browserupgrade">You are using an <strong>outdated</strong> browser. Please <a href="http://browsehappy.com/">upgrade your browser</a> to improve your experience.</p>
        <![endif]-->

        <div class="container">
            <div class="row">
                <div class="login-box grid-6 push-3">
                    <form action="<?php echo $_SERVER['PHP_SELF'];?>" method="post" class="pure-form pure-form-aligned">
                        <?php
                            if ($_SERVER['REQUEST_METHOD'] == 'POST') {

                                $username = $_POST['username'];
                                $password = md5($_POST['password']);

                                $verify_info = $con->query("SELECT * FROM users WHERE username='".$username."' AND password='".$password."' ");

                                if(mysqli_num_rows($verify_info) > 0) {

                                    ?>
                                    
                                    <div class="panel panel-small panel-success text-center" role="alert">Logged in successfully. You'll be redirected shortly.</div>

                                    <?php
                                    $user_id = get_user_id($con, $username);
                                    $_SESSION["id"] = $user_id;
                                    header("Location: index.php");

                                } else {
                                    ?>
                                    <div class="panel panel-small panel-danger text-center" role="alert">Username or Password doesn't match. pls try again.</div>
                                    <?php
                                }

                            ?>


                            <?php
                            }
                        ?>
                        <h1 class="text-center">Login</h1>
                        <?php 
                            if(isset($_GET['msg'])) {
                                if($_GET['msg'] == 2) {
                                    echo "<div class='panel panel-small panel-danger text-center' role='alert'>You are not logged in. Please log in first</div>";
                                }                                
                            }

                        ?>
                        <div class="pure-control-group">
                            <label for="username">User Name</label>
                            <input type="text" class="form-control" id="username" placeholder="User Name" name="username">
                        </div>
                        <div class="pure-control-group">
                            <label for="password">Password</label>
                            <input type="password" class="form-control" id="password" placeholder="Password" name="password">
                        </div>

                        <button type="submit" class="button center-block">Log in</button>
                    </form>
                </div>
            </div>
        </div>


        <script src="assets/js/jquery.min.js"></script>
        <script src="assets/js/bootstrap.min.js"></script>
        <script src="assets/js/main.js"></script>
    </body>
</html>