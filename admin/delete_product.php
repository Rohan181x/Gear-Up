<?php
session_start();
include('../connection.php'); // Ensure correct connection

if (isset($_GET['id'])) {
    $product_id = intval($_GET['id']);

    // Check if the product ID is valid
    if ($product_id > 0) {
        // Delete Product using prepared statement
        $stmt = $conn->prepare("DELETE FROM products WHERE id = ?");
        if ($stmt) {
            $stmt->bind_param("i", $product_id);
            $result = $stmt->execute();

            if ($result) {
                $_SESSION['message'] = "Product Deleted Successfully!";
            } else {
                $_SESSION['message'] = "Failed to delete product!";
            }

            $stmt->close();
        } else {
            $_SESSION['message'] = "Failed to prepare the statement!";
        }
    } else {
        $_SESSION['message'] = "Invalid Product ID!";
    }

    header("Location: products.php"); // Redirect back to the products page
    exit();
} else {
    $_SESSION['message'] = "Product ID not set!";
    header("Location: products.php"); // Redirect back to the products page
    exit();
}
?>
