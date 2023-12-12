<?php
include("includes/connect.php");

// Start a session
session_start();

// Check if a user is logged in
if (!isset($_SESSION['username'])) {
    // Redirect to login page or handle the case where the user is not logged in
    header("Location: login.php");
    exit();
}

// Get the username from the session
$username = $_SESSION['username'];

// Fetch orders for the logged-in user with product details
$fetchOrdersQuery = "SELECT o.`order_id`, o.`user_id`, o.`product_id`, o.`customization_details`, o.`user_address`, o.`user_contact`, o.`reference_number`, o.`quantity`, o.`total_product_price`, o.`total_customization_price`, o.`total_order_price`, o.`order_date`, o.`order_status`, p.`name` AS `product_name`, p.`image` AS `product_image`
                     FROM `orders` o
                     JOIN `products` p ON o.`product_id` = p.`product_id`
                     JOIN `users` u ON o.`user_id` = u.`user_id`
                     WHERE u.`username` = '$username'";
$ordersResult = mysqli_query($conn, $fetchOrdersQuery);
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Orders</title>
    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css">
    <!-- Custom Styles -->
    <link rel="stylesheet" href="userdefinedstyle.css">
</head>

<body>
    <!-- Navigation Bar -->
    <nav class="navbar navbar-expand-lg navbar-light bg-dark">
        <a class="navbar-brand text-light" href="#">Orders</a>
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNav" aria-controls="navbarNav"
            aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarNav">
            <ul class="navbar-nav ml-auto text-light">
                <li class="nav-item text-light">
                    <a class="nav-link text-light" href="user_dashboard.php">Home</a>
                </li>
            </ul>
        </div>
    </nav>

    <div class="container mt-5 d-flex mx-5">
        <?php if (mysqli_num_rows($ordersResult) > 0) : ?>
            <?php while ($orderDetails = mysqli_fetch_assoc($ordersResult)) : ?>
                <div class="card mb-3" style="max-width: 18rem;">
                    <div class="card-header">
                        <h5 class="card-title">Order #<?php echo $orderDetails['order_id']; ?></h5>
                        <p class="card-text">Reference Number: <?php echo $orderDetails['reference_number']; ?></p>
                        <p class="card-text">
                            Order Status:
                            <?php
                            $statusLabelClass = '';
                            switch ($orderDetails['order_status']) {
                                case 'on_the_way':
                                    $statusLabelClass = 'badge-info';
                                    break;
                                case 'delivered':
                                    $statusLabelClass = 'badge-success';
                                    break;
                                case 'cancelled':
                                    $statusLabelClass = 'badge-danger';
                                    break;
                                default:
                                    $statusLabelClass = 'badge-secondary';
                                    break;
                            }
                            ?>
                            <span class="badge <?php echo $statusLabelClass; ?> rounded-pill">
                                <?php echo ucfirst(str_replace('_', ' ', $orderDetails['order_status'])); ?>
                            </span>
                        </p>
                    </div>
                    <div class="card-body">
                        <img src="admin/product_images/<?php echo $orderDetails['product_image']; ?>" class="card-img-top w-50 m-auto"
                            alt="<?php echo $orderDetails['product_name']; ?>">
                        <p class="card-text">Product Name: <?php echo $orderDetails['product_name']; ?></p>
                        <p class="card-text">Customization Details: <?php echo $orderDetails['customization_details']; ?></p>
                        <p class="card-text">Delivery Address: <?php echo $orderDetails['user_address']; ?></p>
                        <p class="card-text">Contact Delivery: <?php echo $orderDetails['user_contact']; ?></p>
                        <p class="card-text">Quantity: <?php echo $orderDetails['quantity']; ?></p>
                        <p class="card-text">Total Product Price: <?php echo $orderDetails['total_product_price']; ?></p>
                        <p class="card-text">Total Customization Price: <?php echo $orderDetails['total_customization_price']; ?></p>
                        <p class="card-text">Total Order Price: <?php echo $orderDetails['total_order_price']; ?></p>
                        <p class="card-text">Date Ordered: <?php echo $orderDetails['order_date']; ?></p>
                    </div>
                </div>
            <?php endwhile; ?>
        <?php else : ?>
            <p class="text-center">No orders yet.</p>
        <?php endif; ?>
    </div>

    <footer class="bg-info">
        <p>&copy; <?php echo date("Y"); ?> CRE8. All rights reserved.</p>
    </footer>

    <!-- Include Bootstrap JS and Popper.js (required for Bootstrap dropdowns) -->
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.3/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>

</html>
