<?php
require_once 'includes/header.php'; // Include the header file
require_once '../config/function.php'; // Include the function file
require_once '../connection.php'; // Include the connection file

// Check if the admin is logged in
if (!isset($_SESSION['auth']) || $_SESSION['role'] !== 'admin') {
    header("Location: login.php");
    exit();
}

if (!isset($_GET['order_id'])) {
    die("Order ID is not set in the URL.");
}

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
    <title>Order Details</title>
    <link rel="stylesheet" href="styles.css"> <!-- Add your CSS file -->
    <style>
        /* Internal CSS for table and button styling */
        table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 20px;
        }

        table th, table td {
            padding: 12px 15px;
            border: 1px solid #ddd;
            text-align: left;
        }

        table th {
            background-color: #f4f4f4;
            color: #333;
        }

        table tr:nth-child(even) {
            background-color: #f9f9f9;
        }

        table tr:hover {
            background-color: #f1f1f1;
        }

        .btn {
            display: inline-block;
            padding: 10px 15px;
            background-color: #fc7414;
            color: #fff;
            text-decoration: none;
            border-radius: 5px;
            transition: background-color 0.3s;
        }

        .btn:hover {
            background-color: #e05e00;
        }
    </style>
    <!-- Navbar -->
<nav class="navbar navbar-main navbar-expand-lg px-0 mx-4 shadow-none border-radius-xl" id="navbarBlur" navbar-scroll="true">
      <div class="container-fluid py-1 px-3">
        <nav aria-label="breadcrumb">
          <ol class="breadcrumb bg-transparent mb-0 pb-0 pt-1 px-0 me-sm-6 me-5">
            <li class="breadcrumb-item text-sm"><a class="opacity-5 text-dark" href="javascript:;">Pages</a></li>
            <li class="breadcrumb-item text-sm text-dark active" aria-current="page">Order Details</li>
          </ol>
        </nav>
      </div>
    </nav>
    <!-- End Navbar -->
</head>
<body>

    <div class="container">
        <h2>Order Details</h2>
        <table>
            <tr>
                <th>Order ID</th>
                <td><?php echo htmlspecialchars($order['id']); ?></td>
            </tr>
            <tr>
                <th>User Name</th>
                <td><?php echo htmlspecialchars($user['username']); ?></td>
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
        <a href="orders.php" class="btn">Back to Orders</a>
    </div>

    <?php include('includes/footer.php'); ?>
</body>
</html>