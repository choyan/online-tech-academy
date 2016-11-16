<header>
    <div class="container">
        <div class="logo">
            <a href="index.php">
                <img src="assets/img/logo.png" alt="Repto Education">
            </a>
        </div>
        <nav class="pull-right">
            <ul>
                <li>
                    <a href="add-course.php">Create Course</a>
                </li>
                <li>
                    <a href="#">Courses <i class="fa fa-angle-down"></i> </a>
                    <ul>

                        <?php 
                            $categories = $con->query("SELECT id, name FROM course_categories");
                            while ($category = $categories->fetch_array()) {
                                ?>
                                <li>
                                    <a href="category.php?id=<?= $category['id'] ?>"><?= $category['name']; ?></a>
                                    <ul class="secondary">
                                        <?php 
                                            $cat_id = $category['id'];
                                            $subc = $con->query("SELECT id, name FROM course_subcategories WHERE course_category_id = '$cat_id'");
                                            while ($cat_single = $subc->fetch_array()) {
                                                ?>
                                                <li>
                                                    <a href="sub-category.php?id=<?= $cat_single['id'] ?>"><?= $cat_single['name'] ?></a>
                                                </li>
                                                <?php
                                            }
                                        ?>
                                    </ul>
                                </li>
                                <?php                                
                            }
                        ?>

                        
                        
                    </ul>
                </li>
                <?php 
                    if(!isset($_SESSION['id'])) {
                        ?>
                        <li class="login">
                            <a href="login.php">Login</a>
                        </li>
                        <li class="register">
                            <a href="registration.php">Register</a>
                        </li>
                        <?php
                    } else {
                        ?>
                        <li>
                            <a href="student.php?id=<?= $user_id; ?>">My Profile</a>
                        </li>
                        <?php 
                            $check_ins = $con->query("SELECT id FROM instructor WHERE user_id = '$user_id' AND ins_status=1");
                            if(mysqli_num_rows($check_ins) == 1) {
                                ?>
                                <li>
                                    <a href="instructor.php?id=<?= $user_id; ?>">Instructor Profile</a>
                                </li>
                                <?php
                            }
                            if(is_admin($con, $user_id) == 1) {
                                ?>
                                <li><a href="dashboard.php">Dashboard</a></li>
                                <?php
                            }
                        ?>
                        <li>
                            <a href="logout.php">Logout</a>
                        </li>
                        <?php
                    }
                ?>

            </ul>
        </nav>
    </div>
</header>