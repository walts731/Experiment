<?php
include("includes/connect.php");
session_start();
// Fetch the product details based on cart_id
if (isset($_GET['cart_id'])) {
    $cartId = intval($_GET['cart_id']);

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
        $totalAmount = $productDetails['total_amount'];
    } else {
        // Handle the case where the product is not found
        // Redirect or display an error message as needed
    }
}


// payment.php

if ($_SERVER["REQUEST_METHOD"] == "GET") {
    // Check if the form is submitted with the correct button
    if (isset($_GET["process_order"])) {
        // Retrieve the cart_id from the form
        $cartId = isset($_GET['cart_id']) ? intval($_GET['cart_id']) : 0;

        // Retrieve the selected options for each step
        $step1 = isset($_GET['step1']) ? $_GET['step1'] : '';
        $step2 = isset($_GET['step2']) ? $_GET['step2'] : '';
        $step3 = isset($_GET['step3']) ? $_GET['step3'] : '';
        $step4 = isset($_GET['step4']) ? $_GET['step4'] : [];

        // Process the selected options as needed
        // For example, you can insert them into a database or perform other business logic

        // Redirect to a confirmation page or perform other actions
        header("Location: payment.php");
        exit();
    } else {
        // Handle other form submissions or invalid requests
        // Redirect or display an error message as needed
    }
} else {
    // Handle non-GET requests if necessary
}

?>





<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Order Customization</title>
    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css">
    <!-- Custom Styles -->
    <link rel="stylesheet" href="userdefinedstyle.css">
    <style>
    .custom-image {
        width: 50%; /* Set a fixed width or percentage as needed */
        height: auto; /* Maintain aspect ratio */
    }
</style>

</head>

<body>

    <form action="payment.php" method="get">
        <!-- Hidden input to include cart_id -->
    <input type="hidden" name="cart_id" value="<?php echo $cartId; ?>">
        <!-- Navbar -->
        <nav class="navbar navbar-expand-lg navbar-light bg-dark">
            <a class="navbar-brand text-light" href="view_cart.php">Go Back to Cart</a>
            <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNav"
                aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav ml-auto">
                    <li class="nav-item">
                        <input type="submit" name="process_order" class="btn btn-warning" value="Order Now >>">
                    </li>
                </ul>
            </div>
        </nav>
<!-- ... rest of your code ... -->

<!-- ... rest of your code ... -->


       <!-- Display Product in Card Form -->
<div class="col-lg-3 col-md-4 col-sm-6 m-auto">
    <div class="card mt-5 mb-3">
        <img src="admin/product_images/<?php echo $productImage; ?>" class="card-img-top w-50 m-auto" alt="<?php echo $productName; ?>">
        <div class="card-body">
            <h5 class="card-title"><?php echo $productName; ?></h5>
            <p class="card-text">Price: Php <?php echo number_format($productPrice, 2); ?></p>
            <p class="card-text">Stock: <?php echo $productStock; ?></p>
            <p class="card-text">Quantity: <?php echo $quantity; ?></p>
            <h4 class="display-6">Total Amount: Php <?php echo number_format($totalAmount, 2); ?></h4>
        </div>
    </div>
