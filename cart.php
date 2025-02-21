<?php
session_start();
include('connection.php');

// Check if the user is logged in
if (!isset($_SESSION['email'])) {
    // User not logged in, show the "Not Logged In" page
    ?>
    <!DOCTYPE html>
    <html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Not Logged In</title>
        <style>
            body {
                margin: 0;
                padding: 0;
                display: flex;
                justify-content: center;
                align-items: center;
                height: 100vh;
                background-color: #c8d8e4;
                font-family: Arial, sans-serif;
            }
            .container {
                text-align: center;
                background: #ffffff;
                padding: 20px;
                border-radius: 10px;
                box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
                width: 300px;
            }
            .logo {
                margin-bottom: 20px;
            }
            .logo img {
                width: 50px;
                height: auto;
            }
            h1 {
                margin-bottom: 20px;
                color: black;
            }
            p {
                margin-bottom: 20px;
                font-size: 16px;
                color: black;
            }
            a {
                text-decoration: none;
                padding: 10px 20px;
                border-radius: 5px;
                font-size: 14px;
                font-weight: bold;
                display: inline-block;
            }
            a[href="login.php"] {
                background-color: #52ab98;
                color: white;
            }
            a[href="login.php"]:hover {
                background-color: #2b6777;
            }
            a[href="homepage.php"] {
                background-color: #c8d8e4;
                color: black;
            }
            a[href="homepage.php"]:hover {
                background-color: #f2f2f2;
            }
        </style>
    </head>
    <body>
        <div class="container">
            <div class="logo">
                <img src="./images/topgear.png" alt="Logo">
            </div>
            <h1>You are not logged in</h1>
            <p>Would you like to log in?</p>
            <a href="login.php">Yes</a>
            <a href="homepage.php">No</a>
        </div>
    </body>
    </html>
    <?php
    exit();
}

// Initialize the cart if it doesn't exist
if (!isset($_SESSION['cart'])) {
    $_SESSION['cart'] = [];
}

// Handle adding items to the cart
if (isset($_POST['addToCart'])) {
    $product_id = $_POST['product_id'];
    $price = $_POST['price'];
    $image = $_POST['image'];
    $name = $_POST['name'];
    $quantity = 1;

    // Check if the product is already in the cart
    $found = false;
    foreach ($_SESSION['cart'] as &$item) {
        if ($item['product_id'] == $product_id) {
            $item['quantity'] += 1;
            $found = true;
            break;
        }
    }

    // If the product is not in the cart, add it
    if (!$found) {
        $_SESSION['cart'][] = [
            'product_id' => $product_id,
            'price' => $price,
            'image' => $image,
            'name' => $name,
            'quantity' => $quantity
        ];
    }

    header("Location: cart.php");
    exit();
}

// Handle updating quantities
if (isset($_POST['updateCart'])) {
    foreach ($_POST['quantities'] as $product_id => $quantity) {
        foreach ($_SESSION['cart'] as &$item) {
            if ($item['product_id'] == $product_id) {
                $item['quantity'] = $quantity;
                break;
            }
        }
    }

    header("Location: cart.php");
    exit();
}

// Handle removing items from the cart
if (isset($_POST['removeFromCart'])) {
    $product_id = $_POST['product_id'];
    $_SESSION['cart'] = array_filter($_SESSION['cart'], function($item) use ($product_id) {
        return $item['product_id'] != $product_id;
    });

    header("Location: cart.php");
    exit();
}

