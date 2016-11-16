<?php 
session_start();
if(!isset($_SESSION['id'])) {
   header("Location: login.php");
}
include 'functions.php';
$user_id = $_SESSION['id'];

// if(is_admin($con, $user_id) == 0) {
//     header("location: not-allowed.php");
// }
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
    <body class="edit-profile form">
        <!--[if lt IE 8]>
            <p class="browserupgrade">You are using an <strong>outdated</strong> browser. Please <a href="http://browsehappy.com/">upgrade your browser</a> to improve your experience.</p>
        <![endif]-->
        <?php 
        include 'header.php'; ?>
        <?php 
            if (!empty($_POST['data_submit'])) {
                $fullname = $_POST['fullname'];
                $email = $_POST['email'];
                $password = md5($_POST['password']);
                $phone = $_POST['phone'];
                $about = $_POST['about'];
                $address = $_POST['address'];

                $update_profile = $con->query("UPDATE users SET full_name='$fullname', password='$password', email='$email', phone='$phone', about_me='$about', address='$address' WHERE id='$user_id'");

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
                $file_name = $_FILES['profile_pic']['name'];
                $uploadOk = 1;
                $imageFileType = pathinfo($file_name, PATHINFO_EXTENSION);

                // Check if really an image
                $check_image = getimagesize($_FILES["profile_pic"]["tmp_name"]);
                if($check_image !== false) {
                    //echo "File is an image - " . $check_image["mime"] . ".";
                    $uploadOk = 1;
                } else {
                    echo "File is not an image.";
                    $uploadOk = 0;
                }

                // Check file size
                if ($_FILES["profile_pic"]["size"] > 500000) {
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

                    if (move_uploaded_file($_FILES["profile_pic"]["tmp_name"], $target_file)) {
                        $insert_data = $con->query("UPDATE users SET profile_pic='$newfilename' WHERE id='$user_id'");
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
            <h1 class="page-header">Edit Profile</h1>
            <div class="row">
                <?php 
                    $user_info = $con->query("SELECT * FROM users WHERE id='$user_id'");
                    $user_info = $user_info->fetch_assoc();
                ?>
                <!-- left column -->
                <div class="grid-4">
                    <div class="text-center">
                        <?php 
                            if($user_info['profile_pic'] == NULL) {
                                $img_src = 'assets/img/200.png';
                                echo "<img src='$img_src' class='avatar img-circle img-thumbnail' alt='avatar'>";
                            } else {
                                $img_src = $user_info['profile_pic'];
                                echo "<img src='data/images/$img_src' class='avatar img-circle img-thumbnail' alt='avatar'>";
                            }
                        ?>
                        
                        <form class="pure-form pure-form-aligned" action="<?php echo $_SERVER['PHP_SELF'];?>" method="post"  enctype="multipart/form-data">
                           <input type="file" class="text-center center-block panel panel-small" name="profile_pic">
                           <input type="submit" name="pic_submit" class="button" value="Upload">
                        </form>
                    </div>
                </div>

                <div class="grid-8 personal-info">
                    <h3>Personal info</h3>
                        <form class="pure-form pure-form-aligned" action="<?php echo $_SERVER['PHP_SELF'];?>" method="post" >
                            <fieldset>
                                <div class="pure-control-group">
                                    <label for="name">Username</label>
                                    <input type="text" class="pure-input-2-3" value='<?php echo $user_info['username']; ?>' disabled>
                                    <h6>Username cant be changed</h6>
                                </div>

                                <div class="pure-control-group">
                                    <label for="name">Full name</label>
                                    <input type="text" name="fullname" class="pure-input-2-3" value="<?php echo $user_info['full_name']; ?>">
                                </div>
                                
                                <div class="pure-control-group">
                                    <label for="password">Password</label>
                                    <input id="password" name="password" class="pure-input-2-3" type="password" placeholder="Input password again">
                                </div>

                                <div class="pure-control-group">
                                    <label for="email">Email Address</label>
                                    <input id="email" name="email" class="pure-input-2-3" type="email" value="<?php echo $user_info['email']; ?>">
                                </div>

                                <div class="pure-control-group">
                                    <label for="name">Phone Number:</label>
                                    <input type="number" name="phone" class="pure-input-2-3" value="<?php echo $user_info['phone']; ?>">
                                </div>

                                <div class="pure-control-group">
                                    <label for="name">About me</label>
                                    <input type="text" name="about" class="pure-input-2-3" value="<?php echo $user_info['about_me']; ?>">
                                </div>

                                <div class="pure-control-group">
                                    <label for="name">Address</label>
                                    <input type="text" name="address" class="pure-input-2-3" value="<?php echo $user_info['address']; ?>">
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
