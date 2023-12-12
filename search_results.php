<?php
// Include the database connection file
include("includes/connect.php");

// Fetch categories from the database
$categoryQuery = "SELECT category_id, category_name FROM categories";
$categoryResult = $conn->query($categoryQuery);

// Fetch brands from the database
$brandQuery = "SELECT brand_id, brand_name FROM brands";
$brandResult = $conn->query($brandQuery);

// Start a session
session_start();


// Check if the search query is provided
if (!isset($_GET['query'])) {
    // Redirect to the home page if no search query is provided
    header("Location: index.php");
    exit();
}

// Get the search query
$searchQuery = $_GET['query'];

// Perform a search in the products table based on the name or description
$searchProductsQuery = "SELECT * FROM products WHERE name LIKE '%$searchQuery%' OR description LIKE '%$searchQuery%'";
$searchProductsResult = $conn->query($searchProductsQuery);

// Function to add an item to the cart
function addToCart($productId, $quantity = 1) {
    global $conn;

    // Check if the user is logged in
    if (isset($_SESSION['username'])) {
        $username = $_SESSION['username'];

        // Fetch the price of the product
        $priceQuery = "SELECT price FROM products WHERE product_id = $productId";
        $priceResult = $conn->query($priceQuery);

        if ($priceResult->num_rows > 0) {
            $price = $priceResult->fetch_assoc()['price'];

            // Check if the item is already in the cart
            $checkQuery = "SELECT * FROM cart WHERE username = '$username' AND product_id = $productId";
            $checkResult = $conn->query($checkQuery);
            
            if ($checkResult->num_rows > 0) {
                // Update the quantity if the item is already in the cart
                $updateQuery = "UPDATE cart SET quantity = quantity + $quantity, total_amount = total_amount + ($quantity * $price) WHERE username = '$username' AND product_id = $productId";
                $conn->query($updateQuery);
            } else {
                // Insert a new item into the cart
                $insertQuery = "INSERT INTO cart (username, product_id, quantity, total_amount) VALUES ('$username', $productId, $quantity, $quantity * $price)";
                $conn->query($insertQuery);
            }
        }
    }
}

// Check if the "Add to Cart" button is clicked
if (isset($_POST['add_to_cart'])) {
    $productId = $_POST['product_id'];
    addToCart($productId);
}

// Fetch the count of items in the cart
if (isset($_SESSION['username'])) {
    $username = $_SESSION['username'];
    $cartCountQuery = "SELECT SUM(quantity) AS cart_count FROM cart WHERE username = '$username'";
    $cartCountResult = $conn->query($cartCountQuery);
    $cartCount = $cartCountResult->fetch_assoc()['cart_count'];
} else {
    $cartCount = 0;
}

if (isset($_SESSION['username'])) {
    $username = $_SESSION['username'];
    $uniqueItemCountQuery = "SELECT COUNT(DISTINCT product_id) AS unique_item_count FROM cart WHERE username = '$username'";
    $uniqueItemCountResult = $conn->query($uniqueItemCountQuery);
    $uniqueItemCount = $uniqueItemCountResult->fetch_assoc()['unique_item_count'];
} else {
    $uniqueItemCount = 0;
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Search Results</title>
    <!-- Include Bootstrap CSS -->
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
    <!-- Include Font Awesome CSS (you can replace this with the latest version) -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.1/css/all.min.css" rel="stylesheet">
    <!-- Custom Styles -->
    <link rel="stylesheet" href="userdefinedstyle.css">
</head>

<body class="bg-light">

    <!-- nav_bar.php -->
<nav class="navbar navbar-expand-lg navbar-light bg-info">
    <a class="navbar-brand" href="#">
        <img src="img/logo.png" class="rounded-circle" alt="Logo">
        <span class="text-dark">CRE8</span>
    </a>
    <a class="navbar-brand text-dark" href="user_dashboard.php">Home</a>

    <ul class="navbar-nav ml-auto">
        <li class="nav-item">
            <a class="nav-link" href="view_cart.php">
                <i class="fas fa-shopping-cart cart-icon"></i>
                <sup class="cart-count"><?php echo $uniqueItemCount; ?></sup>
            </a>
        </li>
    </ul>

    <!-- Search Bar -->
    <form class="form-inline my-2 my-lg-0" action="search_results.php" method="get">
        <input class="form-control mr-sm-2" type="search" placeholder="Search" aria-label="Search" name="query">
        <button class="btn btn-outline-dark my-2 my-sm-0" type="submit">Search</button>
    </form>

    <ul class="navbar-nav ml-auto">
        <div class="collapse navbar-collapse" id="navbarNav">
            <ul class="navbar-nav ml-auto">
                <!-- Orders Button -->
                <li class="nav-item">
                    <a class="nav-link btn btn-info" href="orders.php">Orders</a>
                </li>

                <!-- Categories Dropdown -->
                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle" href="#" id="categoriesDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                        Categories
                    </a>
                    <div class="dropdown-menu" aria-labelledby="categoriesDropdown">
                        <?php while ($category = $categoryResult->fetch_assoc()): ?>
                            <a class="dropdown-item" href="?category_id=<?php echo $category["category_id"]; ?>"><?php echo $category["category_name"]; ?></a>
                        <?php endwhile; ?>
                    </div>
                </li>

                <!-- Brands Dropdown -->
                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle" href="#" id="brandsDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                        Brands
                    </a>
                    <div class="dropdown-menu" aria-labelledby="brandsDropdown">
                        <?php while ($brand = $brandResult->fetch_assoc()): ?>
                            <a class="dropdown-item" href="?brand_id=<?php echo $brand["brand_id"]; ?>"><?php echo $brand["brand_name"]; ?></a>
                        <?php endwhile; ?>
                    </div>
                </li>

                <!-- User Authentication Dropdown -->
                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle" href="#" id="userDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                        <i class="fas fa-user"></i> <!-- Font Awesome user icon -->
                    </a>
                    <div class="dropdown-menu" aria-labelledby="userDropdown">
                        <a class="dropdown-item" href="login.php">Login</a>
                        <a class="dropdown-item" href="sign_up.php">Sign Up</a>
                    </div>
                </li>

                <li class="nav-item">
                    <a class="nav-link" href="logout.php">Logout</a>
                </li>
            </ul>
        </div>
    </nav>


    <div class="container">
        <h2 class="text-center mt-5 text-dark">Search Results for "<?php echo $searchQuery; ?>"</h2>
        <?php if ($searchProductsResult->num_rows > 0): ?>
            <?php $product = $searchProductsResult->fetch_assoc(); ?>
            <div class="row">
                <div class="col-md-4 mx-auto">
                    <!-- Display search result as a card -->
                    <div class="card">
                        <!-- Display product information here -->
                        <img src="admin/product_images/<?php echo $product["image"]; ?>" class="card-img-top w-50 m-auto" alt="<?php echo $product["name"]; ?>">
                        <div class="card-body">
                            <h5 class="card-title"><?php echo $product["name"]; ?></h5>
                            <p class="card-text"><?php echo $product["description"]; ?></p>
                            <p class="card-text">Price: <?php echo $product["price"]; ?></p>
                            <form method="post">
                                <input type="hidden" name="product_id" value="<?php echo $product["product_id"]; ?>">
                                <button type="submit" name="add_to_cart" class="btn btn-success add-to-cart">Add to Cart</button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        <?php else: ?>
            <p class="text-center">No results found.</p>
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
