<?php
session_start();
include('connection.php');

// Check if the user is logged in
if (!isset($_SESSION['email'])) {
// User not logged in, show the "Not Logged In" page
?>
<!DOCTYPE html>
    <html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Not Logged In</title>
        <style>
            body {
                margin: 0;
                padding: 0;
                display: flex;
                justify-content: center;
                align-items: center;
                height: 100vh;
                background-color: #f0f2f5;
                font-family: Arial, sans-serif;
            }
            .container {
                text-align: center;
                background: #fff;
                padding: 20px;
                border-radius: 10px;
                box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
                width: 300px;
            }
            .logo {
                margin-bottom: 20px;
            }
            .logo img {
                width: 100px;
                height: auto;
            }
            h1 {
                margin-bottom: 20px;
                color: #333;
            }
            p {
                margin-bottom: 20px;
                font-size: 16px;
                color: #555;
            }
            a {
                text-decoration: none;
                padding: 10px 20px;
                border-radius: 5px;
                font-size: 14px;
                font-weight: bold;
                display: inline-block;
            }
            a[href="login.php"] {
                background-color: #007bff;
                color: white;
            }
            a[href="login.php"]:hover {
                background-color: #0056b3;
            }
            a[href="homepage.php"] {
                background-color: #dc3545;
                color: white;
            }
            a[href="homepage.php"]:hover {
                background-color: #a71d2a;
            }
        </style>
    </head>
    <body>
        <div class="container">
            <div class="logo">
                <img src="images/Chad_logo2.png" alt="Logo">
            </div>
            <h1>You are not logged in</h1>
            <p>Would you like to log in?</p>
            <a href="login.php">Yes</a>
            <a href="homepage.php">No</a>
        </div>
    </body>
    </html>
<?php
    exit();
}

// Retrieve session variables
$username = $_SESSION['username'];
$email = $_SESSION['email'];

// Default profile picture path
$default_profile_picture = "images/default_profile.png";
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Account - Chad Wears Website</title>
    <link rel="stylesheet" href="homepage.css">
    <style>

        .container {
            text-align: center;
            margin-top: 20px;
            padding: 20px;
        }

        .profile-picture img {
            width: 150px;
            height: 150px;
            border-radius: 50%;
            border: 2px solid #ddd;
        }

        .user-details {
            margin-top: 20px;
            font-size: 18px;
        }

        .user-details p {
            margin: 5px 0;
        }

        .account-options {
            display: flex;
            flex-direction: column; /* Stack buttons vertically */
            align-items: center;
        }

        .account-options a {
            display: inline-block;
            margin: 10px;
            padding: 10px 20px;
            background-color: #007bff; /* Blue for "Change Password" */
            color: white;
            text-decoration: none;
            border-radius: 5px;
        }

        .account-options button {
            margin: 10px;
            padding: 10px 20px;
            background-color: #ff4d4d; /* Red for "Logout" */
            color: white;
            border: none;
            border-radius: 5px;
            cursor: pointer;
        }
    </style>
</head>
<body>
<header>
        <div class="logo">
            <img src="images/Chad_logo2.png" alt="Logo" class="logo-img">
        </div>
        <nav>
        <a href="homepage.php">Home</a>
        <div class="dropdown">
            <span class="dropbtn">Categories</span>
            <div class="dropdown-content">
                <?php
                $query = "SELECT * FROM categories";
                $categories = mysqli_query($conn, $query);

                while ($cat = mysqli_fetch_assoc($categories)) {
                    echo '<a href="categories.php?category_id=' . htmlspecialchars($cat['id']) . '">' . htmlspecialchars($cat['name']) . '</a>';
                }
                ?>
            </div>
        </div>
        <a href="cart.php">Cart</a>
        <a href="aboutus_contactus.php">Contact Us</a>
        <a href="account.php">Account</a>
    </nav>
    </header>

    <div class="container">
        <div class="profile-picture">
            <img src="<?php echo $default_profile_picture; ?>" alt="Profile Picture">
        </div>

        <div class="user-details">
            <h1>Welcome, <?php echo htmlspecialchars($username); ?>!</h1>
            <p>Email: <?php echo htmlspecialchars($email); ?></p>
        </div>

        <div class="account-options">
            <form action="logout.php" method="POST" style="margin: 0;">
            <button type="submit">Logout</button>
            </form>
            <p>If you want to modify your details, please contact us.</p>
            <a href="aboutus_contactus.php" class="btn">Contact Us</a>
        </div>

    </div>

    <footer>
        <p>&copy; 2024 E-commerce Website Chad Wears. All rights reserved. | <a href="aboutus_contactus.php">About Us</a> | <a href="#">Privacy Policy</a></p>
    </footer>
</body>
</html>
