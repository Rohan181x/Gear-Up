<?php
session_start();
include('../connection.php'); // Ensure correct connection

if (isset($_POST['updateProduct'])) {
    $product_id = intval($_POST['product_id']);
    $category_id = intval($_POST['category_id']);
    $product_name = mysqli_real_escape_string($conn, $_POST['product_name']);
    $product_description = mysqli_real_escape_string($conn, $_POST['product_description']);
    $product_price = mysqli_real_escape_string($conn, $_POST['product_price']);

    // Handle image upload if a new image is provided
    if (!empty($_FILES['product_image']['name'])) {
        $image_name = $_FILES['product_image']['name'];
        $image_tmp_name = $_FILES['product_image']['tmp_name'];
        $image_folder = '../uploads/' . $image_name;
        move_uploaded_file($image_tmp_name, $image_folder);

        // Update product with new image
        $query = "UPDATE products SET category_id = ?, name = ?, description = ?, price = ?, image = ? WHERE id = ?";
        $stmt = $conn->prepare($query);
        $stmt->bind_param("issssi", $category_id, $product_name, $product_description, $product_price, $image_name, $product_id);
    } else {
        // Update product without changing the image
        $query = "UPDATE products SET category_id = ?, name = ?, description = ?, price = ? WHERE id = ?";
        $stmt = $conn->prepare($query);
        $stmt->bind_param("isssi", $category_id, $product_name, $product_description, $product_price, $product_id);
    }

    $result = $stmt->execute();

    if ($result) {
        $_SESSION['message'] = "Product Updated Successfully!";
    } else {
        $_SESSION['message'] = "Failed to update product!";
    }

    header("Location: products.php"); // Redirect back to the products page
    exit();
}
?>