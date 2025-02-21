<?php
require_once 'includes/header.php'; // Include the header file
require_once '../config/function.php'; // Include the function file
require_once '../connection.php'; // Include the connection file

// Check if admin is logged in
if (!isset($_SESSION['auth']) || $_SESSION['role'] !== 'admin') {
    header("Location: login.php");
    exit();
}

// Check if product ID is set in the URL
if (!isset($_GET['id'])) {
    die("Product ID is not set in the URL.");
}

$product_id = intval($_GET['id']);

// Fetch product details from the database
$query = "SELECT * FROM products WHERE id = ?";
$stmt = $conn->prepare($query);
$stmt->bind_param("i", $product_id);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows == 0) {
    die("Product not found!");
}

$product = $result->fetch_assoc();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Edit Product</title>
    <link rel="stylesheet" href="styles.css"> <!-- Add your CSS file -->
</head>
<body>
    <!-- Navbar -->
    <nav class="navbar navbar-main navbar-expand-lg px-0 mx-4 shadow-none border-radius-xl" id="navbarBlur" navbar-scroll="true">
        <div class="container-fluid py-1 px-3">
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb bg-transparent mb-0 pb-0 pt-1 px-0 me-sm-6 me-5">
                    <li class="breadcrumb-item text-sm"><a class="opacity-5 text-dark" href="javascript:;">Pages</a></li>
                    <li class="breadcrumb-item text-sm text-dark active" aria-current="page">Edit Product</li>
                </ol>
            </nav>
        </div>
    </nav>
    <!-- End Navbar -->

    <div class="container mt-5">
        <h4>Edit Product</h4>
        <form action="update_product.php" method="POST" enctype="multipart/form-data">
            <input type="hidden" name="product_id" value="<?= htmlspecialchars($product['id']); ?>">

            <label>Select Category</label>
            <select name="category_id" class="form-select">
                <?php 
                $category_query = "SELECT * FROM categories";
                $categories = mysqli_query($conn, $category_query);
                while ($row = mysqli_fetch_assoc($categories)) {
                    $selected = $row['id'] == $product['category_id'] ? 'selected' : '';
                    echo "<option value='".htmlspecialchars($row['id'])."' $selected>".htmlspecialchars($row['name'])."</option>";
                }
                ?>
            </select>

            <label>Product Name</label>
            <input type="text" name="product_name" class="form-control" value="<?= htmlspecialchars($product['name']); ?>" required>

            <label>Description</label>
            <textarea name="product_description" class="form-control" required><?= htmlspecialchars($product['description']); ?></textarea>

            <label>Price</label>
            <input type="text" name="product_price" class="form-control" value="<?= htmlspecialchars($product['price']); ?>" required>

            <label>Image</label>
            <input type="file" name="product_image" class="form-control">

            <button type="submit" name="updateProduct" class="btn btn-primary mt-3">Update Product</button>
        </form>
    </div>

    <?php include('includes/footer.php'); ?>
</body>
</html>