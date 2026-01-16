<?php
session_start();

/*
 | LOGOUT PROCESS
 | - Clears session data
 | - Destroys the session
 | - Redirects to login page
*/

// Remove all session variables
session_unset();

// Destroy the session completely
session_destroy();

// Redirect back to login page
header("Location: index.php");
exit;
