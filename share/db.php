<?php
$host = "localhost";    // where MySQL is running
$user = "root";         // default XAMPP username
$pass = "";             // default XAMPP password (empty)
$db   = "club_db";      // name of your database

$conn = mysqli_connect($host, $user, $pass, $db);

if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}
?>