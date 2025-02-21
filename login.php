<?php
// Check if the registration success message should be shown
$registrationSuccess = isset($_GET['registration']) && $_GET['registration'] == 'success';

session_start();

// Check if the user is logged in
if (isset($_SESSION['email'])) {
    header("Location: homepage.php");
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
    <link rel="stylesheet" href="login.css"> <!-- Link to the login-specific CSS file -->
    <style>
        /* Add some styles for the success message */
        .success-message {
            background-color: #52ab98;
            color: black;
            border: 1px solid #2b6777;
            padding: 15px;
            margin-bottom: 20px;
            text-align: center;
            border-radius: 5px;
        }
    </style>
</head>
<body>

<div class="container">
    <div class="form-container">
        <h1>WELCOME BACK</h1>
        <p>Welcome back! Please enter your details.</p>
        
        <!-- Display registration success message if the query parameter is present -->
        <?php if ($registrationSuccess): ?>
            <div class="success-message">
                <p>Registration is successful! Do you want to log in now?</p>
                <a href="login.php" class="signup-link">Yes, Login</a>
            </div>
        <?php endif; ?>

        <!-- Error Message Placeholder -->
        <div id="error-message" style="color:red;">
            <?php
            if (isset($_GET['error'])) {
                echo htmlspecialchars($_GET['error']); // Display errors from the server
            }
            ?>
        </div>

        <form action="login_validation.php" method="POST">
            <!-- Email Input -->
            <label for="email">Email</label>
            <input type="email" id="email" name="email" placeholder="Enter your email" required>
            
            <!-- Password Input -->
            <label for="password">Password</label>
            <input type="password" id="password" name="password" placeholder="Enter your password" required>
        
            <!-- Options -->
            <!-- <div class="options">
                <label>
                    <input type="checkbox" name="remember"> Remember me
                </label>
                <a href="#" class="forgot-password">Forgot password</a>
            </div> -->
        
            <!-- Submit Button -->
            <button type="submit" class="sign-in-btn">Sign in</button>
        
            <!-- Signup Link -->
            <p class="signup-text">
                Don't have an account? <a href="signup.php" class="signup-link">Sign up for free!</a>
            </p>
        </form>
    </div>
</div>

</body>
</html>
