<?php
// Include the database connection file
include("../includes/connect.php");

// Start a session
session_start();

// Fetch brands from the database
$brandQuery = "SELECT * FROM brands";
$brandResult = $conn->query($brandQuery);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>View Brands</title>
    <!-- Include Bootstrap CSS -->
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
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
    </style>
</head>
<body class="bg-light">
    <header class="navbar navbar-dark bg-dark">
        <div class="container">
            <a class="navbar-brand" href="#">View Brands</a>
            <ul class="navbar-nav ml-auto">
            <li class="nav-item">
                    <a class="nav-link" href="admin_dashboard.php">Go back Dashboard</a>
                </li>
            </ul>
            <ul class="navbar-nav ml-auto">
                <li class="nav-item">
                    <a class="nav-link" href="logout.php">Logout</a>
                </li>
            </ul>
        </div>
    </header>

    <div class="container mt-4">
        <section>
            <h2>Brand List</h2>
            <table class="table">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Name</th>
                        <th>Edit</th> <!-- New column for Edit button -->
                        <!-- Add more columns as needed -->
                    </tr>
                </thead>
                <tbody>
                    <?php while ($brand = $brandResult->fetch_assoc()): ?>
                        <tr>
                            <td><?php echo $brand["brand_id"]; ?></td>
                            <td><?php echo $brand["brand_name"]; ?></td>
                            <td>
                                <a href="edit_brand.php?brandId=<?php echo $brand["brand_id"]; ?>" class="btn btn-warning">Edit</a>
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
