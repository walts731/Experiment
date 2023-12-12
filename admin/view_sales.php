<?php
include("../includes/connect.php");

// Fetch all delivered orders with product details and user information
$fetchDeliveredOrdersQuery = "SELECT o.`order_id`, o.`user_id`, o.`product_id`, o.`customization_details`, o.`user_address`, o.`user_contact`, o.`reference_number`, o.`quantity`, o.`total_product_price`, o.`total_customization_price`, o.`total_order_price`, o.`order_date`, p.`name` AS `product_name`, p.`image` AS `product_image`, u.`username`
                     FROM `orders` o
                     JOIN `products` p ON o.`product_id` = p.`product_id`
                     JOIN `users` u ON o.`user_id` = u.`user_id`
                     WHERE o.`order_status` = 'delivered'";
$deliveredOrdersResult = mysqli_query($conn, $fetchDeliveredOrdersQuery);

// Fetch total order prices for the chart
$totalOrderPricesQuery = "SELECT SUM(total_order_price) AS total_price, DATE_FORMAT(order_date, '%Y-%m') AS order_month
                          FROM orders
                          WHERE order_status = 'delivered'
                          GROUP BY order_month
                          ORDER BY order_month";

$totalOrderPricesResult = mysqli_query($conn, $totalOrderPricesQuery);

// Prepare data for the chart
$chartData = [];
while ($row = mysqli_fetch_assoc($totalOrderPricesResult)) {
    $chartData[] = [
        'month' => $row['order_month'],
        'total_price' => $row['total_price'],
    ];
}

// Convert PHP array to JSON for JavaScript
$chartDataJSON = json_encode($chartData);
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Delivered Orders</title>
    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css">
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
</head>

<body>
    <!-- Navigation Bar -->
    <nav class="navbar navbar-expand-lg navbar-light bg-dark">
        <a class="navbar-brand text-light" href="#">Delivered Orders</a>
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNav" aria-controls="navbarNav"
            aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarNav">
            <ul class="navbar-nav ml-auto">
                <li class="nav-item">
                    <a class="nav-link text-light" href="admin_dashboard.php">Go Back Dashboard</a>
                </li>
            </ul>
        </div>
    </nav>

    <!-- Canvas for Chart.js -->
    <div class="container mt-5">
        <canvas id="orderChart" width="800" height="400"></canvas>
    </div>

    <div class="container mt-5 d-flex mx-5">
        <?php while ($deliveredOrderDetails = mysqli_fetch_assoc($deliveredOrdersResult)) : ?>
            <div class="card mb-3" style="max-width: 18rem;">
                <div class="card-header">
                    <h3 class="card-text"> <?php echo $deliveredOrderDetails['username']; ?></h3>
                    <h5 class="card-title">Order #<?php echo $deliveredOrderDetails['order_id']; ?></h5>
                    <p class="card-text">Reference Number: <?php echo $deliveredOrderDetails['reference_number']; ?></p>
                    <p class="card-text">
                        Order Status: Delivered
                    </p>
                </div>
                <div class="card-body">
                    <img src="../admin/product_images/<?php echo $deliveredOrderDetails['product_image']; ?>" class="card-img-top w-50 m-auto"
                        alt="<?php echo $deliveredOrderDetails['product_name']; ?>">
                    <p class="card-text">Product Name: <?php echo $deliveredOrderDetails['product_name']; ?></p>
                    <p class="card-text">Customization Details: <?php echo $deliveredOrderDetails['customization_details']; ?></p>
                    <p class="card-text">Delivery Address: <?php echo $deliveredOrderDetails['user_address']; ?></p>
                    <p class="card-text">Contact Delivery: <?php echo $deliveredOrderDetails['user_contact']; ?></p>
                    <p class="card-text">Quantity: <?php echo $deliveredOrderDetails['quantity']; ?></p>
                    <p class="card-text">Total Product Price: <?php echo $deliveredOrderDetails['total_product_price']; ?></p>
                    <p class="card-text">Total Customization Price: <?php echo $deliveredOrderDetails['total_customization_price']; ?></p>
                    <p class="card-text">Total Order Price: <?php echo $deliveredOrderDetails['total_order_price']; ?></p>
                    <p class="card-text">Date Ordered: <?php echo $deliveredOrderDetails['order_date']; ?></p>
                </div>
            </div>
        <?php endwhile; ?>
    </div>

    <!-- Include Bootstrap JS and Popper.js (required for Bootstrap dropdowns) -->
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.3/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>

    <!-- Add this script block at the end of the body section -->
    <script>
        // Convert JSON data to JavaScript array
        var chartData = <?php echo $chartDataJSON; ?>;

        // Get canvas element and create a bar chart
        var ctx = document.getElementById('orderChart').getContext('2d');
        var orderChart = new Chart(ctx, {
            type: 'bar',
            data: {
                labels: chartData.map(data => data.month),
                datasets: [{
                    label: 'Total Order Sales',
                    data: chartData.map(data => data.total_price),
                    backgroundColor: 'rgba(75, 192, 192, 0.2)',
                    borderColor: 'rgba(75, 192, 192, 1)',
                    borderWidth: 1
                }]
            },
            options: {
                scales: {
                    y: {
                        beginAtZero: true
                    }
                }
            }
        });
    </script>
</body>

</html>
