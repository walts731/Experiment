<?php
include("../includes/connect.php");

// Check if the form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Retrieve the selected order status and order ID from the form
    $newOrderStatus = $_POST['new_order_status'];
    $orderId = $_POST['order_id'];

    // Update the order status in the database
    $updateOrderStatusQuery = "UPDATE `orders` SET `order_status` = '$newOrderStatus' WHERE `order_id` = $orderId";
    mysqli_query($conn, $updateOrderStatusQuery);
}
// Fetch delivered orders
$deliveredOrdersQuery = "SELECT o.`order_id`, o.`user_id`, o.`product_id`, o.`customization_details`, o.`user_address`, o.`user_contact`, o.`reference_number`, o.`quantity`, o.`total_product_price`, o.`total_customization_price`, o.`total_order_price`, o.`order_date`, o.`order_status`, p.`name` AS `product_name`, p.`image` AS `product_image`, u.`username`
                         FROM `orders` o
                         JOIN `products` p ON o.`product_id` = p.`product_id`
                         JOIN `users` u ON o.`user_id` = u.`user_id`
                         WHERE o.`order_status` = 'pending'
                         ORDER BY o.`order_date` DESC";
$deliveredOrdersResult = mysqli_query($conn, $deliveredOrdersQuery);
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Delivered Orders</title>
    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css">
</head>

<body>
    <!-- Navigation Bar -->
    <nav class="navbar navbar-expand-lg navbar-light bg-dark">
        <a class="navbar-brand text-light" href="#">On The Way Orders</a>
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNav" aria-controls="navbarNav"
            aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <a class="navbar-brand text-light" href="manage_orders.php">Go Back Manage Orders</a>
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNav" aria-controls="navbarNav"
            aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <!-- Add other navigation elements if necessary -->
    </nav>

    <div class="container mt-5">
        <div class="row">
            <?php while ($orderDetails = mysqli_fetch_assoc($deliveredOrdersResult)) : ?>
                <div class="col-md-4">
                    <div class="card mb-3">
                        <div class="card-header">
                            <h3 class="card-text"><?php echo $orderDetails['username']; ?></h3>
                            <h5 class="card-title">Order #<?php echo $orderDetails['order_id']; ?></h5>
                            <!-- Add other order details as needed -->
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
                        <form method="post" action="">
                                <div class="form-group">
                                    <label for="new_order_status">Update Order Status:</label>
                                    <select class="form-control" id="new_order_status" name="new_order_status">
                                        <option value="on_the_way">On the Way</option>
                                        <option value="delivered">Delivered</option>
                                        <option value="cancelled">Cancelled</option>
                                    </select>
                                </div>
                                <input type="hidden" name="order_id" value="<?php echo $orderDetails['order_id']; ?>">
                                <button type="submit" class="btn btn-primary">Update Status</button>
                            </form>
                            <hr>
                            <!-- Add other order details as needed -->
                            <img src="../admin/product_images/<?php echo $orderDetails['product_image']; ?>" class="card-img-top w-50 m-auto"
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
                </div>
            <?php endwhile; ?>
        </div>
    </div>

    <!-- Include Bootstrap JS and Popper.js (required for Bootstrap dropdowns) -->
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.3/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>

</html>
