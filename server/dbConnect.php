<?php

$con = mysqli_connect('localhost', 'root', '', 'mathmystery') or die("Database Connection Failed");

if ($con->connect_error) {
    die("Connection failed: " . $con->connect_error);
}

?>