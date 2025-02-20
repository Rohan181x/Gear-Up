<?php
include('connection.php');

// Get product ID from URL
$product_id = isset($_GET['id']) ? $_GET['id'] : 0;

// Fetch product details
$query = "SELECT * FROM products WHERE id = '$product_id'";
$product = mysqli_query($conn, $query);
$product_data = mysqli_fetch_assoc($product);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title><?php echo htmlspecialchars($product_data['name']); ?> - Details</title>
    <link rel="stylesheet" href="style.css"> <!-- Link to the CSS file -->
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

<div class="container">
    <div class="product-details">
        <h2><?php echo htmlspecialchars($product_data['name']); ?></h2>
        <img src="<?php echo htmlspecialchars($product_data['image']); ?>" alt="<?php echo htmlspecialchars($product_data['name']); ?>" class="product-image">
        <p>Price: Rs <?php echo htmlspecialchars($product_data['price']); ?></p>
        <p>Description: <?php echo htmlspecialchars($product_data['description']); ?></p>
        <form action="cart.php" method="POST">
            <input type="hidden" name="product_id" value="<?php echo htmlspecialchars($product_data['id']); ?>">
            <input type="hidden" name="price" value="<?php echo htmlspecialchars($product_data['price']); ?>">
            <input type="hidden" name="image" value="<?php echo htmlspecialchars($product_data['image']); ?>">
            <input type="hidden" name="name" value="<?php echo htmlspecialchars($product_data['name']); ?>">
            <button type="submit" name="addToCart">Add to Cart</button>
        </form>
    </div>
</div>
    <footer>
        <p>&copy; 2024 E-commerce Website Chad Wears. All rights reserved. | <a href="aboutus_contactus.php">About Us</a> | <a href="#">Privacy Policy</a></p>
    </footer>
</body>
</html>
