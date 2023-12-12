<?php
// Include database configuration (replace with your actual database connection code)
include("includes/connect.php");

// Check if the form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Get user input
    $username = $_POST["username"];
    $email = $_POST["email"];
    $contact = $_POST["contact"];
    $password = $_POST["password"];
    $confirm_password = $_POST["confirm_password"];
    $address = $_POST["address"]; // Assuming you have added the address input

    // Perform basic form validation
    if ($password !== $confirm_password) {
        // Passwords do not match, redirect to registration page with an error message
        header("Location: register.php?error=password_mismatch");
        exit();
    }

    // Hash the password
    $hashed_password = password_hash($password, PASSWORD_DEFAULT);

    // Perform SQL query to check if the username or email is already taken using prepared statement
    $check_user_query = "SELECT * FROM users WHERE username = '$username' OR email = '$email'";
    $check_user_result = mysqli_query($conn, $check_user_query);

    if (mysqli_num_rows($check_user_result) > 0) {
        // Username or email is already taken, redirect to registration page with an error message
        header("Location: register.php?error=username_taken");
        exit();
    }

    // Insert new user into the database using prepared statement
    $insert_user_query = "INSERT INTO users (username, email, contact, address, password) VALUES ('$username', '$email', '$contact', '$address', '$hashed_password')";
    $insert_user_result = mysqli_query($conn, $insert_user_query);

    if ($insert_user_result) {
        // User successfully registered, redirect to login page
        header("Location: login.php");
        exit();
    } else {
        // Error registering user, redirect to registration page with an error message
        header("Location: register.php?error=register_error");
        exit();
    }

    // Close database connection
    mysqli_close($conn);
} else {
    // If the form is not submitted, redirect to the registration page
    header("Location: register.php");
    exit();
}
?>
