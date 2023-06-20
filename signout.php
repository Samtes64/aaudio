<?php
    // Clear the user ID cookie
    setcookie('user_id', '', time() - 3600, '/'); // Expire the cookie by setting an expiration time in the past

    // Redirect to the home page or any other desired location
    header("Location: login.php");
    exit;
?>