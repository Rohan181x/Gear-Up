<?php
session_start();
include('connection.php');

$order_id = $_GET['order_id'];

// Fetch order details from the database
$query = "SELECT * FROM orders WHERE id = '$order_id'";
$result = mysqli_query($conn, $query);

if (!$result) {
    die("Error fetching order details: " . mysqli_error($conn));
}

$order = mysqli_fetch_assoc($result);

if (!$order) {
    die("Order not found!");
}

// Fetch user details
$user_id = $order['user_id'];
$user_query = "SELECT * FROM users WHERE id = '$user_id'";
$user_result = mysqli_query($conn, $user_query);

if (!$user_result) {
    die("Error fetching user details: " . mysqli_error($conn));
}

$user = mysqli_fetch_assoc($user_result);

if (!$user) {
    die("User not found!");
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Order Confirmation</title>
    <link rel="stylesheet" href="style.css"> <!-- Add your CSS file -->
</head>
<body>

    <div class="container">
        <h2>Order Confirmation</h2>
        <p>Thank you for your purchase, <?php echo htmlspecialchars($user['username']); ?>!</p>
        <p>Your order has been placed successfully. Here are the details:</p>
        <table>
            <tr>
                <th>Order ID</th>
                <td><?php echo htmlspecialchars($order['id']); ?></td>
            </tr>
            <tr>
                <th>Delivery Location</th>
                <td><?php echo htmlspecialchars($order['delivery_location']); ?></td>
            </tr>
            <tr>
                <th>Phone Number</th>
                <td><?php echo htmlspecialchars($order['phone_number']); ?></td>
            </tr>
            <tr>
                <th>Total Price</th>
                <td>Rs <?php echo htmlspecialchars($order['total_price']); ?></td>
            </tr>
            <tr>
                <th>Status</th>
                <td><?php echo htmlspecialchars($order['status']); ?></td>
            </tr>
            <tr>
                <th>Order Date</th>
                <td><?php echo htmlspecialchars($order['created_at']); ?></td>
            </tr>
        </table>
        <a href="homepage.php" class="btn">Go to Home Page</a>
    </div>

    <footer>
        <p>&copy; 2024 E-commerce Website Chad Wears. All rights reserved. | <a href="aboutus_contactus.php">About Us</a> | <a href="#">Privacy Policy</a></p>
    </footer>
</body>
</html>