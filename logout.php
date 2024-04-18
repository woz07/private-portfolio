<?php
// Start the session
session_start();

// Unset all session variables
$_SESSION = array();

// Destroy the session
session_destroy();

// Redirect to another page or display a message to the user
header("Location: login.html");
exit();
?>
