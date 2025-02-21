<?php
require 'vendor/autoload.php';

\Stripe\Stripe::setApiKey('sk_test_51QsyLwKBgthi6f7Wbxp3fdO0K0AzwstUYpIiDXbrScpHs5jx819PmnkZqkth3hgc5PzL5pBkHAWLyaNYapduhnwl00vBAAWQC9');

$order_id = $_GET['order_id'];
$amount = $_GET['amount'] * 100; // Convert to cents

$success_url = 'http://localhost/ec/stripe_success.php?session_id={CHECKOUT_SESSION_ID}&order_id=' . $order_id;
$cancel_url = 'http://localhost/ec/stripe_cancel.php?order_id=' . $order_id;

// Log the URLs for debugging
error_log("Success URL: " . $success_url);
error_log("Cancel URL: " . $cancel_url);

$session = \Stripe\Checkout\Session::create([
    'payment_method_types' => ['card'],
    'line_items' => [[
        'price_data' => [
            'currency' => 'npr',
            'product_data' => [
                'name' => 'Order #' . $order_id,
            ],
            'unit_amount' => $amount,
        ],
        'quantity' => 1,
    ]],
    'mode' => 'payment',
    'success_url' => $success_url,
    'cancel_url' => $cancel_url,
]);

header('Location: ' . $session->url);
exit();
?>