<?php
session_start();

if (!isset($_SESSION['name'])) {
    header("Location: login.php");
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Order Confirmation</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <link href="css/bootstrap.min.css" rel="stylesheet">
    <link href="css/style.css" rel="stylesheet">
</head>
<body style="background:#eef6fb;">

<div class="container min-vh-100 d-flex justify-content-center align-items-center">
    <div class="card shadow border-0 text-center p-5" style="max-width: 600px;">
        <h1 class="text-primary mb-3">Order Placed Successfully!</h1>
        <p class="lead">Thank you for ordering from Coffee Shop.</p>
        <p>Your order has been saved and will be prepared by the admin.</p>

        <div class="mt-4">
            <a href="menu.php" class="btn btn-primary px-4">Continue Shopping</a>
            <a href="index.php" class="btn btn-outline-dark px-4 ms-2">Back to Home</a>
        </div>
    </div>
</div>

</body>
</html>