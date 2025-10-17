<?php
session_start();

// Regenerate session ID to invalidate the old session
session_regenerate_id(true);

// Clear all session data
session_unset();

// Destroy the session
session_destroy();

// Redirect to the login page
header("Location: login.php");
exit;
?>