<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Contact Us</title>
    <!-- Include Bootstrap CSS -->
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
    <!-- Custom Styles -->
    <link rel="stylesheet" href="userdefinedstyle.css">
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
    </style>
</head>
<body>
    <header class="navbar navbar-dark bg-dark">
        <div class="container">
            <a class="navbar-brand text-center" href="#">Welcome to CRE8 Where Style Meets Confidence!</a>
            <ul class="navbar-nav ml-auto">
                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                        Account
                    </a>
                    <div class="dropdown-menu" aria-labelledby="navbarDropdown">
                        <a class="dropdown-item" href="login.php">Login</a>
                        <a class="dropdown-item" href="sign_up.php">Sign Up</a>
                    </div>
                </li>
            </ul>
        </div>
    </header>

    <div class="container mt-4">
        <section>
            <h2>Contact Us</h2>
            <p>
                If you have any questions or need assistance, please use the form below to contact us.
            </p>

            <!-- Contact Form -->
            <form action="" method="post">
                <div class="form-group">
                    <label for="name">Name:</label>
                    <input type="text" class="form-control" id="name" name="name" >
                </div>
                <div class="form-group">
                    <label for="email">Email:</label>
                    <input type="email" class="form-control" id="email" name="email" >
                </div>
                <div class="form-group">
                    <label for="message">Message:</label>
                    <textarea class="form-control" id="message" name="message" rows="4" ></textarea>
                </div>
                <button type="submit" class="btn btn-secondary">Submit</button>
            </form>
            <!-- End of Contact Form -->
            <button class="btn btn-secondary mt-3"><a href="index.php" class="text-light text-decoration-none">Go Back</a></button>
        </section>
    </div>

    <footer class="bg-info">
        <p>&copy; <?php echo date("Y"); ?> CRE8. All rights reserved.</p>
    </footer>

    <!-- Include Bootstrap JS and Popper.js (required for Bootstrap dropdowns) -->
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.3/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>
</html>

<?php
// Check if the form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Include database configuration
    include("includes/connect.php"); // Replace with your actual database configuration file

    // Collect form data
    $name = mysqli_real_escape_string($conn, $_POST['name']);
    $email = mysqli_real_escape_string($conn, $_POST['email']);
    $message = mysqli_real_escape_string($conn, $_POST['message']);

    // Validate data (add more validation as needed)
    if (empty($name) || empty($email) || empty($message)) {
        // Handle validation errors (you can redirect or display an error message)
        echo "All fields are required.";
    } else {
        // Insert data into the database
        $query = "INSERT INTO contacts (name, email, message) VALUES ('$name', '$email', '$message')";
        $result = mysqli_query($conn, $query);

        if ($result) {
            // Insertion successful, you can redirect or display a success message
            echo "<script>alert('Message sent successfully!')</script>"; 
        } else {
            // Insertion failed, handle the error (you can redirect or display an error message)
            echo "Error: " . mysqli_error($conn);
        }
    }

    // Close database connection
    mysqli_close($conn);
} else {
    // Redirect or handle the case when the form is not submitted
    echo "Invalid form submission.";
}
?>
