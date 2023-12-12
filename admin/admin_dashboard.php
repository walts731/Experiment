<?php
include('../includes/connect.php');
// Start a session
session_start();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard</title>
    <!-- Include Bootstrap CSS -->
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
    <!-- Include Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" integrity="sha384-e3TJ4rEC/K+x5qJlI5aDVKdMZh3U97weD40gELzA9v7+3eTZ5ltgve7F4uNeeTnN" crossorigin="anonymous">
    <!-- Custom Styles -->
    <style>
        body {
            background-color: #f8f9fa;
        }
        .container {
            background-color: #fff;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            margin-top: 50px;
        }
        h2 {
            color: #007bff;
        }
        .row {
            margin-top: 20px;
        }
        .btn-primary, .btn-success, .btn-warning, .btn-info, .btn-danger {
            width: 100%;
            margin-top: 10px;
        }
        .message-icon {
            position: relative;
            display: inline-block;
        }

        .message-count {
            position: absolute;
            top: 0;
            right: 0;
            background-color: red;
            color: white;
            border-radius: 50%;
            padding: 2px 6px;
            font-size: 12px;
        }
    </style>
</head>
<body>
    <div class="container">
        <h2>Welcome, Admin <?php echo $_SESSION["username"]; ?>!</h2>

        <div class="message-icon">
    <a href="view_messages.php" class="btn btn-info">
    <i class="fa-regular fa-comment"></i>
        <?php
        // Fetch and display the number of messages
        $sqlCount = "SELECT COUNT(*) as count FROM `contacts`";
        $resultCount = $conn->query($sqlCount);
        
        if ($resultCount) {
            $rowCount = $resultCount->fetch_assoc()['count'];
            if ($rowCount > 0) {
                echo '<span class="message-count">' . $rowCount . '</span>';
            }
        }
        ?>
    </a>
</div>


        <div class="row">
            <div class="col-md-4">
                <h4 class="mb-4">Manage Products</h4>
                <a href="view_products.php" class="btn btn-primary">View Products</a>
                <a href="insert_product.php" class="btn btn-success">Insert Product</a>
            </div>

            <div class="col-md-4">
                <h4 class="mb-4">Manage Brands</h4>
                <a href="view_brands.php" class="btn btn-info">View Brands</a>
                <a href="insert_brand.php" class="btn btn-success">Insert Brand</a>
            </div>

            <div class="col-md-4">
                <h4 class="mb-4">Manage Categories</h4>
                <a href="view_categories.php" class="btn btn-warning">View Categories</a>
                <a href="insert_category.php" class="btn btn-success">Insert Category</a>
            </div>
        </div>

        <div class="row mt-4">
            <div class="col-md-6">
                <h4 class="mb-4">Manage Orders</h4>
                <a href="manage_orders.php" class="btn btn-primary">Manage Orders</a>
            </div>

            <div class="col-md-6">
                <h4 class="mb-4">View Sales</h4>
                <a href="view_sales.php" class="btn btn-warning">View Sales</a>
            </div>
        </div>

        <div class="row mt-4">
            <div class="col-md-6">
                <h4 class="mb-4">View All Users</h4>
                <a href="view_users.php" class="btn btn-info">View All Users</a>
            </div>

            <div class="col-md-6">
                <h4 class="mb-4">Insert Customization</h4>
                <a href="add_customization.php" class="btn btn-success">Insert Customization</a>
            </div>
        </div>

        <a href="../logout.php" class="btn btn-danger mt-4">Logout</a>
    </div>

    <!-- Include Bootstrap JS and Popper.js (required for Bootstrap) -->
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.3/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>
</html>

