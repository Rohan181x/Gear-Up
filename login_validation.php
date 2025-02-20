<?php
session_start();
include('connection.php');

// Check if the request method is POST
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $email = trim($_POST['email']);
    $password = $_POST['password'];

    // Validate inputs
    if (empty($email) || empty($password)) {
        die("Email and password are required.");
    }

    // Prevent brute-force attacks by limiting failed attempts
    if (!isset($_SESSION['login_attempts'])) {
        $_SESSION['login_attempts'] = 0;
    }
    if ($_SESSION['login_attempts'] >= 5) {
        die("Too many failed login attempts. Try again later.");
    }

    // Query the database to check credentials
    $sql = "SELECT * FROM users WHERE email = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();

        // Check if password matches (using password_verify)
        if (password_verify($password, $row['password'])) {

            // Store user information in session
            $_SESSION['auth'] = true; // Marks user as authenticated
            $_SESSION['user_id'] = $row['id']; // Store user ID in session
            $_SESSION['username'] = $row['username'];
            $_SESSION['email'] = $row['email'];
            $_SESSION['role'] = $row['role'];

            // Reset login attempts on successful login
            $_SESSION['login_attempts'] = 0;

            // Redirect based on role
            if ($row['role'] === 'admin') {
                header("Location: admin/orders.php");
            } else {
                header("Location: homepage.php");
            }
            exit();
        } else {
            $_SESSION['login_attempts'] += 1;
            echo "Invalid password.";
        }
    } else {
        echo "No user found with that email.";
    }

    // Close the statement and connection
    $stmt->close();
    $conn->close();
}
?>