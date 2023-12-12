<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>User Registration</title>
    <!-- Include Bootstrap CSS -->
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            background-image: url('img/pexels-polina-tankilevitch-3875430.jpg');
            background-size: cover;
            background-position: center;
            background-repeat: no-repeat;
            color: #ffffff;
            margin: 0;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .container {
            max-width: 800px; /* Adjusted max-width for a larger form */
        }

        form {
            background-color: rgba(0, 0, 0, 0.7);
            color: #ffffff;
            padding: 40px; /* Adjusted padding for a larger form */
            border-radius: 10px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }

        .form-group {
            margin-bottom: 20px; /* Increased margin-bottom for better spacing */
        }

        .form-control {
            margin-bottom: 15px; /* Increased margin-bottom for better spacing */
        }

        .btn-block {
            margin-top: 20px; /* Increased top margin for better spacing */
        }

        h2 {
            text-align: center;
            color: #ffffff; /* Added color to h2 */
        }
    </style>
</head>

<body>
    <div class="container mt-5">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <h2 class="mb-4">User Registration</h2>
                <!-- ... your PHP code ... -->
                <form action="register_process.php" method="post" class="p-4 rounded">
                    <div class="form-group">
                        <label for="username">Username:</label>
                        <input type="text" class="form-control" id="username" name="username" required>
                    </div>
                    <div class="form-group">
                        <label for="email">Email:</label>
                        <input type="email" class="form-control" id="email" name="email" required>
                    </div>
                    <div class="form-group">
                        <label for="contact">Contact:</label>
                        <input type="text" class="form-control" id="contact" name="contact" required>
                    </div>
                    <div class="form-group">
                        <label for="address">Address:</label>
                        <input type="text" class="form-control" id="address" name="address" required>
                    </div>
                    <div class="form-group">
                        <label for="password">Password:</label>
                        <input type="password" class="form-control" id="password" name="password" required>
                    </div>
                    <div class="form-group">
                        <label for="confirm_password">Confirm Password:</label>
                        <input type="password" class="form-control" id="confirm_password" name="confirm_password"
                            required>
                    </div>
                    <button type="submit" class="btn btn-primary btn-block mt-3">Register</button>
                </form>
                <p class="mt-3 text-center"><strong>Already have an account? <a href="login.php"
                            class="btn btn-link text-decoration-none">Log in</a></strong></p>
            </div>
        </div>
    </div>

    <!-- Include Bootstrap JS and Popper.js (required for Bootstrap) -->
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.3/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>

</html>
