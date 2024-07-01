<?php
    session_start();
    // Unset all of the session variables
    session_unset();
    // Destroy the session
    session_destroy();
    // Redirect to the signin page
    header("Location: ../interfaces/signin.php");
    exit();
?>