<?php
// Include the database connection file
include("../includes/connect.php");

// Fetch categories from the database
$categoryQuery = "SELECT category_id, category_name FROM categories";
$categoryResult = $conn->query($categoryQuery);

// Fetch brands from the database
$brandQuery = "SELECT brand_id, brand_name FROM brands";
$brandResult = $conn->query($brandQuery);

// Check if the product ID is provided in the URL
if (isset($_GET["productId"])) {
    $productId = $_GET["productId"];

    // Fetch product details from the database
    $productQuery = "SELECT * FROM products WHERE product_id = $productId";
    $productResult = $conn->query($productQuery);

    if ($productResult->num_rows > 0) {
        $product = $productResult->fetch_assoc();
    } else {
        // Redirect to view_products.php if the product is not found
        header("Location: view_products.php");
        exit();
    }
} else {
    // Redirect to view_products.php if the product ID is not provided
    header("Location: view_products.php");
    exit();
}

// Function to validate input and prevent SQL injection
function validateInput($input) {
    global $conn;
    return mysqli_real_escape_string($conn, htmlspecialchars(trim($input)));
}

// Function to validate status
function validateStatus($status) {
    $validStatus = ['active', 'inactive'];
    return in_array($status, $validStatus) ? $status : 'inactive'; // Set default to 'inactive' if status is not valid
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Product - Admin Dashboard</title>
    <!-- Include Bootstrap CSS -->
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    <div class="container mt-5">
        <h2>Edit Product</h2>

        <!-- Product Form goes here -->
        <form method="post" action="" enctype="multipart/form-data">
            <div class="form-group">
                <label for="newName">Product Name:</label>
                <input type="text" class="form-control" id="newName" name="newName" value="<?php echo $product["name"]; ?>" required>
            </div>
            <div class="form-group">
                <label for="newDescription">Description:</label>
                <textarea class="form-control" id="newDescription" name="newDescription" rows="3"><?php echo $product["description"]; ?></textarea>
            </div>
            <div class="form-group">
                <label for="newKeywords">Keywords:</label>
                <input type="text" class="form-control" id="newKeywords" name="newKeywords" value="<?php echo $product["keywords"]; ?>">
            </div>
            <div class="form-group">
                <label for="newStock">Stock:</label>
                <input type="number" class="form-control" id="newStock" name="newStock" value="<?php echo $product["stock"]; ?>" required>
            </div>
            <div class="form-group">
                <label for="newCategory_id">Category:</label>
                <select class="form-control" id="newCategory_id" name="newCategory_id" required>
                    <?php
                    while ($row = $categoryResult->fetch_assoc()) {
                        $selected = ($row["category_id"] == $product["category_id"]) ? "selected" : "";
                        echo "<option value='{$row["category_id"]}' $selected>{$row["category_name"]}</option>";
                    }
                    ?>
                </select>
            </div>
            <div class="form-group">
                <label for="newBrand_id">Brand:</label>
                <select class="form-control" id="newBrand_id" name="newBrand_id" required>
                    <?php
                    while ($row = $brandResult->fetch_assoc()) {
                        $selected = ($row["brand_id"] == $product["brand_id"]) ? "selected" : "";
                        echo "<option value='{$row["brand_id"]}' $selected>{$row["brand_name"]}</option>";
                    }
                    ?>
                </select>
            </div>
            <div class="form-group">
                <label for="newImage">Image File:</label>
                <input type="file" class="form-control-file" id="newImage" name="newImage" required>
            </div>
            <div class="form-group">
                <label for="newPrice">Price:</label>
                <input type="number" class="form-control" id="newPrice" name="newPrice" value="<?php echo $product["price"]; ?>" required>
            </div>
            <div class="form-group">
                <label for="newStatus">Status:</label>
                <select class="form-control" id="newStatus" name="newStatus" required>
                    <option value="active" <?php echo ($product["status"] == "active") ? "selected" : ""; ?>>Active</option>
                    <option value="inactive" <?php echo ($product["status"] == "inactive") ? "selected" : ""; ?>>Inactive</option>
                </select>
            </div>
            <button type="submit" class="btn btn-primary btn-sm" name="update_product">Update Product</button>
        </form>
    </div>

    <!-- Include Bootstrap JS and Popper.js (required for Bootstrap) -->
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.3/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>
</html>

<?php
// Check if the form is submitted
if ($_SERVER["REQUEST_METHOD"] === "POST" && isset($_POST['update_product'])) {
    // Validate and sanitize user inputs
    $newName = validateInput($_POST["newName"]);
    $newDescription = validateInput($_POST["newDescription"]);
    $newKeywords = validateInput($_POST["newKeywords"]);
    $newStock = validateInput($_POST["newStock"]);
    $newCategory_id = validateInput($_POST["newCategory_id"]);
    $newBrand_id = validateInput($_POST["newBrand_id"]);
    $newPrice = validateInput($_POST["newPrice"]);
    $newStatus = validateStatus($_POST["newStatus"]);

    // File upload handling for the image
    $newImage = $_FILES['newImage']['name'];
    $tempImage = $_FILES['newImage']['tmp_name'];

    // Move the file to the product_images directory
    move_uploaded_file($tempImage, "./product_images/$newImage");

    // Update product details in the database
    $updateProductQuery = "UPDATE `products` SET 
        `name` = '$newName', 
        `description` = '$newDescription', 
        `keywords` = '$newKeywords', 
        `stock` = '$newStock', 
        `category_id` = '$newCategory_id', 
        `brand_id` = '$newBrand_id', 
        `image` = '$newImage', 
        `price` = '$newPrice', 
        `status` = '$newStatus', 
        `created_at` = NOW()
        WHERE `product_id` = '$productId'";

    $conn->query($updateProductQuery);

    // Redirect to view_products.php after updating
    header("Location: view_products.php");
    exit();
}
?>
