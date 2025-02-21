<?php
session_start();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>About Us & Contact Us - Topgear Website</title>
    <link rel="stylesheet" href="homepage.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css"> <!-- Add Font Awesome CSS -->
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
                    include('connection.php');
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

    <section class="about-us">
        <div class="about-container">
            <h1>About Us</h1>
            <p>At topgear, we believe in offering high-quality safety gear that suits every style. Our mission is to provide our customers with trendy, comfortable, and affordable gear options for every occasion.</p>
            <p>We are a team of enthusiastic bikers, always on the lookout for the latest trends to bring to our collection. Whether you're looking for casual gear, accessories, or bodywear to complement your look, we've got you covered.</p>
        </div>
    </section>

    <section class="contact-us">
        <div class="contact-container">
            <h1>Contact Us</h1>
            <p>If you have any questions, inquiries, or feedback, feel free to get in touch with us. Here are our contact details:</p>
            
            <div class="contact-info">
                <div class="info-item">
                    <h3>Our Location</h3>
                    <p>Kirtipur - 6, Kathmandu City, Nepal</p>
                </div>
                
                <div class="info-item">
                    <h3>Email</h3>
                    <p><a href="mailto:support@topgear.com">support@topgear.com</a></p>
                </div>

                <div class="info-item">
                    <h3>Phone Numbers</h3>
                    <p>+977 9808890351</p>
                    <p>+977 9749496024</p>
                </div>

                <div class="info-item">
                    <h3>Follow Us</h3>
                    <p>
                        <a href="https://www.facebook.com/topgear" target="_blank">Facebook</a><br>
                        <a href="https://www.instagram.com/topgear" target="_blank">Instagram</a>
                    </p>
                </div>
            </div>
        </div>
    </section>

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

    <footer>
        <p>&copy; 2024 E-commerce Website topgear. All rights reserved. | <a href="aboutus_contactus.php">About Us</a> | <a href="#">Privacy Policy</a></p>
    </footer>

</body>
</html>