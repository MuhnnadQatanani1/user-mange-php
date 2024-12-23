<?php
session_start();
session_unset();  // Removes all session variables
session_destroy();  // Destroys the session
header("Location: login.php");  // Redirects to login page
exit();
?>
