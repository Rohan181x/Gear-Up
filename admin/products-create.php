<?php
require_once '../config/function.php'; // Include the function file

if (isset($_SESSION['message'])) {
    echo "<script>alert('" . htmlspecialchars($_SESSION['message']) . "');</script>";
    unset($_SESSION['message']); // Clear the message after showing it
}

include('includes/header.php');
require_once '../connection.php'; 

// Fetch categories
$categories = $conn->query("SELECT * FROM categories");
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Add Product</title>
    <link rel="stylesheet" href="styles.css"> <!-- Add your CSS file -->
    <style>
        /* Inline CSS for form styling */
        .container {
            margin-top: 50px;
        }

        .form-control, .form-select {
            width: 100%;
            padding: 10px;
            margin-bottom: 15px;
            border: 1px solid #c8d8e4;
            border-radius: 5px;
        }

        .btn {
            display: inline-block;
            padding: 10px 15px;
            background-color: #2b6777;
            color: #ffffff;
            text-decoration: none;
            border-radius: 5px;
            transition: background-color 0.3s;
        }

        .btn:hover {
            background-color: #52ab98;
        }
    </style>
</head>
<body>
    <div class="container mt-5">
        <h4>Add Product</h4>
        <form action="code.php" method="POST" enctype="multipart/form-data">
            <label>Select Category</label>
            <select name="category_id" class="form-select">
                <?php 
                    while($row = mysqli_fetch_assoc($categories)) {
                        echo "<option value='".htmlspecialchars($row['id'])."'>".htmlspecialchars($row['name'])."</option>";
                    }
                ?>
            </select>

            <label>Product Name</label>
            <input type="text" name="product_name" class="form-control" required>

            <label>Description</label>
            <textarea name="product_description" class="form-control" required></textarea>

            <label>Price</label>
            <input type="number" name="product_price" class="form-control" step="0.01" required>

            <label>Product Image</label>
            <input type="file" name="product_image" class="form-control" required>

            <button type="submit" name="saveProduct" class="btn">Add Product</button>
        </form>
    </div>

    <?php include('includes/footer.php'); ?>
</body>
</html>