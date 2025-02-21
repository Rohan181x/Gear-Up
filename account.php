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
                background-color: #c8d8e4;
                font-family: Arial, sans-serif;
            }
            .container {
                text-align: center;
                background: #ffffff;
                padding: 20px;
                border-radius: 10px;
                box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
                width: 300px;
            }
            .logo {
                margin-bottom: 20px;
            }
            .logo img {
                width: 50px;
                height: auto;
            }
            h1 {
                margin-bottom: 20px;
                color: black;
            }
            p {
                margin-bottom: 20px;
                font-size: 16px;
                color: black;
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
                background-color: #52ab98;
                color: white;
            }
            a[href="login.php"]:hover {
                background-color: #2b6777;
            }
            a[href="homepage.php"] {
                background-color: #c8d8e4;
                color: black;
            }
            a[href="homepage.php"]:hover {
                background-color: #f2f2f2;
            }
        </style>
    </head>
    <body>
        <div class="container">
            <div class="logo">
                <img src="images/topgear.png" alt="Logo">
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
    <title>Account - Topgear</title>
    <link rel="stylesheet" href="homepage.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css"> <!-- Add Font Awesome CSS -->
    <style>
        .container {
            text-align: center;
            margin-top: 20px;
            padding: 50px;
        }

        .user-details {
            margin-top: 20px;
            font-size: 18px;
        }

        .user-details p {
            margin: 20px 0;
            color: black;
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
            background-color: #52ab98; /* Green for "Contact Us" */
            color: white;
            text-decoration: none;
            border-radius: 5px;
        }

        .account-options a:hover {
            background-color: #2b6777;
        }

        .account-options button {
            margin: 20px;
            padding: 10px 20px;
            background-color: #52ab98; /* Green for "Logout" */
            color: white;
            border: none;
            border-radius: 5px;
            cursor: pointer;
        }

        .account-options button:hover {
            background-color: #2b6777;
        }
    </style>
</head>
<body>
<header>
    <div class="logo">
        <img src="images/topgear.png" alt="Logo" class="logo-img">
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
        <a href="cart.php"><i class="fas fa-shopping-cart"></i></a> <!-- Cart icon -->
        <a href="aboutus_contactus.php">Contact Us</a>
        <a href="account.php">Account</a>
    </nav>
</header>

<div class="container">
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
</body>
</html>
  <!--footer-->
  <footer class="footer">
       <div class="container">
       	<div class="row">
       		<div class="footer-col">
       			<h4>company</h4>
       			<ul>
       				<li><a href="#">about us</a></li>
       				<li><a href="#">our services</a></li>
       				<li><a href="#">privacy policy</a></li>
       			</ul>
       		</div>
       		<div class="footer-col">
       			<h4>get help</h4>
       			<ul>
       				<li><a href="#">FAQ</a></li>
       				<li><a href="#">shipping</a></li>
       				<li><a href="#">returns</a></li>
       				<li><a href="#">order status</a></li>
       				<li><a href="#">payment options</a></li>
       			</ul>
       		</div>
       		
       		<div class="footer-col">
       			<h4>follow us</h4>
       			<div class="social-links">
       				<a href="#"><i class="fab fa-facebook-f"></i></a>
       				<a href="#"><i class="fab fa-twitter"></i></a>
       				<a href="#"><i class="fab fa-instagram"></i></a>
       			</div>
       		</div>
       	</div>
       </div> 
  </footer>