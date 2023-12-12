<?php
// Include the database connection file
include("../includes/connect.php");

// Start a session
session_start();

// Check if the form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Check if the submit button for updating stock is clicked
    if (isset($_POST["updateStock"])) {
        $productId = $_POST["productId"];
        $newStock = $_POST["newStock"];

        // Update the stock in the database
        $updateStockQuery = "UPDATE products SET stock = $newStock WHERE product_id = $productId";
        $conn->query($updateStockQuery);
    }

    // Check if the submit button for updating status is clicked
    if (isset($_POST["updateStatus"])) {
        $productId = $_POST["productId"];
        $newStatus = $_POST["newStatus"];

        // Update the status in the database
        $updateStatusQuery = "UPDATE products SET status = '$newStatus' WHERE product_id = $productId";
        $conn->query($updateStatusQuery);
    }
}

// Fetch products with category and brand names from the database
$productQuery = "SELECT products.product_id, products.name, products.description, products.price, products.stock, products.status, products.image, categories.category_name, brands.brand_name
                 FROM products
                 JOIN categories ON products.category_id = categories.category_id
                 JOIN brands ON products.brand_id = brands.brand_id";

$productResult = $conn->query($productQuery);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>View Products</title>
    <!-- Include Bootstrap CSS -->
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.1/css/all.min.css" integrity="sha512-xr4V/6enLskZZ68rgTw3av0FcQIoA0tU6IwNwEo4Kaqn5gQdQKbOcpNPiNRIMZrxu2U3tI4FfeUdK/HHDsFGcqA==" crossorigin="anonymous" />

    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
            background-color: #f4f4f4;
        }
        section {
            padding: 20px;
        }
        table {
            width: 100%;
            margin-top: 20px;
            border-collapse: collapse;
        }
        table, th, td {
            border: 1px solid #ddd;
        }
        th, td {
            padding: 15px;
            text-align: left;
        }
        form {
            display: inline-block;
            margin-right: 10px;
        }
        img {
            max-width: 100%;
            height: auto;
        }
    </style>
</head>
<body class="bg-light">
    <header class="navbar navbar-dark bg-dark">
        <div class="container">
            <a class="navbar-brand" href="#">View Products</a>
            <ul class="navbar-nav ml-auto">
            <li class="nav-item">
                    <a class="nav-link" href="admin_dashboard.php">Go back Dashboard</a>
                </li>
            </ul>
            <ul class="navbar-nav ml-auto">
                <li class="nav-item">
                    <a class="nav-link" href="./logout.php">Logout</a>
                </li>
            </ul>
        </div>
    </header>

    <div class="container mt-4">
        <section>
            <h2>Product List</h2>
            <table class="table">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Name</th>
                        <th>Description</th>
                        <th>Price</th>
                        <th>Stock</th>
                        <th>Status</th>
                        <th>Image</th>
                        <th>Category</th>
                        <th>Brand</th>
                        <th>Stock Action</th>
                        <th>Status</th>
                        <th>Edit</th>
                        <!-- Add more columns as needed -->
                    </tr>
                </thead>
                <tbody>
                    <?php while ($product = $productResult->fetch_assoc()): ?>
                        <tr class="align-items-center">
                            <td><?php echo $product["product_id"]; ?></td>
                            <td><?php echo $product["name"]; ?></td>
                            <td><?php echo $product["description"]; ?></td>
                            <td><?php echo $product["price"]; ?></td>
                            <td><?php echo $product["stock"]; ?></td>
                            <td><?php echo $product["status"]; ?></td>
                            <td><img src="product_images/<?php echo $product["image"]; ?>" alt="Product Image"></td>
                            <td><?php echo $product["category_name"]; ?></td>
                            <td><?php echo $product["brand_name"]; ?></td>
                            <td>
                            <div class="d-flex align-items-center">
                                    <form action="" method="post">
                                        <input type="hidden" name="productId" value="<?php echo $product["product_id"]; ?>">
                                        <label for="newStock" class="sr-only">New Stock:</label>
                                        <input type="number" name="newStock" id="newStock" value="0" min="-100" max="100" required>
                                        <button type="submit" name="updateStock" class="btn btn-success btn-block rounded-pill btn-sm">Update Stock</button>
                                    </form>
                                </div>
                            </td>
                            <td>
                            <div class="d-flex align-items-center">
                                    <form action="" method="post">
                                        <input type="hidden" name="productId" value="<?php echo $product["product_id"]; ?>">
                                        <label for="newStatus" class="sr-only">New Status:</label>
                                        <select name="newStatus" id="newStatus" required>
                                            <option value="active">Active</option>
                                            <option value="inactive">Inactive</option>
                                        </select>
                                        <button type="submit" name="updateStatus" class="btn btn-info btn-block rounded-pill btn-sm">Update Status</button>
                                    </form>
                            </td>
                            <td>
                                <a href="edit_product.php?productId=<?php echo $product["product_id"]; ?>" class="btn btn-warning rounded-pill btn-block btn-sm">Edit Product</a>
                            </td>
                            <!-- Add more columns as needed -->
                        </tr>
                    <?php endwhile; ?>
                </tbody>
            </table>
        </section>
    </div>

    <!-- Include Bootstrap JS and Popper.js (required for Bootstrap) -->
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.3/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>
</html>