// Display Cart Items
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Shopping Cart</title>
    <link rel="stylesheet" href="style.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css"> <!-- Add Font Awesome CSS -->
    <style>
        .quantity-controls {
            display: flex;
            align-items: center;
            justify-content: center;
        }
        .quantity-controls button {
            padding: 5px 10px;
            font-size: 16px;
            cursor: pointer;
            background-color: #52ab98;
            color: white;
            border: none;
            border-radius: 5px;
        }
        .quantity-controls button:hover {
            background-color: #2b6777;
        }
        .quantity-controls input {
            width: 50px;
            text-align: center;
            margin: 0 5px;
            -moz-appearance: textfield; /* Firefox */
        }
        .quantity-controls input::-webkit-outer-spin-button,
        .quantity-controls input::-webkit-inner-spin-button {
            -webkit-appearance: none;
            margin: 0;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            background-color: #ffffff; /* Set table background to white */
        }
        table th, table td {
            padding: 12px 15px;
            border: 1px solid #c8d8e4;
            text-align: left;
        }
        table th {
            background-color: #52ab98;
            color: black;
        }
        table tr:nth-child(even) {
            background-color: #f2f2f2;
        }
        table tr:hover {
            background-color: #c8d8e4;
        }
    </style>
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
        <h2>Shopping Cart</h2>
        <?php if (!empty($_SESSION['cart'])): ?>
            <form action="cart.php" method="POST">
                <table>
                    <thead>
                        <tr>
                            <th>Product</th>
                            <th>Name</th>
                            <th>Price</th>
                            <th>Quantity</th>
                            <th>Total</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($_SESSION['cart'] as $item): ?>
                            <tr>
                                <td>
                                    <img src="<?php echo htmlspecialchars($item['image']); ?>" alt="Product Image" style="width: 50px; height: auto;">
                                </td>
                                <td><?php echo htmlspecialchars($item['name']); ?></td>
                                <td>Rs <?php echo htmlspecialchars($item['price']); ?></td>
                                <td>
                                    <div class="quantity-controls">
                                        <button type="button" class="decrease-quantity" data-product-id="<?php echo htmlspecialchars($item['product_id']); ?>">-</button>
                                        <input type="number" name="quantities[<?php echo htmlspecialchars($item['product_id']); ?>]" value="<?php echo htmlspecialchars($item['quantity']); ?>" min="1">
                                        <button type="button" class="increase-quantity" data-product-id="<?php echo htmlspecialchars($item['product_id']); ?>">+</button>
                                    </div>
                                </td>
                                <td>Rs <?php echo htmlspecialchars($item['price'] * $item['quantity']); ?></td>
                                <td>
                                    <form action="cart.php" method="POST" style="display:inline;">
                                        <input type="hidden" name="product_id" value="<?php echo htmlspecialchars($item['product_id']); ?>">
                                        <button type="submit" name="removeFromCart" style="background-color: #52ab98; color: white; border: none; padding: 5px 10px; border-radius: 5px; cursor: pointer;">Remove</button>
                                    </form>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
                <button type="submit" name="updateCart" style="background-color: #52ab98; color: white; border: none; padding: 10px 20px; border-radius: 5px; cursor: pointer;">Update Cart</button>
            </form>
            <a href="checkout.php" class="btn" style="background-color: #52ab98; color: white; padding: 10px 20px; border-radius: 5px; text-decoration: none; display: inline-block; margin-top: 10px;">Proceed to Checkout</a>
        <?php else: ?>
            <p>Your cart is empty.</p>
        <?php endif; ?>
    </div>
    <script>
        document.querySelectorAll('.decrease-quantity').forEach(button => {
            button.addEventListener('click', function() {
                const productId = this.getAttribute('data-product-id');
                const input = document.querySelector(`input[name="quantities[${productId}]"]`);
                if (input.value > 1) {
                    input.value = parseInt(input.value) - 1;
                }
            });
        });

        document.querySelectorAll('.increase-quantity').forEach(button => {
            button.addEventListener('click', function() {
                const productId = this.getAttribute('data-product-id');
                const input = document.querySelector(`input[name="quantities[${productId}]"]`);
                input.value = parseInt(input.value) + 1;
            });
        });
    </script>
   
    <footer>
        <p>&copy; 2024 E-commerce Website topgear. All rights reserved. | <a href="aboutus_contactus.php">About Us</a> | <a href="#">Privacy Policy</a></p>
    </footer>
</body>
</html>