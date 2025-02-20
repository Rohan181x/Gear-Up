<?php
include_once('connection.php');

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Check if fields exist in the POST data
    $uname = isset($_POST['uname']) ? trim($_POST['uname']) : '';
    $pass = isset($_POST['pass']) ? $_POST['pass'] : '';
    $conf = isset($_POST['passw']) ? $_POST['passw'] : '';
    $Email = isset($_POST['email']) ? trim($_POST['email']) : '';

    $errors = [];

    // Validate username
    if (empty($uname)) {
        $errors[] = "Username is required.";
    }

    // Validate email
    if (empty($Email)) {
        $errors[] = "Email is required.";
    } elseif (!filter_var($Email, FILTER_VALIDATE_EMAIL) || substr($Email, -10) !== '@gmail.com') {
        $errors[] = "Email must be a valid Gmail address.";
    }

    // Validate password
    if (empty($pass)) {
        $errors[] = "Password is required.";
    } elseif (strlen($pass) < 8) {
        $errors[] = "Password must be at least 8 characters long.";
    } elseif ($pass !== $conf) {
        $errors[] = "Passwords do not match.";
    }

    // If there are errors, redirect back to the signup page with errors
    if (!empty($errors)) {
        $errorString = implode('&', array_map(function($error) {
            return 'error[]=' . urlencode($error);
        }, $errors));
        header("Location: signup.php?$errorString");
        exit();
    }

    // Hash the password
    $hashed_password = password_hash($pass, PASSWORD_DEFAULT);

    // Insert user into the database
    $sql = "INSERT INTO users (username, email, password, role) VALUES (?, ?, ?, 'user')";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("sss", $uname, $Email, $hashed_password);

    if ($stmt->execute()) {
        header("Location: login.php?registration=success");
    } else {
        echo "Error: " . $stmt->error;
    }

    // Close the statement and connection
    $stmt->close();
    $conn->close();
}
?>