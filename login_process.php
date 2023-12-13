<?php
// Start a session
session_start();

// Include database configuration 
include("includes/connect.php");

// Check if the form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Get user input
    $username = $_POST["username"];
    $password = $_POST["password"];

    // Perform SQL query to check if the user exists
    $check_user_query = "SELECT * FROM users WHERE username = '$username'";
    $check_user_result = mysqli_query($conn, $check_user_query);

    if ($check_user_result && mysqli_num_rows($check_user_result) == 1) {
        // User found, fetch user details
        $user = mysqli_fetch_assoc($check_user_result);

        // Verify the password
        if (password_verify($password, $user["password"])) {
            // Password is correct, set session variables
            $_SESSION["username"] = $username;
            $_SESSION["user_type"] = $user["user_type"];

            if ($user["user_type"] == "admin") {
                // Redirect admin to admin dashboard
                header("Location: admin/admin_dashboard.php");
            } else {
                // Redirect user to user dashboard
                header("Location: user_dashboard.php");
            }
            exit(); // Add exit to stop script execution after redirection
        } else {
            // Password is incorrect, redirect to login page with an error message
            echo "<script>alert('Invalid credentials')</script>"; 
            header("Location: login.php?error=invalid_credentials");
            exit(); // Add exit to stop script execution after redirection
        }
    } else {
        
        // User not found, redirect to login page with an error message
        echo "<script>alert('Invalid credentials')</script>";
        header("Location: login.php?error=invalid_credentials");
        exit(); // Add exit to stop script execution after redirection
    }

    // Close database connection
    mysqli_close($conn);
} else {
    // If the form is not submitted, redirect to the login page
    header("Location: login.php");
    exit(); // Add exit to stop script execution after redirection
}
?>
