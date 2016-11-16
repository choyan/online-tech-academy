<?php
$con = new mysqli('localhost','root','','ova');


if ($con->connect_error) {
    die('Error : ('. $con->connect_errno .') '. $con->connect_error);
}



?>
