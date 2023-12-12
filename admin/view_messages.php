<?php
include('../includes/connect.php');

// Fetch data from the database
$sql = "SELECT `id`, `name`, `email`, `message`, `created_at` FROM `contacts`";
$result = $conn->query($sql);

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>View Messages</title>
    <!-- Include Bootstrap CSS -->
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
    <!-- Include Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" integrity="sha384-e3TJ4rEC/K+x5qJlI5aDVKdMZh3U97weD40gELzA9v7+3eTZ5ltgve7F4uNeeTnN" crossorigin="anonymous">
</head>
<body>
    <div class="container mt-4">
        <h2>View Messages</h2>
        <table class="table table-bordered">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Name</th>
                    <th>Email</th>
                    <th>Message</th>
                    <th>Date</th>
                </tr>
            </thead>
            <tbody>
                <?php
                // Display data in the table
                if ($result->num_rows > 0) {
                    while ($row = $result->fetch_assoc()) {
                        echo "<tr>";
                        echo "<td>{$row['id']}</td>";
                        echo "<td>{$row['name']}</td>";
                        echo "<td>{$row['email']}</td>";
                        echo "<td>{$row['message']}</td>";
                        echo "<td>{$row['created_at']}</td>";
                        echo "</tr>";
                    }
                } else {
                    echo "<tr><td colspan='5'>No messages found</td></tr>";
                }
                ?>
            </tbody>
        </table>
        <a href="admin_dashboard.php" class="btn btn-primary">Back to Dashboard</a>
    </div>

    <!-- Include Bootstrap JS and Popper.js (required for Bootstrap) -->
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.3/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>
</html>

<?php
// Close the database connection
$conn->close();
?>
