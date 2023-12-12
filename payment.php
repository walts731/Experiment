<?php
include("includes/connect.php");

session_start();

// Process the order when the form is submitted
if (isset($_GET['process_order'])) {
    // Check if the necessary parameters are set
    if (isset($_GET['cart_id'])) {
        $cartId = intval($_GET['cart_id']);

        // Retrieve other parameters
        $step1 = isset($_GET['step1']) ? $_GET['step1'] : '';
        $step2 = isset($_GET['step2']) ? $_GET['step2'] : '';
        $step3 = isset($_GET['step3']) ? $_GET['step3'] : '';
        $step4 = isset($_GET['step4']) ? $_GET['step4'] : [];

        // Fetch custom information based on selected steps
        $sql_get_breakdown = "SELECT `custom_name`, `price_amt` FROM `custom` 
                              WHERE `custom_id` IN ('$step1', '$step2', '$step3', '" . implode("','", $step4) . "')";
        $sql_result = mysqli_query($conn, $sql_get_breakdown);

        $customizationDetails = [];
        $totalCustomizationPrice = 0.00;

        while ($row = mysqli_fetch_assoc($sql_result)) {
            $customizationDetails[] = $row;
            $totalCustomizationPrice += $row['price_amt'];
        }

        // Fetch the product details based on cart_id
        $productQuery = "SELECT p.product_id, p.name, p.price, p.image, p.stock, c.quantity, c.total_amount
                        FROM cart c
                        JOIN products p ON c.product_id = p.product_id
                        WHERE c.cart_id = $cartId";

        $productResult = $conn->query($productQuery);

        if ($productResult->num_rows > 0) {
            $productDetails = $productResult->fetch_assoc();

            // Extract product details for pre-filling the customization form
            $productId = $productDetails['product_id'];
            $productName = $productDetails['name'];
            $productPrice = $productDetails['price'];
            $productImage = $productDetails['image'];
            $productStock = $productDetails['stock'];
            $quantity = $productDetails['quantity'];
            $product_total_Price = $productDetails['total_amount'];
        }
    }
}

// Fetch user details
$username = isset($_SESSION['username']) ? $_SESSION['username'] : '';
$userDetailsQuery = "SELECT `address`, `contact`, `user_id` FROM `users` WHERE `username` = '$username'";
$userDetailsResult = mysqli_query($conn, $userDetailsQuery);

if ($userDetailsResult && mysqli_num_rows($userDetailsResult) > 0) {
    $userDetails = mysqli_fetch_assoc($userDetailsResult);
    $userId = $userDetails['user_id'];
    $userAddress = $userDetails['address'];
    $userContact = $userDetails['contact'];
}

$referenceNumber = time();




if (isset($_POST['place_order'])) {
    // Insert order details into the orders table
    $insertOrderQuery = "INSERT INTO orders (user_id, product_id, customization_details, user_address, user_contact, reference_number, quantity, total_product_price, total_customization_price, total_order_price)
                        VALUES ($userId, $productId, '" . json_encode($customizationDetails) . "', '$userAddress', '$userContact', '$referenceNumber', $quantity, $product_total_Price, $totalCustomizationPrice, " . ($product_total_Price + $totalCustomizationPrice) . ")";

    if (mysqli_query($conn, $insertOrderQuery)) {
        // Update the product stock
        $updateStockQuery = "UPDATE products SET stock = stock - $quantity WHERE product_id = $productId";
        if (mysqli_query($conn, $updateStockQuery)) {
            // Delete the item from the cart after placing the order
            $deleteCartQuery = "DELETE FROM cart WHERE cart_id = $cartId";
            if (mysqli_query($conn, $deleteCartQuery)) {
                echo "<script>alert('Order Placed Successfully!')</script>";
                // Order successfully inserted, you can redirect or display a success message
                header("Location: orders.php");
                exit();
            } else {
                // Handle the error, you can redirect or display an error message
                echo "Error deleting item from cart: " . mysqli_error($conn);
            }
        } else {
            // Handle the error, you can redirect or display an error message
            echo "Error updating product stock: " . mysqli_error($conn);
        }
    } else {
        // Handle the error, you can redirect or display an error message
        echo "Error inserting order: " . mysqli_error($conn);
    }
}




