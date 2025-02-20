<?php
include('includes/header.php');
include('connection.php');

if (!isset($_GET['id'])) {
    echo "Product not found!";
    exit();
}

$id = $_GET['id'];
$query = "SELECT products.*, categories.name AS category_name FROM products 
          JOIN categories ON products.category_id = categories.id WHERE products.id = ?";
$stmt = $conn->prepare($query);
$stmt->bind_param("i", $id);
$stmt->execute();
$result = $stmt->get_result();
$product = $result->fetch_assoc();
?>

<div class="container mt-5">
    <h4><?= $product['name']; ?></h4>
    <img src="<?= $product['image']; ?>" class="img-fluid" alt="<?= $product['name']; ?>">
    <p><strong>Category:</strong> <?= $product['category_name']; ?></p>
    <p><strong>Description:</strong> <?= $product['description']; ?></p>
    <p><strong>Price:</strong> $<?= $product['price']; ?></p>
    <a href="products.php" class="btn btn-secondary">Back to Products</a>
</div>

<?php include('includes/footer.php'); ?>
