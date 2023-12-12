<?php
// Include the database connection file
include("../includes/connect.php");

// Start a session
session_start();

// Check if the form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $categoryId = $_POST["categoryId"];
    $newCategoryName = $_POST["newCategoryName"];

    // Update the category details in the database
    $updateCategoryQuery = "UPDATE categories SET category_name = '$newCategoryName' WHERE category_id = $categoryId";
    $conn->query($updateCategoryQuery);

    // Redirect to the category list after updating
    header("Location: view_categories.php");
    exit();
}

// Check if categoryId is provided in the URL
if (isset($_GET["categoryId"])) {
    $categoryId = $_GET["categoryId"];

    // Fetch category details from the database
    $categoryQuery = "SELECT * FROM categories WHERE category_id = $categoryId";
    $categoryResult = $conn->query($categoryQuery);

    if ($categoryResult->num_rows == 1) {
        $category = $categoryResult->fetch_assoc();
    } else {
        // Redirect to the category list if the category is not found
        header("Location: view_categories.php");
        exit();
    }
} else {
    // Redirect to the category list if categoryId is not provided
    header("Location: view_categories.php");
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Category</title>
    <!-- Include Bootstrap CSS -->
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
            background-color: #f4f4f4;
        }
        form {
            max-width: 600px;
            margin: 20px auto;
            background: #fff;
            padding: 30px;
            border-radius: 8px;
            box-shadow: 0 0 20px rgba(0, 0, 0, 0.1);
        }
    </style>
</head>
<body class="bg-light">
    <header class="navbar navbar-dark bg-dark">
        <div class="container">
            <a class="navbar-brand" href="#">Edit Category</a>
            <ul class="navbar-nav ml-auto">
                <li class="nav-item">
                    <a class="nav-link" href="logout.php">Logout</a>
                </li>
            </ul>
        </div>
    </header>

    <div class="container">
        <form action="" method="post">
            <input type="hidden" name="categoryId" value="<?php echo $category["category_id"]; ?>">
            <div class="form-group">
                <label for="newCategoryName">Category Name:</label>
                <input type="text" class="form-control" id="newCategoryName" name="newCategoryName" value="<?php echo $category["category_name"]; ?>" required>
            </div>
            <button type="submit" class="btn btn-primary">Update Category</button>
        </form>
    </div>

    <!-- Include Bootstrap JS and Popper.js (required for Bootstrap) -->
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.3/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>
</html>
