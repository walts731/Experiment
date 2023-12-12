<?php
session_start();
include("includes/connect.php");

$userId = $_SESSION["user_id"]; // Adjust the session variable according to your actual setup

$getCartCountQuery = "SELECT SUM(quantity) AS total FROM cart WHERE user_id = $userId";
$getCartCountResult = $conn->query($getCartCountQuery);

if ($getCartCountResult) {
    $cartCount = $getCartCountResult->fetch_assoc()["total"];
    echo $cartCount;
} else {
    echo "0";
}
?>
