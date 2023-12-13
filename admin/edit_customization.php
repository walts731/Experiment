<?php
include('../includes/connect.php');
session_start();

// Check if custom_id is set in the URL
if (isset($_GET['custom_id'])) {
    $custom_id = $_GET['custom_id'];

    // Fetch the customization record based on custom_id
    $sql = "SELECT `custom_id`, `custom_name`, `step_id`, `price_amt`, `custom_description`, `custom_img` FROM `custom` WHERE `custom_id` = $custom_id";
    $result = $conn->query($sql);

    if ($result->num_rows == 1) {
        // Fetch the customization details
        $row = $result->fetch_assoc();
        $custom_name = $row['custom_name'];
        $step_id = $row['step_id'];
        $price_amt = $row['price_amt'];
        $custom_description = $row['custom_description'];
        $custom_img = $row['custom_img'];
    } else {
        // Redirect to the view_customization.php if the customization record is not found
        header("Location: view_customization.php");
        exit();
    }
} else {
    // Redirect to the view_customization.php if custom_id is not set in the URL
    header("Location: view_customization.php");
    exit();
}

// Check if the form is submitted for updating customization details
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Retrieve updated values from the form
    $new_custom_name = $_POST['new_custom_name'];
    $new_step_id = $_POST['new_step_id'];
    $new_price_amt = $_POST['new_price_amt'];
    $new_custom_description = $_POST['new_custom_description'];

    // Check if a new image file is uploaded
    if ($_FILES['new_custom_img']['error'] === 0) {
        // File upload was successful
        $new_custom_img = $_FILES['new_custom_img']['name'];

        // Move the uploaded file to the desired directory (adjust the path as needed)
        move_uploaded_file($_FILES['new_custom_img']['tmp_name'], './custom_images/' . $new_custom_img);

        // Update the customization record with the new image file
        $update_sql = "UPDATE `custom` SET 
                       `custom_name` = '$new_custom_name',
                       `step_id` = '$new_step_id',
                       `price_amt` = '$new_price_amt',
                       `custom_description` = '$new_custom_description',
                       `custom_img` = '$new_custom_img'
                       WHERE `custom_id` = $custom_id";
    } else {
        // No new image file uploaded, update without changing the image file
        $update_sql = "UPDATE `custom` SET 
                       `custom_name` = '$new_custom_name',
                       `step_id` = '$new_step_id',
                       `price_amt` = '$new_price_amt',
                       `custom_description` = '$new_custom_description'
                       WHERE `custom_id` = $custom_id";
    }

    if ($conn->query($update_sql) === TRUE) {
        echo "<script>alert('Customization updated successfully')</script>"; 
        echo "<script>alert(window.open('view_customization.php','_self')</script>";
    } else {
        echo "Error updating customization: " . $conn->error;
    }
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Customization</title>
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
    </style>
</head>
<body>
    <!-- Navigation Bar -->
    <nav class="navbar navbar-expand-lg navbar-light bg-dark">
        <a class="navbar-brand text-light" href="#">Edit Customization</a>
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNav" aria-controls="navbarNav"
            aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarNav">
            <ul class="navbar-nav ml-auto">
                <li class="nav-item">
                    <a class="nav-link text-light" href="view_customization.php">Go Back to View Customization</a>
                </li>
            </ul>
        </div>
    </nav>

    <div class="container">
        <form method="POST" action="" enctype="multipart/form-data">
            <div class="form-group">
                <label for="new_custom_name">Custom Name:</label>
                <input type="text" class="form-control" id="new_custom_name" name="new_custom_name" value="<?php echo $custom_name; ?>" required>
            </div>
            <div class="form-group">
                <label for="new_step_id">Step ID:</label>
                <input type="number" class="form-control" id="new_step_id" name="new_step_id" value="<?php echo $step_id; ?>" required>
            </div>
            <div class="form-group">
                <label for="new_price_amt">Price:</label>
                <input type="text" class="form-control" id="new_price_amt" name="new_price_amt" value="<?php echo $price_amt; ?>" required>
            </div>
            <div class="form-group">
                <label for="new_custom_description">Custom Description:</label>
                <textarea class="form-control" id="new_custom_description" name="new_custom_description" rows="3" required><?php echo $custom_description; ?></textarea>
            </div>
            <div class="form-group">
                <label for="new_custom_img">New Custom Image:</label>
                <input type="file" class="form-control-file" id="new_custom_img" name="new_custom_img">
            </div>

            <button type="submit" class="btn btn-primary">Update Customization</button>
        </form>
    </div>

    <!-- Include Bootstrap JS and Popper.js (required for Bootstrap) -->
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.3/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>
</html>
