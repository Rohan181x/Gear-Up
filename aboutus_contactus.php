<?php
session_start();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>About Us & Contact Us - Chad Wears Website</title>
    <link rel="stylesheet" href="homepage.css">
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
                    include('connection.php');
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

    <section class="about-us">
        <div class="about-container">
            <h1>About Us</h1>
            <p>At Chad Wears, we believe in offering high-quality fashion that suits every style. Our mission is to provide our customers with trendy, comfortable, and affordable clothing options for every occasion.</p>
            <p>We are a dedicated team of fashion enthusiasts, always on the lookout for the latest trends to bring to our collection. Whether you're looking for casual wear, formal attire, or accessories to complement your look, we've got you covered.</p>
        </div>
    </section>

    <section class="contact-us">
        <div class="contact-container">
            <h1>Contact Us</h1>
            <p>If you have any questions, inquiries, or feedback, feel free to get in touch with us. Here are our contact details:</p>
            
            <div class="contact-info">
                <div class="info-item">
                    <h3>Our Location</h3>
                    <p>Kirtipur - 3, Kathmandu City, Nepal</p>
                </div>
                
                <div class="info-item">
                    <h3>Email</h3>
                    <p><a href="mailto:support@chadwears.com">support@chadwears.com</a></p>
                </div>

                <div class="info-item">
                    <h3>Phone Numbers</h3>
                    <p>+977 9841123456</p>
                    <p>+977 9876543210</p>
                </div>

                <div class="info-item">
                    <h3>Follow Us</h3>
                    <p>
                        <a href="https://www.facebook.com/ChadWears" target="_blank">Facebook</a><br>
                        <a href="https://www.instagram.com/ChadWears" target="_blank">Instagram</a>
                    </p>
                </div>
            </div>
        </div>
    </section>

    <footer>
        <p>&copy; 2024 E-commerce Website Chad Wears. All rights reserved. | <a href="aboutus_contactus.php">About Us</a> | <a href="#">Privacy Policy</a></p>
    </footer>

</body>
</html>
