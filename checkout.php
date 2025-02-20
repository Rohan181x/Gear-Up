<?php
session_start();
include('connection.php');

// Check if the user is logged in
if (!isset($_SESSION['email'])) {
    header("Location: login.php");
    exit();
}

if (isset($_POST['placeOrder'])) {
    if (!isset($_SESSION['user_id'])) {
        die("User ID is not set in the session.");
    }

    $user_id = $_SESSION['user_id'];
    $delivery_location = $_POST['delivery_location'];
    $phone_number = $_POST['phone_number'];
    $total_price = 0;

    foreach ($_SESSION['cart'] as $item) {
        $total_price += $item['price'] * $item['quantity'];
    }

    $query = "INSERT INTO orders (user_id, delivery_location, phone_number, total_price) VALUES ('$user_id', '$delivery_location', '$phone_number', '$total_price')";
    mysqli_query($conn, $query);

    // Get the order ID
    $order_id = mysqli_insert_id($conn);

    // Redirect to Stripe payment page
    header("Location: stripe_payment.php?order_id=$order_id&amount=$total_price");
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Checkout</title>
    <link rel="stylesheet" href="style.css">
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
        <h2>Checkout</h2>
        <div class="order-summary">
            <h3>Order Summary</h3>
            <table>
                <thead>
                    <tr>
                        <th>Product</th>
                        <th>Quantity</th>
                        <th>Price</th>
                        <th>Total</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    $total_price = 0;
                    foreach ($_SESSION['cart'] as $item) {
                        $item_total = $item['price'] * $item['quantity'];
                        $total_price += $item_total;
                        echo "<tr>
                                <td>" . htmlspecialchars($item['name']) . "</td>
                                <td>" . htmlspecialchars($item['quantity']) . "</td>
                                <td>Rs " . htmlspecialchars($item['price']) . "</td>
                                <td>Rs " . htmlspecialchars($item_total) . "</td>
                              </tr>";
                    }
                    ?>
                </tbody>
            </table>
            <p class="total-amount">Total Amount: Rs <?php echo $total_price; ?></p>
        </div>
        <form action="checkout.php" method="POST">
            <div class="form-group">
                <label for="delivery_location">Delivery Location:</label>
                <input type="text" id="delivery_location" name="delivery_location" required>
            </div>
            <div class="form-group">
                <label for="phone_number">Phone Number:</label>
                <input type="text" id="phone_number" name="phone_number" required>
            </div>
            <div class="form-group">
                <label for="total_price">Total Amount:</label>
                <input type="text" id="total_price" name="total_price" value="Rs <?php echo $total_price; ?>" readonly>
            </div>
            <button type="submit" name="placeOrder">Place Order</button>
        </form>
    </div>

    <footer>
        <p>&copy; 2024 E-commerce Website Chad Wears. All rights reserved. | <a href="aboutus_contactus.php">About Us</a> | <a href="#">Privacy Policy</a></p>
    </footer>
</body>
</html>