<?php
include("includes/connect.php");

// Start a session
session_start();

// Check if the user is logged in
if (!isset($_SESSION['username'])) {
    header("Location: login.php"); // Redirect to login page if not logged in
    exit();
}

// Handle removal of item from cart
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['remove_cart_id'])) {
    $removeCartId = intval($_POST['remove_cart_id']);

    // Remove the item from the database
    $removeQuery = "DELETE FROM cart WHERE cart_id = $removeCartId";
    $conn->query($removeQuery);
}

// Handle updates if the form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['update_cart'])) {
    // Update quantity and calculate total amount
    if (isset($_POST['quantity']) && isset($_POST['cart_id'])) {
        $quantities = $_POST['quantity'];
        $cartIds = $_POST['cart_id'];

        for ($i = 0; $i < count($quantities); $i++) {
            $quantity = intval($quantities[$i]);
            $cartId = intval($cartIds[$i]);

            // Update the quantity in the database
            $updateQuery = "UPDATE cart SET quantity = $quantity WHERE cart_id = $cartId";
            $conn->query($updateQuery);

            // Calculate and update the total amount in the database
            $updateTotalQuery = "UPDATE cart SET total_amount = (quantity * (SELECT price FROM products WHERE product_id = (SELECT product_id FROM cart WHERE cart_id = $cartId))) WHERE cart_id = $cartId";
            $conn->query($updateTotalQuery);
        }
    }
}

// Fetch the user's cart items (after handling updates and removals)
$username = $_SESSION['username'];
$cartQuery = "SELECT c.cart_id, p.product_id, p.name, p.price, p.image, p.stock, c.quantity, c.total_amount
              FROM cart c
              JOIN products p ON c.product_id = p.product_id
              WHERE c.username = '$username'";
$cartResult = $conn->query($cartQuery);
?>

<!-- rest of the HTML code remains the same -->



<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Your Cart - CRE8</title>
    <!-- Include Bootstrap CSS -->
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
    <!-- Custom Styles -->
    <link rel="stylesheet" href="userdefinedstyle.css">
</head>
<body class="bg-secondary">
    <div class="container mt-4">
        <h2>Your Cart</h2>

        <?php if ($cartResult->num_rows > 0): ?>
            <form action="view_cart.php" method="post">
                <table class="table table-bordered">
                    <thead>
                        <tr>
                            <th>Product</th>
                            <th>Image</th>
                            <th>Price</th>
                            <th>Quantity</th>
                            <th>Total</th>
                            <th>Stock</th>
                            <th>Remove Item</th>
                            <th>Customize</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php while ($cartItem = $cartResult->fetch_assoc()): ?>
                            <tr>
                                <td><?php echo $cartItem['name']; ?></td>
                                <td><img src="admin/product_images/<?php echo $cartItem['image']; ?>" alt="<?php echo $cartItem['name']; ?>" style="max-width: 100px;"></td>
                                <td><?php echo $cartItem['price']; ?></td>
                                <td>
                                    <input type="number" name="quantity[]" value="<?php echo $cartItem['quantity']; ?>" min="1" max="<?php echo $cartItem['stock']; ?>" required>
                                    <input type="hidden" name="cart_id[]" value="<?php echo $cartItem['cart_id']; ?>">
                                    <button type="submit" name="update_cart" class="btn btn-primary btn-sm">Update Quantity</button>
                                </td>
                                <td><?php echo $cartItem['price'] * $cartItem['quantity']; ?></td>
                                <td><?php echo $cartItem['stock']; ?></td>
                                <td>
                                    <button type="submit" name="remove_cart_id" value="<?php echo $cartItem['cart_id']; ?>" class="btn btn-danger btn-sm">Remove</button>
                                </td>
                                <td><a href="customize_order.php?cart_id=<?php echo $cartItem['cart_id']; ?>" class="btn btn-warning btn-sm">Customize Before Checkout</a></td>
                            </tr>
                        <?php endwhile; ?>
                    </tbody>
                </table>
            </form>
            <a href="user_dashboard.php" class="btn btn-success">Continue Shopping</a>
        <?php else: ?>
            <p class="text-center">Your cart is empty.</p>
            <a href="user_dashboard.php" class="btn btn-success">Continue Shopping</a>
        <?php endif; ?>
    </div>

    <footer class="bg-info">
        <p>&copy; <?php echo date("Y"); ?> CRE8. All rights reserved.</p>
    </footer>

    <!-- Include Bootstrap JS and Popper.js (required for Bootstrap) -->
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.3/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>
</html>