?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Payment</title>
    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css">
    <!-- Custom Styles -->
    <link rel="stylesheet" href="userdefinedstyle.css">
</head>

<body>
    <!-- Navigation Bar -->
    <nav class="navbar navbar-expand-lg navbar-light bg-dark">
        <a class="navbar-brand text-light" href="customize_order.php?cart_id=<?php echo $cartId; ?>">Back to Order Customization</a>
    </nav>

    <form action="" method="post" class="mb-5">
        <!-- Order Summary Card with Product Details -->
        <div class="container mt-5">
            <div class="card col-md-6 mx-auto"> <!-- Set the card to take up 6 columns on medium-sized screens and center it -->
                <div class="card-header">
                    <h5 class="card-title">Order Summary</h5>
                </div>
                <div class="card-body">
                    <!-- Display product details -->
                    <div class="card mb-3">
                        <img src="admin/product_images/<?php echo $productImage; ?>" class="card-img-top w-50 m-auto"
                            alt="<?php echo $productName; ?>">
                        <div class="card-body">
                            <h6 class="card-subtitle mb-2 text-muted"><?php echo $productName; ?></h6>
                            <p class="card-text">Price: Php <?php echo number_format($productPrice, 2); ?></p>
                            <p class="card-text">Stock: <?php echo $productStock; ?></p>
                            <p class="card-text">Quantity: <?php echo $quantity; ?></p>
                        </div>
                    </div>
                    <h6 class="card-subtitle mb-2 text-muted">Delivery Details</h6>
                    <div class="mb-3">
                        <label for="userAddress">Address:</label>
                        <input type="text" id="userAddress" name="userAddress" value="<?php echo $userAddress; ?>" class="form-control">
                    </div>
                    <div class="mb-3">
                        <label for="userContact">Contact Number:</label>
                        <input type="text" id="userContact" name="userContact" value="<?php echo $userContact; ?>" class="form-control">
                    </div>

                    <!-- Reference Number -->
                    <div class="mb-3">
                        <label for="referenceNumber">Reference Number:</label>
                        <input type="text" id="referenceNumber" name="referenceNumber" value="<?php echo $referenceNumber; ?>" class="form-control" readonly>
                    </div>

                    <!-- Display customization details -->
                    <?php if (!empty($customizationDetails)) : ?>
                        <h6 class="card-subtitle mt-4 mb-2 text-muted">Customization Details</h6>
                        <ul class="list-group">
                            <?php foreach ($customizationDetails as $customization) : ?>
                                <li class="list-group-item">
                                    <?php echo $customization['custom_name']; ?>
                                    <span class="float-right">Php <?php echo number_format($customization['price_amt'], 2); ?></span>
                                </li>
                            <?php endforeach; ?>
                        </ul>
                    <?php endif; ?>

                    <!-- Display total price -->
                    <div class="mt-3">
                        <h6>Total Product Total Price: Php <?php echo number_format($product_total_Price, 2); ?></h6>
                        <h6>Total Customization Price: Php <?php echo number_format($totalCustomizationPrice, 2); ?></h6>
                        <h6>Total Order Price: Php <?php echo number_format($product_total_Price + $totalCustomizationPrice, 2); ?></h6>
                    </div>
                </div>
                <div class="card-footer text-muted">
                    <button type="submit" name="place_order" class="btn btn-primary">Place Order</button>
                </div>
            </div>
        </div>
    </form>

    <footer class="bg-info">
        <p>&copy; <?php echo date("Y"); ?> CRE8. All rights reserved.</p>
    </footer>

    <!-- Include Bootstrap JS and Popper.js (required for Bootstrap dropdowns) -->
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.3/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>

</html>
