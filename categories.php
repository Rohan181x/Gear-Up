<?php
include('connection.php');

// Get category ID from URL
$category_id = isset($_GET['category_id']) ? intval($_GET['category_id']) : 0;

if ($category_id === 0) {
    echo "Invalid category ID!";
    exit();
}

// Fetch products for the selected category
$query = "SELECT * FROM products WHERE category_id = '$category_id'";
$products = mysqli_query($conn, $query);

if (!$products) {
    die("Error fetching products: " . mysqli_error($conn));
}

// Fetch category name
$category_query = "SELECT name FROM categories WHERE id = '$category_id'";
$category_result = mysqli_query($conn, $category_query);

if (!$category_result) {
    die("Error fetching category: " . mysqli_error($conn));
}

$category_data = mysqli_fetch_assoc($category_result);

$category_name = $category_data ? $category_data['name'] : 'Unknown Category';

if (!$category_data) {
    echo "Category not found!";
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title><?php echo htmlspecialchars($category_name); ?> - Products</title>
    <link rel="stylesheet" href="style.css"> <!-- Link to the CSS file -->
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
    <h2><?php echo htmlspecialchars($category_name); ?> Products</h2>

    <div class="product-list">
        <?php while ($row = mysqli_fetch_assoc($products)) { ?>
            <div class="product">
                <img src="<?php echo htmlspecialchars($row['image']); ?>" alt="<?php echo htmlspecialchars($row['name']); ?>" class="product-image">
                <h3><?php echo htmlspecialchars($row['name']); ?></h3>
                <div class="product-info">
                    <p>Price: Rs <?php echo htmlspecialchars($row['price']); ?></p>
                    <a href="product-details.php?id=<?php echo htmlspecialchars($row['id']); ?>" class="view-details">view</a>
                </div>
            </div>
        <?php } ?>
    </div>
</div>

<footer>
    <p>&copy; 2024 E-commerce Website topgear. All rights reserved. | <a href="aboutus_contactus.php">About Us</a> | <a href="#">Privacy Policy</a></p>
</footer>
</body>
</html>