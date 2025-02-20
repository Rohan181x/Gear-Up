<?php
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "ecommerce";
$port = 3307;  // Add this line

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname, $port);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

?>
