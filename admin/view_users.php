<?php
// Include the database connection file
include("../includes/connect.php");

// Fetch users with status 'user' from the database
$userQuery = "SELECT * FROM users WHERE user_type = 'user'";
$userResult = $conn->query($userQuery);

// Start a session
session_start();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>View Users</title>
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
        <a class="navbar-brand" href="#">View Users</a>
        <ul class="navbar-nav ml-auto">
            <li class="nav-item">
                <a class="nav-link" href="admin_dashboard.php">Go Back to Dashboard</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="logout.php">Logout</a>
            </li>
        </ul>
    </div>
</header>


    <div class="container mt-4">
        <section>
            <h2>User List</h2>
            <table>
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Username</th>
                        <th>Email</th>
                        <!-- Add more columns as needed -->
                    </tr>
                </thead>
                <tbody>
                    <?php while ($user = $userResult->fetch_assoc()): ?>
                        <tr>
                            <td><?php echo $user["user_id"]; ?></td>
                            <td><?php echo $user["username"]; ?></td>
                            <td><?php echo $user["email"]; ?></td>
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
