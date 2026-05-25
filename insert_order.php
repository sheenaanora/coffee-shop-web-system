<?php
session_start();

if (!isset($_SESSION['name'])) {
    header("Location: login.php");
    exit();
}

if (
    !isset($_SESSION['totalPrice']) ||
    !isset($_SESSION['totalQuantity']) ||
    !isset($_SESSION['item_name_quantity'])
) {
    header("Location: menu.php");
    exit();
}

$totalPrice = $_SESSION['totalPrice'];
$totalQuantity = $_SESSION['totalQuantity'];
$productName = $_SESSION['item_name_quantity'];
$productName = preg_replace('/\s*x\s*\d+\s*,?/i', '', $productName);
$productName = trim($productName);
$customerName = $_SESSION['name'];

$apiUrl = "http://localhost/coffee-api/add_order.php";

$postData = [
    "customer_name" => $customerName,
    "product_name" => $productName,
    "quantity" => $totalQuantity,
    "total_price" => $totalPrice
];

$ch = curl_init($apiUrl);
curl_setopt($ch, CURLOPT_POST, true);
curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($postData));
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

$response = curl_exec($ch);
$error = curl_error($ch);
curl_close($ch);

if ($error) {
    echo "<script>alert('API connection failed. Please make sure the API server is running.'); window.location.href='checkout.php';</script>";
    exit();
}

$result = json_decode($response, true);

if (isset($result['success']) && $result['success'] === true) {
    unset($_SESSION['cart_items']);
    header("Location: confirmation.php");
    exit();
} else {
    echo "<script>alert('Failed to place order through API.'); window.location.href='checkout.php';</script>";
    exit();
}
?>