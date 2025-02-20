<?php
require_once 'includes/header.php'; // Include the header file
require_once '../config/function.php'; // Include the function file
require_once '../connection.php'; // Include the connection file

// Check if admin is logged in
$isAdmin = isset($_SESSION['auth']) && $_SESSION['role'] === 'admin';

// Get category from URL if selected
$category_id = isset($_GET['category']) ? intval($_GET['category']) : null;

// Fetch categories
$category_query = "SELECT * FROM categories";
$categories = mysqli_query($conn, $category_query);
if (!$categories) {
    die("Error fetching categories: " . mysqli_error($conn));
}

// Fetch products based on category using prepared statements
if ($category_id) {
    $stmt = $conn->prepare("SELECT * FROM products WHERE category_id = ?");
    $stmt->bind_param("i", $category_id);
} else {
    $stmt = $conn->prepare("SELECT * FROM products");
}
$stmt->execute();
$products = $stmt->get_result();
if (!$products) {
    die("Error fetching products: " . mysqli_error($conn));
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Products</title>
    <link rel="stylesheet" href="styles.css"> <!-- Add your CSS file -->
</head>
<body>
    <!-- Navbar -->
    <nav class="navbar navbar-main navbar-expand-lg px-0 mx-4 shadow-none border-radius-xl" id="navbarBlur" navbar-scroll="true">
        <div class="container-fluid py-1 px-3">
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb bg-transparent mb-0 pb-0 pt-1 px-0 me-sm-6 me-5">
                    <li class="breadcrumb-item text-sm"><a class="opacity-5 text-dark" href="javascript:;">Pages</a></li>
                    <li class="breadcrumb-item text-sm text-dark active" aria-current="page">Products</li>
                </ol>
            </nav>
        </div>
    </nav>
    <!-- End Navbar -->

    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">
                    <h4>
                        Product Lists
                        <a href="products-create.php" class="btn btn-primary float-end">Add Product</a>
                    </h4>
                </div>
                <div class="card-body">

                    <?= alertMessage(); ?>

                    <table class="table table-bordered table-striped">
                        <thead>
                            <tr>
                                <th>Id</th>
                                <th>Name</th>
                                <th>Price</th>
                                <th>Category</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php 
                            $products = getAll('products');
                            if (mysqli_num_rows($products) > 0) {
                                foreach ($products as $productItem) {
                                    ?>
                                    <tr>
                                        <td><?= $productItem['id']; ?></td>
                                        <td><?= $productItem['name']; ?></td>
                                        <td><?= $productItem['price']; ?></td>
                                        <td><?= $productItem['category_id']; ?></td>
                                        <td>
                                            <a href="products-edit.php?id=<?= $productItem['id']; ?>" class="btn btn-success btn-sm">Edit</a>
                                            <a href="products-delete.php?id=<?= $productItem['id']; ?>" 
                                                class="btn btn-danger btn-sm mx-2"
                                                onclick="return confirm('Are you sure you want to delete this data?')"
                                                >
                                                Delete
                                            </a>
                                        </td>
                                    </tr>
                                    <?php
                                }
                            } else {
                                ?>
                                <tr>
                                    <td colspan="7">No Record Found</td>
                                </tr>
                                <?php
                            }
                            ?>
                        </tbody>
                    </table>

                </div>
            </div>
        </div>
    </div>

    <?php include('includes/footer.php'); ?>
</body>
</html>