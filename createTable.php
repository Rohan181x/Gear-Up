<?php
include_once('connection.php');

// Create users table if it doesn't exist
$sql2 = "CREATE TABLE IF NOT EXISTS users (
    id INT(6) UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    username VARCHAR(30) NOT NULL,
    password VARCHAR(255) NOT NULL,
    email VARCHAR(50) NOT NULL UNIQUE
)";

// Execute the query
if ($conn->query($sql2) === FALSE) {
    die("Error creating table: " . $conn->error);
} else {
    echo "Table 'users' created successfully or already exists.";
}
?>
