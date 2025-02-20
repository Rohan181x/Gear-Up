<?php
require 'vendor/autoload.php';
include('connection.php');

\Stripe\Stripe::setApiKey('sk_test_51QsyLwKBgthi6f7Wbxp3fdO0K0AzwstUYpIiDXbrScpHs5jx819PmnkZqkth3hgc5PzL5pBkHAWLyaNYapduhnwl00vBAAWQC9');

$order_id = $_GET['order_id'];
$session_id = $_GET['session_id'];

$session = \Stripe\Checkout\Session::retrieve($session_id);

if ($session->payment_status == 'paid') {
    // Update the order status to 'Paid'
    $query = "UPDATE orders SET status = 'Paid' WHERE id = '$order_id'";
    mysqli_query($conn, $query);

    // Redirect to the confirmation page
    header("Location: confirmation.php?order_id=$order_id");
    exit();
} else {
    echo "Payment verification failed!";
}
?>