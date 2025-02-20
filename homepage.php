<?php
session_start();
include('connection.php');

// Fetch products from the database
$query = "SELECT * FROM products";
$products = mysqli_query($conn, $query);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>headware Website</title>
    <link rel="stylesheet" href="./homepage.css">
</head>
<body>
    <header>
        <div class="logo">
            <img src="images/logg.jpg" alt="Logo" class="logo-img">
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

    <section class="hero">
        <!-- Slideshow container -->
        <div class="slideshow-container">

            <!-- Full-width images with number and caption text -->
            <div class="mySlides fade">
                <img src="images/white.jpg">
            </div>


            
        </div>
        <br>

        
        </div>

        <div class="hero-content">
            <h1>Welcome to  headware</h1>
            <p>The best gear to make you safe while riding.</p>
            <button id="shop-now-btn">Shop Now</button>
        </div>
    </section>
    
    <h2 class="products-title"> our Products</h2>
    <section id="products" class="products">
    <div class="product-list">
        <?php while ($product = mysqli_fetch_assoc($products)) { ?>
            <div class="product-item">
                <img src="<?php echo htmlspecialchars($product['image']); ?>" alt="<?php echo htmlspecialchars($product['name']); ?>" class="product-image">
                <h3><?php echo htmlspecialchars($product['name']); ?></h3>
                <p>Price: Rs <?php echo htmlspecialchars($product['price']); ?></p>
                <a href="product-details.php?id=<?php echo htmlspecialchars($product['id']); ?>" class="btn">View Details</a>
            </div>
        <?php } ?>
    </div>
    </section>

    <footer>
        <p>&copy; 2024 E-commerce Website Chad Wears. All rights reserved. | <a href="aboutus_contactus.php">About Us</a> | <a href="#">Privacy Policy</a></p>
    </footer>

    <script>

        document.getElementById('shop-now-btn').addEventListener('click', function() {
            document.getElementById('products').scrollIntoView({ behavior: 'smooth' });
        });

        let slideIndex = 1;
        showSlides(slideIndex);

        // Next/previous controls
        function plusSlides(n) {
            showSlides(slideIndex += n);
        }

        // Thumbnail image controls
        function currentSlide(n) {
            showSlides(slideIndex = n);
        }

        function showSlides(n) {
            let i;
            let slides = document.getElementsByClassName("mySlides");
            let dots = document.getElementsByClassName("dot");
            if (n > slides.length) {slideIndex = 1}
            if (n < 1) {slideIndex = slides.length}
            for (i = 0; i < slides.length; i++) {
                slides[i].style.display = "none";
            }
            for (i = 0; i < dots.length; i++) {
                dots[i].className = dots[i].className.replace(" active", "");
            }
            slides[slideIndex-1].style.display = "block";
            dots[slideIndex-1].className += " active";
        }

        // Automatic slide transition
        setInterval(function() {
            showSlides(slideIndex += 1);
        }, 5000); // Change slide every 5 seconds
    </script>
</body>
</html>