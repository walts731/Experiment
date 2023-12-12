<?php
include("../includes/connect.php");

// Start a session
session_start();

// Check if the user is logged in
if (!isset($_SESSION['username'])) {
    header("Location: login.php"); // Redirect to login page if not logged in
    exit();
}

// Handle form submission to add customization
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['add_customization_submit'])) {
    // Retrieve data from the form
    $customName = $_POST['custom_name'];
    $stepId = intval($_POST['step_id']);
    $priceAmt = floatval($_POST['price_amt']);
    $customDescription = $_POST['custom_description'];

    // File upload handling for the image
    $newImage = $_FILES['custom_img']['name'];
    $tempImage = $_FILES['custom_img']['tmp_name'];

    //move file to product_images
    move_uploaded_file($tempImage,"./custom_images/$newImage");

    // Insert customization into the database
    $insertQuery = "INSERT INTO custom (custom_name, step_id, price_amt, custom_description, custom_img)
                    VALUES ('$customName', $stepId, $priceAmt, '$customDescription', '$newImage')";
    $conn->query($insertQuery);

    // Redirect to admin dashboard or any other desired page
    header("Location: admin_dashboard.php");
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add Customization - Admin Dashboard</title>
    <!-- Include Bootstrap CSS -->
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
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
        .btn-primary, .btn-secondary {
            width: 100%;
            margin-top: 10px;
        }
    </style>
</head>
<body>
    <div class="container">
        <h2>Add Customization</h2>

        <form action="add_customization.php" method="post" enctype="multipart/form-data">
            <div class="form-group">
                <label for="custom_name">Customization Name:</label>
                <input type="text" class="form-control" name="custom_name" required>
            </div>
            <div class="form-group">
                <label for="step_id">Step ID: 1-Color 2-Size 3-Design 4-Add-ons</label>
                <input type="number" class="form-control" name="step_id" max="4" min="1"required>
            </div>
            <div class="form-group">
                <label for="price_amt">Price Amount:</label>
                <input type="number" step="1.00" class="form-control" name="price_amt" required>
            </div>
            <div class="form-group">
                <label for="custom_description">Customization Description:</label>
                <textarea class="form-control" name="custom_description" required></textarea>
            </div>
            <div class="form-group">
                <label for="custom_img">Customization Image:</label>
                <input type="file" class="form-control" name="custom_img">
            </div>
            <button type="submit" name="add_customization_submit" class="btn btn-primary">Add Customization</button>
        </form>

        <a href="admin_dashboard.php" class="btn btn-secondary mt-4">Back to Dashboard</a>
    </div>

    <!-- Include Bootstrap JS and Popper.js (required for Bootstrap) -->
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.3/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>
</html>
