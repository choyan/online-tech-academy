<?php
    include '../db.php';

    if(isset($_POST['get_option'])) {
        $state = $_POST['get_option'];
        $find = $con->query("SELECT * from course_subcategories WHERE course_category_id = '$state'");
        while($row = $find->fetch_array()) {
            ?>
            <option value="<?php echo $row['id'] ?>"> <?php echo $row['name'] ?> </option>
            <?php
        }
        exit;
   }

?>