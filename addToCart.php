<?php
session_start();

if (isset($_POST['cart_items']) && !empty($_POST['cart_items'])) {
    $_SESSION['cart_items'] = explode(",", $_POST['cart_items']);
} else {
    $_SESSION['cart_items'] = [];
}

header("Location: checkout.php");
exit();
?>