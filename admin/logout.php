<?php
session_start();
session_unset();  // Unset all session variables
session_destroy(); // Destroy the session

// Clear session cookie
if (ini_get("session.use_cookies")) {
    $params = session_get_cookie_params();
    setcookie(session_name(), '', time() - 42000,
        $params["path"], $params["domain"],
        $params["secure"], $params["httponly"]
    );
}

// Prevent browser from storing the session
header("Cache-Control: no-cache, must-revalidate, max-age=0");
header("Expires: Thu, 01 Jan 1970 00:00:00 GMT");

// Redirect to login page
header("Location: ../login.php");
exit();
