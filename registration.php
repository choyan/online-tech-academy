<?php

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
                            $full_name = $_POST['full_name'];
                            $email = $_POST['email'];
                            $password = md5($_POST['password']);

                            $check_username = mysqli_num_rows(mysqli_query($con, "SELECT * FROM users WHERE username='".$username."'"));

                            $check_email = mysqli_num_rows(mysqli_query($con, "SELECT * FROM users WHERE email='".$email."'"));

                            if($check_username == 0 && $check_email == 0) {

                               $sql = mysqli_query($con, "INSERT INTO users (username, full_name, email, password) VALUES ('$username', '$full_name', '$email', '$password' )");

                               if($sql) {
                                    ?>
                                        <div class="panel panel-small panel-success text-center" role="alert">Registration has been completed. You can now login from <a href="login.php" title="Login">here </a> </div>
                                    <?php
                               } else {
                                    ?>
                                    <div class="panel panel-small  text-center panel-danger" role="alert">Something wrong</div>
                                    <?php
                                    // print_r(mysqli_error($con));
                                }
                            } else {
                                ?>
                                <div class="panel panel-small  panel-danger text-center" role="alert">Username or Email already exists. Please select a different one.</div>
                                <?php
                            }
                            mysqli_close($con);

                        ?>


                        <?php
                        }
                    ?>
                    <h1 class="text-center">Registration</h1>

                    <div class="pure-control-group">
                        <label for="fullname">Full Name</label>
                        <input type="text" class="form-control" id="fullname" placeholder="Full Name" name="full_name">
                    </div>
                    <div class="pure-control-group">
                        <label for="username">User Name</label>
                        <input type="text" class="form-control" id="username" placeholder="User Name" name="username">
                    </div>
                    <div class="pure-control-group">
                        <label for="email">Email address</label>
                        <input type="email" class="form-control" id="email" placeholder="Email" name="email">
                    </div>
                    <div class="pure-control-group">
                        <label for="password">Password</label>
                        <input type="password" class="form-control" id="password" placeholder="Password" name="password">
                    </div>
                    
                    <button type="submit" class="button center-block">Register</button>
                </form>
               </div>
           </div>

        </div>


        <script src="assets/js/jquery.min.js"></script>
        <script src="assets/js/bootstrap.min.js"></script>
        <script src="assets/js/main.js"></script>
    </body>
</html>