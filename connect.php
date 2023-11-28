<?php
$host = "localhost";
$user = "root";
$password = "cementceiling";
$database_name = "reygiv";

$mysqli = mysqli_connect($host, $user, $password, $database_name)
    or die("Unable to connect<br>" . mysqli_error($mysqli));