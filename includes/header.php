<?php include 'config/db.php';?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="public/css/style.css"/>
    <title>Document</title>
</head>
<body>
<div class="footer">
    <nav class="navbar">
        <?php
        if(isset($_COOKIE['user_id'])){
            echo '
            <div>
            <a href="/aaudio/feed.php" class="nav-link">Home</a>
            </div>';
        }
        ?>
    <div class="nav-right">
        <?php
         if(!isset($_COOKIE['user_id'])){
            echo '
            <div>
            <a href=" /aaudio/login.php" class="nav-link">Login</a>
            <a href="/aaudio/signup.php" class="nav-link">Signup</a>
            </div>';
        }else{
            echo '<a href="/aaudio/signout.php" class="nav-link">Sign out</a>';
        }
        ?>
    </div>
        
    </nav>
</div>

 