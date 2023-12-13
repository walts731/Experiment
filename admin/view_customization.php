<?php
include('../includes/connect.php');
session_start();

// Fetch data from the 'custom' table and sort by step_id in ascending order
$sql = "SELECT `custom_id`, `custom_name`, `step_id`, `price_amt`, `custom_description`, `custom_img` FROM `custom` ORDER BY `step_id` ASC";
$result = $conn->query($sql);

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>View Customization</title>
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
        div.customization {
            margin-bottom: 20px;
            padding: 15px;
            border: 1px solid #dee2e6;
            border-radius: 5px;
        }
    </style>
</head>
<body>
    <!-- Navigation Bar -->
    <nav class="navbar navbar-expand-lg navbar-light bg-dark">
        <a class="navbar-brand text-light" href="#">View Customization</a>
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

    <div class="container">
        <?php
        // Check if there are any records
        if ($result->num_rows > 0) {
            // Output data of each row
            while ($row = $result->fetch_assoc()) {
                echo "<div class='customization'>";
                echo "<h3>" . $row["custom_name"] . "</h3>";
                echo "<p>Step ID: " . $row["step_id"] . "</p>";
                echo "<p>Price: php" . $row["price_amt"] . "</p>";
                echo "<p>Description: " . $row["custom_description"] . "</p>";
                echo "<img src='./custom_images/" . $row["custom_img"] . "' alt='Custom Image' class='img-fluid'>";
                
                // Add an "Edit" button that redirects to edit_customization.php
                echo "<a href='edit_customization.php?custom_id=" . $row["custom_id"] . "' class='btn btn-primary'>Edit</a>";
                
                echo "</div>";
            }
        } else {
            echo "<p>No customization data available.</p>";
        }

        // Close the database connection
        $conn->close();
        ?>

    </div>

    <!-- Include Bootstrap JS and Popper.js (required for Bootstrap) -->
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.3/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>
</html>
