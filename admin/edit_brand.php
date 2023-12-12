<?php
// Include the database connection file
include("../includes/connect.php");

// Start a session
session_start();

// Check if the form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $brandId = $_POST["brandId"];
    $newBrandName = $_POST["newBrandName"];

    // Update the brand details in the database
    $updateBrandQuery = "UPDATE brands SET brand_name = '$newBrandName' WHERE brand_id = $brandId";
    $conn->query($updateBrandQuery);

    // Redirect to the brand list after updating
    header("Location: view_brands.php");
    exit();
}

// Check if brandId is provided in the URL
if (isset($_GET["brandId"])) {
    $brandId = $_GET["brandId"];

    // Fetch brand details from the database
    $brandQuery = "SELECT * FROM brands WHERE brand_id = $brandId";
    $brandResult = $conn->query($brandQuery);

    if ($brandResult->num_rows == 1) {
        $brand = $brandResult->fetch_assoc();
    } else {
        // Redirect to the brand list if the brand is not found
        header("Location: view_brands.php");
        exit();
    }
} else {
    // Redirect to the brand list if brandId is not provided
    header("Location: view_brands.php");
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Brand</title>
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
            <a class="navbar-brand" href="#">Edit Brand</a>
            <ul class="navbar-nav ml-auto">
                <li class="nav-item">
                    <a class="nav-link" href="logout.php">Logout</a>
                </li>
            </ul>
        </div>
    </header>

    <div class="container">
        <form action="" method="post">
            <input type="hidden" name="brandId" value="<?php echo $brand["brand_id"]; ?>">
            <div class="form-group">
                <label for="newBrandName">Brand Name:</label>
                <input type="text" class="form-control" id="newBrandName" name="newBrandName" value="<?php echo $brand["brand_name"]; ?>" required>
            </div>
            <button type="submit" class="btn btn-primary">Update Brand</button>
        </form>
    </div>

    <!-- Include Bootstrap JS and Popper.js (required for Bootstrap) -->
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.3/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>
</html>
