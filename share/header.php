<?php session_start(); ?>
<!DOCTYPE html>
<html> 
    <head> 
        <title>Grand Prix Society </title>
        <link rel="stylesheet" href="css/style.css"> // link this untuk guna CSS FILE so semua design sama 
</head> 
<body> 

<nav> // navigate to other static page and access through php file 
    <a href = "home.php">Home</a> 
    <a href = "about.php">About</a>
    <a href = "activities.php">Activities</a>
    <a href = "contact.php">Contact</a>
    <a href = "announcements.php">Announcements</a>
    <a href = "about_us.php">About Us</a> 



     <?php if(isset($_SESSION['user_id'])): ?> // if user id exist then show logout 
        <a href="/logout.php">Logout</a>
    <?php else: ?>
        <a href="/login.php">Login</a> // user id tak wujud so ask to login or sign up
        <a href="/signup.php">Sign Up</a>
    <?php endif; ?>
</nav>

