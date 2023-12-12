<?php
include("../includes/connect.php");

// Fetch categories from the database
$categoryQuery = "SELECT category_id, category_name FROM categories";
$categoryResult = $conn->query($categoryQuery);

// Fetch brands from the database
$brandQuery = "SELECT brand_id, brand_name FROM brands";
$brandResult = $conn->query($brandQuery);

// Check if the form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Validate and sanitize user inputs
    $name = validateInput($_POST["name"]);
    $description = validateInput($_POST["description"]);
    $keywords = validateInput($_POST["keywords"]);
    $stock = validateInput($_POST["stock"]);
    $category_id = validateInput($_POST["category_id"]);
    $brand_id = validateInput($_POST["brand_id"]);
    $price = validateInput($_POST["price"]);
    $status = validateStatus($_POST["status"]);

    //accessing images
    $image=$_FILES['image']['name'];

    //accessing image tmp name
    $temp_image=$_FILES['image']['tmp_name'];

    //move file to product_images
    move_uploaded_file($temp_image,"./product_images/$image");

            // Insert product into the database
            $sql = "INSERT INTO products (name, description, keywords, stock, category_id, brand_id, image, price, status) 
                VALUES ('$name', '$description', '$keywords', $stock, $category_id, $brand_id, '$image', $price, '$status')";
            if ($conn->query($sql) === TRUE) {
                // Redirect to the admin dashboard or a confirmation page
                header("Location: admin_dashboard.php");
                exit();
            } else {
                echo "Error: " . $sql . "<br>" . $conn->error;
            }
        } else {
            echo "Sorry, there was an error uploading your file.";
            // Redirect or display an error message as needed
        }



// Function to validate input and prevent SQL injection
function validateInput($input) {
    return htmlspecialchars(trim($input));
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
    <title>Add Product - Admin Dashboard</title>
    <!-- Include Bootstrap CSS -->
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    <div class="container mt-5">
        <h2>Add Product</h2>

        <!-- Product Form goes here -->
        <form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" enctype="multipart/form-data">
            <div class="form-group">
                <label for="name">Product Name:</label>
                <input type="text" class="form-control" id="name" name="name" required>
            </div>
            <div class="form-group">
                <label for="description">Description:</label>
                <textarea class="form-control" id="description" name="description" rows="3"></textarea>
            </div>
            <div class="form-group">
                <label for="keywords">Keywords:</label>
                <input type="text" class="form-control" id="keywords" name="keywords">
            </div>
            <div class="form-group">
                <label for="stock">Stock:</label>
                <input type="number" class="form-control" id="stock" name="stock" required>
            </div>
            <div class="form-group">
                <label for="category_id">Category:</label>
                <select class="form-control" id="category_id" name="category_id" required>
                    <?php
                    while ($row = $categoryResult->fetch_assoc()) {
                        echo "<option value='{$row["category_id"]}'>{$row["category_name"]}</option>";
                    }
                    ?>
                </select>
            </div>
            <div class="form-group">
                <label for="brand_id">Brand:</label>
                <select class="form-control" id="brand_id" name="brand_id" required>
                    <?php
                    while ($row = $brandResult->fetch_assoc()) {
                        echo "<option value='{$row["brand_id"]}'>{$row["brand_name"]}</option>";
                    }
                    ?>
                </select>
            </div>
            <div class="form-group">
                <label for="image">Image File:</label>
                <input type="file" class="form-control-file" id="image" name="image" required>
            </div>
            <div class="form-group">
                <label for="price">Price:</label>
                <input type="number" class="form-control" id="price" name="price" required>
            </div>
            <div class="form-group">
                <label for="status">Status:</label>
                <select class="form-control" id="status" name="status" required>
                    <option value="active">Active</option>
                    <option value="inactive">Inactive</option>
                </select>
            </div>
            <button type="submit" class="btn btn-primary">Add Product</button>
        </form>
    </div>

    <!-- Include Bootstrap JS and Popper.js (required for Bootstrap) -->
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.3/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>
</html>