</div>

        <!-- Step 1: Pick your Color -->
        <div class="row">
            <div class="col-lg-6 col-sm-12">
                <h4 class="display-6">Step 1. Pick your Color</h4>
                <div class="container-fluid">
                    <div class="row">
                        <?php
                        $sql_get_ingredient = "SELECT * FROM `custom` where `step_id` = '1'";
                        $get_result = mysqli_query($conn, $sql_get_ingredient);

                        if (mysqli_num_rows($get_result) > 0) {
                            while ($step1 = mysqli_fetch_assoc($get_result)) {
                                ?>
                                <div class="col-6">
                                <img src="admin/custom_images/<?php echo $step1['custom_img']; ?>" alt="" class="img-fluid custom-image">
                                    <input type="radio" class="btn-check" name="step1"
                                        value="<?php echo $step1['custom_id']; ?>" id="<?php echo $step1['custom_id']; ?>"
                                        autocomplete="off">
                                    <label class="btn col-12 btn-outline-danger mb-1"
                                        for="<?php echo $step1['custom_id']; ?>">
                                        <?php echo $step1['custom_name'] . "<br>"; ?>
                                       
                                        
                                    </label>
                                </div>
                            <?php
                            }
                        }
                        ?>
                    </div>
                </div>
            </div>

            <!-- Step 2: Pick your Size -->
            <div class="col-lg-6 col-sm-12">
                <h4 class="display-6">Step 2. Pick your Size</h4>
                <div class="container-fluid">
                    <div class="row">
                        <?php
                        $sql_get_sizes = "SELECT * FROM `custom` WHERE `step_id` = '2'";
                        $get_sizes_result = mysqli_query($conn, $sql_get_sizes);

                        if (mysqli_num_rows($get_sizes_result) > 0) {
                            while ($size = mysqli_fetch_assoc($get_sizes_result)) {
                                ?>
                                <div class="col-6">
                                <img src="admin/custom_images/<?php echo $size['custom_img']; ?>" alt="" class="img-fluid custom-image">

                                    <input required type="radio" class="btn-check" name="step2"
                                        value="<?php echo $size['custom_id']; ?>" id="<?php echo $size['custom_id']; ?>"
                                        autocomplete="off">
                                    <label class="btn col-12 btn-outline-primary mb-1" for="<?php echo $size['custom_id']; ?>">
                                        <?php echo $size['custom_name'] . "<br>"; ?>
                                        <?php echo "Php " . number_format($size['price_amt'], 2); ?>
                                    </label>
                                </div>
                            <?php
                            }
                        }
                        ?>
                    </div>
                </div>
            </div>

            <!-- Step 3: Pick your Design -->
            <div class="col-lg-6 col-sm-12">
                <h4 class="display-6">Step 3. Pick your Design</h4>
                <div class="container-fluid">
                    <div class="row">
                        <?php
                        $sql_get_designs = "SELECT * FROM `custom` WHERE `step_id` = '3'";
                        $get_designs_result = mysqli_query($conn, $sql_get_designs);

                        if (mysqli_num_rows($get_designs_result) > 0) {
                            while ($design = mysqli_fetch_assoc($get_designs_result)) {
                                ?>
                                <div class="col-6">
                                <img src="admin/custom_images/<?php echo $design['custom_img']; ?>" alt="" class="img-fluid custom-image">
                                    <input type="radio" class="btn-check" name="step3"
                                        value="<?php echo $design['custom_id']; ?>" id="<?php echo $design['custom_id']; ?>"
                                        autocomplete="off">
                                    <label class="btn col-12 btn-outline-success mb-1" for="<?php echo $design['custom_id']; ?>">
                                        <?php echo $design['custom_name'] . "<br>"; ?>
                                        <?php echo "Php " . number_format($design['price_amt'], 2); ?>
                                    </label>
                                </div>
                            <?php
                            }
                        }
                        ?>
                    </div>
                </div>
            </div>

            <!-- Step 4: Add-ons -->
            <div class="col-lg-6 col-sm-12">
                <h4 class="display-6">Step 4. Add-ons</h4>
                <div class="container-fluid">
                    <div class="row">
                        <?php
                        $sql_get_addons = "SELECT * FROM `custom` WHERE `step_id` = '4'";
                        $get_addons_result = mysqli_query($conn, $sql_get_addons);

                        if (mysqli_num_rows($get_addons_result) > 0) {
                            while ($addon = mysqli_fetch_assoc($get_addons_result)) {
                                ?>
                                <div class="col-6">
                                <img src="admin/custom_images/<?php echo $addon['custom_img']; ?>" alt="" class="img-fluid custom-image">
                                    <input type="checkbox" class="btn-check" name="step4[]"
                                        value="<?php echo $addon['custom_id']; ?>" id="<?php echo $addon['custom_id']; ?>"
                                        autocomplete="off">
                                    <label class="btn col-12 btn-outline-warning mb-1" for="<?php echo $addon['custom_id']; ?>">
                                        <?php echo $addon['custom_name'] . "<br>"; ?>
                                        <?php echo "Php " . number_format($addon['price_amt'], 2); ?>
                                    </label>
                                </div>
                            <?php
                            }
                        }
                        ?>
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

</html>

