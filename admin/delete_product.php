<?php
session_start();
include('../connection.php'); // Ensure correct connection

if (isset($_POST['deleteProduct'])) {
    $product_id = intval($_POST['product_id']);

    // Delete Product using prepared statement
    $stmt = $conn->prepare("DELETE FROM products WHERE id = ?");
    $stmt->bind_param("i", $product_id);
    $result = $stmt->execute();

    if ($result) {
        $_SESSION['message'] = "Product Deleted Successfully!";
    } else {
        $_SESSION['message'] = "Failed to delete product!";
    }

    header("Location: products.php"); // Redirect back to the products page
    exit();
}
?>
